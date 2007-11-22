<?php
/*
Script: vg_cache.php
        This clas provide a cache mechanism with a fixed number of entries.
        Cache data might be gzipped.

License: GNU General Public License

This file is part of VisuGps

VisuGps is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

VisuGps is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with VisuGps; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Copyright (c) 2007 Victor Berchet, <http://www.victorb.fr>

*/

require('vg_log.php');

/*
Class: Cache
        Provide a cache mechanism
*/        
class Cache {

    // Private members
    private $fileDir;
    private $idxDir;
    private $capacity;
    private $log;
    private $gzlevel;

    // Constants
    const idTag = 'id';
    const fileTag = 'file';
    const baseName = 'cache';
    const logName = 'log';
    const idxName = 'idx';

    // Public API
    /*
    Method: __construct
            Class constructor.
            
    Arguments:
        dir - folder to be used for storing cache data
        capacity - size of the cache
        gzlevel - compression level (0 = none ... 9 = max)                   
    */
    public function __construct($dir = "cache/", $capacity = 50, $gzlevel = 0) {
        $this->fileDir = $dir;
        $this->idxDir = $this->fileDir . 'index/';
        $this->gzlevel = $gzlevel;

        // Do not allow user to abort the script
        ignore_user_abort(true);

        if (!is_dir($this->idxDir)) mkdir($this->idxDir, 0700, true);
        $this->log = new Log($this->idxDir . self::logName, true);
        $this->capacity = $capacity;
        $this->log->msg("+ Cache constructor");
    }
    /*
    Method: __destruct
            Class destructor.           
    */
    public function __destruct() {
        $this->log->msg("- Cache destructor");
    }
    /*
    Method: get
            Check if the data is in the cache
            
    Arguments:
            data - data (modified if in cache)
            id - uid of the data to check

    Returns:
            true if the data is found in cache, false otherwise                                  
    */
    public function get(&$data, $id) {
        if (!CACHE_ENABLED) {
            $this->log->msg("GET: Cache disabled");
            return false;
        }

        $found = false;

        $indexFile = $this->idxDir . self::idxName;

        $this->log->msg("Cache get id = $id");

        $handle = fopen($indexFile, "a+b");

        if ($handle && flock($handle, LOCK_EX)) {
            rewind($handle);
            $size = fstat($handle);
            $size = $size['size'];
            $index = ($size > 0)?unserialize(fread($handle, $size)):array();

            $id = strtoupper($id);

            for ($idx = 0; $idx < count($index); $idx++) {
                if ($index[$idx][self::idTag] === $id) {
                    $content = $index[$idx];
                    unset($index[$idx]);
                    $fname = $this->fileDir . $content[self::fileTag];
                    $this->log->msg("$id found in cache in [$fname]");
                    if (is_file($fname)) {
                        array_unshift($index, $content);
                        $data = gzinflate(file_get_contents($fname));
                        $found = true;
                        rewind($handle);
                        ftruncate($handle, 0);
                        fwrite($handle, serialize($index));
                        break;
                    } else {
                        $this->log->msg("$fname is not a valid cache file!");
                    }
                }
            }
            fflush($handle);
            fclose($handle);
        }

        return $found;
    }
    /*
    Method: set
            Populate the cache
            
    Arguments:
            data - data
            id - uid of the data                                
    */
    public function set($data, $id) {
        if (!CACHE_ENABLED) {
            $this->log->msg("SET: Cache disabled");
            return;
        }

        $this->log->msg("Cache set id = $id");

        $indexFile = $this->idxDir . self::idxName;

        $handle = fopen($indexFile, "a+b");

        if ($handle && flock($handle, LOCK_EX)) {
            rewind($handle);
            $found = false;
            $size = fstat($handle);
            $size = $size['size'];
            $index = ($size > 0)?unserialize(fread($handle, $size)):array();

            $id = strtoupper($id);

            for ($idx = 0; $idx < count($index); $idx++) {
                if ($index[$idx][self::idTag] === $id) {
                    $this->log->msg("$id found in cache");
                    $content = $index[$idx];
                    unset($index[$idx]);
                    array_unshift($index, $content);
                    $found = true;
                }
            }

            if (!$found) {
                $this->purge($index, 1);
                $content = array(self::idTag => $id, self::fileTag => $this->getFileName());
                $fname = $this->fileDir . $content[self::fileTag];
                $this->log->msg("$id added in cache in [$fname]");
                array_unshift($index, $content);
                file_put_contents($fname, gzdeflate($data, $this->gzlevel));
            }

            rewind($handle);
            ftruncate($handle, 0);
            fwrite($handle, serialize($index));
            fflush($handle);
            fclose($handle);
        }

        return;
    }

    // Private functions
    /*
    Method: getFileName
            Returns an inexisting file name.           
    */    
    private function getFileName() {
        $count = 0;
        do {
            $name = self::baseName . '-' . $count;
            $count++;
        } while (is_file($this->fileDir . $name));
        return $name;
    }
    /*
    Method: purge
            Purge the cache when (current + required) size exceeds
            cache capacity
            
    Arguments:
            index - cache index
            add - space required in cache                       
    */    
    private function purge(&$index, $add = 0) {
        $extraCount = (count($index) + $add) - $this->capacity;
        $this->log->msg("Purge $extraCount files");
        while ($extraCount > 0) {
            $content = array_pop($index);
            $this->log->msg("Cache overflow. Remove " . $content[self::fileTag]);
            unlink($this->fileDir . $content[self::fileTag]);
            $extraCount--;
        }
    }
}

?>
