<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

 $datafile=$_FILES['datafile']['name'];
 open_inner_table( _SUBMIT_FLIGHT,650,"icon_add.png");
 echo "<tr><td>";

 if ($datafile=='') {   
?>
  <form name="inputForm" action="" enctype="multipart/form-data" method="post" >	
  <table class=main_text  width="600" height="400" border="0" align="center" cellpadding="4" cellspacing="2" >
    <tr>
      <td colspan="2"><div align="center" class="style111"><strong><?=_SUBMIT_FLIGHT?> </strong></div>      
        <div align="center" class="style222"><?=_ONLY_THE_IGC_FILE_IS_NEEDED?></div></td>
    </tr>
    <tr>
      <td width="211" valign="top"><div align="right" class="styleItalic"><?=_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT?></div></td>
      <td width="451" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif">
        <input name="datafile" type="file" size="50">
      </font></td>
    </tr>
    <tr>
      <td  valign="top"><div align="right" class="styleItalic"> <?=_GLIDER_TYPE ?></div></td>
      <td  valign="top"><select name="gliderCat">        
      	<?
			foreach ( $CONF_glider_types as $gl_id=>$gl_type) {

				if ($gl_id==$CONF_default_cat_add) $is_type_sel ="selected";
				else $is_type_sel ="";
				echo "<option $is_type_sel value=$gl_id>".$gliderCatList[$gl_id]."</option>\n";
			}
		?>
	  </select></td>
    </tr>
	<? if ($enablePrivateFlights) { ?>
    <tr>
      <td width="211" valign="top"><div align="right" class="styleItalic"><?=_MAKE_THIS_FLIGHT_PRIVATE ?></div></td>
      <td width="451" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif">

        <input type="checkbox" name="is_private" value="1">
      </font></td>
    </tr>
	<? } ?>
	<? if ( in_array($userID,$admin_users)) { ?>
    <tr>
      <td width="211" valign="top"><div align="right" class="styleItalic"><?=_INSERT_FLIGHT_AS_USER_ID?></div></td>
      <td width="451" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif">
        <input name="insert_as_user_id" type="text" size="10">
      </font></td>
    </tr>
 	<? }?>
    <tr>
      <td valign="middle"><div align="right" class="styleItalic"><font face="Verdana, Arial, Helvetica, sans-serif"><?=_COMMENTS_FOR_THE_FLIGHT?>
	  <span class="styleSmallRed"><br>
        <?=_NOTE_TAKEOFF_NAME ?></span> </font></div></td>
      <td valign="top"><font face="Verdana, Arial, Helvetica, sans-serif">
        <textarea name="comments" cols="60" rows="4"></textarea>
      </font></td>
    </tr>
    <tr>
      <td><div align="right" class="styleItalic"><font face="Verdana, Arial, Helvetica, sans-serif"><?=_GLIDER ?></font></div></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">
        <input name="glider" type="text" id="glider" size="30">
      </font>
		<script language="JavaScript">
		function setValue(value)
		{
		document.inputForm.glider.value = value;
		}
		</script>

		<? 
			$gliders=  getUsedGliders($userID) ;
			if (count($gliders)) { ?>
				<select name="gliderSelect" id="gliderSelect" onchange="setValue(this.value);">			
					<option></option>
					<? 
						foreach($gliders as $selGlider) {
							echo "<option>".$selGlider."</option>\n";
						}
					?>
				</select>
			<? } ?>
	  </td>
    </tr>
    <tr>
      <td><div align="right" class="styleItalic"><?=_RELEVANT_PAGE ?> </div></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">
        http://<input name="linkURL" type="text" id="linkURL" size="50" value="">
      </font></td>
    </tr>
    <tr>
      <td><div align="right" class="styleItalic"><?=_PHOTO?> #1</div></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">
        <input name="photo1Filename" type="file" size="50">
      </font></td>
    </tr>
 	<tr>
      <td><div align="right" class="styleItalic"><?=_PHOTO?> #2</div></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">
        <input name="photo2Filename" type="file" size="50">
      </font></td>
    </tr> <tr>
      <td><div align="right" class="styleItalic"><?=_PHOTO?> #3</div></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">
        <input name="photo3Filename" type="file" size="50">
      </font></td>
    </tr>
	 <tr>
      <td><div align="right" class="styleItalic"></div></td>
      <td>  <div align="center" class="style222">
        <div align="left"><?=_PHOTOS_GUIDELINES?></div>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><p><font face="Verdana, Arial, Helvetica, sans-serif">
          <input name="submit" type="submit" value="<?=_PRESS_HERE_TO_SUBMIT_THE_FLIGHT ?>">
</font></p>
      </td>
    </tr>
    <tr>
      <td colspan=2><div align="center" class="smallLetter"><em><?=_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE ?> 
	<a href="?name=<?=$module_name?>&op=add_from_zip"><?=_PRESS_HERE ?> </a></em></div></td>
    </tr>
  </table>
  </form>
<? 
} else {  // form submited - add the flight

	set_time_limit (120);
	ignore_user_abort(true);	

	if ($_POST['insert_as_user_id'] >0 ) $flights_user_id=$_POST['insert_as_user_id'];
	else $flights_user_id=$userID;

	if ($_POST['is_private'] ==1 ) $is_private=1;
	else $is_private=0;

	$gliderCat=$_POST['gliderCat'];

	checkPath($flightsAbsPath."/".$flights_user_id);
	move_uploaded_file($_FILES['datafile']['tmp_name'], $flightsAbsPath."/".$flights_user_id."/".$_FILES['datafile']['name'] );
	$filename=$flightsAbsPath."/".$flights_user_id."/".$_FILES['datafile']['name'];
		echo $filename;
	if (!$filename) addFlightError(_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE);
	list($result,$flightID)=addFlightFromFile($filename,true,$flights_user_id,$is_private,$gliderCat) ;
	if ( $result !=1 ) {	
		$errMsg=getAddFlightErrMsg($result,$flightID);
		addFlightError($errMsg);	
	} else {
		echo "<img src='?name=$module_name&op=postAddFlight&flightID=".$flightID."' width=1 height=1 border=0 alt=''>";			
		?>  	 
		  <p align="center"><span class="style111"><font face="Verdana, Arial, Helvetica, sans-serif"><?=_YOUR_FLIGHT_HAS_BEEN_SUBMITTED ?></font></span> <br>
		  <br>
		  <a href="?name=<?=$module_name?>&op=show_flight&flightID=<?=$flightID ?>"><?=_PRESS_HERE_TO_VIEW_IT ?></a><br>
		  <em><?=_WILL_BE_ACTIVATED_SOON ?></em> 
		  <hr>	  
		<?
	}


}
	echo "</td></tr>";
	close_inner_table(); 
?>