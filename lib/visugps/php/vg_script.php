<?php
/*
Script: vg_script.php
        Merge .JS files together to limit the number of server requests

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

require('vg_cfg.php');
require('jsmin-1.1.0.php');

define('SCRIPT_FILE', CACHE_BASE_FOLDER . 'scripts.js');

// JS folder
$jsFiles = array( 'js/visugps/charts.js',
                  'js/visugps/sliderprogress.js',
                  'js/visugps/visugps.js',
                  'js/chart/canvaschartpainter.js',
                  'js/chart/chart.js',
                  'js/chart/excanvas.js');

// Script
$script = '';

$copyright = <<<EOD
/*
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

Credits:
        - This script uses a modified version of chart by WebFX.
          <http://webfx.eae.net/dhtml/chart/chart.html>
        - Some code is inspired from by the Google Maps API tutorial of
          Mike Williams <http://www.econym.demon.co.uk/googlemaps/index.htm>

*/
EOD;

if (VISUGPS_DEV) {
    // Always merge files in the development version
    foreach ($jsFiles as $file) {
        $script = $script . file_get_contents(PJT_FOLDER_FROM_PHP . $file) . "\n";
    }
} else {
    // Create the cache folder when it does not exist
    if (!is_dir(CACHE_BASE_FOLDER)) mkdir(CACHE_BASE_FOLDER, 0700, true);
    // Check if the cached version is older than any of the source files
    $cacheTime = getFileTime(SCRIPT_FILE);
    $outdated = false;
    foreach ($jsFiles as $file) {
        if (getFileTime(PJT_FOLDER_FROM_PHP . $file) > $cacheTime) {
            $outdated = true;
            break;
        }
    }

    if ($outdated) {
        // Regenerate the outdated cache file
        foreach ($jsFiles as $file) {
            $script = $script . file_get_contents(PJT_FOLDER_FROM_PHP . $file) . "\n";
        }
        $script = $copyright . JSMin::minify($script);
        file_put_contents(SCRIPT_FILE, $script, LOCK_EX);
    } else {
        // Use the up to date version when it exists
        $script = file_get_contents(SCRIPT_FILE);
    }
}

header('Content-type: text/javascript');
echo $script;

function getFileTime($file) {
    if (file_exists($file)) return filemtime($file);
    return 0;
}

?>
