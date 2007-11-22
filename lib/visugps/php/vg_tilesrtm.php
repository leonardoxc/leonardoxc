<?php
/*
Script: vg_tilesrtm.php
        Create SRTM tiles for google maps

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

if (isset($_GET['x']) && isset($_GET['y']) && isset($_GET['z'])) {
    $x = (int)$_GET['x'];
    $y = (int)$_GET['y'];
    $z = (int)$_GET['z'];

    require('vg_cache.php');

    $cache = new Cache(CACHE_BASE_FOLDER . CACHE_FOLDER_SRTM, CACHE_NB_SRTM);

    $id = "x=$x&y=$y&z=$z";

    if ($cache->get($data, $id)) {
        header('Content-Type: image/png');
        echo $data;
    } else {

        set_time_limit(0);

        $imgWidth = G_TILE_SIZE;
        $imgHeight = G_TILE_SIZE;
        $image = imagecreate($imgWidth, $imgHeight);

        // Allocate the color map
        InterpolateRGB($colorScale, RGB(  0,   0, 110), RGB(  0,   0, 110),   0, 255);
        InterpolateRGB($colorScale, RGB(  0, 100,   0), RGB(180, 180,  50),   1,  60);
        InterpolateRGB($colorScale, RGB(180, 180,  50), RGB(150, 110,  50),  60, 100);
        InterpolateRGB($colorScale, RGB(150, 110,  50), RGB(150, 150, 150), 100, 150);
        InterpolateRGB($colorScale, RGB(150, 150, 150), RGB(255, 255, 255), 150, 200);
        InterpolateRGB($colorScale, RGB(255, 255, 255), RGB(255, 255, 255), 200, 253);
        InterpolateRGB($colorScale, RGB(  0,   0,   0), RGB(  0,   0,   0), 254, 255);

        AllocateColorMap($image, $colorScale, $cMap);

        MakeTile($image, $x, $y, $z);

        $cache->set(PngToString($image), $id);

        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
} else {
    header('Content-type: text/plain');
    echo('Invalid URL');
}

// Tile handling

function MakeTile($image, $x, $y, $zoom)
{
    $proj = new Mercator($zoom, G_TILE_SIZE);

    $lonL = $proj->Lon($x * G_TILE_SIZE);
    $lonR = $proj->Lon(($x + 1) * G_TILE_SIZE);

    $lonBound[0] = $lonL;

    $nextBound = floor($lonL / SRTM_TILE_SIZE_DEG) * SRTM_TILE_SIZE_DEG + SRTM_TILE_SIZE_DEG;

    for ($i = 1;; $i++) {
        if ($nextBound >= $lonR) break;
        $lonBound[$i] = $nextBound;
        $nextBound += SRTM_TILE_SIZE_DEG;
    }

    $lonBound[$i] = $lonR;

    $latT = $proj->Lat($y * G_TILE_SIZE);
    $latB = $proj->Lat(($y + 1) * G_TILE_SIZE);

    $latBound[0] = $latB;

    $nextBound = floor($latB / SRTM_TILE_SIZE_DEG) * SRTM_TILE_SIZE_DEG + SRTM_TILE_SIZE_DEG;

    for ($j = 1;; $j++) {
        if ($nextBound >= $latT) break;
        $latBound[$j] = $nextBound;
        $nextBound += SRTM_TILE_SIZE_DEG;
    }

    $latBound[$j] = $latT;

    for ($latIdx = 0; $latIdx < $j; $latIdx++) {
        for ($lonIdx = 0; $lonIdx < $i; $lonIdx++) {
            MakeBlock($image, 
                      $lonBound[$lonIdx], $lonBound[$lonIdx + 1], 
                      $latBound[$latIdx], $latBound[$latIdx + 1], 
                      $proj);
        }
    }
}

function MakeBlock($image, $lonL, $lonR, $latB, $latT, $proj)
{
    global $cMap;

    $fileLat = (int)floor($latB / SRTM_TILE_SIZE_DEG) * SRTM_TILE_SIZE_DEG;;
    $startLon = (int)floor($lonL / SRTM_TILE_SIZE_DEG) * SRTM_TILE_SIZE_DEG;
    $startLat  = $fileLat + SRTM_TILE_SIZE_DEG;

    $xL = (int)$proj->X($lonL) % G_TILE_SIZE;
    $xR = (int)($proj->X($lonR) - 1) % G_TILE_SIZE;

    $yT = (int)$proj->Y($latT) % G_TILE_SIZE;
    $yB = (int)($proj->Y($latB) - 1) % G_TILE_SIZE;

    if (($xL == $xR) || ($yT == $yB)) return;

	if (VISUGPS_useHGT) {
			//echo "# $xL $xR $yT $yB $lonL $lonR $latT $latB $fileLat $startLon $startLat";
			$offLonPx = ($lonL - $startLon) * (SRTM_TILE_SIZE_PX - 1) / SRTM_TILE_SIZE_DEG;
			$stepLonPx = ($lonR - $lonL) * (SRTM_TILE_SIZE_PX - 1) / ($xR - $xL) / SRTM_TILE_SIZE_DEG;
	
			$startLatPx = $proj->Y($latT);
			$startLonPx = $proj->X($lonL);

			for ($row = $yT; $row <= $yB; $row++) {
				$lat = $proj->Lat($startLatPx + $row - $yT);
				$offLatPx = ($startLat - $lat) * (SRTM_TILE_SIZE_PX - 1) / SRTM_TILE_SIZE_DEG;
				
				$lonPx = $offLonPx;
				

				
				for ($col = $xL; $col <= $xR; $col++) {
					$lon = $proj->Lon($startLonPx + $col - $xL);
					$elevation = hgt::getHeight($lat, $lon);
					imagesetpixel($image, $col, $row, $cMap[$elevation%256]);
					// echo "($lat, $lon) $col, $row, $elevation<BR>";
					$lonPx = $lonPx + $stepLonPx;
				}
			}
	} else {
		$fName = "strm3_" . $fileLat . "_" . $startLon . ".strmb";
		$handle = @fopen(SRTM_PATH . $fName, "rb");
	
		if ($handle && flock($handle, LOCK_SH)) {
	
			$offLonPx = ($lonL - $startLon) * (SRTM_TILE_SIZE_PX - 1) / SRTM_TILE_SIZE_DEG;
			$stepLonPx = ($lonR - $lonL) * (SRTM_TILE_SIZE_PX - 1) / ($xR - $xL) / SRTM_TILE_SIZE_DEG;
	
			$startLatPx = $proj->Y($latT);
	
			for ($row = $yT; $row <= $yB; $row++) {
				$lat = $proj->Lat($startLatPx + $row - $yT);
				$offLatPx = ($startLat - $lat) * (SRTM_TILE_SIZE_PX - 1) / SRTM_TILE_SIZE_DEG;
				fseek($handle, (int)($offLatPx) * SRTM_TILE_SIZE_PX);
				$line = fread($handle, SRTM_TILE_SIZE_PX);
				$lonPx = $offLonPx;
				for ($col = $xL; $col <= $xR; $col++) {
					$elevation = ord($line[(int)round($lonPx)]);
					imagesetpixel($image, $col, $row, $cMap[$elevation]);
					$lonPx = $lonPx + $stepLonPx;
				}
			}
			fclose($handle);
		} else {
			imagefilledrectangle($image, 0, 0, G_TILE_SIZE - 1, G_TILE_SIZE - 1, $cMap[254]);
		}
	}
}

// Image function
function PngToString($image)
{
  $contents = ob_get_contents();

  if ($contents !== false) ob_clean(); else ob_start();

  imagepng($image);
  $data = ob_get_contents();

  if ($contents !== false)
  {
    ob_clean();
    echo $contents;
  }
  else ob_end_clean();

  return $data;
}

// Coordinate functions
class Mercator {

    private $nbTiles;
    private $radius;
    private $tileSize;

    public function __construct($zoom, $tileSize) {
        $this->nbTiles = pow(2, $zoom);
        $this->tileSize = $tileSize;
        $circumference = $this->tileSize * $this->nbTiles;
        $this->radius =  $circumference / (2 * pi());
    }

    public function X($lonDeg) {
        $lonRad = deg2rad($lonDeg);
        return ($lonRad * $this->radius) + $this->tileSize * ($this->nbTiles / 2);
    }

    public function Lon($x) {
        $lonRad = ($x - $this->tileSize * ($this->nbTiles / 2)) / $this->radius;
        $lonDeg = rad2deg($lonRad);
        return $lonDeg;
    }

    public function Y($latDeg){
        $latRad = deg2rad($latDeg);
        $y = $this->radius / 2.0 * log((1.0 + sin($latRad)) / (1.0 - sin($latRad)));
        return (-1.0 * $y + $this->tileSize * ($this->nbTiles / 2));
    }

    public function Lat($y) {
        $y = -1.0 * ($y - $this->tileSize * ($this->nbTiles / 2));
        $latRad = (pi() / 2) - (2 * atan(exp(-1.0 * $y / $this->radius)));
        return rad2deg($latRad);
    }

}


// Color handling functions
function RGB($r, $g, $b) { return array($r, $g, $b);}

function AllocateColorMap($image, $array, &$colorMap) {
    for ($index = 0; $index < count($array); $index++) {
        $colorMap[$index] = imagecolorallocate($image,
                                               $array[$index]['R'],
                                               $array[$index]['G'],
                                               $array[$index]['B']);
    }
}

function InterpolateRGB(&$array, $startRGB, $endRGB, $startIdx, $endIdx)
{
    InterpolateArray($rArray, $startRGB[0], $endRGB[0], $startIdx, $endIdx);
    InterpolateArray($gArray, $startRGB[1], $endRGB[1], $startIdx, $endIdx);
    InterpolateArray($bArray, $startRGB[2], $endRGB[2], $startIdx, $endIdx);

    for ($index = $startIdx; $index < $endIdx; $index++) {
        $array[$index]['R'] = $rArray[$index];
        $array[$index]['G'] = $gArray[$index];
        $array[$index]['B'] = $bArray[$index];
    }
}

function InterpolateArray(&$array, $startVal, $endVal, $startIdx, $endIdx)
{
    if ($endIdx <= $startIdx) return;

    $step = ($endVal - $startVal) / ($endIdx - $startIdx);

    for ($index = $startIdx; $index < $endIdx; $index++) {
        $array[$index] = (int)round($startVal);
        $startVal += $step;
    }

    $array[$endIdx] = $endVal;
}

// Debug Log
function DebugLog($msg)
{
    global $image, $cMap, $imgHeight;
    static $y = 260;
    if ($y >= $imgHeight) return;
    imagestring($image, 5, 5, $y, $msg, $cMap[100]);
    $y += 15;
}

?>
