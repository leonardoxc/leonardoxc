<?php
/*
Script: vg_log.php
        Very simple logging class

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
 
/*
Class: Log
        Simple logging class
*/
class Log {
    const maxSize = 1000000;

    private $handle = NULL;
    private $on;

    /*
    Method: __construct
            Class constructor
    
    Arguments:
            name - name of the log file
            on - true to enable logging (default to false)
    
    */
    public function __construct($name = "log", $on = false) {
        $this->on = $on;
        if ($this->on) {
            $this->handle = fopen($name, 'ab');
            if ((ftell($this->handle) > self::maxSize) && 
                flock($this->handle, LOCK_EX)) {
                rewind($this->handle);
                ftruncate($this->handle, 0);
                flock($this->handle, LOCK_UN);
            }
        }
    }

    /*
    Method: msg
            Log a message

    Arguments:
            msg - message
    */
    public function msg($msg) {
        if ($this->on && $this->handle && flock($this->handle, LOCK_EX)) {
            fputs($this->handle, date("[d/m/Y H:i:s] - ") . $msg . "\n");
            flock($this->handle, LOCK_UN);
        }
    }

    /*
    Method: __destruct
            Class destructor
    */
    public function __destruct() {
        if ($this->on) fclose($this->handle);
    }
}
?>
