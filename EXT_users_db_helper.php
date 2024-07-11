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
// $Id: EXT_users_db_helper.php,v 1.4 2010/07/13 11:06:46 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	require_once "FN_pilot.php";
	require_once "FN_flight.php";
	require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();
	
	if (! L_auth::isAdmin($userID)  ) {
		return;
	}
	
	$op=makeSane($_POST['oper']);
	
	if ($op=='add') {

		$sql="INSERT INTO ".$CONF['userdb']['users_table']." (username,user_email)
			VALUES ( '".makeSane($_POST['username'],2)."','".makeSane($_POST['user_email'],2)."' ) ";					
		if (! $db->sql_query($sql) ) {		
			echo "Error in query : $sql<BR>";
		} 
		$user_id=$db->sql_nextid();
		
		// set password ?
		$user_password=makeSane($_POST['user_password'],2);		
		if ($user_password) {
			require_once dirname(__FILE__)."/CL_user.php";
			$res=LeoUser::changePassword($user_id,$user_password);
			if ( $res > 0 ) {
				// echo _PwdChanged;
			} else {
				echo _PwdChangeProblem;
				if ($res==-2) printf(': '._PwdTooShort, $CONF_password_minlength);				
			}
		
		}
		
		$sql="INSERT INTO $pilotsTable (countryCode,CIVL_ID,CIVL_NAME,FirstName,LastName,Sex,Birthdate,pilotID,serverID)
			VALUES(
			'".makeSane($_POST['countryCode'])."',
			'".makeSane($_POST['CIVL_ID'])."',
			'".makeSane($_POST['CIVL_NAME'],2)."',
			'".makeSane($_POST['FirstName'],2)."',
			'".makeSane($_POST['LastName'],2)."',
			'".makeSane($_POST['Sex'])."',
			'".makeSane($_POST['Birthdate'])."', 
			$user_id,0) ";
		if (! $db->sql_query($sql) ) {		
			echo "Error in query : $sql<BR>";
		} 	
		echo "User Added";	
		exit;
	} else if ($op=='del') {
		$user_id=makeSane($_POST['id']);
		
		$sql="DELETE FROM ".$CONF['userdb']['users_table']." WHERE user_id=$user_id ";					
		if (! $db->sql_query($sql) ) {		
			echo "Error in query : $sql<BR>";
		} 
					
		$pilot=new 	pilot(0,$user_id);
		$pilot->deletePilot(1,1);

		exit;
	} else if ($op=='edit') {
	
		$user_id=makeSane($_POST['id']);
		$sql="UPDATE $pilotsTable SET 
			countryCode='".makeSane($_POST['countryCode'])."',
			CIVL_ID='".makeSane($_POST['CIVL_ID'])."',
			CIVL_NAME='".makeSane($_POST['CIVL_NAME'],2)."',
			FirstName='".makeSane($_POST['FirstName'],2)."',
			LastName='".makeSane($_POST['LastName'],2)."',
			Sex='".makeSane($_POST['Sex'])."',
			Birthdate='".makeSane($_POST['Birthdate'])."' 
			WHERE pilotID=$user_id AND serverID=0";
		if (! $db->sql_query($sql) ) {		
			echo "Error in query : $sql<BR>";
		} 

		$sql="UPDATE ".$CONF['userdb']['users_table']." SET 
			username='".makeSane($_POST['username'],2)."',
			user_email='".makeSane($_POST['user_email'],2)."'		
			WHERE user_id=$user_id ";					
		if (! $db->sql_query($sql) ) {		
			echo "Error in query : $sql<BR>";
		} 
		
		// change password ?
		$user_password=makeSane($_POST['user_password'],2);		
		if ($user_password) {
			require_once dirname(__FILE__)."/CL_user.php";
			$res=LeoUser::changePassword($user_id,$user_password);
			if ( $res > 0 ) {
				echo _PwdChanged;
			} else {
				echo _PwdChangeProblem;
				if ($res==-2) printf(': '._PwdTooShort, $CONF_password_minlength);				
			}
		
		}
		exit;
	}
	
	
// to the url parameter are added 4 parameters as described in colModel
// we should get these parameters to construct the needed query
// Since we specify in the options of the grid that we will use a GET method 
// we should use the appropriate command to obtain the parameters. 
// In our case this is $_GET. If we specify that we want to use post 
// we should use $_POST. Maybe the better way is to use $_REQUEST, which
// contain both the GET and POST variables. For more information refer to php documentation.
// Get the requested page. By default grid sets this to 1. 
$page = $_REQUEST['page']; 

// get how many rows we want to have into the grid - rowNum parameter in the grid 
$limit = $_REQUEST['rows']; 
if (!$limit ) $limit =100;

// sorting order - at first time sortorder 
$sord = $_REQUEST['sord']; 

// get index row - i.e. user click to sort. At first time sortname parameter -
// after that the index from colModel 
$sidx = $_REQUEST['sidx']; 
if(!$sidx) $sidx ='user_id'; 

$sStr=" $sidx $sord ";

// search variables
$where_clause=" WHERE (1=1) ";
$wh = "";
$searchOn = $_REQUEST['_search'];
if($searchOn=='true') {
	$sarr = $_REQUEST;
	foreach( $sarr as $k=>$v) {
		switch ($k) {
			case 'username':
			case 'countryCode':
			case 'FirstName':
			case 'LastName':
			case 'user_email':
				$wh .= " AND ".$k." LIKE '%".$v."%'";
				break;
			case 'user_id':
			case 'Sex':
			case 'CIVL_ID':
				$wh .= " AND ".$k." = ".$v;
				break;
		}
	}
}

$where_clause.=$wh;

// calculate the number of rows for the query. We need this for paging the result 
$result = mysql_query("SELECT COUNT(*) AS count FROM  ".$CONF['userdb']['users_table'].", $pilotsTable $where_clause 
 AND  $pilotsTable.pilotID=".$CONF['userdb']['users_table'].".user_id AND $pilotsTable.serverID= 0" ); 

$row = mysql_fetch_array($result,MYSQL_ASSOC); 
$count = $row['count']; 

// calculate the total pages for the query 
if( $count > 0 ) { 
        $total_pages = ceil($count/$limit); 
} else { 
        $total_pages = 0; 
} 

// if for some reasons the requested page is greater than the total 
// set the requested page to total page 
if ($page > $total_pages) $page=$total_pages;

// calculate the starting position of the rows 
$start = $limit*$page - $limit;

// if for some reasons start position is negative set it to 0 
// typical case is that the user type 0 for the requested page 
if($start <0) $start = 0; 

// the actual query for the grid data 
$SQL = "SELECT *  FROM ".$CONF['userdb']['users_table'].", $pilotsTable $where_clause 
 AND  $pilotsTable.pilotID=".$CONF['userdb']['users_table'].".user_id AND $pilotsTable.serverID= 0
 ORDER BY $sStr LIMIT $start , $limit"; 
// echo $SQL;exit;
$result = mysql_query( $SQL ) or die("Couldn't execute query. $SQL ".mysql_error()); 

// echo  $SQL;exit;

// we should set the appropriate header information
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
              header("Content-type: application/xhtml+xml;charset=utf-8"); 
} else {
          header("Content-type: text/xml;charset=utf-8");
}
echo "<?xml version='1.0' encoding='utf-8'?>";
echo "<rows>";
echo "<page>".$page."</page>";
echo "<total>".$total_pages."</total>";
echo "<records>".$count."</records>";

// be sure to put text data in CDATA
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	
	echo "<row id='". $row['user_id']."'>";            
            echo "<cell>". $row['user_id']."</cell>";		
			echo "<cell><![CDATA[". $row['username']."]]></cell>";
			echo "<cell></cell>";
        	echo "<cell><![CDATA[". $row['user_email']."]]></cell>";
			echo "<cell><![CDATA[". $row['countryCode']."]]></cell>";
			echo "<cell><![CDATA[". $row['CIVL_ID']."]]></cell>";
			echo "<cell><![CDATA[". $row['CIVL_NAME']."]]></cell>";
			echo "<cell><![CDATA[". $row['FirstName']."]]></cell>";
			echo "<cell><![CDATA[". $row['LastName']."]]></cell>";
			echo "<cell><![CDATA[". $row['Sex']."]]></cell>";
			echo "<cell><![CDATA[". $row['Birthdate']."]]></cell>";
			// the act col
			//echo "<cell></cell>";
	echo "</row>";
}
echo "</rows>"; 
?>