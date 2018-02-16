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
// $Id: GUI_EXT_pilot_info.php,v 1.11 2012/09/12 19:41:03 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
 	require_once dirname(__FILE__)."/EXT_config.php";

	require_once dirname(__FILE__)."/CL_flightData.php";
	require_once dirname(__FILE__)."/FN_functions.php";	
	require_once dirname(__FILE__)."/FN_UTM.php";
	require_once dirname(__FILE__)."/FN_waypoint.php";	
	require_once dirname(__FILE__)."/FN_output.php";
	require_once dirname(__FILE__)."/FN_pilot.php";
	require_once dirname(__FILE__)."/FN_flight.php";
	require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";

	$op=$_GET['op'];	
	
	$pilotID1=makeSane($_GET['pilotID'],0);
	list($serverID,$pilotIDview)=explode('u',$pilotID1);

	if (!$pilotIDview) {
		echo $pilotID1.' '."$serverID,$pilotIDview#";
		return;
	}
	
	if ($op=='info_full') {  	
  		// $pilotIDview =
  		$serverIDview=$serverID;
  		$pilotID=$pilotIDview;
  		
  		//echo "$serverIDview:$pilotID";
  		define('INLINE_VIEW',1);  		
  		
  		$filter01='';
  		$country='';
  		$takeoffID=0;
  		$nacid=0;
  		$nacclubid=0;
  		$class='';
  		$xctype='';
  		$season=0;
  		$year=0;
  		$month=0;
  		$PREFS->itemsPerPage=5;
  		
	  	
	  	$pilotFlights="<a class='greenButtonLink' href='".
	  			getLeonardoLink(array('op'=>'list_flights','pilotID'=>$serverID.'_'.$pilotIDview,'year'=>'0','country'=>'')).
				"'>"._PILOT_FLIGHTS."</a>";
	  	
	  	$pilotStats="<a class='greenButtonLink' href='".
			getLeonardoLink(array('op'=>'pilot_profile_stats','pilotIDview'=>$serverID.'_'.$pilotIDview)).
			"'>"._pilot_stats."</a>";

		$pilotProfile="<a class='greenButtonLink' href='".getLeonardoLink(array('op'=>'pilot_profile','pilotIDview'=>$serverID.'_'.$pilotIDview)).
			"'>"._Pilot_Profile."</a>";
		
	
  		echo "<div class='pilotLinks'>$pilotFlights $pilotStats $pilotProfile</div><hr>";
  		
  		require_once "GUI_list_flights.php";
  		
  		require_once "GUI_pilot_profile.php";
  		
  		
  		exit;
	}
	
	if ($CONF_use_utf) {		
		$CONF_ENCODING='utf-8';
	} else  {		
		$CONF_ENCODING=$langEncodings[$currentlang];
	}

	header('Content-type: application/text; charset="'.$CONF_ENCODING.'"',true);
	
	//$selQuery="SELECT * FROM $pilotsTable, ".$CONF['userdb']['users_table'].
	//					" WHERE pilotID=".$pilotIDview ." AND serverID=$serverID AND pilotID=".$CONF['userdb']['user_id_field'];
						
	//$selQuery="SELECT * FROM $pilotsTable WHERE pilotID=".$pilotIDview." AND serverID=$serverID ";
	$selQuery="SELECT * FROM $pilotsTable LEFT JOIN $pilotsInfoTable ON
				($pilotsTable.pilotID=$pilotsInfoTable.pilotID AND $pilotsTable.serverID=$pilotsInfoTable.serverID )
			WHERE 
				$pilotsTable.pilotID=".$pilotIDview." AND $pilotsTable.serverID=$serverID ";
	
    $res= $db->sql_query($selQuery);

	if($res <= 0){
		echo("<H3>Error in pilot query</H3>\n");
		return;
	} else if ( mysql_num_rows($res)==0){
		$res= $db->sql_query("INSERT INTO $pilotsTable (pilotID,serverID) VALUES($pilotIDview,$serverID)" );
		$res= $db->sql_query($selQuery);			
	}
  
  $pilot = mysql_fetch_assoc($res);
  
 
  
  if ($op=='info_nac'){
  
		$nacQuery="SELECT * FROM $NACclubsTable WHERE NAC_ID=".$pilot['NACid']." AND clubID=".$pilot['NACclubID'];		
		$res2= $db->sql_query($nacQuery);	
		if($res2 <= 0){
			echo("<H3>Error in nac club query</H3>\n");
			return;
		}
		$row=mysql_fetch_assoc($res2);
		
		// echo _MEMBER_OF."<BR>".$row['clubName'];
		echo $row['clubName'];
		
		exit;
  } 
  

  $pilotName=getPilotRealName($pilotIDview,$serverID,1);
  $legend=_Pilot_Profile.": <b>$pilotName</b>";
  $legendRight="<a href='".
  	getLeonardoLink(array('op'=>'list_flights','pilotID'=>$serverID.'_'.$pilotIDview,'year'=>'0','country'=>'')).
	"'>"._PILOT_FLIGHTS."</a>";
  $legendRight.=" | <a href='".
		getLeonardoLink(array('op'=>'pilot_profile_stats','pilotIDview'=>$serverID.'_'.$pilotIDview)).
		"'>"._pilot_stats."</a>";
  if ( $pilotIDview == $userID || L_auth::isAdmin($userID) && $serverID==0  ) {
	  $legendRight.=" | <a href='".
	 		 getLeonardoLink(array('op'=>'pilot_profile_edit','pilotIDview'=>$pilotIDview))."'>"._edit_profile."</a>";
  }
  else $legendRight.="";
  
  
  echo "<table><tr>";
  echo "<td>";
?> 
<table  class=main_text  width="100%" border="0">

<? 
	$BirthdateHideMask=$pilot['BirthdateHideMask'] ;
		$Birthdate=$pilot['Birthdate'] ;
		if ($Birthdate) {
			$hiddenFields=0;
			for($i=0;$i<10;$i++) {
				if ( $BirthdateHideMask[$i]=='x' )	{
					$hiddenFields++;
					$Birthdate[$i]='x';
				} else {
					$Birthdate[$i]=$Birthdate[$i];
				}	
			}
		}

?>
  <tr> 
    <td colspan="2" valign="top" bgcolor="006699"> <div align="left"><strong><font color="#FFA34F"><? echo _Flying_Stuff ?></font></strong></div></td>
    <td width="150" rowspan="9" valign="top"><? 
	  	if ($pilot['PilotPhoto']>0) {
                        if (!file_exists(getPilotPhotoRelFilename($serverIDview,$pilotIDview))){
                                $cdnURL='';
                        }

			echo "<div align='center'><a href='".$cdnURL.getPilotPhotoRelFilename($serverID,$pilotIDview)."' target='_blank'><img src='".$cdnURL.getPilotPhotoRelFilename($serverID,$pilotIDview,1)."' border=0></a></div>";
		}
	  ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Flying_Since ?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['FlyingSince'] ?>    </td>
  </tr>
  <tr>
    <td width="150" valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Personal_Distance_Record?></div></td>
    <td width="150" valign="top" bgcolor="#F5F5F5"><? echo $pilot['personalDistance'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Personal_Height_Record?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['personalHeight'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Hours_Flown?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['HoursFlown'] ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo  _Hours_Per_Year?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['HoursPerYear'] ?></td>
  </tr>

  <tr> 
    <td colspan="2" bgcolor="006699"><strong><font color="#FFA34F"><? echo _Equipment_Stuff?></font></strong></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Glider?></div></td>
    <td valign="top" bgcolor="#F5F5F5"><? echo $pilot['glider'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Harness?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Harness'] ?></td>
  </tr>
</table>
<?
  echo "</td></tr>"; 
  echo "</table>";
//  close_inner_table();
?>
