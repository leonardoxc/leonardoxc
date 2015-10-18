<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: EXT_pilot_functions.php,v 1.20 2012/09/17 22:33:49 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	require_once "FN_pilot.php";
	require_once "FN_flight.php";
	require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();

function cmp($a0, $b0)
{
	$a=$a0['score'];
	$b=$b0['score'];
	if ($a == $b) {
		return 0;
	}
	return ($a < $b) ? -1 : 1;
}

	$op=makeSane($_GET['op']);	

	if ($op=='findPilot'){
		$hash=$_SESSION['sessionHashCode'];
		if ( makeHash('EXT_pilot_functions') != $hash   ) {
			if ( ! $CONF['bugs']['badSessions']) {
				echo "Access Denied";
				return;
			}
		}

		require_once dirname(__FILE__).'/lib/json/CL_json.php';
		
		if ($CONF_use_utf) {		
			$CONF_ENCODING='utf-8';
		} else  {		
			$CONF_ENCODING=$langEncodings[$currentlang];
		}

		// header('Content-type: application/text; charset="'.$CONF_ENCODING.'"',true);

		$pilotName0=stripslashes($_GET['q']);
		$pilotName0=trim($pilotName0);
		
		$pilotName=str_replace(" ", "%",$pilotName0);

		/*
		$parts=explode(" ",$pilotName );
		foreach ($parts as $part ) {
			
			
		}
	
		$nameDistanceFromPrevious1=levenshtein (strtolower($lastIntName),strtolower($row2['intName'])); 
		similar_text (strtolower($lastIntName),strtolower($row2['intName']),&$nameDistanceFromPrevious2); 
			*/		
					
		$query="SELECT * FROM $pilotsTable WHERE 
			serverID=0 AND 
			(	FirstName LIKE '%$pilotName%' OR 
				LastName LIKE '%$pilotName%' OR 
				CONCAT(FirstName,' ',LastName) LIKE  '%$pilotName%'  OR 
				CONCAT(LastName,' ',FirstName) LIKE  '%$pilotName%'
			) 
			LIMIT 200";
		
		// echo "a|$query|0";
		//return;
		$res= $db->sql_query($query);
		
		if($res <= 0){   
			echo("<H3> Error in query: $query</H3>\n");
			return;			 
		}
		$pilots=array();
		while($row= $db->sql_fetchrow($res) ){
			if ($row['countryCode']) $flag=	strtolower($row['countryCode']);
			else $flag='unknown';
			
			$flagIcon="<img src='".moduleRelPath()."/img/fl/$flag.gif' border=0> ";
			//$flagIcon="<img class='fl fl.sprite-$tmpLang' src='".moduleRelPath()."/img/space.gif' border=0> ";
			
			if ($row['Sex']=='F') $sexIcon="<img src='".moduleRelPath()."/img/icon_female.gif' border=0> ";
			else $sexIcon='';
			
			
			$name=$row['FirstName'].' '.$row['LastName'];
			$name=str_replace($pilotName,"<b>$pilotName</b>",$name);
			$pilotName=strtoupper($pilotName{0}).substr($pilotName,1);
			$name=str_replace($pilotName,"<b>$pilotName</b>",$name);

			$pilotName0=strtolower($pilotName0);
			
			$d1=levenshtein ($pilotName0,strtolower($row['FirstName'].' '.$row['LastName'] )  ); 
			$d2=levenshtein ($pilotName0,strtolower($row['LastName'].' '.$row['FirstName'])); 
			$d3=levenshtein ($pilotName0,strtolower($row['FirstName'])); 
			$d4=levenshtein ($pilotName0,strtolower($row['LastName']));

			$dmax=max(array($d1,$d2,$d3,$d4));
			// similar_text (strtolower($lastIntName),strtolower($row2['intName']),&$nameDistanceFromPrevious2);

	
			$html=$row['FirstName'].' '.$row['LastName'].'|'.$flagIcon.$sexIcon.$name.'|'.$row['serverID'].'u'.$row['pilotID']."\n";
			
			$serverIDview=$row["serverID"];
			$pilotIDview=$row["pilotID"];
			$photo='';	
			if ($row['PilotPhoto']>0) {
		
				//checkPilotPhoto($serverIDview,$pilotIDview);
	     		$imgBigRel=getPilotPhotoRelFilename($serverIDview,$pilotIDview);	
				$imgBig=getPilotPhotoFilename($serverIDview,$pilotIDview);	
				// echo $imgBig."<BR>";
				list($width, $height, $type, $attr) = getimagesize($imgBig);
				
				//echo $imgBig."  $CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height <br>";
				list($width, $height)=CLimage::getJPG_NewSize($CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height);
				
				
				$photo="<a href='$imgBigRel' target='_blank'><img src='".getPilotPhotoRelFilename($serverIDview,$pilotIDview,1)."'
			onmouseover=\"trailOn('$imgBigRel','','','','','','1','$width','$height','','.');\" onmouseout=\"hidetrail();\" 
			 border=0></a>";					
				
				$photo="<img src='".getPilotPhotoRelFilename($serverIDview,$pilotIDview,1)."'>";
			}
			if( $_GET['json'] ){
				$photo=json::prepStr($photo);
			}
			if ($_GET['json']) {
				$json=' { "firstName":"'.json::prepStr($row["FirstName"]).'", "lastName":"'.json::prepStr($row["LastName"]).'", '.
			' "name":"'.json::prepStr($name).'",'.
			' "flag":"'.json::prepStr($flagIcon).'",'.
			' "photo":"'.$photo.'", '.
			' "sex":"'.json::prepStr($sexIcon).'", "userID":"'.json::prepStr($row["serverID"].'u'.$row["pilotID"]).'" } ';
			} else {
				$jsom='';
			}
		    $pilots[]=array("score"=>$dmax,"text"=>$html,"json"=>$json);
			
			
		}

		
		usort($pilots, "cmp");
		
		$i=0;
		$count=$_GET['count'];
		if (!$count) $count=15;
		
		if ($_GET['json']) {
			echo ' { "pilots":[ ';
		}
		foreach ($pilots as $pilot) {
			if ($_GET['json']) {
				if ( $i>0) echo " ,\n";
				echo $pilot['json'];
			} else {
		    	echo $pilot['text'];
			}	
		    $i++;
		    if ($i>$count) break;
		}

		if ($_GET['json']) {
			echo "]} ";
		}
		return;

	}

if ($op=='findFriends'){
	$hash=$_SESSION['sessionHashCode'];
	if ( makeHash('EXT_pilot_functions') != $hash   ) {
		if ( ! $CONF['bugs']['badSessions']) {
			echo "Access Denied";
			return;
		}
	}

	require_once dirname(__FILE__).'/lib/json/CL_json.php';

	if ($CONF_use_utf) {
		$CONF_ENCODING='utf-8';
	} else  {
		$CONF_ENCODING=$langEncodings[$currentlang];
	}

	// header('Content-type: application/text; charset="'.$CONF_ENCODING.'"',true);

	$pilotName0=stripslashes($_GET['q']);
	$pilotName0=trim($pilotName0);

	$pilotName=str_replace(" ", "%",$pilotName0);

	/*
    $parts=explode(" ",$pilotName );
    foreach ($parts as $part ) {


    }

    $nameDistanceFromPrevious1=levenshtein (strtolower($lastIntName),strtolower($row2['intName']));
    similar_text (strtolower($lastIntName),strtolower($row2['intName']),&$nameDistanceFromPrevious2);
        */

	$query="SELECT * FROM $pilotsTable WHERE
			serverID=0 AND
			(	FirstName LIKE '%$pilotName%' OR
				LastName LIKE '%$pilotName%' OR
				CONCAT(FirstName,' ',LastName) LIKE  '%$pilotName%'  OR
				CONCAT(LastName,' ',FirstName) LIKE  '%$pilotName%'
			)
			LIMIT 200";

	// echo "a|$query|0";
	//return;
	$res= $db->sql_query($query);

	if($res <= 0){
		echo("<H3> Error in query: $query</H3>\n");
		return;
	}
	$pilots=array();
	while($row= $db->sql_fetchrow($res) ){
		if ($row['countryCode']) $flag=	strtolower($row['countryCode']);
		else $flag='unknown';

		$flagIcon="<img src='".moduleRelPath()."/img/fl/$flag.gif' border=0> ";
		//$flagIcon="<img class='fl fl.sprite-$tmpLang' src='".moduleRelPath()."/img/space.gif' border=0> ";

		if ($row['Sex']=='F') $sexIcon="<img src='".moduleRelPath()."/img/icon_female.gif' border=0> ";
		else $sexIcon='';


		$name=$row['FirstName'].' '.$row['LastName'];
		$name=str_replace($pilotName,"<b>$pilotName</b>",$name);
		$pilotName=strtoupper($pilotName{0}).substr($pilotName,1);
		$name=str_replace($pilotName,"<b>$pilotName</b>",$name);

		$pilotName0=strtolower($pilotName0);

		$d1=levenshtein ($pilotName0,strtolower($row['FirstName'].' '.$row['LastName'] )  );
		$d2=levenshtein ($pilotName0,strtolower($row['LastName'].' '.$row['FirstName']));
		$d3=levenshtein ($pilotName0,strtolower($row['FirstName']));
		$d4=levenshtein ($pilotName0,strtolower($row['LastName']));

		$dmax=max(array($d1,$d2,$d3,$d4));
		// similar_text (strtolower($lastIntName),strtolower($row2['intName']),&$nameDistanceFromPrevious2);


		$html=$row['FirstName'].' '.$row['LastName'].'|'.$flagIcon.$sexIcon.$name.'|'.$row['serverID'].'u'.$row['pilotID']."\n";

		$serverIDview=$row["serverID"];
		$pilotIDview=$row["pilotID"];
		$photo='';
		if ($row['PilotPhoto']>0) {

			//checkPilotPhoto($serverIDview,$pilotIDview);
			$imgBigRel=getPilotPhotoRelFilename($serverIDview,$pilotIDview);
			$imgBig=getPilotPhotoFilename($serverIDview,$pilotIDview);
			// echo $imgBig."<BR>";
			list($width, $height, $type, $attr) = getimagesize($imgBig);

			//echo $imgBig."  $CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height <br>";
			list($width, $height)=CLimage::getJPG_NewSize($CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height);


			$photo="<a href='$imgBigRel' target='_blank'><img src='".getPilotPhotoRelFilename($serverIDview,$pilotIDview,1)."'
			onmouseover=\"trailOn('$imgBigRel','','','','','','1','$width','$height','','.');\" onmouseout=\"hidetrail();\"
			 border=0></a>";

			$photo="<img src='".getPilotPhotoRelFilename($serverIDview,$pilotIDview,1)."'>";
		}
		if( $_GET['json'] ){
			$photo=json::prepStr($photo);
		}
		if ($_GET['json']) {
			$json=' { "firstName":"'.json::prepStr($row["FirstName"]).'", "lastName":"'.json::prepStr($row["LastName"]).'", '.
				' "name":"'.json::prepStr($name).'",'.
				' "flag":"'.json::prepStr($flagIcon).'",'.
				' "photo":"'.$photo.'", '.
				' "sex":"'.json::prepStr($sexIcon).'", "userID":"'.json::prepStr($row["serverID"].'u'.$row["pilotID"]).'" } ';
		} else {
			$jsom='';
		}
		//$pilots[]=array("score"=>$dmax,"text"=>$html,"json"=>$json);
		$pilots[]=array("id"=>$pilotIDview, "name"=>$name,"score"=>$dmax);

	}

	if (count($pilots)>0) {

		usort($pilots, "cmp");

		$i=0;
		$count=$_GET['count'];
		if (!$count) $count=15;
		foreach ($pilots as $pilot) {
			$pilotsFinal[]=$pilot;
			$i++;
			if ($i>$count) break;
		}
	} else {
		$pilotsFinal=array();
	}
	echo json_encode($pilotsFinal);
	return;


}

if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }

	if ($op=='mapPilot'){	
			$pilotID1=makeSane($_GET['pilotID1'],0);
			$pilotID2=makeSane($_GET['pilotID2'],0);

		  list($serverID1,$userID1)=explode('_',$pilotID1);
		  list($serverID2,$userID2)=explode('_',$pilotID2);
		  $query="INSERT INTO $remotePilotsTable (remoteServerID,remoteUserID,serverID,userID) VALUES 
		  			($serverID1,$userID1,$serverID2,$userID2 )";
		  $res= $db->sql_query($query);
		  if($res <= 0){   
			 echo("<H3> Error in mapping pilots: $query</H3>\n");
		  } else echo "Pilot Mapping successfull";
	} else if ($op=='copyRemoteToLocalInfo'){		  
		    $pilotID1=makeSane($_GET['pilotID1'],0);
		    $pilotID2=makeSane($_GET['pilotID2'],0);
			
			$serverID1=makeSane($_GET['serverID1'],0);
			$serverID2=makeSane($_GET['serverID2'],0);
			require_once "CL_pilot.php";

			echo "Copying Pilot Info from $serverID1  $pilotID1 -> $serverID2 $pilotID2<br>";
			$pilot1=new pilot($serverID1,$pilotID1);
			$pilot1->getFromDB();
			
			$pilot1->pilotID=$pilotID2;
			$pilot1->serverID=$serverID2;
			
			$res=$pilot1->putToDB1(1);
			echo "Res:$res<BR>";
			
	} else if ($op=='movePilotFlights'){	
			$pilotID1=makeSane($_GET['pilotID1'],0);
			$pilotID2=makeSane($_GET['pilotID2'],0);
			
			$serverID1=makeSane($_GET['serverID1'],0);
			$serverID2=makeSane($_GET['serverID2'],0);

			echo "moving flights from $serverID1  $pilotID1 -> $serverID2 $pilotID2 ";
			
			require_once "CL_pilot.php";
			
			$pilot=new pilot($serverID1,$pilotID1);
			$res=$pilot->movePilotFlights($serverID2,$pilotID2);
			
			echo "Res:$res<BR>";
		  	return;
		  
	} else  if ($op=='getExternalPilotInfo'){	
		//$pilotID1=makeSane($_GET['pilotID'],0);
		//list($serverID1,$userID1)=explode('_',$pilotID1);
		
		$serverIDview=makeSane($_GET['serverID'],0);
		$pilotIDview=makeSane($_GET['pilotID'],0);
		
		if ( $serverIDview==0) { 
			$serverIDview=$CONF_server_id;
		}
		require_once dirname(__FILE__)."/CL_server.php";				
		$server=new Server($serverIDview);
		
		// set to 1 for debug
		if ($DBGlvl) $server->DEBUG=1;
		$pilotList=$server->getPilots( $pilotIDview );
		
		//echo $pilotInfo;
		//echo "#$serverIDview,$pilotIDview#<BR>";
		$pilotInfo=$pilotList[0];
		echo "<pre>";
			echo $CONF['servers']['list'][ $serverIDview ]['name'] ."\n";
		
			echo $CONF['servers']['list'][ $pilotInfo['serverID'] ]['name'] .
					"\n----------------------------\n";
			;
			print_r($pilotInfo);		
		echo "</pre>";
		
		if ($_GET['updateData']>0) {
		
			$pilot=new pilot($serverIDview,$pilotIDview);
			
			if ($_GET['updateData']!=2) {
				$pilot->getFromDB();
			}	
			
			if ($DBGlvl) {
				echo "<pre>";
				echo "-----------------------\n";
				print_r($pilot);
			}
			foreach($pilotInfo as $varName=>$varValue) {
				if ( in_array($varName,$pilot->valuesArray) ) {
					$pilot->$varName=$varValue;
				}
			}
			if ($DBGlvl) {
				echo "-----------------------\n";
				print_r($pilot);
				echo "</pre>";
			}	
			if ( $pilot->putToDB(1) ) {
				echo "<span class='ok'>Pilot data updated OK</span>";
			} else {
				echo "<span class='note'>Problem in updating pilot data</span>";
			}	
		}
	}
	

?>