<?php
/*
Script: vg_cfg.php
        VisuGps server side configuration

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

	require_once dirname(__FILE__).'/../../../config.php';
	require_once dirname(__FILE__).'/../../json/CL_json.php';

    // Development version (cache off, easier debugging)
    define('VISUGPS_DEV', true);

    define('VISUGPS_useHGT', true);
	if (VISUGPS_useHGT) 
		require_once dirname(__FILE__).'/../../../CL_hgt.php';


    // Google maps tile size (pixels)
    define('G_TILE_SIZE', 256);
    
    // PHP folder to PJT folder
    define('PJT_FOLDER_FROM_PHP', $CONF_abs_path.'/'); //from leonardo
    
    // SRTM tile size (pixels)
    define('SRTM_TILE_SIZE_PX', 6000);
    // SRTM tile size (degre)
    define('SRTM_TILE_SIZE_DEG', 5);
    // Path to SRTM files
    define('SRTM_PATH', '../data/srtm/'); // we dont use that 

    // CACHE settings
    define('CACHE_BASE_FOLDER', '../cache/');

    if (VISUGPS_DEV) {
        define('CACHE_ENABLED', false);
    } else {
        define('CACHE_ENABLED', true);
    }

    // SRTM tiles cache folder
    define('CACHE_FOLDER_SRTM', 'cache_srtm/');
    // SRTM tiles cache size
    define('CACHE_NB_SRTM', 1000);

    // MODIS tiles cache folders
    define('CACHE_FOLDER_MODIST', 'cache_modis/tile/');
    define('CACHE_FOLDER_MODISS', 'cache_modis/src/');
    // MODIS cache sizes
    define('CACHE_NB_MODISS', 50);
    define('CACHE_NB_MODIST', 1000);


    // Track cache folder
    define('CACHE_FOLDER_TRACK', 'cache_track/');
    // Track cache size
    define('CACHE_NB_TRACK', 100);

    // Chart size
    define('CHART_NBLBL', 5);
    define('CHART_NBPTS', 800);

?>