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
// $Id: GUI_flight_add.php,v 1.45 2012/01/16 07:21:22 manolis Exp $                                                                 
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
/*
	new defines
define("_GLIDER_CERT","Glider Certification");
define("_PLEASE_SELECT_YOUR_GLIDER_CERTIFICATION","Please select the certification of your glider");

AirTime
*/


?>
<style type="text/css">
<!--

.addGlider {
    font-style: italic;
}

.box {
	 background-color:#F4F0D5;
	 border:1px solid #555555;
	padding:3px; 
	margin-bottom:5px;
}

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
.takeoffOptionsDropDown {width:410px; }
.categorySpan {
	padding:3px;
	border:1px solid #CC9900;
	background-color:#FFFFCC;
}
-->
</style>
<div id="takeoffAddID" class="dropBox takeoffOptionsDropDown" style="visibility:hidden;">
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr><td class="infoBoxHeader" style="width:725px;" >
	<div align="left" style="display:inline; float:left; clear:left;" id="takeoffBoxTitle">Register Takeoff</div>
	<div align="right" style="display:inline; float:right; clear:right;">
	<a href='#' onclick="toggleVisible('takeoffAddID','takeoffAddPos',14,-20,0,0);return false;"><img src='<? echo $moduleRelPath."/templates/".$PREFS->themeName ?>/img/exit.png' border=0></a></div>
	</td></tr></table>
	<div id='addTakeoffDiv'>
		<iframe name="addTakeoffFrame" id="addTakeoffFrame" width="700" height="320" frameborder=0 style='border-width:0px'></iframe>
	</div>
</div>
<?
 $datafile=$_FILES['datafile']['name'];
 
 openMain( _SUBMIT_FLIGHT,0,"icon_add.png");

 if ($datafile=='') {   
?>

<script src="<?=$moduleRelPath?>/js/jquery.selectboxes.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/flight_info.js" type="text/javascript"></script>
<script language="JavaScript">

function submitForm() {
	var filename=$("#datafile").val();
	
	// for testing the other tests
	//filename='aa.igc';
	
	if ( filename=='' ) {
		alert('<?=_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE?>');
		return false;
	}

	var suffix=filename.substr(filename.length -3, 3).toLowerCase();
	// $("#glider").val(suffix);
	if ( suffix!='igc' && suffix!='olc' && suffix!='kml'  ) {
		alert('<?=_FILE_DOESNT_END_IN_IGC?>');
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
		if ( $("#startType").val()==0 ) {
			$("#startType").focus();
			alert('<?=_FLIGHTADD_STARTTYPE_MISSING?>');
			return false;
		}
	<? } ?>


	// for testing
	// alert('all tests passed'); 	return false;
	
	return true;
}

var moduleRelPath='<?=$moduleRelPath?>';
var gliderCerts=[];

function addGlider(){
    var brandID=$("#gliderBrandID").val();
    window.open("<? echo $moduleRelPath ?>/GUI_EXT_add_glider.php?brandID="+brandID,
            '_blank','scrollbars=no,resizable=yes,WIDTH=450,HEIGHT=300,LEFT=150,TOP=100',false);

}

function selectBrand() {
   var  gliderBrandID= $("#gliderBrandID").val();
    $.getJSON(moduleRelPath+'/AJAX_gliders.php?op=gliders_list&brandID='+gliderBrandID, function(resJson) {
            var options = '<option value=0></option>';
            gliderCerts=[];
            $.each(resJson.Records,function(k,v){
                var gID= v.gliderID;
                var gName= v.gliderName;
                options+= '<option value="'+gID+'">'+gName+'</option>';
                gliderCerts[gID]=v.gliderCert;
            });
            $("#gliderID").html(options);

    });

}


function selectGlider() {
    var gliderID= $("#gliderID").val();
    var gliderName=$( "#gliderID option:selected" ).text();
    var gliderCert=gliderCerts[gliderID];

    $("#glider").val(gliderName);
    $("#gliderCertCategory").val(gliderCert);
    $("#gliderCertCategorySelect").val(gliderCert);
    selectGliderCertCategory(0);
}


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


  <form name="inputForm" id="inputForm" action="" enctype="multipart/form-data" method="post" onsubmit="return submitForm();" >	
  <table class=main_text  width="700" height="400" border="0" align="center" cellpadding="4" cellspacing="2" >
    <tr>
      <td colspan="4"><div align="center" class="style111"><strong><?=_SUBMIT_FLIGHT?> </strong></div>      
        <div align="center" class="style222"><?=_ONLY_THE_IGC_FILE_IS_NEEDED?></div></td>
    </tr>
    <tr>
      <td width="205" valign="top"><div align="right" class="styleItalic"><?=_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT?></div></td>
      <td colspan="3" valign="top"><input name="datafile" id="datafile" type="file" size="50"></td>
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

	<span class="styleItalic">
        <label for='is_friends_only'><?=_IS_FRIENDS_ONLY_ ?></label>
      </span>
		<input type="checkbox" name="is_friends_only" value="1"  >



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
	  <select disabled="disabled" name="gliderCertCategorySelect" id="gliderCertCategorySelect" onchange="selectGliderCertCategory(0)">
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
    <td></td>
      <td valign="top"><div colspan="3" ><?=_Cat_Info ?></div></td>
      </tr>
    <tr>
      <td valign="top"><div align="right" class="styleItalic"><?=_Glider_Brand ?></div></td>
      <td colspan="3" valign="top"> <select name="gliderBrandID" id="gliderBrandID" onchange="selectBrand();">
					<option value=0></option>
					<? 
					$brandsListFilter=brands::getBrandsList();
					foreach($brandsListFilter as $brandNameFilter=>$brandIDfilter) {
						echo "<option  value=$brandIDfilter>$brandNameFilter</option>";
					}					
				?>
				</select>
                <?=_GLIDER ?>
                  <select name="gliderID" id="gliderID" onchange="selectGlider();">
                      <option value=0></option>
                  </select>

				 <input  name="glider"  id="glider" type="hidden" >			</td>
			</tr>	 

			 <tr>
      <td valign="top"><div align="right" class="styleItalic"><?=_Or_Select_from_previous ?></div></td>
      <td colspan="3" valign="top">

				<select name="gliderSelect" id="gliderSelect" onchange="setValue(this);">			
					<option value="0_"></option>

					<?
                        $gliders=  getUsedGliders($userID) ;
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
                <br>
                <a class='addGlider' href='javascript:addGlider();' ><?=_Cannot_find_your_glider ?></a>
			</td>
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
	  <td></td>
      <td colspan="4" valign="middle"><div align="left" class="styleItalic"><?=_COMMENTS_FOR_THE_FLIGHT?>
	 </div>
	  <div align="left">
	   <label><?=_Comments_are_enabled_for_this_flight?>
  		<input type="checkbox" name="commentsEnabled" id="commentsEnabled" value="1" <?=(($thisPilot->commentsEnabled)?'checked':'')?> />
  	  </label>
	
	    <? 	require_once dirname(__FILE__).'/FN_editor.php';
	  		if ( L_auth::isModerator($userID) ) {
				$toolbar='Leonardo';
				$allowUploads=false;
			} else{
				$toolbar='LeonardoSimple';
 				$allowUploads=false;
			}
			createTextArea($flight->userServerID,$flight->userID,'comments',$flight->comments ,
							'flight_comments', $toolbar , $allowUploads, 700,200);
							?>	  
		</td>
    </tr>

    <tr>
      <td><div align="right" class="styleItalic"><?=_RELEVANT_PAGE ?> </div></td>
      <td colspan="3">
        http://<input name="linkURL" type="text" id="linkURL" size="50" value="">		</td>
    </tr>
	<? for($i=0;$i<$CONF_photosPerFlight;$i++) { ?>
    <tr>
      <td><div align="right" class="styleItalic"><? echo _PHOTO.' #'.($i+1); ?></div></td>
      <td colspan="3">
        <input id="photo<?=$i?>Filename" name="photo<?=$i?>Filename" type="file" size="50">	  </td>
    </tr>
	<? } ?>
	 <tr>
      <td><div align="right" class="styleItalic"></div></td>
      <td colspan="3">  <div align="center" class="style222">
        <div align="left"><?=_PHOTOS_GUIDELINES.$CONF_max_photo_size.' Kb';?></div>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><p><input name="submit"  id="submit" type="submit" value="<?=_PRESS_HERE_TO_SUBMIT_THE_FLIGHT ?>"></p>      </td>
    </tr>
<? if ( defined('_FLIGHTADD_CONFIRMATIONTEXT')) { //_FLIGHTADD_CONFIRMATIONTEXT?>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3" style="font-weight:bold"">
      	<?=_FLIGHTADD_CONFIRMATIONTEXT?>      </td>
     </tr>
 <? } ?>
     <tr>
      <td colspan=4><div align="center" class="smallLetter"><em><?=_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE ?>
	<a href="<?=getLeonardoLink(array('op'=>'add_from_zip'))?>"><?=_PRESS_HERE ?> </a></em></div></td>
    </tr>
  </table>
  </form>
<? 
} else {  // form submited - add the flight

	set_time_limit (120);
	ignore_user_abort(true);	

	// print_r($_POST); exit;

	if ($_POST['insert_as_user_id'] >0 && L_auth::isAdmin($userID) ) $flights_user_id=$_POST['insert_as_user_id']+0;
	else $flights_user_id=$userID;

	$is_private=0;
	if ($_POST['is_private'] ==1 ) $is_private=1;
	if ($_POST['is_friends_only'] ==1 ) $is_private=4;


	$gliderCat=$_POST['gliderCat']+0;


	$tmpFilename=$_FILES['datafile']['tmp_name'];
	$tmpFormFilename=$_FILES['datafile']['name'];	

	$suffix=strtolower(substr($tmpFormFilename,-4));
	if ($suffix==".olc") $tmpFormFilename=substr($tmpFormFilename,0,-4).".igc"; // make it an igc file (we deal with its content later )
	
	if ($suffix==".kml") { // see if it is a kml file from GPSdump
		// echo "kml file<BR>";
		require_once dirname(__FILE__).'/FN_kml2igc.php';
		if ( kml2igc($tmpFilename) ) {
			$tmpFormFilename=substr($tmpFormFilename,0,-4).".igc"; 
		} 
	}
	
	
	if ( strtolower(substr($tmpFormFilename,-4))!=".igc" ) { // not allowed extension
		$result=ADD_FLIGHT_ERR_FILE_DOESNT_END_IN_IGC;
		@unlink($tmpFilename);
	} else {
		if (!$_FILES['datafile']['name']) addFlightError(_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE);

		# modification martin jursa 17.05.2008: require glider and brandid
		$glider=$_POST["glider"];
		$gliderBrandID=$_POST["gliderBrandID"]+0;
		if (!empty($CONF_require_glider) && (empty($glider) || empty($gliderBrandID))) {
			addFlightError(_YOU_HAVENT_ENTERED_GLIDER);
		}

		$gliderCertCategory=$_POST['gliderCertCategory']+0;
		
		$filename=LEONARDO_ABS_PATH.'/'.$CONF['paths']['tmpigc'].'/'.$tmpFormFilename ;
		// $filename=$flightsAbsPath."/".$flights_user_id."/".$tmpFormFilename;
		move_uploaded_file($tmpFilename, $filename );
		//$filename = preg_replace('/[\s\W]+/','_',$filename); //P.Wild A.Rieck - patch to prevent nasty characters spoiling filenames
		
		//	echo $filename; 
		$category=$_POST['category']+0;
		$comments=$_POST["comments"];
		//$glider=$_POST["glider"];
		//$gliderBrandID=$_POST["gliderBrandID"]+0;
		$linkURL=$_POST["linkURL"];

		if ($CONF['NAC']['clubPerFlight'] ) {
			$NACclubID=$_POST['NACclubID']+0;
			$NACid=$_POST['NACid']+0;
		} else {
			$NACclubID=-1;
			$NACid=-1;
		}
		
		list($result,$flightID)=addFlightFromFile($filename,true,$flights_user_id,
				array('gliderBrandID'=>$gliderBrandID,'private'=>$is_private,
					  '$linkURL'=>$linkURL,'comments'=>$comments,'glider'=>$glider,'category'=>$category,'cat'=>$gliderCat ,
					//	'allowDuplicates'=>($CONF['servers']['list'][$CONF_server_id]['allow_duplicate_flights']+0) ,
						'allowDuplicates'=>1, // we always allow duplicates when locally submitted. (will take over eternal flights) 
						'gliderCertCategory'=>$gliderCertCategory,
						'startType'=>$_POST["startType"]+0,
						'NACclubID'=>$NACclubID,'NACid'=>$NACid,
						'commentsEnabled'=>($_POST['commentsEnabled']+0)
					  ) 
				) ;
		
	}
	
	if ( $result !=1 ) {	
		// we must log the failure for debuging purposes
		@unlink($filename);
		$errMsg=getAddFlightErrMsg($result,$flightID);
		addFlightError($errMsg);	
	} else {
		$flight=new flight();
		$flight->getFlightFromDB($flightID);

		if ($flight->takeoffVinicity > $takeoffRadious*2 ) {
?>
<script language="javascript">
	 function user_add_takeoff(lat,lon,id) {	 
		MWJ_changeContents('takeoffBoxTitle',"Register Takeoff");
		document.getElementById('addTakeoffFrame').src='<?=$moduleRelPath?>/GUI_EXT_user_waypoint_add.php?refresh=0&lat='+lat+'&lon='+lon+'&takeoffID='+id;		
		MWJ_changeSize('addTakeoffFrame',720,345);
		MWJ_changeSize( 'takeoffAddID', 725,365 );
		toggleVisible('takeoffAddID','takeoffAddPos',-10,-50,725,435);
	 }
</script>




<?
			// $firstPoint=new gpsPoint($flight->FIRST_POINT,$flight->timezone);
			
			$firstPoint=new gpsPoint('',$flight->timezone);
			$firstPoint->setLat($flight->firstLat);
			$firstPoint->setLon($flight->firstLon);
			$firstPoint->gpsTime=$flight->firstPointTM;				

			$takeoffLink="<div align='center' id='attentionLinkPos' class='attentionLink box'><img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle> 
The takeoff/launch of your flight is not registered in Leonardo. <img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle><br>
This is nothing to worry about, but you can easily provide this info <br>by clicking on the 'Register Takeoff' link below.
<br> If you are not sure about some of the information is OK to skip this step. <br><BR> <a
				 href=\"javascript:user_add_takeoff(".$firstPoint->lat.",".$firstPoint->lon.",".$flight->takeoffID.")\">Register Takeoff</a><div id='takeoffAddPos'></div></div>";
			echo $takeoffLink;
			
		}
	//New 18.08.2013 P.Wild - Airspace warning before flight_show
		$flight->checkAirspace(1);
		if ((strpos($flight->airspaceCheckMsg,"HorDist"))) { // problem
			
			$checkLines=explode("\n",$flight->airspaceCheckMsg);
			//if (strrchr($flight->airspaceCheckMsg,"Punkte")){
			//	$adminPanel.="<br><strong>Deutschland Pokal</strong><BR>";
				if ((strpos($flight->airspaceCheckMsg,"HorDist"))) {
					$adminPanel.="<br><strong>Airspace PROBLEM</strong><BR>";
					for($i=1;$i<count($checkLines); $i++) {
						$adminPanel.=$checkLines[$i]."<br>";
					}
						
					echo "<div align='center' id='attentionLinkPos' class='attentionLink box'><img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle>
					$adminPanel<img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle><br></div>";
					$warningtext="<br><br><b>Der DHV-XC Server meldet ein Luftraumproblem f�r diesen Flug.</b><br><br>Wenn diese Meldung erfolgt sein sollte, obwohl eine Freigabe vorlag (z.B. wegen einer zeitlichen Deaktivierung eines kontrollierten Luftraumes (HX, EDR), einem aktiven Segelflugsektor oder einer Freigabe durch die Flugsicherung), kann der Flug mit dem unten stehenden Button �Freigabe best�tigen� durch dich frei gegeben werden. <br><br><i>Au�erdem muss der das Problem aufhebende Grund zwingend im Pilotenkommentar beschrieben werden.</i><br><br>Luftraumverletzungen sind verboten. Wenn die aufgezeichneten Positionsdaten mehr als 100 m horizontal oder vertikal in einem gesperrten Luftraum liegen, gilt eine Luftraumverletzung als nachgewiesen. In diesem Fall bitten wir mit dem unten stehenden zweiten Button �Flug l�schen� um die sofortige L�schung dieses Fluges vom Server.<br><br>Mit dem Abschicken dieser Daten best�tige ich, dass ich die f�r den eingereichten Flug geltenden luftrechtlichen Bestimmungen eingehalten habe. <br> ";
					echo "<div align='center' id='attentionLinkPos' class='attentionLink box'><img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle>
					$warningtext<img src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle><br></div>";
					
		}
			
		?>  	 
       				
       				<table>
       				<tr>
       			      <td>&nbsp;</td>
       			      <td colspan="3"><p><form action="<?=getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID))?>" method='post' ><input type="submit" value="<?=_PRESS_HERE_TO_CONFIRM_CLEARANCE ?>"></p></form></td>
       			    
       			      <td>&nbsp;</td>
       			      <td colspan="3"><p><form action="<?=getLeonardoLink(array('op'=>'delete_flight','flightID'=>$flightID))."&confirmed=1"?>" method='post' ><input type="submit" value="<?=_PRESS_HERE_TO_DELETE_FLIGHT ?>"></p></form></td>
       			    </tr>
       		    	</table>
       		    	
       					
       				<?php 	
       				}
       				
		
		else{	
		?>  	 
		  <p align="center"><span class="style111"><font face="Verdana, Arial, Helvetica, sans-serif"><?=_YOUR_FLIGHT_HAS_BEEN_SUBMITTED ?></font></span> <br>
		  <br>
		  <a href="<?=getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID))?>"><?=_PRESS_HERE_TO_VIEW_IT ?></a><br>
		  <em><?=_WILL_BE_ACTIVATED_SOON ?></em> 
		  <hr>	  
		<?
	}


}
	
}	
	closeMain(); 
?>