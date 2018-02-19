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
// $Id: GUI_waypoint_show.php,v 1.15 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************

  $wpInfo =new waypoint($waypointIDview );
  $wpInfo->getFromDB();
  
//  $wpName= getWaypointName($waypointIDview);

  $wpName= selectWaypointName($wpInfo->name,$wpInfo->intName,$wpInfo->countryCode);
  $wpLocation = selectWaypointLocation($wpInfo->location,$wpInfo->intLocation,$wpInfo->countryCode);

  if ( L_auth::isAdmin($userID)  ) $opString="<a href='".
  		getLeonardoLink(array('op'=>'edit_waypoint','waypointIDedit'=>$waypointIDview))
		."'><img src='".$moduleRelPath.	"/img/change_icon.png' border=0 align=bottom></a>"; 
  $titleString=_Waypoint_Name." : ".$wpName." (".$countries[$wpInfo->countryCode].") &nbsp;";
?>

<style type="text/css">
<!--
.titleText {font-weight: bold}
.col1 { background-color:#9FBC7F; }
.col2 { background-color:#BE8C80; }
.col3 { background-color:#7F91BF; }

.col1_in { background-color:#EEF3E7; }
.col2_in { background-color:#F8F3F2; }
.col3_in { background-color:#DAE5F0; }
-->
</style>

<?
 // open_inner_table("<table class=main_text width=100% cellpadding=0 cellspacing=0><tr><td>".$titleString."</td><td align=right width=50><div align=right>".$opString."</div></td></tr></table>",760,"icon_pin.png");

 $imgStr="<img src='$moduleRelPath/img/icon_pin.png' align='absmiddle'> ";

 openMain("<div style='width:90%;font-size:12px;clear:none;display:block;float:left'>$imgStr$titleString</div><div align='right' style='width:10%; text-align:right;clear:none;display:block;float:right' bgcolor='#eeeeee'>$opString</div>",0,'');


?> 
<table width="100%" border="0" bgcolor="#EFEFEF" class=main_text>

  <tr>
    <td valign="middle">
      <table width="710"  align="center" class="Box">
        <tr align="center" bgcolor="#D0E2CD">
          <td bgcolor="#49766D" class="col1"><div align="center" class="titleWhite titleText"><? echo _FLIGHTS ?></div></td>
          <td bgcolor="#49766D" class="col2"><div align="center" class="titleWhite titleText"><? echo _COORDINATES ?></div></td>
          <td width="150" class="col3"><div align="center" class="titleWhite titleText">Navigate</div></td>
        </tr>
        <tr align="center" bgcolor="#D0E2CD">
          <td rowspan="3" class="col1_in">
<b><? echo _SITE_RECORD ?></b>:
	<?
	 $query="SELECT  MAX(MAX_LINEAR_DISTANCE) as record_km, ID FROM $flightsTable  WHERE takeoffID =".$waypointIDview." GROUP BY ID ORDER BY record_km DESC ";

	 $flightNum=0;
     $res= $db->sql_query($query);
     if($res > 0){
		$flightNum=mysql_num_rows($res);
		$row = mysql_fetch_assoc($res);

		echo "<a href='https://".$_SERVER['SERVER_NAME'].
			getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['ID']))."'>".
			formatDistance($row['record_km'],1)."</a>";
	 } 


?>
<p>
<strong><? echo "<a href='".getLeonardoLink(array('op'=>'list_flights','takeoffID'=>$waypointIDview))."'>"._See_flights_near_this_point." [ ".$flightNum." ]</a>"; ?></strong>
			</td>
          <td rowspan="3" class="col2_in"><p><strong>lat/lon (WGS84):</strong><br>
		  <? 	echo $wpInfo->lat." , ".-$wpInfo->lon ;
				echo "<br>".$wpInfo->getLatMinDec()." , ".$wpInfo->getLonMinDec();
				echo "<br>".$wpInfo->getLatDMS()." , ".$wpInfo->getLonDMS();
				echo "<p>";
				list($UTM_X,$UTM_Y,$UTMzone,$UTMlatZone)=$wpInfo->getUTM();
				echo "<b>UTM:</b> $UTMzone$UTMlatZone X: ".floor($UTM_X)." Y: ".floor($UTM_Y);
		 ?></td>
          <td class="col3_in"><div align="center"><strong><? echo "<a href='".
		  getDownloadLink(array('type'=>'kml_wpt','wptID'=>$waypointIDview))
		  ."'>"._Navigate_with_Google_Earth."</a>"; ?></strong></div></td>
        </tr>
        <tr align="center" class="col3_in">
          <td><strong><? echo "<a href='https://maps.google.com/maps?q=".$wpName."&ll=". $wpInfo->lat.",".-$wpInfo->lon."&spn=1.535440,2.885834&t=h&hl=en' target='_blank'>"._See_it_in_Google_Maps."</a>"; ?></strong></td>
        </tr>
        <tr align="center" class="col3_in">
          <td><strong><? echo "<a href='https://www.mapquest.com/maps/map.adp?searchtype=address&formtype=address&latlongtype=decimal&latitude=".$wpInfo->lat."&longitude=".-$wpInfo->lon."' target='_blank'>"._See_it_in_MapQuest."</a>"; ?></strong></td>
        </tr>
      </table>
<? if ($wpLocation || $wpInfo->description || $wpInfo->link) { ?>
	 <br>
      <table class="Box"  align="center" width=710>
        <tr >
          <td colspan="2" class="col3">             
          <div align="center" class="titleWhite titleText"><? echo _SITE_INFO ?></div></td>
        </tr>
		<? if ($wpLocation) { ?>
        <tr bgcolor="white">
          <td width=200 class="col3_in"> <? echo _SITE_REGION ?></td>
          <td valign="top" ><? echo $wpLocation ?>&nbsp;</td>
        </tr>
		<? } ?>
		<? if ($wpInfo->link) { ?>
        <tr bgcolor="white">
          <td width=200 class="col3_in"><? echo _SITE_LINK ?></td>
          <td valign="top"><a href='<? echo formatURL($wpInfo->link) ?>' target="_blank"><? echo formatURL($wpInfo->link) ?></a>&nbsp;</td>
        </tr>
		<? } ?>
		<? if ($wpInfo->description) { ?>
        <tr bgcolor="#49766D">
          <td colspan=2 class="col3"><div align="center" class="titleWhite  titleText"><? echo _SITE_DESCR ?>
          </div></td>
        </tr>
        <tr>
          <td colspan=2 valign="top"><? echo $wpInfo->description ?>&nbsp;</td>
        </tr>
		<? } ?>
      </table>    
	  <? } ?>  
      </td>
  </tr>
  <tr> 
    <td colspan="1">
	<div align="center">
		<?  list($browser_agent,$browser_version)=getBrowser();
			if ( $CONF_google_maps_api_key  ) { ?> 
		<iframe align="center"
		  SRC="<? echo "https://".$_SERVER['SERVER_NAME'].getRelMainDir()."EXT_google_maps.php?wpID=".$wpInfo->waypointID."&wpName=".$wpInfo->intName."&lat=".$wpInfo->lat."&lon=".-$wpInfo->lon; ?>"
		  TITLE="Google Map" width="710px" height="400px"
		  scrolling="no" frameborder="0">
		Sorry. If you're seeing this, your browser doesn't support IFRAMEs.
		You should upgrade to a more current browser.
		</iframe>
		<? } else { ?>	
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><img src="<? echo $moduleRelPath ?>/EXT_showWaypointGlobe.php?type=small&lat=<? echo $wpInfo->lat?>&lon=<? echo $wpInfo->lon ?>" ></td>
            <td valign="top"><img src="<? echo $moduleRelPath ?>/EXT_showWaypointGlobe.php?type=big&zoomFactor=2&lat=<? echo $wpInfo->lat ?>&lon=<? echo $wpInfo->lon ?>" ></td>
          </tr>
        </table>      
		<? } ?> 
	</div>
	</td>
  </tr>
</table>
<?
  
  closeMain();
?>
