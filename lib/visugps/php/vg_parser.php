<?php
/*
Script: vg_parser.php
        GPS track file parsers.

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
    - Some of GPX, NMEA and TRK parsing routines are from Emmanuel Chabani <mans@parawing.net>
*/

/*
Function: ParseIgc
        Parse a GPS track - IGC format
        
Arguments:
        trackFile - input track file
        trackData - output track (associative array)
        
Returns:
        The number of points of the track.
        0 if the track format is not recognized
*/
function ParseIgc($trackFile, &$trackData)
{
    // Regexp fields
    define('IGC_hour', 1);
    define('IGC_min', 2);
    define('IGC_sec', 3);
    define('IGC_latE', 4);
    define('IGC_latD', 5);
    define('IGC_latS', 6);
    define('IGC_lonE', 7);
    define('IGC_lonD', 8);
    define('IGC_lonS', 9);
    define('IGC_elevP', 10);
    define('IGC_elevG', 11);

    if (preg_match('/HFDTE(\d{2})(\d{2})(\d{2})/mi', $trackFile, $m)) {
        $trackData['date']['day'] = intval($m[1]);
        $trackData['date']['month'] = intval($m[2]);
        $trackData['date']['year'] = intval($m[3]) + (($m[3] > 60)?1900:2000);
    }

    if (preg_match('/HFPLTPILOT:([\x20-\x7e\x80-\xfe]+)/mi', $trackFile, $m)) {
        $trackData['pilot'] = htmlentities(trim($m[1]));
    }

    preg_match_all('/B(\d{2})(\d{2})(\d{2})(\d{2})(\d{5})(\w)(\d{3})(\d{5})(\w).(\d{5})(\d{5})/im',
                   $trackFile, $m);

    $nbPts = $trackData['nbPt'] = count($m[0]);

    if ($nbPts > 5) {
        // Extract latitude, longitude, altitudes and time in second
        for ($i = 0; $i < $nbPts; $i++) {
            $m[IGC_latD][$i] = ("0." . $m[IGC_latD][$i]) * 100 / 60;
            $m[IGC_lonD][$i] = ("0." . $m[IGC_lonD][$i]) * 100 / 60;
            $trackData['lat'][$i] = ($m[IGC_latE][$i] + $m[IGC_latD][$i]) * (strtoupper($m[IGC_latS][$i]) == 'N'?1:-1);
            $trackData['lon'][$i] = ($m[IGC_lonE][$i] + $m[IGC_lonD][$i]) * (strtoupper($m[IGC_lonS][$i]) == 'E'?1:-1);
            $trackData['elev'][$i] = intval($m[IGC_elevG][$i]);
            $trackData['time']['hour'][$i] = intval($m[IGC_hour][$i]);
            $trackData['time']['min'][$i] = intval($m[IGC_min][$i]);
            $trackData['time']['sec'][$i] = intval($m[IGC_sec][$i]);
        }
    }
    return $nbPts;
}

/*
Function: ParseOzi
        Parse a GPS track - OziExplorer PLT format

Arguments:
        trackFile - input track file
        trackData - output track (associative array)

Returns:
        The number of points of the track.
        0 if the track format is not recognized
*/
function ParseOzi($trackFile, &$trackData)
{
    // Regexp fields
    define('OZI_lat', 1);
    define('OZI_lon', 2);
    define('OZI_elev', 3);
    define('OZI_date', 4);

    if (!preg_match('/OziExplorer/i', $trackFile, $m)) {
        return 0;
    }

    preg_match_all('/^\s+([-\d\.]+)[,\s]+([-\d\.]+)[,\s]+[01][,\s]+([-\d\.]+)[,\s]+([\d\.]+).*$/im',
                   $trackFile, $m);

    $nbPts = $trackData['nbPt'] = count($m[0]);

    if ($nbPts > 5) {
        // Extract latitude, longitude, altitudes and time in second
        for ($i = 0; $i < $nbPts; $i++) {
            $trackData['lat'][$i] = floatval($m[OZI_lat][$i]);
            $trackData['lon'][$i] = floatval($m[OZI_lon][$i]);
            $trackData['elev'][$i] = max(intval($m[OZI_elev][$i] * 0.3048), 0);

            $time = floatval($m[OZI_date][$i]) - intval($m[OZI_date][$i]);
            $time = $time * 24;
            $hour = intval($time);
            $time = ($time - $hour) * 60;
            $min = intval($time);
            $time = ($time - $min) * 60;
            $sec = intval($time);
            $trackData['time']['hour'][$i] = $hour;
            $trackData['time']['min'][$i] = $min;
            $trackData['time']['sec'][$i] = $sec;
        }
    $date = date_create();
    date_date_set($date, 1980, 1, 1);
    date_modify($date, '+' . (intval($m[OZI_date][0]) - 29221) . ' days');
    $trackData['date']['day'] = intval(date_format($date, 'j'));
    $trackData['date']['month'] = intval(date_format($date, 'n'));
    $trackData['date']['year'] = intval(date_format($date, 'Y'));

    }
    return $nbPts;
}

/*
Function: ParseTrk
        Parse a GPS track - TRK format

Arguments:
        trackFile - input track file
        trackData - output track (associative array)

Returns:
        The number of points of the track.
        0 if the track format is not recognized
*/
function ParseTrk($trackFile, &$trackData)
{
    // Regexp fields
    define('TRK_lat', 1);
    define('TRK_latS', 2);
    define('TRK_lon', 3);
    define('TRK_lonS', 4);
    define('TRK_day', 5);
    define('TRK_month', 6);
    define('TRK_year', 7);                
    define('TRK_hour', 8);
    define('TRK_min', 9);
    define('TRK_sec', 10);
    define('TRK_elev', 11);

    preg_match_all('/^T\s+A\s+([0-9\.]+).(\w)\s+([0-9\.]+).(\w)\s+(\d{2})-(JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)-(\d{2})\s+(\d{2}):(\d{2}):(\d{2})\s+.\s+(\d+)/im',
                   $trackFile, $m);

    $nbPts = $trackData['nbPt'] = count($m[0]);

    if ($nbPts > 5) {
        // Extract latitude, longitude, altitudes and time in second
        for ($i = 0; $i < $nbPts; $i++) {
            $trackData['lat'][$i] = ($m[TRK_lat][$i]) * (strtoupper($m[TRK_latS][$i]) == 'N'?1:-1);
            $trackData['lon'][$i] = ($m[TRK_lon][$i]) * (strtoupper($m[TRK_lonS][$i]) == 'E'?1:-1);
            $trackData['elev'][$i] = intval($m[TRK_elev][$i]);
            $trackData['time']['hour'][$i] = intval($m[TRK_hour][$i]);
            $trackData['time']['min'][$i] = intval($m[TRK_min][$i]);
            $trackData['time']['sec'][$i] = intval($m[TRK_sec][$i]);
        }

        $months = array('JAN' => 1, 'FEB' => 2, 'MAR' => 3, 'APR' => 4, 'MAY' => 5, 'JUN' => 6, 
                        'JUL' => 7, 'AUG' => 8, 'SEP' => 9, 'OCT' => 10, 'NOV' => 11, 'DEC' => 12);
        $trackData['date']['day'] = intval($m[TRK_day][0]);             
        $trackData['date']['month'] = $months[strtoupper($m[TRK_month][0])];
        $trackData['date']['year'] = intval($m[TRK_year][0]) + (($m[TRK_year][0] > 60)?1900:2000);           
        
    }
    return $nbPts;
}

/*
Function: ParseNmea
        Parse a GPS track - NMEA format

Arguments:
        trackFile - input track file
        trackData - output track (associative array)

Returns:
        The number of points of the track.
        0 if the track format is not recognized
*/
function ParseNmea($trackFile, &$trackData)
{
    // Regexp fields
    define('NMEA_hour', 1);
    define('NMEA_min', 2);
    define('NMEA_sec', 3);
    define('NMEA_lat', 4);
    define('NMEA_latS', 5);
    define('NMEA_lon', 6);
    define('NMEA_lonS', 7);
    define('NMEA_elev', 8);

    if (preg_match('/^\$GPRMC,\d+,.,[\d\.]+,.,[\d\.]+,.,[\d\.]+,[\d\.]+,(\d{2})(\d{2})(\d{2})/mi', $trackFile, $m)) {
        $trackData['date']['day'] = intval($m[1]);
        $trackData['date']['month'] = intval($m[2]);
        $trackData['date']['year'] = intval($m[3]) + (($m[3] > 60)?1900:2000);
    }

    preg_match_all('/^\$GPGGA,(\d{2})(\d{2})(\d{2})[\d\.]*,([\d\.]+),(\w),([\d\.]+),(\w),\d+,\d+,[\d\.]+,([\d\.]+)/im',
                   $trackFile, $m);

    $nbPts = $trackData['nbPt'] = count($m[0]);

    if ($nbPts > 5) {
        // Extract latitude, longitude, altitudes and time in second
        for ($i = 0; $i < $nbPts; $i++) {
            $lonDeg= intval($m[NMEA_lon][$i] / 100);
            $lonMin= $m[NMEA_lon][$i] - $lonDeg * 100;
            $latDeg= intval($m[NMEA_lat][$i] / 100);
            $latMin= $m[NMEA_lat][$i] - $latDeg * 100;
            $trackData['lat'][$i] = ($latDeg + $latMin / 60) * (strtoupper($m[NMEA_latS][$i]) == 'N'?1:-1);
            $trackData['lon'][$i] = ($lonDeg + $lonMin / 60) * (strtoupper($m[NMEA_lonS][$i]) == 'E'?1:-1);
            $trackData['elev'][$i] = intval($m[NMEA_elev][$i]);
            $trackData['time']['hour'][$i] = intval($m[NMEA_hour][$i]);
            $trackData['time']['min'][$i] = intval($m[NMEA_min][$i]);
            $trackData['time']['sec'][$i] = intval($m[NMEA_sec][$i]);
        }
    }
    return $nbPts;
}

/*
Function: ParseGpx
        Parse a GPS track - GPX format

Arguments:
        trackFile - input track file
        trackData - output track (associative array)

Returns:
        The number of points of the track.
        0 if the track format is not recognized
*/
function ParseGpx($trackFile, &$trackData) 
{

    if (!($xml = @simplexml_load_string($trackFile))) return 0;

    if (!isset($xml->trk[0]->trkseg[0]->trkpt[0])) return 0;

    $dateSet = false;
    $i = $ptLat = $ptLon = $ptElev = $ptHour = $ptMin = $ptSec = 0;

    $trkIdx = $gpsTrkIdx = 0;
    foreach ($xml->trk as $track) {
        if (isset($track->name) &&
            (strtoupper($track->name) === 'GNSSALTTRK')) {
            $gpsTrkIdx = $trkIdx;
            break;
        }
        $trkIdx++;
    }
    
    foreach ($xml->trk[$gpsTrkIdx]->trkseg as $trackSeg) {
        foreach ($trackSeg->trkpt as $trackPt) {
            $atr = $trackPt->attributes();
            if (isset($atr->lat)) $ptLat = floatval($atr->lat);
            if (isset($atr->lon)) $ptLon = floatval($atr->lon);                 

            if (isset($trackPt->ele)) $ptElev = round($trackPt->ele);
            if (isset($trackPt->time)) {
                if (preg_match('/(\d{2}):(\d{2}):(\d{2})/', $trackPt->time, $m)) {
                    $ptHour = intval($m[1]);
                    $ptMin = intval($m[2]);
                    $ptSec = intval($m[3]);
                }
                if (!$dateSet &&
                    preg_match('/(\d{4})-(\d{2})-(\d{2})/', $trackPt->time, $m)) {
                    $dateSet = true;
                    $trackData['date']['year'] = intval($m[1]);
                    $trackData['date']['month'] = intval($m[2]);
                    $trackData['date']['day'] = intval($m[3]);
                }
            }
            $trackData['lat'][$i] = $ptLat;
            $trackData['lon'][$i] = $ptLon;
            $trackData['elev'][$i] = $ptElev;
            $trackData['time']['hour'][$i] = $ptHour;
            $trackData['time']['min'][$i] = $ptMin;
            $trackData['time']['sec'][$i] = $ptSec;
            $i++;
        }
    }

    $trackData['nbPt'] = $i;
    
    return $i;
}

/*
Function: IsKml
        Detect KML file format

Arguments:
        trackFile - input track file

Returns:
        true if the file is a valid KML file
*/
function IsKml($trackFile)
{
    return (preg_match('/xmlns *= *"http:\/\/earth\.google\.com\/kml\/[\d\.]+/im', $trackFile) > 0);
}

?>