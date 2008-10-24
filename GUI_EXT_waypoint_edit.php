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

	// echo "# $userID #";
    if (! L_auth::isAdmin($userID)) {
		 return;
    }
?><head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?=$CONF_ENCODING?>">
  <style type="text/css">
  body, p, table,tr,td {font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;}
  body {margin:0px}
  </style>
</head>
<?
	$waypointIDedit=makeSane($_REQUEST['waypointIDedit'],1);
echo $waypointIDedit."#"
;
	if ( $_POST['editWaypoint']==1 ) { // CHANGE waypoint
		$waypt=new waypoint($waypointIDedit);
		
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

		if ( $waypt->putToDB(1) ) {
		?>
		  <script language="javascript">
			  function refreshParent() {
				  topWinRef=top.location.href;
				  top.window.location.href=topWinRef;
			  }
		  </script>
		<?
			 echo "<center>"._THE_CHANGES_HAVE_BEEN_APPLIED."<br><br>";
			 echo "<a href='javascript:refreshParent();'>RETURN </a>"; 
			 echo "<br></center>";
		} else echo("<H3> Error in puting waypoint info into DB! </H3>\n");			
	} else {

	$waypt=new waypoint($waypointIDedit);
	$waypt->getFromDB();

?> 

      
<form name="form1" method="post" action="">

        <table width="350" border="0" align="center" cellpadding="2" class="shadowBox main_text">
          <tr>
            <td width="80" bgcolor="#CFE2CF"><div align="right"><font color="#003366">Name</font></div></td>
            <td width="150" bgcolor="#E3E7F2"><font color="#003366">
              <input name="wname" type="text" id="wname" size="25" value="<? echo $waypt->name ?>" >
              <input name="waypointIDedit " type="hidden" id="waypointIDedit " value="<? echo $waypointIDedit ?>" >
              <input name="type" type="hidden" id="type" value="<? echo $waypt->type ?>" >
            </font></td>
            <td colspan="2" bgcolor="#E3E7F2"><input type="submit" name="Submit" value="<? echo "Apply changes" ?>" /></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">International
            Name</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="intName" type="text" id="intName" size="25" value="<? echo $waypt->intName ?>" >
            </font></td>
            <td width="21" bgcolor="#E3E7F2">&nbsp;</td>
            <td width="120" bgcolor="#E3E7F2"><input type="hidden" name="editWaypoint" value="1" /></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Region</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="location" type="text" id="Location" size="25" value="<? echo $waypt->location ?>" >
            </font></td>
            <td bgcolor="#CFE2CF"><font color="#003366">lat</font></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="lat" type="text" id="lat"  value="<? echo $waypt->lat ?>" size="10" />
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">International
            Region</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="intLocation" type="text" id="intLocation" size="25" value="<? echo $waypt->intLocation ?>" >
            </font></td>
            <td bgcolor="#CFE2CF"><font color="#003366">lon</font></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="lon" type="text" id="lon"  value="<? echo $waypt->lon ?>" size="10" />
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Country
            Code</font></div></td>
            <td colspan="3" bgcolor="#E3E7F2"><font color="#003366">
		    <select name="countryCode">
				<? 				
					foreach ($countries as $key => $value) {
						if ($waypt->countryCode==$key) $sel=" selected ";
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
              <input name="link" type="text" id="link"  value="<? echo $waypt->link ?>" size="45" >
            </font></td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#CFE2CF"><div align="right"><font color="#003366">Description</font></div></td>
            <td colspan="3" bgcolor="#E3E7F2"><font color="#003366">
              <textarea name="description" cols="35" rows="5" id="description"><? echo $waypt->description ?></textarea>
            </font></td>
          </tr>
        </table>
</form>
    

<? } ?>