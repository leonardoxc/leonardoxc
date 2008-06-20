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

	$query = 'SELECT * '	
		. ' FROM '.$flightsTable
		. ' WHERE '.$flightsTable.'.userID = '.$pilotIDview.' AND '.$flightsTable.'.userServerID = '.$serverID;
	$res= $db->sql_query($query);
		
	if($res <= 0){
	  echo("<H3> Error in pilot stats query </H3>\n");
	  return;
	}  



  $row = mysql_fetch_assoc($res);
  
  $realName=getPilotRealName($pilotIDview,$serverID);	
  $legend="<b>$realName</b> "._flights_stats;
  $legendRight="<a href='".CONF_MODULE_ARG."&op=list_flights&pilotID=".$serverID."_$pilotIDview&year=0&country='>"._PILOT_FLIGHTS."</a>";
  $legendRight.=" | <a href='".CONF_MODULE_ARG."&op=pilot_profile&pilotIDview=".$serverID."_$pilotIDview'>"._Pilot_Profile."</a>";
  

?>
<link rel="stylesheet" type="text/css" href="<?=$moduleRelPath?>/js/ext-2.1/ext-all.css" />
<link rel="stylesheet" type="text/css" href="<?=$moduleRelPath?>/js/ext-2.1/xtheme-gray.css" />
<link rel="stylesheet" type="text/css" href="<?=$moduleRelPath?>/js/ext-2.1/grid-examples.css" />
<link rel="stylesheet" type="text/css" href="<?=$moduleRelPath?>/js/ext-2.1/examples.css" />
<link rel="stylesheet" type="text/css" href="<?=$moduleRelPath?>/js/ext-2.1/lib.css" />

<script language="javascript" src="<?=$moduleRelPath?>/js/ext-2.1/adapter/ext/ext-base.js"></script>
<script language="javascript" src="<?=$moduleRelPath?>/js/ext-2.1/ext-all.js"></script>
<script language="javascript" src="<?=$moduleRelPath?>/js/ext-2.1/pager.js"></script>
<script language="javascript" src="<?=$moduleRelPath?>/js/ext-2.1/examples.js"></script>
<?

  open_inner_table("<table  class=main_text  width=100%><tr><td>$legend</td><td width=340 align=right bgcolor=#eeeeee>$legendRight</td></tr></table>",720,"icon_profile.png");
  open_tr();  
  echo "<td>";
  ?>
<div id="topic-grid"></div>

<?
  echo "</td></tr>"; 
  close_inner_table();
?>
