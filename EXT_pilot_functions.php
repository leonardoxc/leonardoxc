<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: EXT_pilot_functions.php,v 1.14 2010/02/03 14:20:52 manolis Exp $                                                                 
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

	


	$op=makeSane($_GET['op']);	

	if ($op=='findPilot'){
		$hash=$_SESSION['sessionHashCode'];
		if ( makeHash('EXT_pilot_functions') != $hash   ) {
			if ( ! $CONF['bugs']['badSessions']) {
				echo "Access Denied";
				return;
			}
		}

		if ($CONF_use_utf) {		
			$CONF_ENCODING='utf-8';
		} else  {		
			$CONF_ENCODING=$langEncodings[$currentlang];
		}

		header('Content-type: application/text; charset="'.$CONF_ENCODING.'"',true);

		$pilotName=stripslashes  ($_GET['q']);
	
		$query="SELECT * FROM $pilotsTable WHERE serverID=0 AND (FirstName LIKE '%$pilotName%' OR LastName LIKE '%$pilotName%' ) LIMIT 15";
		// echo "a|$query|0";
		//return;
		$res= $db->sql_query($query);
		
		if($res <= 0){   
			echo("<H3> Error in query: $query</H3>\n");
			return;			 
		} 
		while($row= $db->sql_fetchrow($res) ){
			if ($row['countryCode']) $flag=	strtolower($row['countryCode']);
			else $flag='unknown';
			
			$flagIcon="<img src='".moduleRelPath()."/img/flags/$flag.gif' border=0> ";
			//$flagIcon="<img class='fl fl.sprite-$tmpLang' src='".moduleRelPath()."/img/space.gif' border=0> ";
			
			if ($row['Sex']=='F') $sexIcon="<img src='".moduleRelPath()."/img/icon_female.gif' border=0> ";
			else $sexIcon='';
			
			
			$name=$row['FirstName'].' '.$row['LastName'];
			$name=str_replace($pilotName,"<b>$pilotName</b>",$name);
			$pilotName=strtoupper($pilotName{0}).substr($pilotName,1);
			$name=str_replace($pilotName,"<b>$pilotName</b>",$name);

			echo $row['FirstName'].' '.$row['LastName'].'|'.$flagIcon.$sexIcon.$name.'|'.$row['serverID'].'u'.$row['pilotID']."\n";
			
		}

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
	}  if ($op=='getExternalPilotInfo'){	
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