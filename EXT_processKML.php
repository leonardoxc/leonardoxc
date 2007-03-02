<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

 	require_once "EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	require_once "FN_pilot.php";
	require_once "FN_flight.php";
	setDEBUGfromGET();

	$op=makeSane($_REQUEST['op']);
	if (!$op) $op="getKML";	

	if (!in_array($op,array("getKML")) ) return;

	$encoding="iso-8859-1";

	if ($op=="getKML") {
		require_once dirname(__FILE__).'/lib/miniXML/minixml.inc.php';
		$XML_str="<result>\n";
		$XML_path=$_GET['KMLfile'];
		$XML_str.="<debug>Processing $XML_path</debug>\n";
echo "Processing $XML_path<br>";

$foundPoints=0;
		$linesArray=file($XML_path);
		$lines=implode(" ",$linesArray);

		preg_match_all("/<Folder>(.*)<\/Folder>/isU",$lines,$folders);
		foreach($folders[1] as $folder) {
			preg_match("/<name>(.*)<\/name>/isU",$folder,$folderNameRes);
			$folderName=$folderNameRes[1];
			//echo "<br>### doing folder : $folderName <br>";
			preg_match_all("/<Placemark>(.*)<\/Placemark>/isU",$folder,$placemarks);

			foreach($placemarks[1] as $placemark) {
				if (preg_match("/<name>(.*)<\/name>.*<Point.*>.*<coordinates>(.*),(.*),(.*)<\/coordinates>.*<\/Point>/isU",$placemark,$info)) {
					//echo "<hr>name=".$info[1].", lat=".$info[2].", lon=".$info[3].", alt=".$info[4]."<hr>";
				$foundPoints++;
				}
			}
		}

		echo "Found $foundPoints points<br>";
$foundPoints =0;
		require_once dirname(__FILE__).'/lib/miniXML/minixml.inc.php';
		$parsedDoc = new MiniXMLDoc();
		$parsedDoc->fromString($lines);
		$rootEl =& $parsedDoc->getRoot();

		procElement($rootEl->getElementByPath("kml") );

//$mainFolder=$rootEl->getElementByPath("Folder");
//$elChildren =& $mainFolder->getAllChildren();
			echo "Found $foundPoints points<br>";

	}

function procElement(&$el,$folderName="",$depth=1)
{
global $foundPoints ;
	$elChildren =& $el->getAllChildren();
	
//	echo "element has ".$el->numChildren()." childs, we are at depth: $depth<br>";

	for($i = 0; $i < $el->numChildren(); $i++)
	{	
		if ($elChildren[$i]->name() =="Placemark" ) {
			$pl_name=$elChildren[$i]->getElementByPath("name");
			$parent_name=$el->getElementByPath("name");
			echo  "@@ ".$parent_name->getValue()." : ".$pl_name->getValue() ."<br>";
			$foundPoints ++;
		} else {
			procElement(&$elChildren[$i],"",$depth+1);
		}	

	}
}

	function send_XML($XML_str) {
		if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
			header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
		else header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
		header ('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
		header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header ('Content-Type: text/xml');
		echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>\n";
		echo $XML_str;	
	}
?>