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
		 $flight->cat=$_REQUEST["gliderCat"];
		 $flight->glider=$_REQUEST["glider"];
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
 
  <form action="" enctype="multipart/form-data" method="post">	
  <input type="hidden" name="changeFlight" value=1>
  <input type="hidden" name="flightID" value="<? echo $flightID ?>">
  <?  open_inner_table(_CHANGE_FLIGHT_DATA,650,"change_icon.png"); echo "<tr><td>"; ?>
  <table class=main_text width="100%" border="0" align="center" cellpadding="5" cellspacing="3" bgcolor="#FBFCEF" >

    <tr>
      <td width="170" valign="top"><div align="right" class="style2"><? echo _PILOT_NAME ?></div></td>
      <td valign="top">
        <table class=main_text width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><b><? echo  $flight->userName ?></b></td>
            <td width="170"><? if ($enablePrivateFlights) { ?><input type="checkbox" name="is_private" value="1" <? echo ($flight->private)?"checked":"" ?> >
            <? echo  _IS_PRIVATE ?><? } ?></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td  valign="top"><div align="right" class="style2"> <? echo _GLIDER_TYPE ?></div></td>
      <td  valign="top"><b><img src="<? echo $moduleRelPath?>/img/icon_cat_<? echo $flight->cat ?>.png" border=0 />
           <select name="gliderCat">
           <?
				foreach ( $CONF_glider_types as $gl_id=>$gl_type) {
					if ($flight->cat==$gl_id) $is_type_sel ="selected";
					else $is_type_sel ="";
					echo "<option $is_type_sel value=$gl_id>".$gliderCatList[$gl_id]."</option>\n";
				}
			?>
			</select>
		</b>
	</td>
    </tr>
	<? if ($CONF_use_validation && in_array($userID,$admin_users) ) {?>
    <tr>
      <td  valign="top"><div align="right">Validation</div></td>
      <td  valign="top">
	 	  <table class=main_text width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
				G Record <select name="grecord">
				<?
					echo "<option $is_type_sel value='1'>Valid</option>\n";
				 	echo "<option $is_type_sel value='-1'>Invalid or N/A</option>\n";
				  	echo "<option $is_type_sel value='0'>Unknown</option>\n";
				?>
				</select>

				Validation <select name="grecord">
				<?
					echo "<option $is_type_sel value='1'>Valid</option>\n";
				 	echo "<option $is_type_sel value='-1'>Invalid or N/A</option>\n";
				  	echo "<option $is_type_sel value='0'>Unknown</option>\n";
				?>
				</select>
				
				<a href=''>Revalidate</a>
				<? $flight->validate(); ?>
			</td>
			</tr>
			</table>	  
	  </td>
    </tr>
	<? } ?>
    <tr>
      <td  valign="top"><div align="right" class="style2"><? echo _THE_DATE." - "._TAKEOFF ?></div></td>
      <td  valign="top"><b><? echo  formatDate($flight->DATE)." - ".getWaypointName($flight->takeoffID) ?></b></td>
    </tr>
    <tr>
      <td  valign="top"><div align="right" class="style2"><? echo _IGC_FILE_OF_THE_FLIGHT ?></div></td>
      <td  valign="top"><b><? echo  $flight->filename ?></b></td>
    </tr>

    <tr>
      <td valign="middle"><div align="right" class="style2"><font face="Verdana, Arial, Helvetica, sans-serif"><? echo _COMMENTS_FOR_THE_FLIGHT ?></font></div></td>
      <td valign="top"><font face="Verdana, Arial, Helvetica, sans-serif">
        <textarea name="comments" cols="60" rows="5"><? echo  $flight->comments ?></textarea>
      </font></td>
    </tr>
    <tr>
      <td><div align="right" class="style2"><font face="Verdana, Arial, Helvetica, sans-serif"><? echo _GLIDER ?></font></div></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">
        <input name="glider" type="text" size="30" value="<? echo  $flight->glider ?>">
      </font>       
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
			<? } ?>	  </td>
    </tr>
    <tr>
      <td><div align="right" class="style2"><? echo _RELEVANT_PAGE ?></div></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">
        http://<input name="linkURL" type="text" id="linkURL" size="50" value="<? echo  $flight->linkURL ?>">
      </font></td>
    </tr>
	<? for($i=1;$i<=$CONF_photosPerFlight;$i++) {
		$var_name="photo".$i."Filename";
	?>
    <tr>
      <td><div align="right" class="style2"><? echo _PHOTO ?> #<? echo $i?></div></td>
      <td><? if ( $flight->$var_name) { ?>
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
        <div align="left"><? echo _PHOTOS_GUIDELINES ?></div>
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
