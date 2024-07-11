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
// $Id: GUI_flight_edit.php,v 1.52 2010/11/21 14:26:01 manolis Exp $                                                                 
//
//************************************************************************

// require_once dirname(__FILE__).'/GUI_flight_edit_new.php'; return;
  require_once dirname(__FILE__).'/CL_image.php';
  require_once dirname(__FILE__)."/CL_NACclub.php";
  require_once dirname(__FILE__)."/CL_user.php";
  $flight=new flight();

  $flight->getFlightFromDB($flightID);


  if ( 	$flight->belongsToUser($userID) ||	L_auth::isModerator($userID)  ) {

	require_once dirname(__FILE__)."/CL_flightScore.php";
	$flightScore=new flightScore($flight->flightID);
	$flightScore->getFromDB();


	if ($_REQUEST["changeFlight"]) {  // make changes

		$newUserIDStr=$_POST["newUserID"];
		if ($newUserIDStr) { // move this flight to a new userID
			 $newUserIDStrPart=split('_',$newUserIDStr);
			 $newUserServerID=0;
			 if (count($newUserIDStrPart)>1) {
				$newUserServerID=$newUserIDStrPart[0];
			 	$newUserID=$newUserIDStrPart[1];				
	  	     } else if (is_numeric($newUserIDStr) ){
				$newUserID=$newUserIDStr;
			 } else {
				echo "Not correct format for new user ID<BR>";
				$inError=1;
			 }

			 if (!$inError) {
				 $flight->changeUser($newUserID,$newUserServerID);
			 }
		} else {

		 $flight->cat=$_REQUEST["gliderCat"]+0;
 		 $flight->category=$_REQUEST["category"]+0;
		 
		 $flight->gliderCertCategory=$_REQUEST["gliderCertCategory"]+0;
		 $flight->startType=$_REQUEST["startType"]+0;
		 
		 $flight->gliderBrandID=$_REQUEST["gliderBrandID"];
		 $flight->glider=$_REQUEST["glider"];
		 $flight->grecord=$_REQUEST["grecord"]+0;
		 $flight->validated=$_REQUEST["validated"]+0;

		$flight->airspaceCheck=$_REQUEST["airspaceCheck"]+0;
		$flight->airspaceCheckFinal=$_REQUEST["airspaceCheckFinal"]+0;
		$flight->airspaceCheckMsg=$_REQUEST["airspaceCheckMsg"];
		$flight->checkedBy=$_REQUEST["checkedBy"];

		// $flight->comments=$_REQUEST["comments"];
		 $flight->commentsEnabled=$_REQUEST["commentsEnabled"]+0;
		 //echo $flight->comments."<HR><HR>";
		 //exit;
		 $flight->linkURL=$_REQUEST["linkURL"];
  		 if ( substr($flight->linkURL,0,7) == "http://" ) $flight->linkURL=substr($flight->linkURL,7);

		if ($_REQUEST['is_private']=="1") {
		 	$flight->private = $flight->private | 0x01; 
		} else {
			$flight->private = $flight->private & (~0x01 & 0xff ); 
			// dont make any changes
			// $flight->private=0;
		}

		if ($_REQUEST['is_disabled']=="1") {
		 	$flight->private = $flight->private | 0x02; 
		} else {
			$flight->private = $flight->private & (~0x02 & 0xff ); 
		}

		if ($_REQUEST['is_friends_only']=="1") {
			$flight->private = $flight->private | 0x04;
		} else {
			$flight->private = $flight->private & (~0x04 & 0xff );
		}


		// to change nac club
		if ($CONF['NAC']['clubPerFlight'] ) {
			$flight->NACclubID=$_REQUEST["NACclubID"]+0;
			$flight->NACid=$_REQUEST["NACid"]+0;
		}

		require_once dirname(__FILE__)."/CL_flightPhotos.php";

		$flightPhotos=new flightPhotos($flight->flightID);
		$flightPhotos->getFromDB();

		$photosChanged=false;

		$j= $flightPhotos->photosNum ;

		for($i=0;$i<$CONF_photosPerFlight;$i++) {

			$var_name="photo".$i."Filename";
			$photoName=$_FILES[$var_name]['name'];
			$photoFilename=$_FILES[$var_name]['tmp_name'];
			if ( $photoName ) {  // upload new
				// $flight->deletePhoto($i);  //first delete old
				if ( CLimage::validJPGfilename($photoName) && CLimage::validJPGfile($photoFilename) ) {
					
					// $newPhotoName=toLatin1($photoName);
					// Fix for same photo filenames 2009.02.03
					// global $flightsAbsPath;	
					global $CONF;
					$newPhotoName=flightPhotos::getSafeName(
						LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$flight->getPilotID(),str_replace("%YEAR%",$flight->getYear(),$CONF['paths']['photos']) ),
						$photoName);				
						//$flightsAbsPath.'/'.$flight->getPilotID()."/photos/".$flight->getYear() , 
						//$photoName	) ;
						
					$phNum=$flightPhotos->addPhoto($j,$flight->getPilotID()."/photos/".$flight->getYear(), $newPhotoName,$description);								
					$photoAbsPath=$flightPhotos->getPhotoAbsPath($j);
					
					if ( move_uploaded_file($photoFilename, $photoAbsPath ) ) {
						CLimage::resizeJPG( $CONF['photos']['thumbs']['max_width'],
						 					$CONF['photos']['thumbs']['max_height'],
											$photoAbsPath, $photoAbsPath.".icon.jpg", 
											$CONF['photos']['compression']);
						CLimage::resizeJPG(
						 $CONF['photos']['normal']['max_width'],
						 $CONF['photos']['normal']['max_height'], $photoAbsPath, $photoAbsPath, 
						 $CONF['photos']['compression']);
						$flight->hasPhotos++;
						$photosChanged=true;
						$j++;
					} else { //upload not successfull - track back
						$flightPhotos->deletePhoto($j);
					}
				}
			}
		}

		// now delete photos if requested
		for($i=0;$i<$CONF_photosPerFlight;$i++) {
			if ($_REQUEST["photo".$i."Delete"]=="1") {		// DELETE photo
				// echo "deleting photo $i<HR>";
				$flightPhotos->deletePhoto($i);
				$flight->hasPhotos--;
				$photosChanged=true;
			} 
		}
		
		if ( $photosChanged ){

			// recompute geoTag info
			$flightPhotos->computeGeoInfo();

			//delete igc2kmz.kmz file
			require_once dirname(__FILE__).'/FN_igc2kmz.php';			
			deleteOldKmzFiles($flight->getKMLFilename(3),'xxx'); // delete all versions
		}


		$flight->putFlightToDB(1);

		// $flightPhotos->putToDB();
		 
		 
	   } // end else
		 openMain(_CHANGE_FLIGHT_DATA,0,'');

		 echo "<center><br><span class='OK'>"._THE_CHANGES_HAVE_BEEN_APPLIED."</span><br><br><br>";
		 echo "<a href='".getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID))."'>"._RETURN_TO_FLIGHT."</a><br><br><br>";
		 echo "</center>";
		 closeMain();
	} else { // show the form
// 

	if ( ($_GET['checkg']+0)==1) {
		$grecord_res="[ G-record checking result: ".$flight->validate()." ]";		
	}


	?>

<script src="<?=$moduleRelPath?>/js/jquery.selectboxes.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/flight_info.js" type="text/javascript"></script>

<script language="JavaScript">

function submitForm() {	
		
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
	// alert('all tests passed'); 	return false;


	return true;
}

var moduleRelPath='<?=$moduleRelPath?>';

$(document).ready(
	function(){
		selectGliderCat() ;
		selectGliderCertCategory(<?=$flight->category?>);
		// $("#category").val();
	}
);	

</script>

<? if ( L_auth::isAdmin($userID) && $CONF_airspaceChecks ) { ?>
<script language="javascript">
function update_comment(area_id) {	 	
	document.getElementById('addTakeoffFrame').src='<?=$moduleRelPath?>/GUI_EXT_airspace_update_comment.php?area_id='+area_id;
	MWJ_changeSize('addTakeoffFrame',270,105);
	MWJ_changeSize( 'takeoffAddID', 270,130 );
	toggleVisible('takeoffAddID','takeoffAddPos'+area_id,14,-50,410,320);
}
</script>	
<style type="text/css">
.dropBox {
	display:block;
	position:absolute;

	top:0px;
	left: -999em;
	width:auto;
	height:auto;
	
	visibility:hidden;

	border-style: solid; 
	border-right-width: 2px; border-bottom-width: 2px; border-top-width: 1px; border-left-width: 1px;
	border-right-color: #999999; border-bottom-color: #999999; border-top-color: #E2E2E2; border-left-color: #E2E2E2;
	border-right-color: #555555; border-bottom-color: #555555; border-top-color: #E2E2E2; border-left-color: #E2E2E2;
	
	background-color:#FFFFFF;
	padding: 1px 1px 1px 1px;
	margin-bottom:0px;

}

.categorySpan {
	padding:3px;
	border:1px solid #CC9900;
	background-color:#FFFFCC;
}

</style>
<div id="takeoffAddID" class="dropBox takeoffOptionsDropDown" style="visibility:hidden;">
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr><td class="infoBoxHeader" style="width:725px;" >
	<div align="left" style="display:inline; float:left; clear:left;" id="takeoffBoxTitle">Update Comment</div>
	<div align="right" style="display:inline; float:right; clear:right;">
	<a href='#' onclick="toggleVisible('takeoffAddID','takeoffAddPos',14,-20,0,0);return false;"><img src='<? echo $moduleRelPath."/templates/".$PREFS->themeName ?>/img/exit.png' border=0></a></div>
	</td></tr></table>
	<div id='addTakeoffDiv'>
		<iframe name="addTakeoffFrame" id="addTakeoffFrame" width="700" height="320" frameborder=0 style='border-width:0px'></iframe>
	</div>
</div> 
<? } ?>

<style type="text/css">
fieldset.legendBox { 
	border-style: solid; 
	border-right-width: 2px; border-bottom-width: 2px; border-top-width: 1px; border-left-width: 1px;
	border-right-color: #999999; border-bottom-color: #999999; border-top-color: #E2E2E2; border-left-color: #E2E2E2;

	padding:0 1em .5em 0.4em; 	
	margin-bottom:0.5em;
	margin-right:5px;
	margin-left:5px;
	text-align:left;
	background-color:#ffffff;
}
.legendBox legend {
	border:1px outset #E2E2E2;
	padding:0.2em 1.2em 0.2em 1.2em;
	margin:0;
	color:#000000;
	font-weight:normal;
	background-color:#F5E9CB;
}

.legend2 legend {	background-color: #D6E5F6 }
.legend3 legend {	background-color: #D7F5CB }

</style>
<? 
require_once dirname(__FILE__).'/FN_editor.php';
?>
  <form name="inputForm" id="inputForm"  action="" enctype="multipart/form-data" method="post" onsubmit="return submitForm();">	
  <input type="hidden" name="changeFlight" value=1>
  <input type="hidden" name="flightID" value="<? echo $flightID ?>">
  <?  openMain(_CHANGE_FLIGHT_DATA,0,"change_icon.png"); ?>

  <table class=main_text width="100%" border="0" align="center" cellpadding="0" cellspacing="3" bgcolor="#E6EAE6" >

<? if ($enablePrivateFlights || L_auth::isAdmin($userID) ) { ?>
    <tr>
      <td colspan=2 valign="top">  
	  <div align="right">
		  <? if ($enablePrivateFlights ) { ?>

			  <input type="checkbox" name="is_friends_only" value="1" <? echo ($flight->private & 4)?"checked":"" ?> >
			  <? echo  _IS_FRIENDS_ONLY_ ?>

              <input type="checkbox" name="is_private" value="1" <? echo ($flight->private & 1)?"checked":"" ?> >
             <? echo  _IS_PRIVATE ?>

		  <? } ?>
		<? if ( L_auth::isAdmin($userID) ) { ?>
              <input type="checkbox" name="is_disabled" value="1" <? echo ($flight->private & 2)?"checked":"" ?> >
             <? echo  "Disable Flight"; ?>    
		<? } ?>
		</div>         
		</td>
    </tr>
<? } ?>
    <tr>
      <td colspan="2"  valign="top">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
			<fieldset class="legendBox">
			<legend><? echo _PILOT_NAME ?></legend>
			<div align="left">
			<b><? echo $flight->userName ?></b>
			</b>	  </div>
			</fieldset>	
			</td>
            <td>
				<fieldset class="legendBox">
				<legend><? echo _THE_DATE." - "._TAKEOFF ?></legend>
				<div align="left">
				<b><? echo  formatDate($flight->DATE)." - ".getWaypointName($flight->takeoffID) ?></b>
				</b>	  </div>
				</fieldset>	
			</td>
            <td>
				<fieldset class="legendBox">
				<legend><? echo _IGC_FILE_OF_THE_FLIGHT ?></legend>
				<div align="left">
				<b><? echo  $flight->filename ?></b>
				</b>	  </div>
				</fieldset>	
			</td>
          </tr>
        </table>    
</td>
    </tr>
	<? if ($CONF['NAC']['clubPerFlight'] ) { ?>
	 <script type="text/javascript" language="javascript">
		var NAC_club_input_url="<? echo $moduleRelPath."/GUI_EXT_set_club.php"; ?>";	
		function setClub(NACid) {			
			if 	(NACid>0) {
				var NACclubID=$("#NACclubID").val();
				window.open(NAC_club_input_url+'?NAC_ID='+NACid+'&clubID='+NACclubID, '_blank',	'scrollbars=no,resizable=yes,WIDTH=450,HEIGHT=600,LEFT=150,TOP=100',false);
			}
		}
	</script>	
	<? } ?>
    <tr>
      <td colspan="2"  valign="top">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>	    <fieldset class="legendBox legend2">
		    <legend><? echo _GLIDER_TYPE ?></legend>
			<div align="left">
		    <b><?=leoHtml::img("icon_cat_".$flight->cat.".png",0,0,'absmiddle','','icons1')?>      
            <select name="gliderCat" id="gliderCat" onchange="selectGliderCat();">
           <?
				foreach ( $CONF_glider_types as $gl_id=>$gl_type) {
					if ($flight->cat==$gl_id) $is_type_sel ="selected";
					else $is_type_sel ="";
					echo "<option $is_type_sel value=$gl_id>".$gliderCatList[$gl_id]."</option>\n";
				}
			?>
		</select>
		</b>	  </div>
	    </fieldset>			
		</td>
		
		<td>
		 <fieldset class="legendBox legend2">
		    <legend><? echo _Start_type ?></legend>
			<div align="left">
		    
			<select name="startType" id="startType">
			<?
				foreach ( $CONF['startTypes'] as $s_id=>$s_type) {
	
					if ($s_id==$flight->startType) $is_type_sel ="selected";
					else $is_type_sel ="";
					echo "<option $is_type_sel value=$s_id>".$s_type."</option>\n";
				}
			?>
		  </select>
			  </div>
	    </fieldset>	
		
		</td>
	</tr>
	<? if ($CONF['NAC']['clubPerFlight'] ) {
	
		if ($flight->NACid) {
			$flightNacID=$flight->NACid;
		} else {
			list($flightNacID,$defaultPilotNacClubID)=NACclub::getPilotClub($flight->userID) ;
			// echo "#$flightNacID,$defaultPilotNacClubID#";
			// $flightNacID=24;
		}
		?>
		<tr>
            <td>
			<fieldset class="legendBox ">
			<legend><? echo _MEMBER_OF ?></legend>
			<div align="left">
				<? $NACName= $CONF_NAC_list[$flightNacID]['name']; ?>
                <strong><? echo $NACName ?></strong>
            </div>
			</fieldset>	
			</td>
            
            <td>
  			<?	$NACclub=NACclub::getClubName($flightNacID,$flight->NACclubID);	?>
				<fieldset class="legendBox legend2">
				<legend><? echo _Club ?></legend>
				<div align="left">
				<input name="NACclub" id="NACclub" type="text" size="60" value="<?=$NACclub?>">
                <input name="NACclubID" id="NACclubID" type="hidden" value="<?=$flight->NACclubID?>">
				<input name="NACid" id="NACid" type="hidden" value="<?=$flightNacID?>">
				<?	
				$showChangeClubLink="inline";		
				echo "<div id=\"mClubLink\" style=\"display: $showChangeClubLink\">[ <a href='#' onclick=\"setClub($flightNacID);return false;\">"._Select_Club."</a> ]</div>";
				?>
				</div>
				</fieldset>	
			</td>
          </tr>
		<? } ?>
        
		<tr>
		   <td colspan=2>
			   <fieldset class="legendBox legend2">
	    <legend><? echo _GLIDER_CERT  ?> / <? echo _Category  ?></legend>
	  <span align="left" id='categoryPg'>	
	  
	  <? 
		$catDesc=$CONF['gliderClasses'][$flight->cat]['classes'][$flight->category];
		$gliderCertID=$flight->gliderCertCategory;
	  ?>
	  <input name="gliderCertCategory" id="gliderCertCategory" type="hidden" value="<?=$flight->gliderCertCategory ?>">
	  <select name="gliderCertCategorySelect" id="gliderCertCategorySelect" onchange="selectGliderCertCategory(0)">
      	<?
			echo "<option value=0></option>\n";
			foreach ( $CONF_glider_certification_categories as $gl_id=>$gl_type) {
				if ($flight->gliderCertCategory == $gl_id) $sel=' selected ';
				else $sel='';
				echo "<option $sel value=$gl_id>".$CONF_glider_certification_categories[$gl_id]."</option>\n";
				
			}
		?>
	  </select>&nbsp;
      </span>
      
      <select name="category" id="category">
	  </select>
        			 
	</fieldset>	
			
			</td>
			</tr></table>
			</td>
		</tr>
		<tr>
	      <td colspan="2"  valign="top">			
            
			   <fieldset class="legendBox legend2"><legend><? echo _GLIDER ?></legend>
	  <div align="left">
	  
	  <table><tr><td><div align="left" class="styleItalic"><?=_Glider_Brand ?> </div>
			</td>
			<td><? echo _GLIDER ?>
			</td>
			<td><? echo _Or_Select_from_previous ?>
			</td>
			</tr>
			<tr>
			<td>
				<select name="gliderBrandID" id="gliderBrandID" >			
					<option value="0"></option>
					<? 
					$brandsListFilter=brands::getBrandsList();
					foreach($brandsListFilter as $brandNameFilter=>$brandIDfilter) {
						if (  $flight->gliderBrandID== $brandIDfilter ) $glSel="selected";
						else $glSel="";
						echo "<option $glSel value=$brandIDfilter>$brandNameFilter</option>";
					}					
				?>
				</select>
			</td>
			<td>
     <input name="glider" id="glider" type="text" size="20" value="<? echo  $flight->glider ?>">
         </td>
		 <td>
		<? 
			$gliders=  getUsedGliders($flight->userID) ;
			if (count($gliders)) { ?>
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
							
							if ( $flight->glider == $selGlider[1] && 
								 $flight->gliderBrandID==$selGlider[0] && 
								 $flight->cat==$selGlider[3] && 
								 $flight->category==$selGlider[4] && 
								 $flight->gliderCertCategory==$selGlider[2] 
								 ) $glSel="selected";
							else $glSel="";
							echo "<option $glSel value='".$selGlider[0]."_".$selGlider[1]."_".$selGlider[2]."_".$selGlider[3]."_".$selGlider[4]."'>".$flightBrandName.' '.$selGlider[1]." [$selCatStr$selCertStr$selClassStr]</option>\n";

//							echo "<option $glSel>".$selGlider."</option>\n";
						}
					?>	
					<? 
						if (0) 	
						foreach($gliders as $selGlider) {
							if ($selGlider[0]!=0) $flightBrandName= $CONF['brands']['list'][$selGlider[0]];
							else $flightBrandName='';

							if ( $flight->glider == $selGlider[1] && $flight->gliderBrandID==$selGlider[0]) $glSel="selected";
							else $glSel="";
							echo "<option $glSel value='".$selGlider[0]."_".$selGlider[1]."'>".$flightBrandName.' '.$selGlider[1]."</option>\n";

//							echo "<option $glSel>".$selGlider."</option>\n";
						}
					?>
				</select>
			<? } ?>	
					</td>
					</tr>
				</table>
				</div>
				</fieldset>		
		  	</td>

        	</td>
    </tr>
	<? if ($CONF_use_validation && L_auth::isAdmin($userID) ) {?>
    <tr>
      <td colspan="2"  valign="top">
	    <fieldset class="legendBox legend2">
	    <legend><? echo "Validation" ?></legend>
	  <div align="left">
	 	  <table class=main_text width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
				G Record: 
				<?
					if ($flight->grecord==0) $flight->validate();

					if ($flight->grecord==-1) 		{ $vImg="icon_valid_nok.gif"; $vStr="Invalid or N/A"; }
					else if ($flight->grecord==0) 	{ $vImg="icon_valid_unknown.gif"; $vStr="Not yet processed"; }
					else if ($flight->grecord==1) 	{$vImg="icon_valid_ok.gif"; $vStr="Valid"; }
					
					$valiStr="$vStr ".leoHtml::img($vImg,12,12,'absmiddle',$vStr,'icons1 listIcons');
					echo $valiStr;
				
/*
					if ($flight->grecord==1) $grecord_sel_1="selected";
					else if ($flight->grecord==-1) $grecord_sel_2="selected";
					else if ($flight->grecord==0) $grecord_sel_3="selected";
					echo "<option $grecord_sel_1 value='1'>Valid</option>\n";
				 	echo "<option $grecord_sel_2 value='-1'>Invalid or N/A</option>\n";
				  	echo "<option $grecord_sel_3 value='0'>Not yet processed</option>\n";
*/
				?>
				<input type="hidden" name="grecord" value="<?=$flight->grecord?>">
				<a href='<?=getLeonardoLink(array('op'=>'edit_flight','flightID'=>$flightID,'checkg'=>'1'))?>'>Re-check G-record</a>&nbsp;&nbsp;
				Validation <select name="validated">
				<?
					if ($flight->validated==1) $val_sel_1="selected";
					else if ($flight->validated==-1) $val_sel_2="selected";
					else if ($flight->validated==0) $val_sel_3="selected";
					echo "<option $val_sel_1 value='1'>Valid</option>\n";
				 	echo "<option $val_sel_2 value='-1'>Invalid</option>\n";
				  	echo "<option $val_sel_3 value='0'>Not yet processed</option>\n";
				?>
				</select>
				
				<? echo $grecord_res ?>			</td>
			</tr>
		</table>	
	    </div>
	    </fieldset></td>
    </tr>
	<? } ?>
	<? if ($CONF_airspaceChecks && L_auth::isAdmin($userID) ) {?>
    <tr>
      <td colspan="2"  valign="top">
	    <fieldset class="legendBox legend2">
	    <legend><? echo "Airspace Check" ?></legend>
	  <div align="left">
	 	  <table class=main_text width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
				<?
				
				function get_airspace_area_comment($area_id) {
					  global $db,$airspaceTable;
					  $query="SELECT Comments , disabled FROM $airspaceTable WHERE id=$area_id";
					  $res= $db->sql_query($query);	
					  # Error checking
					  if($res <= 0){
						 echo("<H3> Error in getting Comment for airspace from DB! $query</H3>\n");
						 exit();
					  }
						
					  if (! $row = $db->sql_fetchrow($res) ) {
						 //echo("<H3> Error #2 in getting Comment for airspace from DB! $query</H3>\n");
						 // exit();
						 return "";
					  }
					  if ($row['disabled']) $dStr="<strong>DISABLED</strong> ";
					  else $dStr='';
					  return $dStr.$row['Comments'];
				}
					// echo "#".$flight->airspaceCheck."#";
					if ($flight->airspaceCheck==0 || $flight->airspaceCheckFinal==0 ) $flight->checkAirspace(1);
					if ($flight->airspaceCheck==-1) { // problem
						echo "<strong>PROBLEM!</strong><BR>";
						$checkLines=explode("\n",$flight->airspaceCheckMsg);
						$area_ids=explode(",",$checkLines[0]);
						for($i=1;$i<count($checkLines); $i++) {
							echo $checkLines[$i];
							echo "<BR>COMMENT: ".get_airspace_area_comment($area_ids[$i-1]);
							echo " [ <a id='takeoffAddPos".$area_ids[$i-1]."' href='javascript:update_comment(".$area_ids[$i-1].");'>Update comment</a> ]<br>";
						}
						// echo "DETAILS:  <BR>";
					} else {// clear
						echo "<strong>CLEAR</strong><BR>";
					}

				?>
				<input type="hidden" name="airspaceCheck" value="<?=$flight->airspaceCheck?>">
				<input type="hidden" name="airspaceCheckMsg" value="<?=$flight->airspaceCheckMsg?>">

				Mark flight as <select name="airspaceCheckFinal">
				<?
					if ($flight->airspaceCheckFinal==1) $air_sel_1="selected";
					else if ($flight->airspaceCheckFinal==-1) $air_sel_2="selected";
					else if ($flight->airspaceCheckFinal==0) $air_sel_3="selected";
					echo "<option $air_sel_1 value='1'>Valid</option>\n";
				 	echo "<option $air_sel_2 value='-1'>Invalid</option>\n";
				  	echo "<option $air_sel_3 value='0'>Not yet processed</option>\n";
				?>
				</select>
				Comment / Checked by
				<input name="checkedBy" type="text" id="checkedBy" size="40" value="<? echo  $flight->checkedBy ?>">
				
				</td>
			</tr>
		</table>	
	    </div>
	    </fieldset></td>
    </tr>
	<? } ?>

    <tr>
      <td colspan="2" valign="middle">
	  
	  <fieldset class="legendBox legend3"><legend><? echo _COMMENTS_FOR_THE_FLIGHT ?></legend>
	  
	  <div align="left">
	   <label><?=_Comments_are_enabled_for_this_flight?>
  		<input type="checkbox" name="commentsEnabled" id="commentsEnabled" value="1" <?=(($flight->commentsEnabled)?'checked':'')?> />
  	</label>
	    <?
		/*  if ( L_auth::isModerator($userID) ) {
				$toolbar='Leonardo';
				$allowUploads=false;
			} else{
				$toolbar='LeonardoSimple';
 				$allowUploads=false;
			}
			createTextArea($flight->userServerID,$flight->userID,'comments',$flight->comments ,
							'flight_comments', $toolbar , $allowUploads, 693,200); 
		*/					
		?>	    
	    </div>
	  </fieldset>	</td>
    </tr>
    <tr>
      <td colspan="2"><fieldset class="legendBox legend3">
      <legend><? echo _RELEVANT_PAGE ?></legend>
	  <div align="left">
			http://<input name="linkURL" type="text" id="linkURL" size="90" value="<? echo  $flight->linkURL ?>">
	    </div>
	  </fieldset></td>
    </tr>
	<?	
		$photoNum=0;
		if ($flight->hasPhotos) {
			require_once dirname(__FILE__)."/CL_flightPhotos.php";
			$flightPhotos=new flightPhotos($flight->flightID);
			$flightPhotos->getFromDB();

		?>
		<tr>
	      <td valign="top">
		  		<table align="center">
		  			<tr>				 
    	  
	  <?
			foreach ( $flightPhotos->photos as $photoNum=>$photoInfo) {	
				echo '<td valign="top" align=center>'._PHOTO.' #'.($photoNum+1).
						'<BR />'._DELETE_PHOTO.
						'<input type="checkbox" name="photo'.$photoNum.'Delete" value="1">'.
						'<BR><img src="'.$flightPhotos->getPhotoRelPath($photoNum).'.icon.jpg" border=0>'.
						'</td>';
				if ( ( $photoNum +1) % 5 == 0  ) echo "</tr><tr>";
			}
			$photoNum= $flightPhotos->photosNum;
		?>
					</tr>
				</table>
		 </td>
		</tr>
		<?	
			
	 	}
		
		for($i=$photoNum;$i<$CONF_photosPerFlight;$i++) {
			$var_name="photo".$i."Filename";
			?>
			<tr>
				<td><div align="right" class="style2"><? echo _PHOTO ?> #<? echo ($i+1)?></div></td>
				<td>  
					<input name="photo<? echo $i?>Filename" type="file" size="30">
				</td>
			</tr>
			<? 
		} // end for 
		?>
	
	 <tr>
      <td><div align="right" class="style2"></div></td>
      <td>  <div align="center" class="style222">
        <div align="left"><?=_PHOTOS_GUIDELINES.$CONF_max_photo_size.' Kb'; ?></div>
      </div></td>
    </tr>
<? if ( L_auth::isAdmin($userID) ) {?>
    <tr>
      <td colspan=2 valign="top">        
	    <fieldset class="legendBox legend3">
		    <legend>ADMIN OPTION: Assign this flight to another pilot</legend>			
			 <input name="newUserID" type="text" size="10" value="">	
	    </fieldset>
		</td>
    </tr>
<? } ?>
    <tr>
      <td colspan=2 valign="top">&nbsp;       
	  </td></tR>
    <tr>
      <td>&nbsp;</td>
      <td><p><font face="Verdana, Arial, Helvetica, sans-serif">
          <input name="submit" type="submit" value="<? echo _PRESS_HERE_TO_CHANGE_THE_FLIGHT ?>">
</font></p>      </td>
    </tr>
  </table>
  
</form>
<?

	 		closeMain();
		} //show FORM
	} // end user check

?>
