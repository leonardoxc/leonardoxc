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

if ( auth::isAdmin($userID)  ) {
	$flight=new flight();
	$flight->getFlightFromDB($flightID);

	if ($_REQUEST["changeFlight"]) {  // make changes
		 $flight->cat=makeSane($_REQUEST["gliderCat"]);
		 $flight->glider=$_REQUEST["glider"];
		 $flight->comments=$_REQUEST["comments"];
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
		 echo "<a href='".CONF_MODULE_ARG."&op=show_flight&flightID=".$flightID."'>"._RETURN_TO_FLIGHT."</a><br><br><br>";
		 echo "</center>";
		 close_inner_table();
	} else { // show the form

	?>
  <form action="" enctype="multipart/form-data" method="post">	
  <input type="hidden" name="changeFlight" value=1>
  <input type="hidden" name="flightID" value="<? echo $flightID ?>">
  <?  open_inner_table("Review Validation Status",650,"change_icon.png"); echo "<tr><td>"; ?>
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
      <td  valign="top"><img src="<? echo $moduleRelPath?>/img/icon_cat_<? echo $flight->cat ?>.png" border=0><select name="gliderCat">        
      	<?
			foreach ( $CONF_glider_types as $gl_id=>$gl_type) {

				if ($flight->cat==$gl_id) $is_type_sel ="selected";
				else $is_type_sel ="";
				echo "<option $is_type_sel value=$gl_id>".$gliderCatList[$gl_id]."</option>\n";
			}
		?>
	  </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
          <input name="submit" type="submit" value="<? echo _PRESS_HERE_TO_CHANGE_THE_FLIGHT ?>">
     </td>
    </tr>
  </table>
  
</form>
<?
			echo "</td></tr>";
	 		close_inner_table();
	} //show FORM

} // end user check

?>
