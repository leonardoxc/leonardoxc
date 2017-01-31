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
// $Id: GUI_waypoint_add.php,v 1.9 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************

    if (! L_auth::isAdmin($userID)) {
		return;
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
		$waypt->location=$_POST['location'];
		$waypt->intLocation=$_POST['intLocation'];
		$waypt->countryCode=$_POST['countryCode'];
		$waypt->link=$_POST['link'];
		$waypt->description=$_POST['description'];

		if ( $waypt->putToDB(0) ) {
	 		echo "<div align=center><BR><BR>"._WAYPOINT_ADDED."<BR><BR>";								
		 	echo "<a href='".getLeonardoLink(array('op'=>'list_flights'))."'>RETURN to flights</a>"; 
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
    $nearestCountryCode=$row["countryCode"];
    mysql_freeResult($res);

  echo "<br>";

  open_inner_table(_ADD_WAYPOINT,650,"icon_pin.png"); 
  echo "<tr><td>";	


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

        <table width="600" border="0" align="center" cellpadding="2" class=main_text>
          <tr>
            <td width=200 bgcolor="#CFE2CF"><div align="right"><font color="#003366">Name</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="wname" type="text" id="wname" size="40">
              <input name="type" type="hidden" id="type" value="1000">
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">International
            Name</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="intName" type="text" id="intName" size="40">
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Region</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="location" type="text" id="location" size="40">
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">International
            Region</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="intLocation" type="text" id="intLocation" size="40">
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Country
            Code</font></div></td>
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
            <td width="199" bgcolor="#CFE2CF">
            <div align="right"><font color="#003366">lat</font></div></td>
            <td width="277" bgcolor="#E3E7F2"><font color="#003366">
              <input name="lat" type="text" id="lat" value='<? echo $waypointLat?>'>
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">lon</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="lon" type="text" id="lon" value='<? echo $waypointLon?>'>
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Relevant URL</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="link" type="text" id="link" size="60" >
            </font></td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#CFE2CF"><div align="right"><font color="#003366">Description</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <textarea name="description" cols="60" rows="5" id="description"></textarea>
            </font></td>
          </tr>

          <tr>
            <td bgcolor="#CFE2CF"><div align="right"></div></td>
            <td bgcolor="#E3E7F2">
				<input type="submit" name="Submit" value="<? echo _ADD_WAYPOINT ?>">
				<input type="hidden" name="addWaypoint" value="1"></td>
          </tr>
        </table>
</form>
    

<?
  echo "</td></tr>";
  close_inner_table();
?>
