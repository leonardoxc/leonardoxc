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

  $flight=new flight();
  $flight->getFlightFromDB($flightID);

  if ( $flight->userID == $userID || in_array($userID,$admin_users)  ) {


	if ($_REQUEST["changeFlight"]) {  // make changes
		 $flight->cat=$_REQUEST["gliderCat"]+0;
 		 $flight->category=$_REQUEST["category"]+0;
		 $flight->glider=$_REQUEST["glider"];
		 $flight->grecord=$_REQUEST["grecord"]+0;
		 $flight->validated=$_REQUEST["validated"]+0;

		 $flight->comments=$_REQUEST["comments"];
		 //echo $flight->comments."<HR><HR>";
		 //exit;
		 $flight->linkURL=$_REQUEST["linkURL"];
  		 if ( substr($flight->linkURL,0,7) == "http://" ) $flight->linkURL=substr($flight->linkURL,7);

		if ($_REQUEST['is_private']=="1")  $flight->private=1; 
		else $flight->private=0;

		 for($i=1;$i<=$CONF_photosPerFlight;$i++) {
			$var_name="photo".$i."Filename";
			if ($_REQUEST["photo".$i."Delete"]=="1") {		// DELETE photo
				$flight->deletePhoto($i);
			} else if ($_FILES[$var_name]['name'] ) {  // upload new
				$flight->deletePhoto($i);  //first delete old
				$flight->$var_name=$_FILES[$var_name]['name'];
				if ( move_uploaded_file($_FILES[$var_name]['tmp_name'],  $flight->getPhotoFilename($i) ) ) {
					resizeJPG(130,130, $flight->getPhotoFilename($i), $flight->getPhotoFilename($i).".icon.jpg", 15);
					resizeJPG(1280,1280, $flight->getPhotoFilename($i), $flight->getPhotoFilename($i), 15);
				} else { //upload not successfull
					$flight->$var_name="";
				}
			}
		 }  

		 $flight->putFlightToDB(1);

		 open_inner_table(_CHANGE_FLIGHT_DATA,650);

		 echo "<center> <br><br>"._THE_CHANGES_HAVE_BEEN_APPLIED."<br><br><br>";
		 echo "<a href='?name=".$module_name."&op=show_flight&flightID=".$flightID."'>"._RETURN_TO_FLIGHT."</a><br><br><br>";
		 echo "</center>";
		 close_inner_table();
	} else { // show the form
// 

	if ( ($_GET['checkg']+0)==1) {
		$grecord_res="[ G-record checking result: ".$flight->validate()." ]";		
	}
	?>

<script language="JavaScript">
function setValue(obj)
{		
	var n = obj.selectedIndex;    // Which menu item is selected
	var val = obj[n].text;        // Return string value of menu item

	gl=MWJ_findObj("glider");
	gl.value=val;
	// document.inputForm.glider.value = value;
}
</script>
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
 
  <form action="" enctype="multipart/form-data" method="post">	
  <input type="hidden" name="changeFlight" value=1>
  <input type="hidden" name="flightID" value="<? echo $flightID ?>">
  <?  open_inner_table(_CHANGE_FLIGHT_DATA,730,"change_icon.png"); echo "<tr><td>"; ?>
  <table class=main_text width="100%" border="0" align="center" cellpadding="0" cellspacing="3" bgcolor="#E6EAE6" >

<? if ($enablePrivateFlights) { ?>
    <tr>
      <td colspan=2 valign="top">        
		<div align="right">
              <input type="checkbox" name="is_private" value="1" <? echo ($flight->private)?"checked":"" ?> >
             <? echo  _IS_PRIVATE ?>    
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
    <tr>
      <td colspan="2"  valign="top">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>	    <fieldset class="legendBox legend2">
		    <legend><? echo _GLIDER_TYPE ?></legend>
			<div align="left">
		    <b><img src="<? echo $moduleRelPath?>/img/icon_cat_<? echo $flight->cat ?>.png" border=0 />
            <select name="gliderCat">
           <?
				foreach ( $CONF_glider_types as $gl_id=>$gl_type) {
					if ($flight->cat==$gl_id) $is_type_sel ="selected";
					else $is_type_sel ="";
					echo "<option $is_type_sel value=$gl_id>".$gliderCatList[$gl_id]."</option>\n";
				}
			?>
		</select>
		</b>	  </div>
	    </fieldset>			</td>
            <td>
			   <fieldset class="legendBox legend2"><legend><? echo _GLIDER ?></legend>
	  <div align="left">
     <input name="glider" type="text" size="30" value="<? echo  $flight->glider ?>">
         
		<? 
			$gliders=  getUsedGliders($flight->userID) ;
			if (count($gliders)) { ?>
				<select name="gliderSelect" id="gliderSelect" onchange="setValue(this);">			
					<option></option>
					<? 
						foreach($gliders as $selGlider) {
							if ( $flight->glider == $selGlider) $glSel="selected";
							else $glSel="";
							echo "<option $glSel>".$selGlider."</option>\n";
						}
					?>
				</select>
			<? } ?>	
		       </div>
	  </fieldset>			</td>
            <td>
			   <fieldset class="legendBox legend2">
	    <legend><? echo _Category ?></legend>
	  <div align="left">	  
           <select name="category">
           <?
				foreach ( $CONF_category_types as $gl_id=>$gl_type) {
					if ($flight->category==$gl_id) $is_type_sel ="selected";
					else $is_type_sel ="";
					echo "<option $is_type_sel value=$gl_id>".$gl_type."</option>\n";
				}
			?>
		</select>
			  </div>
	    </fieldset>	
			
			</td>
          </tr>
        </table>		</td>
    </tr>
	<? if ($CONF_use_validation && in_array($userID,$admin_users) ) {?>
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
					
					$valStr="$vStr <img class='listIcons' src='".$moduleRelPath."/img/$vImg' title='$vStr' alt='$vStr' width='12' height='12' border='0' />";
					echo $valStr;
				
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
				<a href='?name=<?=$module_name?>&op=edit_flight&flightID=<?=$flight->flightID?>&checkg=1'>Re-check G-record</a>&nbsp;&nbsp;
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


    <tr>
      <td colspan="2" valign="middle">
	  <fieldset class="legendBox legend3"><legend><? echo _COMMENTS_FOR_THE_FLIGHT ?></legend>
	  <div align="left">
	    <textarea name="comments" cols="100" rows="5"><? echo  $flight->comments ?></textarea>
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
	<? for($i=1;$i<=$CONF_photosPerFlight;$i++) {
		$var_name="photo".$i."Filename";
	?>
    <tr>
      <td><div align="right" class="style2"><? echo _PHOTO ?> #<? echo $i?></div></td>
      <td>
	  
	  		<? if ( $flight->$var_name) { ?>
			<table width="100%"  border="0" cellspacing="0" cellpadding="2" class="main_text">
				<tr>
				  <td width="120"><img src="<? echo $flight->getPhotoRelPath($i).".icon.jpg"; ?>" border=0></td>
				  <td ><div align="center">
				    <? echo _DELETE_PHOTO ?>
				      <input type="checkbox" name="photo<? echo $i?>Delete" value="1">
				    	 <br><br><strong><? echo _OR ?> </strong><br><br> <? echo _NEW_PHOTO ?>
					  <input name="photo<? echo $i?>Filename" type="file" size="30">					
				  </div></td>
				</tr>
	    </table> <? } else {?>     
        <input name="photo<? echo $i?>Filename" type="file" size="30">
		<? } ?>      </td>
    </tr>
	<? } // end for ?>
	 <tr>
      <td><div align="right" class="style2"></div></td>
      <td>  <div align="center" class="style222">
        <div align="left"><?=_PHOTOS_GUIDELINES.$CONF_max_photo_size.' Kb'; ?></div>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><p><font face="Verdana, Arial, Helvetica, sans-serif">
          <input name="submit" type="submit" value="<? echo _PRESS_HERE_TO_CHANGE_THE_FLIGHT ?>">
</font></p>      </td>
    </tr>
  </table>
  
</form>
<?
			echo "</td></tr>";
	 		close_inner_table();
		} //show FORM
	} // end user check

?>
