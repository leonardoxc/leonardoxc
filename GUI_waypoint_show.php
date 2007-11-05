<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

  $wpInfo =new waypoint($waypointIDview );
  $wpInfo->getFromDB();
  
//  $wpName= getWaypointName($waypointIDview);

  $wpName= selectWaypointName($wpInfo->name,$wpInfo->intName,$wpInfo->countryCode);
  $wpLocation = selectWaypointLocation($wpInfo->location,$wpInfo->intLocation,$wpInfo->countryCode);

  if ( auth::isAdmin($userID)  ) $opString="<a href='".CONF_MODULE_ARG."&op=edit_waypoint&waypointIDedit=".$waypointIDview."'><img src='".$moduleRelPath."/img/change_icon.png' border=0 align=bottom></a>"; 
  $titleString=_Waypoint_Name." : ".$wpName." (".$countries[$wpInfo->countryCode].") &nbsp;";

  open_inner_table("<table class=main_text width=100% cellpadding=0 cellspacing=0><tr><td>".$titleString."</td><td align=right width=50><div align=right>".$opString."</div></td></tr></table>",720,"icon_pin.png");
  open_tr();
  echo "<td>";	
?>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
 
<table width="100%" border="0" bgcolor="#EFEFEF" class=main_text>

  <tr>
    <td valign="middle">
      <table class="Box" width="600"  align="center">
        <tr align="center" bgcolor="#D0E2CD">
          <td width="196"><strong><? echo "<a href='".$moduleRelPath."/download.php?type=kml_wpt&wptID=".$waypointIDview."'>"._Navigate_with_Google_Earth."</a>"; ?>
            </strong>
          <div align="center"></div></td>
          <td width="218"><strong><? echo "<a href='http://maps.google.com/maps?q=".$wpName."&ll=". $wpInfo->lat.",".-$wpInfo->lon."&spn=1.535440,2.885834&t=h&hl=en' target='_blank'>"._See_it_in_Google_Maps."</a>"; ?>
            </strong>
          <div align="center"></div></td>
          <td width="170"><strong><? echo "<a href='http://www.mapquest.com/maps/map.adp?searchtype=address&formtype=address&latlongtype=decimal&latitude=".$wpInfo->lat."&longitude=".-$wpInfo->lon."' target='_blank'>"._See_it_in_MapQuest."</a>"; ?>
            </strong>
          <div align="center"></div></td>
        </tr>
      </table>
<? if ($wpLocation || $wpInfo->description || $wpInfo->link) { ?>
	 <br>
      <table class="Box"  align="center" width=600>
        <tr bgcolor="#49766D">
          <td colspan="2">             
              <div align="center" class="titleWhite"><strong><? echo _SITE_INFO ?></strong></div></td>
        </tr>
		<? if ($wpLocation) { ?>
        <tr bgcolor="#F2ECDB">
          <td width=200><? echo _SITE_REGION ?></td>
          <td valign="top"><? echo $wpLocation ?>&nbsp;</td>
        </tr>
		<? } ?>
		<? if ($wpInfo->link) { ?>
        <tr bgcolor="#F2ECDB">
          <td width=200><? echo _SITE_LINK ?></td>
          <td valign="top"><a href='<? echo formatURL($wpInfo->link) ?>' target="_blank"><? echo formatURL($wpInfo->link) ?></a>&nbsp;</td>
        </tr>
		<? } ?>
		<? if ($wpInfo->description) { ?>
        <tr bgcolor="#F2ECDB">
          <td width=200><? echo _SITE_DESCR ?></td>
          <td valign="top"><? echo $wpInfo->description ?>&nbsp;</td>
        </tr>
		<? } ?>
      </table>    
	  <? } ?>  
      <br>
      <table class="Box" width="600"  align="center">
        <tr bgcolor="#49766D">
          <td><div align="left" ></div>
              <div align="left" class="titleWhite"><b><? echo _COORDINATES ?></b></div></td>
          <td><span class="titleWhite"><b><? echo _FLIGHTS ?></b></span></td>
        </tr>
        <tr bgcolor="#EBE1C5">
          <td width="271" bgcolor="#EBE1C5"><p><strong>lat/lon (WGS84):</strong><br>
		  <? 	echo $wpInfo->lat." , ".-$wpInfo->lon ;
				echo "<br>".$wpInfo->getLatMinDec()." , ".$wpInfo->getLonMinDec();
				echo "<br>".$wpInfo->getLatDMS()." , ".$wpInfo->getLonDMS();
				echo "<p>";
				list($UTM_X,$UTM_Y,$UTMzone,$UTMlatZone)=$wpInfo->getUTM();
				echo "<b>UTM:</b> $UTMzone$UTMlatZone X: ".floor($UTM_X)." Y: ".floor($UTM_Y);
		 ?>
		  </td>
          <td width="317" bgcolor="#EBE1C5" valign="top"><b><? echo _SITE_RECORD ?></b>:
	<?
	 $query="SELECT  MAX(MAX_LINEAR_DISTANCE) as record_km, ID FROM $flightsTable  WHERE takeoffID =".$waypointIDview." GROUP BY ID ORDER BY record_km DESC ";

	 $flightNum=0;
     $res= $db->sql_query($query);
     if($res > 0){
		$flightNum=mysql_num_rows($res);
		$row = mysql_fetch_assoc($res);

		echo "<a href='http://".$_SERVER['SERVER_NAME'].getRelMainFileName()."&op=show_flight&flightID=".$row['ID']."'>".
			formatDistance($row['record_km'],1)."</a>";
	 } 


?>
<p>
<strong><? echo "<a href='".CONF_MODULE_ARG."&op=list_flights&takeoffID=$waypointIDview'>"._See_flights_near_this_point." [ ".$flightNum." ]</a>"; ?></strong></td>
        </tr>
      </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>
      <br>      <div align="center"></div>
    <div align="center"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">
		<div align="center">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><img src="<? echo $moduleRelPath ?>/EXT_showWaypointGlobe.php?type=small&lat=<? echo $wpInfo->lat?>&lon=<? echo $wpInfo->lon ?>" ></td>
            <td valign="top"><img src="<? echo $moduleRelPath ?>/EXT_showWaypointGlobe.php?type=big&zoomFactor=2&lat=<? echo $wpInfo->lat ?>&lon=<? echo $wpInfo->lon ?>" ></td>
          </tr>
        </table>
        </div>
		<? list($browser_agent,$browser_version)=getBrowser();
			if ( $CONF_google_maps_api_key  ) { ?> 
		<iframe align="right"
		  SRC="<? echo "http://".$_SERVER['SERVER_NAME'].getRelMainDir()."EXT_google_maps.php?wpName=".$wpInfo->intName."&lat=".$wpInfo->lat."&lon=".-$wpInfo->lon; ?>"
		  TITLE="Google Map" width="680px" height="400px"
		  scrolling="no" frameborder="0">
		Sorry. If you're seeing this, your browser doesn't support IFRAMEs.
		You should upgrade to a more current browser.
		</iframe>
		<? } ?>
	</td>
  </tr>
</table>
<?
  echo "</td></tr>";
  close_inner_table();
?>