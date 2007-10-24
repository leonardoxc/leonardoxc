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
//************************************************************************/

 
  if ( !is_leo_admin($userID) ) { echo "go away"; return; }
  
  open_inner_table("ADMIN AREA :: Glider Brands Managment",650);
  open_tr();
  echo "<td align=left>";	

	if (!in_array($userID,$admin_users)) {
		echo "<br><br>You dont have access to this page<BR>";
		exitPage();
	}
	$admin_op=makeSane($_GET['admin_op']);


	echo "<br>";
	echo "<ul>";
	echo "<li><a href='?name=".$module_name."&op=admin_brands&admin_op=glidersDetect'>Auto detect glider brands</a><BR></a>";
	echo "<li><a href='?name=".$module_name."&op=admin_brands&admin_op=displayUnknown'>See gliders with unknown brands</a><BR></a>";
	echo "<li><a href='?name=".$module_name."&op=admin_brands&admin_op=displayKnown'>See glider Names with KNONW brands</a><BR></a>";
	echo "<hr>";

function sanitizeGliderName($gliderName) {
	$gliderNameNorm=trim( preg_replace("/[\/\-\,\.]/",' ',$gliderName) );
	$gliderNameNorm=preg_replace("/( )+/",' ',$gliderNameNorm);
	
	$gliderNameNorm=preg_replace("/(III)/",'3',$gliderNameNorm);
	$gliderNameNorm=preg_replace("/(II)/",'2',$gliderNameNorm);
	$gliderNameNorm=preg_replace("/(one)/",'1',$gliderNameNorm);
	$gliderNameNorm=preg_replace("/(two)/",'2',$gliderNameNorm);
	$gliderNameNorm=preg_replace("/(three)/",'3',$gliderNameNorm);
	$gliderNameNorm=preg_replace("/(four)/",'4',$gliderNameNorm);
	$gliderNameNorm=preg_replace("/(five)/",'5',$gliderNameNorm);
	$gliderNameNorm=preg_replace("/(six)/",'6',$gliderNameNorm);
	$gliderNameNorm=preg_replace("/(seven)/",'7',$gliderNameNorm);
	$gliderNameNorm=preg_replace("/(eight)/",'8',$gliderNameNorm);
	$gliderNameNorm=preg_replace("/(nine)/",'9',$gliderNameNorm);
	
	$gliderNameNorm=ucwords(strtolower($gliderNameNorm));
	return $gliderNameNorm;
}

	if ($admin_op=="displayKnown") {	
		$query="SELECT gliderBrandID, glider , count(*) as gNum FROM  $flightsTable WHERE gliderBrandID <> 0 group by glider ORDER BY glider DESC ";
		$res= $db->sql_query($query);
		$i=0;
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
				$gliderName=$row['glider'];
				$count=$row['gNum'];
				$gliderName=str_ireplace($brandsList[1][$row['gliderBrandID']],'',$gliderName);
				
				$gliderNameNorm=sanitizeGliderName($gliderName);
				echo  " $gliderNameNorm=>$count<BR>";
			}
		}	
	} else if ($admin_op=="displayUnknown") {	
		$query="SELECT glider , count(*) as gNum FROM  $flightsTable WHERE gliderBrandID =0 group by glider ORDER BY glider DESC ";
		$res= $db->sql_query($query);
		$i=0;
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 

				$gliderName=$row['glider'];
				$gliderNameNorm=sanitizeGliderName($gliderName);
				$glidersList[$row['glider']]=$gliderNameNorm;
				$glidersListNorm[$gliderNameNorm]++;
				
				echo $row['glider'].' -> '.$row['gNum']." [ $gliderNameNorm ]<br>";
			}		
			echo "<HR><HR>";
			foreach ($glidersListNorm as $gliderNameNorm=>$count){
				echo  " $gliderNameNorm=>$count<BR>";
			}
		}
	} else if ($admin_op=="glidersDetect") {
		global $flightsAbsPath;
		$forceRedetection=1;

		$query="SELECT ID, cat, glider,  gliderBrandID FROM  $flightsTable WHERE batchOpProcessed=0 ";
		if (! $forceRedetection) $query.=" AND gliderBrandID<>0 ";
		$query.=" LIMIT 10000 ";
		$res= $db->sql_query($query);
		
		$detectedGliderBrands=0;
		$totalGliderBrands=0;
		$i=0;
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
					$gliderBrandID=guessBrandID($row['cat'],$row['glider']);
					$totalGliderBrands++;
					if ( $gliderBrandID) { 
						$detectedGliderBrands++;
						$query2="UPDATE $flightsTable SET batchOpProcessed=1, gliderBrandID=$gliderBrandID  WHERE ID=".$row['ID'];
						$res2= $db->sql_query($query2);					
						if(!$res2){
							echo "Problem in query:$query2<BR>";
							exit;
						}
					}
					$i++;
					if ($i%200==0) {
						echo "Total: $totalGliderBrands Detected: $detectedGliderBrands<BR>";
					}
			 }
		}
		echo "<BR><br><br>DONE !!!<BR>";		
	} 


	echo "</td></tr>";
    close_inner_table();
?>