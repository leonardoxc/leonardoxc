<?
//************************************************************************
// Leonardo XC Server, https://github.com/leonardoxc/leonardoxc
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_EXT_waypoint_delete.php,v 1.12 2010/03/14 20:56:10 manolis Exp $                                                                 
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
	$waypointIDdelete=makeSane($_REQUEST['waypointIDdelete'],1);
	$waypt=new waypoint($waypointIDdelete);
	$waypt->getFromDB();

	if ( $_POST['deleteWaypoint']==1 ) { // DELETE waypoint
		$waypt=new waypoint($waypointIDdelete);
		if ( $waypt->delete() ) {
		?>
		  <script language="javascript">
			  function refreshParent() {
				  topWinRef=top.location.href;
				  top.window.location.href=topWinRef;
			  }
		  </script>
		<?
			 echo "<center>"._THE_TAKEOFF_HAS_BEEN_DELETED."<br><br>";
			 echo "<a href='javascript:refreshParent();'>RETURN </a>"; 
			 echo "<br></center>";
		} else echo("<H3> Error in deleting waypoint  from DB! </H3>\n");			
	} else {
?> 

      
<form name="form1" method="post" action="">

        <table width="350" border="0" align="center" cellpadding="2" class="shadowBox main_text">
          <tr>
            <td width="80" bgcolor="#CFE2CF"><div align="right"><font color="#003366">Name</font></div></td>
            <td width="150" bgcolor="#E3E7F2"><font color="#003366">
              <? echo $waypt->name ?>
              <input name="waypointIDdelete" type="hidden" id="waypointIDdelete" value="<? echo $waypointIDdelete ?>" >
              <input name="type" type="hidden" id="type" value="<? echo $waypt->type ?>" >
            </font></td>
            <td colspan="2" bgcolor="#E3E7F2"><input type="submit" name="Submit" value="<? echo "Delete waypoint" ?>" /></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">International
            Name</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366"><? echo $waypt->intName ?>
            </font></td>
            <td width="21" bgcolor="#E3E7F2">&nbsp;</td>
            <td width="120" bgcolor="#E3E7F2">Type: <? echo $waypt->type; ?><input type="hidden" name="deleteWaypoint" value="1" /></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Region</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366"><? echo $waypt->location ?></font></td>
            <td bgcolor="#CFE2CF"><font color="#003366">lat</font></td>
            <td bgcolor="#E3E7F2"><font color="#003366"><? echo $waypt->lat ?>
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">International
            Region</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366"><? echo $waypt->intLocation ?>
            </font></td>
            <td bgcolor="#CFE2CF"><font color="#003366">lon</font></td>
            <td bgcolor="#E3E7F2"><font color="#003366"><? echo $waypt->lon ?>
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Country
            Code</font></div></td>
            <td colspan="3" bgcolor="#E3E7F2"><font color="#003366"><? echo $countries[$waypt->countryCode];?>
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Relevant URL</font></div></td>
            <td colspan="3" bgcolor="#E3E7F2"><font color="#003366"><? echo $waypt->link ?>
            </font></td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#CFE2CF"><div align="right"><font color="#003366">Description</font></div></td>
            <td colspan="3" bgcolor="#E3E7F2"><font color="#003366"><? echo $waypt->description ?>
            </font></td>
          </tr>
        </table>
</form>
    

<? } ?>