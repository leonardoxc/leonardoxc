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
// $Id: GUI_admin_brands.php,v 1.12 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************

 
  if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }
  
  $workTable="temp_leonardo_gliders";
//  $workTable=$flightsTable;

  open_inner_table("ADMIN AREA :: Glider Brands Managment",650);
  open_tr();
  echo "<td align=left>";	

	if (!L_auth::isAdmin($userID)) {
		echo "<br><br>You dont have access to this page<BR>";
		exitPage();
	}
	$admin_op=makeSane($_GET['admin_op']);


	echo "<br>";
	echo "<ul>";
	
	
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_brands&admin_op=init'>1. Init (make temp table and copy gliders)</a><BR></a>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_brands&admin_op=glidersDetect'>2. Auto detect glider brands</a><BR></a>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_brands&admin_op=normalize'>3. Normalize 'glider' -> 'gliderName</a><BR></a>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_brands&admin_op=removeBrand'>4. Remove Brand from 'gliderName' Field</a><BR></a>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_brands&admin_op=useKnown'>5. Use known glider names to find unknown</a><BR></a>";
	echo "<HR>";

	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_brands&admin_op=createCSV'>6a. Create CSV file (copy - paste the output into a csv file) </a><BR>";
	echo "<li>6b. Edit the CSV file locally in Excel and fix errors<BR>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_brands&admin_op=createSQL'>6c. Create SQL to update main table from CSV file </a><BR>";
	echo "<li>6d. Run the SQL manually into the DB<BR>";

	echo "<HR>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_brands&admin_op=displayUnknown'>* See gliders with unknown brands</a><BR></a>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_brands&admin_op=displayKnown'>* See glider Names with KNOWN brands</a><BR></a>";
	echo "<hr>";


	if ($admin_op=="init") {
		execMysqlQuery("DROP TABLE IF EXISTS temp_leonardo_gliders;");
		execMysqlQuery("CREATE TABLE temp_leonardo_gliders (
			  glider varchar(100) NOT NULL default '',
			  gliderName VARCHAR( 100) NOT NULL default '',
			  gliderBrandID int(11) NOT NULL default '0',
			  PRIMARY KEY  (glider ),
			  KEY gliderBrandID(gliderBrandID)
			) TYPE=MyISAM;");
		execMysqlQuery("		
			INSERT INTO temp_leonardo_gliders
			SELECT glider, '', 0
			FROM `leonardo_flights`
			WHERE gliderBrandID=0
			GROUP BY glider
			ORDER BY glider;
		");	
	} else if ($admin_op=="createCSV") {
		$query="SELECT * FROM  $workTable   ORDER BY gliderBrandID,glider DESC ";		
		$res= $db->sql_query($query);
		$i=0;

		if($res > 0){
			echo "<pre>";
			while ($row = mysql_fetch_assoc($res)) {
				$gliderName=$row['glider'];
				$sql=str_replace("'","#",$row['gliderName'] ).";".$row['gliderBrandID'].";".$CONF['brands']['list'][$row['gliderBrandID']].";".addslashes ($row['glider']); 
				echo  "$sql\n";
			}
			echo "</pre>";
		}	

	} else if ($admin_op=="createSQL") {

		if (!$_POST['createSQL']) {
?>
		<BR><strong>Create SQL to update main table from CSV file </strong><BR>
		<FORM name="createSQLform" action="" enctype="multipart/form-data" method="post" >
			<input name="csvFile" type="file" size="50">Select CSV file<br>
			<input name="createSQL" type="submit" value="Create SQL"></p>      
		</form>
<?
			

		} else{ // parse the csv file

			echo "Uploaded CSV file <BR>";

			$tmpFilename=$_FILES['csvFile']['tmp_name'];
			$tmpFormFilename=$_FILES['csvFile']['name'];	
			if (!$tmpFilename) {
				echo "You havent provided a csv file<BR>";
			} else {
				$lines=file($tmpFilename);
				$i=0;
				echo "<pre>";
				foreach($lines as $line) {
					$parts=split(";",trim($line));
					$sql="UPDATE $flightsTable SET glider='".
					str_replace("'","\'",$parts[0] )."' , gliderBrandID = ".
					$parts[1]." WHERE glider='".addslashes ($parts[3])."' ; "; 
					echo $sql."\n";
					$i++;
					//if ($i>10) break;
				}
				echo "</pre>";
			}
		}
/*
		$query="SELECT * FROM  $workTable WHERE gliderBrandID<>0  ORDER BY glider DESC ";		
		$res= $db->sql_query($query);
		$i=0;

		if($res > 0){
			echo "<pre>";
			 while ($row = mysql_fetch_assoc($res)) { 
				$gliderName=$row['glider'];
				$sql="UPDATE $flightsTable SET glider='".str_replace("'","#",$row['gliderName'] )."' , gliderBrandID = ".$row['gliderBrandID']." WHERE glider='".addslashes ($row['glider'])."' ; "; 
				echo  "$sql\n";
			}
			echo "</pre>";
		}	
*/
	} else if ($admin_op=="normalize") {	
		echo "Normalize the 'glider' field and put it in 'gliderName'<BR>";
		$query="SELECT gliderBrandID, glider FROM  $workTable WHERE 1=1  ORDER BY glider DESC ";
		$res= $db->sql_query($query);
		$i=0;
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
				$gliderName=$row['glider'];
				
				// $gliderName=str_ireplace($brandsList[1][$row['gliderBrandID']],'',$gliderName);
				
				$gliderNameNorm=brands::sanitizeGliderName($gliderName);
				echo  " $gliderName => $gliderNameNorm <BR>";
				execMysqlQuery("update $workTable set gliderName='$gliderNameNorm' where glider='$gliderName'");
			}
		}	
	} else if ($admin_op=="removeBrand") {	
		echo "Remove the Brand name from the'gliderName' field<BR>";
		$query="SELECT gliderBrandID, gliderName , glider FROM  $workTable WHERE 1=1  ORDER BY glider DESC ";
		$res= $db->sql_query($query);
		$i=0;
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
				$gliderName=$row['glider'];
				$gliderNameNorm=$row['gliderName'];
				
				$gliderNameNew=str_ireplace($CONF['brands']['list'][$row['gliderBrandID']],'',$gliderNameNorm);
				
				$gliderNameNew=brands::sanitizeGliderName($gliderNameNew);
				echo  " $gliderNameNorm => $gliderNameNew <BR>";
				execMysqlQuery("update $workTable set gliderName='$gliderNameNew' where gliderName='$gliderNameNorm'");
			}
		}	
	} else if ($admin_op=="useKnown") {
		$query="SELECT gliderBrandID, glider ,gliderName FROM  $workTable WHERE gliderBrandID <> 0 group by glider ORDER BY glider DESC ";
		$res= $db->sql_query($query);
		$i=0;
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
				$gliderName=$row['glider'];
				//$count=$row['gNum'];
				//$gliderName=str_ireplace($brandsList[1][$row['gliderBrandID']],'',$gliderName);
				
				$gliderNameNorm=$row['gliderName'];
								
				$gliderNameNorm=strtolower($gliderNameNorm);	
				$gliderNameNorm=preg_replace('/[^\w]/','',$gliderNameNorm);
				if (strlen($gliderNameNorm) >2) $brandGliders[$row['gliderBrandID']][]=$gliderNameNorm;
	
				// echo  " $gliderName =>$gliderNameNorm=>brandID = ".$row['gliderBrandID']." <BR>";
			}
			
			foreach ($brandGliders as $bID=>$bGlidersList) {
				foreach ($bGlidersList as $gName) {
					execMysqlQuery("update $workTable set gliderBrandID=$bID where glider LIKE '%$gName%' AND gliderBrandID=0 ");
				}	
			
			}
			
		}	

	} else if ($admin_op=="displayKnown") {
		$query="SELECT gliderBrandID, glider ,gliderName FROM  $workTable WHERE gliderBrandID <> 0 ORDER BY gliderBrandID, gliderName  ASC";
		$res= $db->sql_query($query);
		$i=1;
		if($res > 0){
			echo "<table border=1 ><tr><td></td><td>Original Name</td><td>Brand Name</td><td>Glider Name</td></tr>";
			 while ($row = mysql_fetch_assoc($res)) { 
				$gliderName=$row['glider'];
				$gliderNameNorm=$row['gliderName'];
								
				//$gliderNameNorm=strtolower($gliderNameNorm);	
				//$gliderNameNorm=preg_replace('/[^\w]/','',$gliderNameNorm);
				//$brandGliders[$row['gliderBrandID']][]=$gliderNameNorm;
	
				echo  "<tr><td>$i</td><td>$gliderName</td><td>".$CONF['brands']['list'][$row['gliderBrandID']]."</td><td>$gliderNameNorm</td></tr>\n";
				$i++;
			}			
			echo "</table>";
		}	
	} else if ($admin_op=="displayUnknown") {	
		$query="SELECT * FROM  $workTable WHERE gliderBrandID =0 group by glider ORDER BY glider DESC ";
		$res= $db->sql_query($query);
		$i=1;
		if($res > 0){
		echo "<table border=1 ><tr><td></td><td>Original Name</td><td>Glider Name</td></tr>";
			 while ($row = mysql_fetch_assoc($res)) { 

				$gliderName=$row['glider'];
				$gliderNameNorm=$row['gliderName']; //brands::sanitizeGliderName($gliderName);
				//$glidersList[$row['glider']]=$gliderNameNorm;
				//$glidersListNorm[$gliderNameNorm]++;
				
				echo "<tr><td>$i</td><td>".$row['glider']."</td><td>".$gliderNameNorm."</td></tr>";
				$i++;
			}		
			echo "</table>";

		}
	} else if ($admin_op=="glidersDetect") {
		$forceRedetection=1;

		$query="SELECT glider, gliderBrandID FROM  $workTable WHERE 1=1 ";
		if (! $forceRedetection) $query.=" AND gliderBrandID<>0 ";
		// $query.=" LIMIT 10000 ";
		$res= $db->sql_query($query);
		
		$detectedGliderBrands=0;
		$totalGliderBrands=0;
		$i=0;
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
					$gliderBrandID=brands::guessBrandID($row['glider']);
					$totalGliderBrands++;
					if ( $gliderBrandID) { 
						$detectedGliderBrands++;
						$query2="UPDATE $workTable SET  gliderBrandID=$gliderBrandID  WHERE glider='".$row['glider']."'";
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
	
	function execMysqlQuery($query) {
		global $db;
		$res= $db->sql_query($query);
		if(! $res ){
			echo "Problem in query :$query<BR>";
			exit;
		}
	}
?>