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
// $Id: GUI_EXT_waypoint_add.php,v 1.16 2009/03/11 16:12:22 manolis Exp $                                                                 
//
//************************************************************************
	@session_start();
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

	if (! L_auth::isAdmin($userID)) {
		return;
    }
	$waypointLat=$_REQUEST['lat']+0;
	$waypointLon=$_REQUEST['lon']+0;



	if ( $_POST['addWaypoint']==1 ) { // ADD waypoint
		$waypt=new waypoint(0);
		
		$waypt->name=makeSane($_POST['wname'],2);
		$waypt->intName=makeSane($_POST['intName'],2);
		$waypt->type=makeSane($_POST['type'],1);
		$waypt->lat=makeSane($_POST['lat'],1);
		$waypt->lon=makeSane($_POST['lon'],1);
		$waypt->location=makeSane($_POST['location'],2);
		$waypt->intLocation=makeSane($_POST['intLocation'],2);
		$waypt->countryCode=makeSane($_POST['countryCode'],2);
		$waypt->link=makeSane($_POST['link'],2);
		$waypt->description=makeSane($_POST['description'],2);

		if (! $waypt->name && ! $waypt->intName  ) {
			echo("<H3> Please give takeoff name! </H3>\n");		
		   return;
		}

		// fill in values that the user left out.
		if (! $waypt->name ) 	$waypt->name =$waypt->intName;
		if (! $waypt->intName ) $waypt->intName=$waypt->name;
		if (! $waypt->location ) 	$waypt->location =$waypt->intLocation;
		if (! $waypt->intLocation ) $waypt->intLocation=$waypt->location;


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
		 	echo "<a href='javascript:refreshParent();'>RETURN </a>"; 
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
  ?><head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?=$CONF_ENCODING?>">
  <style type="text/css">
  body, p, table,tr,td {font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;}
  body {margin:0px}
  </style>
</head>
  <?

 // open_inner_table(_ADD_WAYPOINT,450,"icon_pin.png"); 
 // echo "<tr><td>";	


	// get info from leonardo server around the world !!!
    // $leonardoServers=array("www.paraglidingforum.com","www.sky.gr","www.vololibero.net","xc.parapente.com.ar","www.ypforum.com","parablog.com.ar","www.heidel.com.ar");
    $leonardoServers=array();
	foreach ($leonardoServers as $leonardoServer) {
		getWaypointInfo($leonardoServer,$waypointLat,$waypointLon);
	}

	function getWaypointInfo($leonardoServer,$lat,$lon) {
		global $moduleRelPath;
		echo "Trying server : $leonardoServer<br>";
		$fp = @fsockopen ($leonardoServer,80, $errno, $errstr, 3); 
		if (!$fp)  { 
			echo "SERVER $leonardoServer NOT ACTIVE"; 
			return 0;
		} else fclose ($fp); 


		$fl= "http://$leonardoServer/modules/leonardo/EXT_takeoff.php?op=find_wpt&lat=$lat&lon=$lon";
		 echo $fl."<br>";
		$contents = implode("\n",file($fl)); 

		require_once dirname(__FILE__).'/lib/miniXML/minixml.inc.php';
		$xmlDoc = new MiniXMLDoc();
		$xmlDoc->fromString($contents);
		$xmlArray=$xmlDoc->toArray();

		echo "Name: ".$xmlArray[search][waypoint][name]."#<BR>";
		echo "Name: ".$xmlArray[search][waypoint][intName]."#<BR>";
		echo "Name: ".$xmlArray[search][waypoint][location]."#<BR>";
		echo "Name: ".$xmlArray[search][waypoint][intLocation]."#<BR>";
		echo "Name: ".$xmlArray[search][waypoint][type]."#<BR>";
		echo "Name: ".$xmlArray[search][waypoint][countryCode]."#<BR>";
		echo "Name: ".$xmlArray[search][waypoint][lat]."#<BR>";
		echo "Name: ".$xmlArray[search][waypoint][lon]."#<BR>";
		echo "Name: ".$xmlArray[search][waypoint][link]."#<BR>";
		echo "Name: ".$xmlArray[search][waypoint][description]."#<BR>";
		echo "Name: ".$xmlArray[search][waypoint][modifyDate]."#<BR>";
		echo "Name: ".$xmlArray[search][distance]."#<BR>";

		echo "<hr>";

	}
?> 

      
<form name="form1" method="post" action="">

        <table width=350 border="0" align="center" cellpadding="2" class="shadowBox main_text">
          <tr>
            <td width=100 bgcolor="#CFE2CF"><div align="right"><font color="#003366">Name</font></div></td>
            <td width=150 bgcolor="#E3E7F2"><font color="#003366">
              <input name="wname" type="text" id="wname" size="25">
              <input name="type" type="hidden" id="type" value="1000">
            </font></td>
            <td colspan="2" bgcolor="#CFE2CF"><input type="submit" name="Submit" value="<? echo _ADD_WAYPOINT ?>" />
              <input type="hidden" name="addWaypoint" value="1" /></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">International
            Name</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="intName" type="text" id="intName" size="25">
            </font></td>
            <td colspan="2" bgcolor="#E3E7F2">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Region</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="location" type="text" id="location" size="25">
            </font></td>
            <td bgcolor="#CFE2CF"><font color="#003366">lat</font></td>
            <td bgcolor="#E3E7F2">
              <input name="lat" type="text" id="lat" value='<? echo $waypointLat?>' size="10" />
            </td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">International
            Region</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="intLocation" type="text" id="intLocation" size="25">
            </font></td>
            <td bgcolor="#CFE2CF"><font color="#003366">lon</font></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="lon" type="text" id="lon" value='<? echo $waypointLon?>' size="10" />
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Country
            Code</font></div></td>
            <td colspan="3" bgcolor="#E3E7F2"><font color="#003366">
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
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Relevant URL</font></div></td>
            <td colspan="3" bgcolor="#E3E7F2"><font color="#003366">
              <input name="link" type="text" id="link" size="45" >
            </font></td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#CFE2CF"><div align="right"><font color="#003366">Description</font></div></td>
            <td colspan="3" bgcolor="#E3E7F2"><font color="#003366">
              <textarea name="description" cols="35" rows="4" id="description"></textarea>
            </font></td>
          </tr>
        </table>
</form>
    

<?
//  echo "</td></tr>";
//  close_inner_table();
?>