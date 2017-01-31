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
// $Id: GUI_flight_add_from_zip.php,v 1.29 2012/01/16 07:21:22 manolis Exp $                                                                 
//
//************************************************************************
	# modification martin jursa 02.06.2009: keep user==-1 from uploading flights and place a message
	if (!$userID || $userID==-1) {
		echo _You_are_not_login;
		return;
	}

 require_once dirname(__FILE__)."/CL_NACclub.php";
 require_once dirname(__FILE__)."/CL_pilot.php";
   
 $thisPilot=new pilot(0,$userID);
 $thisPilot->getFromDB();
 
 openMain( _SUBMIT_FLIGHT,0,"icon_add.png");

 if (!isset($_FILES['zip_datafile']['name'])) {
?>  
<style type="text/css">
<!--
.categorySpan {
	padding:3px;
	border:1px solid #CC9900;
	background-color:#FFFFCC;
}
-->
</style>
<script src="<?=$moduleRelPath?>/js/jquery.selectboxes.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/flight_info.js" type="text/javascript"></script>

<script language="JavaScript">
function submitForm() {

	var filename=$("#zip_datafile").val();
	
	// for testing the other tests
	//filename='aa.zip';
	if ( filename=='' ) {
		alert('<?=_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE?>');
		return false;
	}

	var suffix=filename.substr(filename.length -3, 3).toLowerCase();
	// $("#glider").val(suffix);
	if ( suffix!='zip'  ) {
		alert('<?=_FILE_DOESNT_END_IN_ZIP?>');
		return false;
	}	
		
	<? if ( $CONF_addflight_js_validation ) { ?>
		if ( $("#gliderCertCategory").val()==0 && $("#gliderCat").val() == 1 ) {
			$("#gliderCertCategorySelect").focus();
			alert('<?=_PLEASE_SELECT_YOUR_GLIDER_CERTIFICATION?>');
			return false;
		}		
		
		if ( $("#category").val()==0 && ( $("#gliderCat").val() == 1 || $("#gliderCat").val() == 2)  ) {
			$("#category").focus();
			alert('<?=_FLIGHTADD_CATEGORY_MISSING?>');
			return false;
		}
		
	<? } ?>
	
	<? if ( $CONF_require_glider ) { ?>	
		if ( $("#gliderBrandID").val()==0 && 
			 ( $("#gliderCat").val() == 1 || $("#gliderCat").val() == 2 || $("#gliderCat").val() == 4 || $("#gliderCat").val() == 16)
			 ) {
			$("#gliderSelect").focus();
			alert('<?=_FLIGHTADD_BRAND_MISSING?>');
			return false;
		}
	
		if ( $("#glider").val()==0 ) {
			$("#glider").focus();
			alert('<?=_FLIGHTADD_GLIDER_MISSING?>');
			return false;
		}
	<? } ?>

	// for testing
	//alert('all tests passed'); 	return false;
	
	return true;
}

var moduleRelPath='<?=$moduleRelPath?>';

$(document).ready(
		function(){
			selectGliderCat() ;
		}
	);

<? if ($CONF['NAC']['clubPerFlight'] ) { ?>	
var NAC_club_input_url="<? echo $moduleRelPath."/GUI_EXT_set_club.php"; ?>";	
function setClub(NACid) {			
	if 	(NACid>0) {
		var NACclubID=$("#NACclubID").val();
		window.open(NAC_club_input_url+'?NAC_ID='+NACid+'&clubID='+NACclubID, '_blank',	'scrollbars=no,resizable=yes,WIDTH=450,HEIGHT=600,LEFT=150,TOP=100',false);
	}
}	
<? } ?>

</script>

<form name="inputForm" action="" enctype="multipart/form-data" method="post" onsubmit="return submitForm();">	

  <table class=main_text width="630" border="0" align="center" cellpadding="5" cellspacing="3">
    <tr>
      <td colspan="4"><div align="center" class="style111"><strong><? echo _SUBMIT_MULTIPLE_FLIGHTS?> </strong></div>      
        <div align="center" class="style222"><? echo _ONLY_THE_IGC_FILES_WILL_BE_PROCESSED?></div></td>
    </tr>
    <tr>
      <td width="120" valign="top"><div align="right" class="styleItalic"><? echo _SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS ?></div></td>
      <td  colspan="3" valign="top">
        <input name="zip_datafile" id="zip_datafile" type="file" size="50">
      </td>
    </tr>
	<? // common part with GUI_flight_add_from_zip.php ?>
    <tr>
      <td  valign="top"><div align="right" class="styleItalic"> <?=_GLIDER_TYPE ?></div></td>
      <td width="160"  valign="top"><select name="gliderCat" id="gliderCat" onchange="selectGliderCat();">        
      	<?
			foreach ( $CONF_glider_types as $gl_id=>$gl_type) {

				if ($gl_id==$CONF_default_cat_add) $is_type_sel ="selected";
				else $is_type_sel ="";
				echo "<option $is_type_sel value=$gl_id>".$gliderCatList[$gl_id]."</option>\n";
			}
		?>
	  </select></td>
	  <td width="133"  valign="top"><? if ($enablePrivateFlights) { ?>
		<span class="styleItalic">
        <label for='is_private'><?=_MAKE_THIS_FLIGHT_PRIVATE ?></label>
      </span>
        <input type="checkbox" name="is_private" id="is_private" value="1">
		<? } ?></td>
    </tr>
    <tr>
      <td  valign="top"><div align="right" class="styleItalic"><?=_Start_Type?></div></td>
      <td  valign="top"><select name="startType" id="startType">
        <?
			foreach ( $CONF['startTypes'] as $s_id=>$s_type) {

				if ($s_id==$CONF['defaultStartType']) $is_type_sel ="selected";
				else $is_type_sel ="";
				echo "<option $is_type_sel value=$s_id>".$s_type."</option>\n";
			}
		?>
      </select></td>
      <td  valign="top">&nbsp;</td>
    </tr>
	<? if ($CONF['NAC']['clubPerFlight'] ) {

			list($flightNacID,$defaultPilotNacClubID)=NACclub::getPilotClub($userID) ;
			$NACName= $CONF_NAC_list[$flightNacID]['name'];
			$NACclub=NACclub::getClubName($flightNacID,$defaultPilotNacClubID);
		?>
		<tr>
            <td>
			<div align="right" class="styleItalic">
				<? echo _MEMBER_OF ?> <strong><? echo $NACName ?></strong>
            </div>
			</td>
            
            <td colspan=2>
				<div align="left">
				<? echo _Club ?>

				<input name="NACclub" id="NACclub" type="text" size="40" value="<?=$NACclub?>">
                <input name="NACclubID" id="NACclubID" type="hidden" value="<?=$defaultPilotNacClubID?>">
				<input name="NACid" id="NACid" type="hidden" value="<?=$flightNacID?>">
				[ <a href='#' onclick="setClub(<?=$flightNacID?>);return false;"><?=_Select_Club?></a> ]
				</div>
			</td>
          </tr>
		<? } ?>
	<tr >
      <td  valign="top"><div id='gCertDescription' align="right" class="styleItalic"> <?=_GLIDER_CERT ?></div></td>
      <td valign="top" colspan=2>
      <span id='categoryPg'>
	  <input name="gliderCertCategory" id="gliderCertCategory" type="hidden" value="0">
	  <select name="gliderCertCategorySelect" id="gliderCertCategorySelect" onchange="selectGliderCertCategory(0)">
      	<?
			echo "<option value=0></option>\n";
			foreach ( $CONF_glider_certification_categories as $gl_id=>$gl_type) {
				echo "<option  value=$gl_id>".$CONF_glider_certification_categories[$gl_id]."</option>\n";
			}
		?>
	  </select>&nbsp;      </span>
      
       <? echo _Category; ?> 
        <select name="category" id="category">
		</select>	        
		<? if (0) { ?>
	  <? echo _Category; ?> <span class='categorySpan' id='categoryDesc'>-</span>	  
	  <? } ?>
	  </td>
	  
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
				 <input name="glider"  id="glider" type="text" size="20" >			</td>
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
						// gliderBrandID,glider,gliderCertCategory,cat,category	
						foreach($gliders as $selGlider) {
							if ($selGlider[0]!=0) $flightBrandName= $CONF['brands']['list'][$selGlider[0]];
							else $flightBrandName='';
							
							$selCat=$selGlider[3];
							$selCatStr=$gliderCatList[$selCat];
							$selClassStr=$CONF['gliderClasses'][$selCat]['classes'][$selGlider[4]];
							if ($selClassStr)  $selClassStr=" - ".$selClassStr;
							
							$selCertStr="";
							if ($selCat==1) {
								$selCertStr=$CONF_glider_certification_categories[$selGlider[2] ];
								if ($selCertStr) $selCertStr=" - ".$selCertStr;
							}
							echo "<option value='".$selGlider[0]."_".$selGlider[1]."_".$selGlider[2]."_".$selGlider[3]."_".$selGlider[4]."'>".$flightBrandName.' '.$selGlider[1]." [$selCatStr$selCertStr$selClassStr]</option>\n";

//							echo "<option $glSel>".$selGlider."</option>\n";
						}
					?>
				</select>
			<? } ?>				</td>
    </tr>
	
	 <tr>
	  <td valign="top"><div align="right" class="styleItalic"><?=_COMMENTS_FOR_THE_FLIGHT ?></div></td>
      <td colspan="3" valign="top">
	  <div align="left">
	   <label><?=_Comments_are_enabled_for_this_flight?>
  		<input type="checkbox" name="commentsEnabled" id="commentsEnabled" value="1" <?=(($thisPilot->commentsEnabled)?'checked':'')?> />
  		</label>   
	    </div>
	  </fieldset></td>
    </tr>

	<? if ( L_auth::isAdmin($userID)) { ?>
    <tr>
      <td width="205" valign="top"><div align="right" class="styleItalic"><?=_INSERT_FLIGHT_AS_USER_ID?></div></td>
      <td colspan="3" valign="top">
        <input name="insert_as_user_id"  id="insert_as_user_id"  type="text" size="10">		</td>
    </tr>
 	<? }?>

	<? // End of common part ?>	
	
    <tr>
      <td>&nbsp;</td>
      <td colspan=3><p><font face="Verdana, Arial, Helvetica, sans-serif">
          <input name="submit" id="submit" type="submit" value="<? echo _PRESS_HERE_TO_SUBMIT_THE_FLIGHTS ?>">
</font></p>
      </td>
    </tr>
<? if ( defined('_FLIGHTADD_CONFIRMATIONTEXT')) { //_FLIGHTADD_CONFIRMATIONTEXT?>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3" style="font-weight:bold"">
      	<?=_FLIGHTADD_CONFIRMATIONTEXT?>
      </td>
    </tr>
 <? } ?>
 </table>

</form>
<?  
} else {  
	ignore_user_abort(true);
	set_time_limit (120);

	$filename=$_FILES['zip_datafile']['name'];
	$gliderCat=$_POST['gliderCat'];

	if (!$filename) addFlightError(_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE);

	# modification martin jursa 17.05.2008: require glider and brandid
	$glider=$_POST["glider"];
	$gliderBrandID=$_POST["gliderBrandID"]+0;
	if (!empty($CONF_require_glider) && (empty($glider) || empty($gliderBrandID))) {
		addFlightError(_YOU_HAVENT_ENTERED_GLIDER);
	}
	$category=$_POST['category']+0;
	$gliderCertCategory=$_POST['gliderCertCategory']+0;

	if ($CONF['NAC']['clubPerFlight'] ) {
		$NACclubID=$_POST['NACclubID']+0;
		$NACid=$_POST['NACid']+0;
	} else {
		$NACclubID=-1;
		$NACid=-1;
	}
		
	if (strtolower(substr($filename,-4))!=".zip") addFlightError(_FILE_DOESNT_END_IN_ZIP);


	if ($_POST['insert_as_user_id'] >0 && L_auth::isAdmin($userID) ) $flights_user_id=$_POST['insert_as_user_id']+0;
	else $flights_user_id=$userID;

	$randName=sprintf("%05d",rand(1, 10000) );
	
	$tmpZIPfolder=LEONARDO_ABS_PATH.'/'.$CONF['paths']['tmpigc'].'/zipTmp_'.$flights_user_id.'_'.$randName ;
	// $tmpZIPfolder=$flightsAbsPath."/".$flights_user_id."/flights/zipTmp".$randName ;
	$tmpZIPPath=LEONARDO_ABS_PATH.'/'.$CONF['paths']['tmpigc'].'/zipFile'.$flights_user_id.'_'.$randName.'.zip';
	//$tmpZIPPath=$flightsAbsPath."/".$flights_user_id."/flights/zipFile".$randName.".zip";
	
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
										'glider'=>$glider,'category'=>$category,'allowDuplicates'=>1 ,
										'gliderCertCategory'=>$gliderCertCategory,
										'startType'=>$_POST["startType"]+0,
										'NACclubID'=>$NACclubID,'NACid'=>$NACid,
										'commentsEnabled'=>($_POST['commentsEnabled']+0)
										) 
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
	

	closeMain(); 

?>