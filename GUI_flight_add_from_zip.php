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
 if (!$userID) return;
 
 open_inner_table( _SUBMIT_FLIGHT,650,"icon_add.png");
 echo "<tr><td>";

 if (!isset($_FILES['zip_datafile']['name'])) {
?>  
<script language="JavaScript">
function setValue(obj)
{		
	var n = obj.selectedIndex;    // Which menu item is selected
	var val = obj[n].value;        // Return string value of menu item

	var valParts= val.split("_");

	gl=MWJ_findObj("glider");
	gl.value=valParts[1];

	gl=MWJ_findObj("gliderBrandID");
	gl.value=valParts[0];

	// document.inputForm.glider.value = value;
}
</script>
<form name="inputForm" action="" enctype="multipart/form-data" method="post" >	

  <table class=main_text width="630" border="0" align="center" cellpadding="5" cellspacing="3">
    <tr>
      <td colspan="4"><div align="center" class="style111"><strong><? echo _SUBMIT_MULTIPLE_FLIGHTS?> </strong></div>      
        <div align="center" class="style222"><? echo _ONLY_THE_IGC_FILES_WILL_BE_PROCESSED?></div></td>
    </tr>
    <tr>
      <td width="120" valign="top"><div align="right" class="styleItalic"><? echo _SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS ?></div></td>
      <td  colspan="3" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif">
        <input name="zip_datafile" type="file" size="50">
      </font></td>
    </tr>
    <tr>
	<td  valign="top"><div align="right" class="styleItalic"> <?=_GLIDER_TYPE ?></div></td>
      <td width="193"  valign="top"><select name="gliderCat">        
      	<?
			foreach ( $CONF_glider_types as $gl_id=>$gl_type) {

				if ($gl_id==$CONF_default_cat_add) $is_type_sel ="selected";
				else $is_type_sel ="";
				echo "<option $is_type_sel value=$gl_id>".$gliderCatList[$gl_id]."</option>\n";
			}
		?>
	  </select></td>
      <td width="172"  valign="top"><? echo _Category; ?> <select name="category">
	  <? 
			foreach ( $CONF_category_types as $gl_id=>$gl_type) {
					if ($CONF_default_category==$gl_id) $is_type_sel ="selected";
					else $is_type_sel ="";
					echo "<option $is_type_sel value=$gl_id>".$gl_type."</option>\n";
			}
		?></select>		</td>
      <td width=155 align="center"  valign="top"><? if ($enablePrivateFlights) { ?>
		<span class="styleItalic">
        <?=_MAKE_THIS_FLIGHT_PRIVATE ?>
      </span>
        <input type="checkbox" name="is_private" value="1">
	  <? } ?></td>
    </tr>
	
	
    <tr>
      <td valign="top"><div align="right" class="styleItalic"><?=_Glider_Brand ?></div></td>
      <td colspan="3" valign="top"> <select name="gliderBrandID" id="gliderBrandID" >			
					<option value=0></option>
					<? 
					$brandsListFilter=brands::getBrandsList();
					foreach($brandsListFilter as $brandNameFilter=>$brandIDfilter) {
						echo "<option  value=$brandIDfilter>$brandNameFilter</option>";
					}					
				?>
				</select>
				<?=_GLIDER ?>
				 <input name="glider" type="text" size="20" > 
		</td>
	</tr>	 
				 		<? 
			$gliders=  getUsedGliders($userID) ;
			if (count($gliders) ||1) {
				
				 ?>
	  <tr>
      <td valign="top"><div align="right" class="styleItalic"><?=_Or_Select_from_previous ?></div></td>
      <td colspan="3" valign="top"> 
				<select name="gliderSelect" id="gliderSelect" onchange="setValue(this);">			
					<option value="0_"></option>
					<? 
							
						foreach($gliders as $selGlider) {
							if ($selGlider[0]!=0) $flightBrandName= $CONF['brands']['list'][$selGlider[0]];
							else $flightBrandName='';
							
							echo "<option value='".$selGlider[0]."_".$selGlider[1]."'>".$flightBrandName.' '.$selGlider[1]."</option>\n";

//							echo "<option $glSel>".$selGlider."</option>\n";
						}
					?>
				</select>
			</td>	
		</tr>
			<? } ?>	

	<? if ( L_auth::isAdmin($userID)) { ?>
    <tr>
      <td width="120" valign="top"><div align="right" class="styleItalic"><?=_INSERT_FLIGHT_AS_USER_ID?></div></td>
      <td colspan="3" valign="top">
        <input name="insert_as_user_id" type="text" size="10">
	  </td>
    </tr>
 	<? }?>
    <tr>
      <td>&nbsp;</td>
      <td colspan=3><p><font face="Verdana, Arial, Helvetica, sans-serif">
          <input name="submit" type="submit" value="<? echo _PRESS_HERE_TO_SUBMIT_THE_FLIGHTS ?>">
</font></p>
      </td>
    </tr>
  </table>
  
</form>
<?  
} else {  
	ignore_user_abort(true);
	set_time_limit (120);

	$filename=$_FILES['zip_datafile']['name'];
	$gliderCat=$_POST['gliderCat'];

	$category=$_POST['category']+0;
	$glider=$_POST["glider"];
	$gliderBrandID=$_POST["gliderBrandID"]+0;
		
		
	if (!$filename) addFlightError(_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE);
	if (strtolower(substr($filename,-4))!=".zip") addFlightError(_FILE_DOESNT_END_IN_ZIP);


	if ($_POST['insert_as_user_id'] >0 && L_auth::isAdmin($userID) ) $flights_user_id=$_POST['insert_as_user_id']+0;
	else $flights_user_id=$userID;
	
	checkPath($flightsAbsPath."/".$flights_user_id);

	$tmpZIPfolder=$flightsAbsPath."/".$flights_user_id."/flights/zipTmp".sprintf("%05d",rand(1, 10000) ) ;
	$tmpZIPPath=$flightsAbsPath."/".$flights_user_id."/flights/".$filename;
	move_uploaded_file($_FILES['zip_datafile']['tmp_name'], $tmpZIPPath );

	//delDir($tmpZIPfolder);
	//exec("unzip -o -j ".$tmpZIPPath." -d '".$tmpZIPfolder."'" );

	makeDir($tmpZIPfolder);
	require_once dirname(__FILE__)."/lib/pclzip/pclzip.lib.php";
	$archive = new PclZip($tmpZIPPath);
    $list 	 = $archive->extract(PCLZIP_OPT_PATH, $tmpZIPfolder,
                                PCLZIP_OPT_REMOVE_ALL_PATH,
								PCLZIP_OPT_BY_PREG, "/(\.igc)|(\.olc)$/i");

	echo "<b>List of uploaded igc/olc files</b><BR>";
	$f_num=1;
	foreach($list as $fileInZip) {
		echo "$f_num) ".$fileInZip['stored_filename']. ' ('.floor($fileInZip['size']/1024).'Kb)<br>';
		$f_num++;
	}
	flush2Browser();
	flush2Browser();

	 $igcFiles=0;
	 $igcFilesSubmited=0;
	 $dir=	$tmpZIPfolder;
	 $current_dir = opendir($dir);

	 global $alreadyValidatedInPage;
	 
	 while($entryname = readdir($current_dir)){
		if( ! is_dir("$dir/$entryname") && ($entryname != "." and $entryname!="..")  && 
			( strtolower(substr($entryname,-4))==".igc" ||  strtolower(substr($entryname,-4))==".olc" )  ) {					
		   	 $igcFiles++;
			 $igcFilename=$dir."/".$entryname;
			 echo _ADDING_FILE." ".$entryname."<br>\n";

			flush2Browser();
			flush2Browser();
			sleep(1);

			$alreadyValidatedInPage=0;
			list($res,$flightID)=addFlightFromFile($igcFilename,0,$flights_user_id,
								array('gliderBrandID'=>$gliderBrandID, 'cat'=>$gliderCat,
										'glider'=>$glider,'category'=>$category,'allowDuplicates'=>1 ) 
			) ;
			 
			 if ($res==1) { 
					echo _ADDED_SUCESSFULLY."<BR>";
					$igcFilesSubmited++;					
			 } else  {
				$errMsg=getAddFlightErrMsg($res,$flightID);
				echo _PROBLEM.": ".$errMsg."<br>";
			 }
			 echo "<hr>";
			 flush2Browser();
			// flush2Browser();
		}
	 }
	 closedir($current_dir);

	 echo "<br><br>"._TOTAL." ".$igcFiles." "._IGC_FILES_PROCESSED."<br>";
	 echo "<br>"._TOTAL." ".$igcFilesSubmited." "._IGC_FILES_SUBMITED."<br><br>";
	 @unlink($tmpZIPPath);
	 delDir($tmpZIPfolder);

 	 flush2Browser();
	 //while (@ob_end_flush()); 

	}
	
	echo "</td></tr>";
	close_inner_table(); 



?>