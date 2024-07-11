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
// $Id: GUI_admin_logs.php,v 1.13 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************

 
  if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }
  
  $sortOrder=makeSane($_REQUEST["sortOrder"]);
  if ( $sortOrder=="")  $sortOrder="actionTime";

  //$page_num=$_REQUEST["page_num"]+0;
  //if ($page_num==0)  $page_num=1;

	$query="SELECT count(*) as itemNum FROM ".$logTable;
	 // echo "#count query#$query<BR>";
	$res= $db->sql_query($query);
	if($res <= 0){   
	 echo("<H3> Error in count items query! $query</H3>\n");
	 exit();
	}
	$row = $db->sql_fetchrow($res);
	$itemsNum=$row["itemNum"];   
	
	$page_num=$_REQUEST["page_num"]+0;
	if ($page_num==0)  $page_num=1;
	
	$startNum=($page_num-1)*$PREFS->itemsPerPage;
	$pagesNum=ceil ($itemsNum/$PREFS->itemsPerPage);
	
//-----------------------------------------------------------------------------------------------------------
	
	$legend="Log entries";
	$legendRight=generate_flights_pagination(
			getLeonardoLink(array('op'=>'admin_logs','sortOrder'=>$sortOrder)),		
			$itemsNum,$PREFS->itemsPerPage,$page_num*$PREFS->itemsPerPage-1, TRUE , 3, 3); 

	$endNum=$startNum+$PREFS->itemsPerPage;
	if ($endNum>$itemsNum) $endNum=$itemsNum;
	$legendRight.=" [&nbsp;".($startNum+1)."-".$endNum."&nbsp;"._From."&nbsp;".$itemsNum ."&nbsp;]";
	if ($itemsNum==0) $legendRight="[ 0 ]";

	echo  "<div class='tableTitle shadowBox'>
	<div class='titleDiv'>$legend</div>
	<div class='pagesDivSimple' style='white-space:nowrap'>$legendRight</div>
	</div>" ;
	

  	$query="SELECT * FROM ".$logTable." ORDER BY $sortOrder DESC LIMIT $startNum,".$PREFS->itemsPerPage;	
   // echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){
		echo "no log entries found<br>";
		return ;
    }



function printHeaderTakeoffs($width,$sortOrder,$fieldName,$fieldDesc,$query_str) {
  global $moduleRelPath;
  global $Theme;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($fieldName=="intName") $alignClass="alLeft";
  else $alignClass="";

  if ($sortOrder==$fieldName) { 
   echo "<td $widthStr  class='SortHeader activeSortHeader $alignClass'>
			<a href='".CONF_MODULE_ARG."&op=admin_logs&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0  width=10 height=10></div>
		</td>";
  } else {  
	   echo "<td $widthStr  class='SortHeader $alignClass'><a href='".CONF_MODULE_ARG."&op=admin_logs&sortOrder=$fieldName$query_str'>$fieldDesc</td>";
   } 
}

  
   $headerSelectedBgColor="#F2BC66";

  ?>
  <table class='simpleTable' width="100%" border=0 cellpadding="2" cellspacing="0">
  <tr>
  	<td width="25" class='SortHeader'>#</td>
 	<?
		printHeaderTakeoffs(100,$sortOrder,"actionTime","DATE",$query_str) ;
		printHeaderTakeoffs(0,$sortOrder,"ServerItemID","Server",$query_str) ;
		printHeaderTakeoffs(80,$sortOrder,"userID","userID",$query_str) ;

		printHeaderTakeoffs(100,$sortOrder,"ItemType","Type",$query_str) ;
		printHeaderTakeoffs(100,$sortOrder,"ItemID","ID",$query_str) ;
		printHeaderTakeoffs(100,$sortOrder,"ActionID","Action",$query_str) ;
		echo '<td width="100" class="SortHeader">Details</td>';
		printHeaderTakeoffs(100,$sortOrder,"Result","Result",$query_str) ;
		echo '<td width="100" class="SortHeader">ACTIONS</td>';
		
	?>
	
	</tr>
<?
   	$currCountry="";
   	$i=1;
	while ($row = $db->sql_fetchrow($res)) {  
		if ( L_auth::isAdmin($row['userID'])  ) $admStr="*ADMIN*";
		else $admStr="";

		if ($row['ServerItemID']==0) $serverStr="Local";
		else $serverStr=$row['ServerItemID'];
		
		$i++;
		echo "<TR class='$sortRowClass'>";	
	   	echo "<TD>".($i-1+$startNum)." (".$row['transactionID'].")</TD>";
		 
		
		echo "<td>".date("d/m/y H:i:s",$row['actionTime'])."</td>\n";
		echo "<td>".$serverStr."</td>\n";
		echo "<td>".$row['userID']."$admStr<br>(".$row['effectiveUserID'].")</td>\n";
		echo "<td>".Logger::getItemDescription($row['ItemType'])."</td>\n";
		echo "<td>".$row['ItemID']."</td>\n";
		echo "<td>".Logger::getActionDescription($row['ActionID'])."</td>\n";
		echo "<td>";

		echo "<div id='sh_details$i'><STRONG><a href='javascript:toggleVisibility(\"details$i\");'>Show details</a></STRONG></div>";
			echo "<div id='details$i' style='display:none'><pre>".$row['ActionXML']."</pre></div>";
		echo "</td>\n";
		echo "<td>".$row['Result']."</td>\n";
		
		echo "<td>";
		if ($row['ItemType']==4) { // waypoint
				echo "<a href='".CONF_MODULE_ARG."&op=show_waypoint&waypointIDview=".$row['ItemID']."'>Display</a>";
		}
		
		echo "</td>\n";

		
		echo "</TR>";
   }     
   echo "</table>";
   $db->sql_freeresult($res);

?>