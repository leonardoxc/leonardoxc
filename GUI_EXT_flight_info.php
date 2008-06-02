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
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";

	$flightID=makeSane($_GET['flightID'],1);
	if ($flightID<=0) exit;
		
	$flight=new flight();
	$flight->getFlightFromDB($flightID);

    if (  !auth::isModerator($userID) ) {
		echo "go away";
		return;
    }


  ?><head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?=$CONF_ENCODING?>">

<style type="text/css">
	 body, p, table,tr,td {font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;}
	 td {border:1px solid #777777; }
	 body {margin:0px; background-color:#E9E9E9}
	.box {
		 background-color:#F4F0D5;
		 border:1px solid #555555;
		padding:3px; 
		margin-bottom:5px;
	}
	.boxTop {margin:0; }
</style>
</head>
<?
	$query="SELECT * from $flightsTable WHERE  ID=$flightID";
	$res= $db->sql_query($query);

	if(!$res > 0) { 
		echo "<h1> ERROR in query: $query</h1>";
		return;
	}
	
	if ( ! $row= mysql_fetch_assoc($res) ) { 
		echo "<h1> ERROR in getting flight from DB</h1>";
		return;	
	}
		
	echo "<table width='400'>";
	$fieldNum=count($row);

	$i=0;
	foreach ($row as $var_name=>$var_value) {
		echo "<tr>";
		echo "<td >$var_name</td><td >$var_value</td>";
		
		echo "</tr>\n";
		$i++;
	}		
	echo "</table>";
?>