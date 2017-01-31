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
// $Id: GUI_EXT_airspace_update_comment.php,v 1.9 2010/03/14 20:56:10 manolis Exp $                                                                 
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
	$area_id=makeSane($_REQUEST['area_id'],1);

	// echo $area_id;

	if ( $_POST['updateComment']==1 ) { // CHANGE waypoint
		$Comments=prep_for_DB($_POST['Comments']);
		$disabled=makeSane($_POST['disabled'],1);
		
		$query="UPDATE $airspaceTable SET Comments='$Comments' , disabled=$disabled WHERE id=$area_id";
		// echo $query;
		$res= $db->sql_query($query);	

	 	# Error checking
		if ( $res > 0) {
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
		} else {
			echo("<H3> Error in updating comment for airspace! </H3>\n");			
		}
		
	} else {

	  $query="SELECT Comments, disabled FROM $airspaceTable WHERE id=$area_id";
	  $res= $db->sql_query($query);	
	  # Error checking
	  if($res <= 0){
		 echo("<H3> Error in getting Comment for airspace from DB! $query</H3>\n");
		 exit();
	  }
		
	  if (! $row = $db->sql_fetchrow($res) ) {
		 echo("<H3> Error #2 in getting Comment for airspace from DB! $query</H3><BR> The area that is referenced as violated is no longer in the DB\n");
		 exit();
	  }


?> 

<form name="form1" method="post" action="">
	  <textarea name="Comments" cols="27" rows="3" id="description"><? echo $row['Comments'] ?></textarea>
      <br />
      Disable Area
	  <input type="checkbox" name="disabled" value="1" <? if ($row['disabled']) echo 'checked="checked"'; ?> />
	  <input type="hidden"  name="updateComment" value="1" />
	  <input type="submit" value="Update" />
</form>
    
<? } ?>