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
// $Id: flight_submit.php,v 1.24 2010/09/10 13:31:47 manolis Exp $                                                                 
//
//************************************************************************

if (0) {
	echo"Wegen Server Wartung können Flüge derzeit nicht zum DHVXC Server hinzugefügt werden.<br>
			Flights can currently not be uploaded to the DHVXC Server due to a hardware upgrade. ";
	return;
}
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
	setDEBUGfromGET();
	// $DBGlvl=255;
	echo "<html><body>";
	if (! $CONF_allow_direct_upload) {
		echo "problem<br>";
		echo "Direct upload is not permitted on this server.";
		exit;
	}
	
	$moduleRelPath=moduleRelPath(0);
	$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;

	if (0) {
		foreach($_POST as $varName=>$varValue) {
			echo "$varName => $varValue<BR>";
		}
		 exit;
	}	

/*log_msg("^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^\r\n");
log_msg("Client: $client \r\n");
log_msg("Script name: ".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."\r\n");
log_msg("User agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n");
log_msg("Date/time - IP: ".date("d/m/Y H:i:s")." -  ".$ip." \r\n");

if (count($_POST) >0 ) {
	log_msg("POST VARIABLES------------\r\n");
	foreach($_POST as $pname=>$pval) {
		log_msg($pname."=".$pval."\r\n");
	}
} */

	$user=utf8_encode(str_replace("\\'", "''", $_POST['user'] ));
	$pass=utf8_encode(str_replace("\\'", "''", $_POST['pass'] ));
	//P.Wild 10.03.2010 - umlauts weren't being looked up properly...
	$sql = "SELECT ".$CONF['userdb']['user_id_field'].", ".$CONF['userdb']['username_field'].", ".$CONF['userdb']['password_field'].
			" FROM ".$CONF['userdb']['users_table']." WHERE ".$CONF['userdb']['username_field']." = '$user'";

	if ( !($result = $db->sql_query($sql)) )
	{
		echo "Invalid user data<BR>";
		exit;
	}

	$passwdProblems=0;
	if( $row = $db->sql_fetchrow($result) ) {
	
		$passwordHashed=$row['user_password'];
		if ( function_exists('leonardo_check_password') ) { // phpbb3 has custom way of hashing passwords
			if( ! leonardo_check_password($pass,$passwordHashed)  ) $passwdProblems=1;			
		} else {
			if( md5($pass) != $passwordHashed ) $passwdProblems=1;
		}	
		
		//if( md5($pass) != $row['user_password'] ) $passwdProblems=1;
	} else 	$passwdProblems=1;

	if ($passwdProblems) {
		echo "Invalid user data<BR></BODY></HTML>";
		exit;
	}

   $userID=$row['user_id'];

   $filename = LEONARDO_ABS_PATH.'/'.$CONF['paths']['tmpigc'].'/'.$_POST['igcfn'].".igc";	   
   if (!$handle = fopen($filename, 'w')) { 
		echo "Cannot open file ($filename) on server for writing<BR></BODY></HTML>";
		exit;
   } 

	// make the first line:
	$igcContents="OLCvnolc=$username&na=$username";
	foreach($_POST as $varName=>$varValue) {
		if ($varName !='IGCigcIGC' && $varName!='user' && $varName!='pass' ) {
			$igcContents.="&$varName=$varValue";
		}
	}

   $igcContents.="\n".$_POST['IGCigcIGC'];
   // Write $somecontent to our opened file. 
   if (!fwrite($handle, $igcContents)) { 		
		echo "Cannot write to file ($filename) on server <br></BODY></HTML>";
		exit;
   } 		
   fclose($handle); 
						

	$klasse=$_POST['klasse'];
	$cat=0;
	$category=6;
	$gliderCertCategory=$_POST['gliderCertCategory']+0;

	
	$glider=$_POST['glider'];
	$gliderBrandID=$_POST['gliderBrandID'];
	
	
	// mod M. Andreadakis 05.12.2014
	$gliderID=$_POST['gliderID']+0;
	if ($gliderID) {
		// override the glider , gliderBrandID , gliderCertCategory
		$gliderInfo=brands::getGliderInfo($gliderID);
        if ($gliderInfo['gliderName']) {
			$gSize= $gliderInfo['gliderSize'];
			if ($gSize) $gSize=" - ".$gSize;
			else $gSize='';
            $glider=$gliderInfo['gliderName'].$gSize;
			$gliderCertCategory=$gliderInfo['gliderCert'];
			$gliderBrandID==$gliderInfo['brandID'];
        }
		//print_r($gliderInfo);		
		//echo "$glider $gliderCertCategory $gliderBrandID<BR>";
	}
	// end mod M. Andreadakis 05.12.2014
	
	if ( !$klasse ) { 
		$cat=$_POST['gliderCat']+0;
		$category=$_POST['Category']+0;
		if (!$cat || !$category) { 		
		echo "Glider class (PG, HG etc.) not present -- flight cannot be entered <br></BODY></HTML>";
		exit;
		} 
	} 

 	else{ 
		switch($klasse){
			case 1:
				$cat=2; $category=2; //HG Flex (Topless)
				break;
			case 2:
				$cat=4; $category=2;//HG Rigid
				break;
			case 3:
				$cat=1; $category=2; //PG Open
				break;
			case 4:
				$cat=1; $category=1; //PG Sport
				break;
			case 5:
				$cat=1; $category=3; //PG Tandem
				break;
			case 6:
				$cat=1; $category=4; //PG Fun
				break;
			case 7:
				$cat=2; $category=1; //HG Fun (Flex+Kingpost)
				break;
			case 8:
				$cat=1; $category=5; //PG Standard
				break;
			case 9:
				$cat=$_POST['gliderCat']+0; $category=6; //Flight book only
				break;
			case 10:
				$cat=8; $category=2; //FAI Class 2
				break;
				
		}
	}
//New switch to catch gliders wrongly entered P.Wild 18.05.2015
if($cat==1 && $category!==6){
	switch($gliderCertCategory){
		case 1:
			$category=4;
			break;
		case 2:
			$category=5;
			break;
		case 4:
			$category=1;
			break;			
		case 8:
			$category=2;
			break;	
		case 16:
			$category=2;
			break;
		case 32:
			$category=4;
			break;
		case 64:
			$category=5;
			break;
		case 128:
			$category=1;
			break;
		case 256:
			$category=2;
			break;
		case 500:
			$category=2;
			break;
		case 512:
			$category=6;
			break;
		case 1024:
			$category=6;
			break;			
	}
}	
	
	if ($klasse==3 && ($gliderCertCategory>512)) {
		echo "This class of glider cannot be entered in the Performance Class -- flight placed in Flight book<br>";$cat=1 ;  $category=6;
	}
	if ($klasse==6 && !($gliderCertCategory==1 || $gliderCertCategory==32)) 
	{echo "This class of glider cannot be entered in the Fun Cup -- flight placed in Flightbook<br>";$cat=1 ;  $category=6;}
	if ($klasse==7 && $category!==1) 
	{echo "This class of glider cannot be entered in the Fun Cup -- flight placed in flight book<br>";$cat=2 ;  $category=6;}
	if ($klasse==4 && !($gliderCertCategory==1 || $gliderCertCategory==2 || $gliderCertCategory==4 || $gliderCertCategory==32 || $gliderCertCategory==64 || $gliderCertCategory==128)) 
	{echo "This class of glider cannot be entered in the Sport Cup -- flight placed in Flight book<br>";$cat=1 ;  $category=6;}
	if ($klasse==8 && !($gliderCertCategory==1 || $gliderCertCategory==2 || $gliderCertCategory==32 || $gliderCertCategory==64 )) 
	{echo "This class of glider cannot be entered in the Standard Cup -- flight placed in Flight book<br>";$cat=1 ;  $category=6;}
	
	
	$comments=$_POST['comments'];		//mod. P. Wild 15.11.2010	
	$startType=$_POST['startType'];
	if (!$startType) {echo "Start type not present -- flight cannot be entered <br></BODY></HTML>";
		exit;
	}
	// log_msg("category=$category,cat=$cat,gliderCertCategory=$gliderCertCategory\r\n");				
	list($errCode,$flightID)=addFlightFromFile($filename,0,$userID,	
		array('category'=>$category,
				'cat'=>$cat,
				'glider'=>$glider,
				'gliderID'=>$gliderID,
				'gliderBrandID'=>$gliderBrandID,
				'comments'=>$comments,
				'startType'=>$startType,
				// 'allowDuplicates'=>($CONF['servers']['list'][$CONF_server_id]['allow_duplicate_flights']+0) 
				'allowDuplicates'=>1 ,
				'gliderCertCategory'=>$gliderCertCategory,
		) ) ;
		
		
	if ($errCode!=1) {
		echo "problem<br>";
		echo getAddFlightErrMsg($errCode,$flightID);
	} else {
		// echo "response=$flightID<br>";
		// fix for wrong timezone
	        $flight=new flight();
       		$flight->getFlightFromDB($flightID);
	//New 18.08.2013 P.Wild - Airspace warning before flight_show
		$flight->checkAirspace(1);
		if ((strpos($flight->airspaceCheckMsg,"HorDist"))) { // problem
			
			$checkLines=explode("\n",$flight->airspaceCheckMsg);
			//if (strrchr($flight->airspaceCheckMsg,"Punkte")){
			//	$adminPanel.="<br><strong>Deutschland Pokal</strong><BR>";
				if ((strpos($flight->airspaceCheckMsg,"HorDist"))) {
					$adminPanel.="<br><strong>Airspace PROBLEM (Deutschland Pokal)</strong><BR>";
					for($i=1;$i<count($checkLines); $i++) {
						$adminPanel.=$checkLines[$i]."<br>";
					}
						
					echo "<div align='center' id='attentionLinkPos' class='attentionLink box'><img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle>
					$adminPanel<img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle><br></div>";
					$warningtext="<br><br>Der DHV-XC Server meldet ein Luftraumproblem für diesen Flug.<br>Wenn diese Meldung erfolgt sein sollte wegen z.B. einer zeitlichen Deaktivierung eines kontrollierten Luftraumes (HX, EDR), einem aktiven Segelflugsektor oder einer Freigabe durch die Flugsicherung, kann dies mit dem hier unten stehenden Button bestätigt werden. Außerdem muss der das Problem aufhebende Grund zwingend im Pilotenkommentar beschrieben werden<br><br>Wenn eine tatsächliche Luftraumverletzung über die Geräte-Messfehler- und Anzeigetoleranz hinaus stattgefunden hat, bitten wir mit dem unten stehenden zweiten Button um die sofortige Löschung dieses Fluges vom Server.<br><br>Mit dem Abschicken dieser Daten bestätige ich, dass ich die für den eingereichten Flug geltenden luftrechtlichen Bestimmungen eingehalten habe. <br> ";
					echo "<div align='center' id='attentionLinkPos' class='attentionLink box'><img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle>
					$warningtext<img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle><br></div>";
					
				}
			   else{
				$adminPanel.= "<br><strong>Airspace PROBLEM</strong><BR>";
				for($i=1;$i<count($checkLines); $i++) {
					$adminPanel.=$checkLines[$i]."<br>";
				}
					
				echo "<div align='center' id='attentionLinkPos' class='attentionLink box'><img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle>
				$adminPanel<img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle><br></div>";
				$warningtext="<br><br>Der DHV-XC Server meldet ein Luftraumproblem für diesen Flug.<br>Wenn diese Meldung erfolgt sein sollte wegen z.B. einer zeitlichen Deaktivierung eines kontrollierten Luftraumes (HX, EDR), einem aktiven Segelflugsektor oder einer Freigabe durch die Flugsicherung, kann dies mit dem hier unten stehenden Button bestätigt werden. Außerdem muss der das Problem aufhebende Grund zwingend im Pilotenkommentar beschrieben werden<br><br>Wenn eine tatsächliche Luftraumverletzung über die Geräte-Messfehler- und Anzeigetoleranz hinaus stattgefunden hat, bitten wir mit dem unten stehenden zweiten Button um die sofortige Löschung dieses Fluges vom Server.<br><br>Mit dem Abschicken dieser Daten bestätige ich, dass ich die für den eingereichten Flug geltenden luftrechtlichen Bestimmungen eingehalten habe. <br> ";
				echo "<div align='center' id='attentionLinkPos' class='attentionLink box'><img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle>
				$warningtext<img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle><br></div>";
				
			}
       			?>
       				
       				<table>
       				<tr>
       			      <td>&nbsp;</td>
       			      <td colspan="3"><p><form action="<?=getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID))?>" method='post' ><input type="submit" value="<?=_PRESS_HERE_TO_CONFIRM_CLEARANCE ?>"></p></form></td>
       			    
       			      <td>&nbsp;</td>
       			      <td colspan="3"><p><form action="<?=getLeonardoLink(array('op'=>'delete_flight','flightID'=>$flightID))."&confirmed=1"?>" method='post' ><input type="submit" value="<?=_PRESS_HERE_TO_DELETE_FLIGHT ?>"></p></form></td>
       			    </tr>
       		    	</table>
       		    	
       					
       				<?php 	
       				}
       				
       				else{	
		echo _YOUR_FLIGHT_HAS_BEEN_SUBMITTED."<br><br><a href='http://".$_SERVER['SERVER_NAME'].
		getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID)).
		"'>"._PRESS_HERE_TO_VIEW_IT.'</a>';
       	}
	}
    // DEBUG_END();
	echo "</body></html>";
	
function log_msg($text ) {
	global $client;

	$filename=dirname(__FILE__).'/flight_submit_log.txt';
	if (!$handle = fopen($filename, 'a')) {
		 echo "Cannot open file ($filename)";
		return 0;	
	}
	if (fwrite($handle, $text) === FALSE) {
		echo "Cannot write to file ($filename)";
		return 0;
	}
	fclose($handle);
	return 1;
}
?>
