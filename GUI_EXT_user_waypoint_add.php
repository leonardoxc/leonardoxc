<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                                */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
	
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
	require_once dirname(__FILE__)."/language/lang-".$currentlang.".php";
	require_once dirname(__FILE__)."/language/countries-".$currentlang.".php";

    if (! in_array($userID,$admin_users)) {
//		return;
    }
	$waypointLat=$_REQUEST['lat']+0;
	$waypointLon=$_REQUEST['lon']+0;
 
	if ( $_POST['addWaypoint']==1 ) { // ADD waypoint
		$waypt=new waypoint(0);
		
		$waypt->name=$_POST['wname'];
		$waypt->intName=$_POST['intName'];
		$waypt->type=$_POST['type'];
		$waypt->lat=$_POST['lat'];
		$waypt->lon=$_POST['lon'];
		$waypt->location=$_POST['wlocation'];
		$waypt->intLocation=$_POST['intLocation'];
		$waypt->countryCode=$_POST['countryCode'];
		$waypt->link=$_POST['link'];
		$waypt->description=$_POST['description'];

		if ( $waypt->putToDB(0) ) {
		?>
		  <script language="javascript">
			  function refreshParent() {
				  topWinRef=top.location.href;
				  top.window.location.href=topWinRef;
			  }
		  </script>
		<?
	 		echo "<div align=center><BR><BR>"._WAYPOINT_ADDED."<BR><BR>";
			echo "<a href='javascript:refreshParent();'>Update flight takeoff and RETURN </a>"; 	
			echo "<br></div>";
		} else  echo("<H3> Error in inserting waypoint info query! </H3>\n");		

	   return;
	}
		

	$query="SELECT  countryCode from $waypointsTable WHERE ID=".makeSane($_REQUEST['takeoffID'],1);
	$res= $db->sql_query($query);
		
    if($res <= 0){
      echo("<H3>"._NO_KNOWN_LOCATIONS."</H3>\n");
      exit();
    }
    $row = mysql_fetch_assoc($res) ; 
	//if (!$row) { echo "##############" ;} 

    $nearestCountryCode=$row["countryCode"];
    mysql_freeResult($res);

	//echo $nearestCountryCode."^^";
  ?>

<style type="text/css">
	 body, p, table,tr,td {font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;}
	 body {margin:0px; background-color:#E9E9E9}
	.box {
		 background-color:#F4F0D5;
		 border:1px solid #555555;
		padding:3px; 
		margin-bottom:5px;
	}
	.boxTop {margin:0; }
</style>
  <?
	
	$takoffsList=getExtrernalServerTakeoffs(1,$waypointLat,-$waypointLon,20,5);
	
	if (count($takoffsList) >0 ) {
		$linkToInfoHdr1="<img src='".$moduleRelPath."/img/paraglidingearth_logo.gif' border=0>";
		
		$linkToInfoStr1="<ul>";
		foreach ($takoffsList as $takeoffItem)  {
				$distance=$takeoffItem['distance']; 
				if ($takeoffItem['area']!='not specified')
					$areaStr=" - ".$takeoffItem['area'];
				else 
					$areaStr="";
					
				$jsStr="fillInForm('".addslashes($takeoffItem['name'])."','".addslashes($takeoffItem['area'])."','".addslashes($takeoffItem['countryCode'])."');";

				$takeoffLink="<a href=\"javascript:$jsStr\">".$takeoffItem['name']."$areaStr (".$takeoffItem['countryCode'].") [~".formatDistance($distance,1)."]</a>";

				$linkToInfoStr1.="<li>$takeoffLink";
		}
		$linkToInfoStr1.="</ul>";
  }

	$takoffsList=getExtrernalServerTakeoffs(2,$waypointLat,-$waypointLon,20,5);
	
	if (count($takoffsList) >0 ) {
		$linkToInfoHdr2="<img src='".$moduleRelPath."/img/paraglider365logo.gif' border=0>";
		
		$linkToInfoStr2="<ul>";
		foreach ($takoffsList as $takeoffItem)  {
				$distance=$takeoffItem['distance']; 
				if ($takeoffItem['area']!='not specified')
					$areaStr=" - ".$takeoffItem['area'];
				else 
					$areaStr="";
					
				$jsStr="fillInForm('".addslashes($takeoffItem['name'])."','".addslashes($takeoffItem['area'])."','".addslashes($takeoffItem['countryCode'])."');";
				
				$takeoffLink="<a href=\"javascript:$jsStr\">".$takeoffItem['name']."$areaStr (".$takeoffItem['countryCode'].") [~".formatDistance($distance,1)."]</a>";

				$linkToInfoStr2.="<li>$takeoffLink";
		}
		$linkToInfoStr2.="</ul>";
  }
?> 
<script language="javascript">
function MWJ_findObj( oName, oFrame, oDoc ) {
	if( !oDoc ) { if( oFrame ) { oDoc = oFrame.document; } else { oDoc = window.document; } }
	if( oDoc[oName] ) { return oDoc[oName]; } if( oDoc.all && oDoc.all[oName] ) { return oDoc.all[oName]; }
	if( oDoc.getElementById && oDoc.getElementById(oName) ) { return oDoc.getElementById(oName); }
	for( var x = 0; x < oDoc.forms.length; x++ ) { if( oDoc.forms[x][oName] ) { return oDoc.forms[x][oName]; } }
	for( var x = 0; x < oDoc.anchors.length; x++ ) { if( oDoc.anchors[x].name == oName ) { return oDoc.anchors[x]; } }
	for( var x = 0; document.layers && x < oDoc.layers.length; x++ ) {
		var theOb = MWJ_findObj( oName, null, oDoc.layers[x].document ); if( theOb ) { return theOb; } }
	if( !oFrame && window[oName] ) { return window[oName]; } if( oFrame && oFrame[oName] ) { return oFrame[oName]; }
	for( var x = 0; oFrame && oFrame.frames && x < oFrame.frames.length; x++ ) {
		var theOb = MWJ_findObj( oName, oFrame.frames[x], oFrame.frames[x].document ); if( theOb ) { return theOb; } }
	return null;
}

function fillInForm(name,area,countrycode){
	a=MWJ_findObj("wname");
	a.value=name;
	a=MWJ_findObj("intName");
	a.value=name;
	a=MWJ_findObj("wlocation");
	a.value=area;
	a=MWJ_findObj("intLocation");
	a.value=area;
	a=MWJ_findObj("countryCode");
	a.value=countrycode;
}
</script>
      <form name="form1" method="post" action="GUI_EXT_user_waypoint_add.php" >

        <table width="700" border="0" align="center">
          <tr>
            <td><div class="box boxTop"><img src="img/icon_help.png" width="16" height="16" align="absmiddle" /><?=_takeoff_add_help_1?><br />
                <img src="img/icon_help.png" width="16" height="16" align="absmiddle" /><?=_takeoff_add_help_2?><br />
            </div></td>
          </tr>
          <tr>
            <td><table width="700" border="0" align="center" cellpadding="2" class="shadowBox main_text">
              <tr>
                <td width="120" bgcolor="#CFE2CF"><div align="right"><font color="#003366"><?=_Takeoff_Name?><br />
                (<?=_In_Local_Language?>) </font></div></td>
                <td  bgcolor="#E3E7F2"><font color="#003366">
                  <input name="wname" type="text" id="wname" size="30" />
                  <input name="type" type="hidden" id="type" value="1000" />
                </font></td>
                <td width="250" rowspan="8" valign="top"><div class="box"><?=_takeoff_add_help_3?></div>
                    <?
				echo $linkToInfoHdr1.$linkToInfoStr1;
				echo $linkToInfoHdr2.$linkToInfoStr2;	
			
			?>
                  &nbsp;</td>
              </tr>
              <tr>
                <td bgcolor="#CFE2CF"><div align="right"><font color="#003366"><?=_Takeoff_Name?><br />
                  (<?=_In_English?>) </font></div></td>
                <td bgcolor="#E3E7F2"><font color="#003366">
                  <input name="intName" type="text" id="intName" size="30" />
                </font></td>
              </tr>
              <tr>
                <td bgcolor="#CFE2CF"><div align="right"><font color="#003366"><?=_SITE_REGION?><br />
                  (<?=_In_Local_Language?>) </font></div></td>
                <td bgcolor="#E3E7F2"><font color="#003366">
                  <input name="wlocation" type="text" id="wlocation" size="30" />
                </font></td>
              </tr>
              <tr>
                <td bgcolor="#CFE2CF"><div align="right"><font color="#003366"><?=_SITE_REGION?><br />
                  (<?=_In_English?>)</font></div></td>
                <td bgcolor="#E3E7F2"><font color="#003366">
                  <input name="intLocation" type="text" id="intLocation" size="30" />
                </font></td>
              </tr>
              <tr>
                <td bgcolor="#CFE2CF"><div align="right"><font color="#003366"><?=_COUNTRY?> </font></div></td>
                <td bgcolor="#E3E7F2"><font color="#003366">
                  <select name="countryCode">
                    <? 				
					foreach ($countries as $key => $value) {
						if ($nearestCountryCode==$key) $sel=" selected ";
						else $sel="";		
						echo '<option value="'.$key.'" '.$sel.' >'.$key.' - '.$value.'</option>';
					}
								
				?>
                  </select>
                </font></td>
              </tr>
              <tr>
                <td bgcolor="#CFE2CF"><div align="right"><font color="#003366"><?=_RELEVANT_PAGE?></font></div></td>
                <td bgcolor="#E3E7F2"><font color="#003366">
                  <input name="link" type="text" id="link" size="45">
                </font></td>
              </tr>
              <tr>
                <td valign="top" bgcolor="#CFE2CF"><div align="right"><font color="#003366"><?=_SITE_DESCR?></font></div></td>
                <td bgcolor="#E3E7F2"><font color="#003366">
                  <textarea name="description" cols="35" rows="4" id="description"></textarea>
                </font></td>
              </tr>
              <tr>
                <td valign="top" bgcolor="#CFE2CF">&nbsp;</td>
                <td bgcolor="#E3E7F2"><input type="submit" name="Submit" value="<? echo _ADD_WAYPOINT ?>" />
                    <input type="hidden" name="addWaypoint" value="1" />
                    <input name="lat" type="hidden" id="lat" value='<? echo $waypointLat?>' />
                    <input name="lon" type="hidden" id="lon" value='<? echo $waypointLon?>'></td>
              </tr>
            </table></td>
          </tr>
        </table>
        </form>    