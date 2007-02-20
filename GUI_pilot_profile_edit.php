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

  if (!$pilotIDview && $userID>0) $pilotIDview=$userID;

  // edit function
  if ( $pilotIDview != $userID && !in_array($userID,$admin_users) && !in_array($userID,$mod_users) ) { 
 	echo "<div>You dont have permission to edit this profile<br></div>";
    return;
  }
  
  if (isset($_REQUEST['updateProfile'])) {// submit form 
	   		
	if ($_REQUEST["PilotPhotoDelete"]=="1") {		// DELETE photo
		@unlink(getPilotPhotoFilename($pilotIDview,1) );
		@unlink(getPilotPhotoFilename($pilotIDview,0) );
		$PilotPhoto=0;

	} else if ($_FILES['PilotPhoto']['name'] ) {  // upload new
		@unlink(getPilotPhotoFilename($pilotIDview,1) );
		@unlink(getPilotPhotoFilename($pilotIDview,0) );

		$path=dirname(getPilotPhotoFilename($pilotIDview));
		if (!is_dir($path)) @mkdir($path,0777);

		if ( move_uploaded_file($_FILES['PilotPhoto']['tmp_name'],  getPilotPhotoFilename($pilotIDview) ) ) {
			resizeJPG(120,120, getPilotPhotoFilename($pilotIDview), getPilotPhotoFilename($pilotIDview,1), 15);
			resizeJPG(800,800, getPilotPhotoFilename($pilotIDview), getPilotPhotoFilename($pilotIDview), 15);
			$PilotPhoto=1;
		} else { //upload not successfull
			@unlink(getPilotPhotoFilename($pilotIDview,1) );
		    @unlink(getPilotPhotoFilename($pilotIDview,0) );
			$PilotPhoto=0;
		}
	} else { // no change 
		if (is_file(getPilotPhotoFilename($pilotIDview)) )	$PilotPhoto=1;
		else $PilotPhoto=0;
	}
	
	$NACid=$_POST['NACid']+0;
	$NACmemberID=$_POST['NACmemberID']+0;
	if ($NACmemberID<=0) $NACid=0;
	
   $query="UPDATE $pilotsTable SET
   		`FirstName` = '".prep_for_DB($_POST['FirstName'])."',
		`LastName` = '".prep_for_DB($_POST['LastName'])."',
		`countryCode` = '".prep_for_DB($_POST['countriesList'])."',
		`NACid` = $NACid,
		`NACmemberID` = $NACmemberID,
		`Birthdate` = '".prep_for_DB($_POST['Birthdate'])."',
		`Occupation` = '".prep_for_DB($_POST['Occupation'])."',
		`MartialStatus` = '".prep_for_DB($_POST['MartialStatus'])."',
		`OtherInterests` = '".prep_for_DB($_POST['OtherInterests'])."',
		`PilotLicence` = '".prep_for_DB($_POST['PilotLicence'])."',
		`BestMemory` = '".prep_for_DB($_POST['BestMemory'])."',
		`WorstMemory` = '".prep_for_DB($_POST['WorstMemory'])."',
		`Training` = '".prep_for_DB($_POST['Training'])."',
		`personalDistance` = '".prep_for_DB($_POST['personalDistance'])."',
		`personalHeight` = '".prep_for_DB($_POST['personalHeight'])."',
		`glider` = '".prep_for_DB($_POST['glider'])."',
		`FlyingSince` = '".prep_for_DB($_POST['FlyingSince'])."',
		`HoursFlown` = '".prep_for_DB($_POST['HoursFlown'])."',
		`HoursPerYear` = '".prep_for_DB($_POST['HoursPerYear'])."',
		`FavoriteLocation` = '".prep_for_DB($_POST['FavoriteLocation'])."',
		`UsualLocation` = '".prep_for_DB($_POST['UsualLocation'])."',
		`FavoriteBooks` = '".prep_for_DB($_POST['FavoriteBooks'])."',
		`FavoriteActors` = '".prep_for_DB($_POST['FavoriteActors'])."',
		`FavoriteSingers` = '".prep_for_DB($_POST['FavoriteSingers'])."',
		`FavoriteMovies` = '".prep_for_DB($_POST['FavoriteMovies'])."',
		`FavoriteSite` = '".prep_for_DB($_POST['FavoriteSite'])."',
		`Sign` = '".prep_for_DB($_POST['Sign'])."',
		`Spiral` = '".prep_for_DB($_POST['Spiral'])."',
		`Bline` = '".prep_for_DB($_POST['Bline'])."',
		`FullStall` = '".prep_for_DB($_POST['FullStall'])."',
		`Sat` = '".prep_for_DB($_POST['Sat'])."',
		`AsymmetricSpiral` = '".prep_for_DB($_POST['AsymmetricSpiral'])."',
		`Spin` = '".prep_for_DB($_POST['Spin'])."',
		`OtherAcro` = '".prep_for_DB($_POST['OtherAcro'])."',
		`camera` = '".prep_for_DB($_POST['camera'])."',
		`camcorder` = '".prep_for_DB($_POST['camcorder'])."',
		`Harness` = '".prep_for_DB($_POST['Harness'])."',
		`Vario` = '".prep_for_DB($_POST['Vario'])."',
		`GPS` = '".prep_for_DB($_POST['GPS'])."',
		`Helmet` = '".prep_for_DB($_POST['Helmet'])."',
		`Reserve` = '".prep_for_DB($_POST['Reserve'])."',
		`Sex` = '".prep_for_DB($_POST['Sex'])."',
		`PilotPhoto` = '".$PilotPhoto."',
		`PersonalWebPage` = '".prep_for_DB($_POST['PersonalWebPage'])."'
		
		 WHERE `pilotID` = '$pilotIDview' ";

    $res= $db->sql_query( $query );
    if($res <= 0){
      echo("<H3>Error in update query</H3>\n");
      return;  
    }
	
    echo "<div align=center>"._Your_profile_has_been_updated."<br></div>";
  }
  
  $res= $db->sql_query("SELECT * FROM $pilotsTable, ".$prefix."_users WHERE pilotID=".$pilotIDview ." AND pilotID=user_id" );

  if($res <= 0){
     echo("<H3>Error in pilot query</H3>\n");
     return;
  } else if ( mysql_num_rows($res)==0){
  	 $res= $db->sql_query("INSERT INTO $pilotsTable (pilotID) VALUES($pilotIDview)" );
	 echo("<H3>No info for this pilot</H3>\n");
	 return;
  }
  
  $pilot = mysql_fetch_assoc($res);
  
  $legend=_Pilot_Profile.": <b>$pilot[username]</b>";
  $legendRight="<a href='?name=$module_name&op=list_flights&pilotID=$pilotIDview&year=0&country='>"._PILOT_FLIGHTS."</a>";
  $legendRight.=" | <a href='?name=".$module_name."&op=pilot_profile&pilotIDview=".$pilotIDview."'>"._View_Profile."</a>";
  $legendRight.=" | <a href='javascript: document.pilotProfile.submit();'>"._Submit_Change_Data."</a>";
/*  if ( $pilotIDview == $userID || in_array($userID,$admin_users) || in_array($userID,$mod_users)  ) 
	  $legendRight.=" | <a href='?name=$module_name&op=pilot_profile_edit&pilotIDview=$pilotIDview'>edit profile</a>";
  else $legendRight.="";
*/ 
?>
<form name=pilotProfile  enctype="multipart/form-data" method="POST" action="?name=<? echo $module_name ?>&op=pilot_profile_edit&pilotIDview=<? echo $pilotIDview?>" >
<?
  open_inner_table("<table  class=main_text  width=100%><tr><td>$legend</td><td width=370 align=right bgcolor=#eeeeee>$legendRight</td></tr></table>",720,"icon_profile.png");
  
  open_tr();  
  echo "<td>";
?>

  <table  class=main_text  width="100%" border="0">
    <tr> 
      <td colspan="5" bgcolor="006699"><strong><font color="#FFA34F"><? echo _Personal_Stuff ?></font></strong></td>
    </tr>
    <tr> 
      <td width=150 valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _First_Name ?></div></td>
      <td width="150">
			<? if ((strlen(str_replace(".","",trim($pilot['FirstName']))) < 2) || (in_array($userID,$admin_users)) || (in_array($userID,$mod_users)) ) { ?> 
			<input name="FirstName" type="text" value="<? echo $pilot['FirstName'] ?>" size="25" maxlength="120"> 
			<? } else { ?>
			<input name="FirstNameD" type="text" value="<? echo $pilot['FirstName'] ?>" size="25" maxlength="120" disabled> 
			<input name="FirstName" type="hidden" value="<? echo $pilot['FirstName'] ?>" > 
			<? } ?></td>
      <td width =3>&nbsp;</td>
      <td colspan="2" rowspan="6" valign="top"> <div align="center"><strong><? echo _Photo ?></strong><br>
          <? 
	  	if ($pilot['PilotPhoto']>0) {
			echo "<a href='".getPilotPhotoRelFilename($pilotIDview)."' target='_blank'><img src='".getPilotPhotoRelFilename($pilotIDview,1)."' border=0></a>";
			echo "<br> "._Delete_Photo. " <input type=checkbox name=PilotPhotoDelete value=1>";
		}
	  ?>
        </div>
        <div align="center"></div></td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Last_Name ?></div></td>
      <td> 
			<? if ((strlen(str_replace(".","",trim($pilot['LastName']))) < 2) || (in_array($userID,$admin_users)) || (in_array($userID,$mod_users)) ) { ?> 
			<input name="LastName" type="text" value="<? echo $pilot['LastName'] ?>" size="25" maxlength="120"> 
			<? } else { ?>
			<input name="LastNameD" type="text" value="<? echo $pilot['LastName'] ?>" size="25" maxlength="120" disabled> 
			<input name="LastName" type="hidden" value="<? echo $pilot['LastName'] ?>" > 
			<? } ?>      </td>
      <td>&nbsp;</td>
    </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _COUNTRY ?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo getNationalityDropDown($pilot['countryCode']); ?>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5"><? if ($CONF_use_NAC) {?><div align="right"><? echo _MEMBER_OF ?></div><? } ?></td>
    <td valign="top" >
	<? if ($CONF_use_NAC) {
				foreach  ($CONF_NAC_list as $NACid=>$NAC) {
					$list1.="NAC_input_url[$NACid]  = '".$NAC['input_url']."';\n";
					$list2.="NAC_id_input_method[$NACid]  = '".$NAC['id_input_method']."';\n";
				}
	?>
	<script language="javascript">
	   var NAC_input_url= [];
	   var NAC_id_input_method= [];
	   var NACid=0;
	   <?=$list1.$list2 ?>

		function changeNAC() {
			var mid=MWJ_findObj("NACmemberID");
			mid.value="";
			
			var sl=MWJ_findObj("NACid");
			NACid= sl.selectedIndex;    // Which menu item is selected
			if (NACid==0) {
				MWJ_changeDisplay("mID","none");		
			} else {		
				MWJ_changeDisplay("mID","block");
			}
			
		}	
		function setID() {	
			if 	(NACid>0) {
				window.open(NAC_input_url[NACid], '_blank',	'scrollbars=no,resizable=yes,WIDTH=700,HEIGHT=400,LEFT=100,TOP=100',false);
			}
		}

	</script>
	<?
			echo "<select name='NACid' id='NACid' onchange='changeNAC(this)'>";
			echo "<option value='0'></option>";
			foreach  ($CONF_NAC_list as $NACid=>$NAC) {
				if ($pilot['NACid']==$NACid) $sel=" selected ";
				else $sel="";
				echo "<option $sel value='$NACid'>".$NAC['name']."</option>\n";
				
			}
	
			echo "</select>";
			echo "<div id='mID' style='display:".(($pilot['NACid']==0)?"none":"block")."'>";
			echo _MemberID.": <input size='6' type='text' name='NACmemberID' value='".$pilot['NACmemberID']."' readonly  /> ";
			echo "<a href='#' onclick=\"setID();return false;\">"._EnterID."</a></div>";
		} else { ?>
	<input type="hidden" name="NACid" value="<?=$row['NACid']?>" />
	<input type="hidden" name="NACmemberID" value="<?=$row['NACmemberID']?>" />
		<? } ?>	</td>
    <td>&nbsp;</td>
  </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"> <? echo _Birthdate ?><br>
          (<? echo _dd_mm_yy ?>) </div></td>
      <td valign="top"> <input name="Birthdate" type="text" value="<? echo $pilot['Birthdate'] ?>" size="25" maxlength="120">      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Sign ?></div></td>
      <td> <input name="Sign" type="text" value="<? echo $pilot['Sign'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Marital_Status ?></div></td>
      <td> <input name="MartialStatus" type="text" value="<? echo $pilot['MartialStatus'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Occupation?></div></td>
      <td> <input name="Occupation" type="text" value="<? echo $pilot['Occupation'] ?>" size="25" maxlength="120">      </td>
      <td>&nbsp;</td>
      <td colspan="2" bgcolor="#E9EDF5"> <div align="center"><? echo _Upload_new_photo_or_change_old ?>
	  </div></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Web_Page ?></div></td>
      <td><input name="PersonalWebPage" type="text" value="<? echo $pilot['PersonalWebPage'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
      <td colspan="2"><div align="center"> 
          <input name="PilotPhoto" type="file" size="30">
        </div></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Other_Interests ?></div></td>
      <td colspan="4" valign="top"><textarea name="OtherInterests" cols="80" rows="2"><? echo $pilot['OtherInterests'] ?></textarea></td>
    </tr>
    <tr> 
      <td colspan="5" valign="top" bgcolor="006699"> <div align="left"><strong><font color="#FFA34F"><? echo _Flying_Stuff ?> 
          (<? echo _note_place_and_date ?>)</font></strong></div></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Flying_Since ?></div></td>
      <td> <input name="FlyingSince" type="text" value="<? echo $pilot['FlyingSince'] ?>" size="25" maxlength="120">      </td>
      <td>&nbsp;</td>
      <td width="150" bgcolor="#E9EDF5"><div align="right"><? echo _Personal_Distance_Record?></div></td>
      <td width="150"> <input name="personalDistance" type="text" value="<? echo $pilot['personalDistance'] ?>" size="25" maxlength="120"></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Pilot_Licence?></div></td>
      <td> <input name="PilotLicence" type="text" value="<? echo $pilot['PilotLicence'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Personal_Height_Record?></div></td>
      <td> <input name="personalHeight" type="text" value="<? echo $pilot['personalHeight'] ?>" size="25" maxlength="120"></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Paragliding_training?></div></td>
      <td> <input name="Training" type="text" value="<? echo $pilot['Training'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Hours_Flown?></div></td>
      <td> <input name="HoursFlown" type="text" value="<? echo $pilot['HoursFlown'] ?>" size="25" maxlength="120"></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Favorite_Location?></div></td>
      <td> <input name="FavoriteLocation" type="text" value="<? echo $pilot['FavoriteLocation'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Hours_Per_Year?></div></td>
      <td> <input name="HoursPerYear" type="text" value="<? echo $pilot['HoursPerYear'] ?>" size="25" maxlength="120"></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Usual_Location?></div></td>
      <td> <input name="UsualLocation" type="text" value="<? echo $pilot['UsualLocation'] ?>" size="25" maxlength="120">      </td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="top"> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Best_Flying_Memory ?></div></td>
      <td colspan="4"><textarea name="BestMemory" cols="80" rows="3"><? echo $pilot['BestMemory'] ?></textarea></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Worst_Flying_Memory ?></div></td>
      <td colspan="4" valign="top"><textarea name="WorstMemory" cols="80" rows="3"><? echo $pilot['WorstMemory'] ?></textarea></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="5" bgcolor="006699"><strong><font color="#FFA34F"><? echo _Equipment_Stuff?></font></strong></td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Glider?></div></td>
      <td> <input name="glider" type="text" value="<? echo $pilot['glider'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Vario?></div></td>
      <td> <input name="Vario" type="text" value="<? echo $pilot['Vario'] ?>" size="25" maxlength="120"></td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Harness?></div></td>
      <td> <input name="Harness" type="text" value="<? echo $pilot['Harness'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"><? echo _GPS?></div></td>
      <td> <input name="GPS" type="text" value="<? echo $pilot['GPS'] ?>" size="25" maxlength="120"></td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Reserve_chute?></div></td>
      <td> <input name="Reserve" type="text" value="<? echo $pilot['Reserve'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Helmet?></div></td>
      <td> <input name="Helmet" type="text" value="<? echo $pilot['Helmet'] ?>" size="25" maxlength="120"></td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Camera?></div></td>
      <td> <input name="camera" type="text" value="<? echo $pilot['camera'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Camcorder?></div></td>
      <td> <input name="camcorder" type="text" value="<? echo $pilot['camcorder'] ?>" size="25" maxlength="120"></td>
    </tr>
    <tr> 
      <td colspan="5" bgcolor="006699"><strong><font color="#FFA34F"><? echo _Manouveur_Stuff ?> 
        (<? echo _note_max_descent_rate?>)</font></strong></td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Spiral?></div></td>
      <td> <input name="Spiral" type="text" value="<? echo $pilot['Spiral'] ?>" size="25" maxlength="80"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Sat?></div></td>
      <td> <input name="Sat" type="text" value="<? echo $pilot['Sat'] ?>" size="25" maxlength="80"></td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Bline?></div></td>
      <td> <input name="Bline" type="text" value="<? echo $pilot['Bline'] ?>" size="25" maxlength="80"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Asymmetric_Spiral?></div></td>
      <td> <input name="AsymmetricSpiral" type="text" value="<? echo $pilot['AsymmetricSpiral'] ?>" size="25" maxlength="80"></td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Full_Stall?></div></td>
      <td> <input name="FullStall" type="text" value="<? echo $pilot['FullStall'] ?>" size="25" maxlength="80"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Spin?></div></td>
      <td> <input name="Spin" type="text" value="<? echo $pilot['Spin'] ?>" size="25" maxlength="80"></td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Other_Manouveurs_Acro?></div></td>
      <td> <input name="OtherAcro" type="text" value="<? echo $pilot['OtherAcro'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="5" bgcolor="006699"><strong><font color="#FFA34F"><? echo _General_Stuff?></font></strong></td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Favorite_Singer?></div></td>
      <td> <input name="FavoriteSingers" type="text" value="<? echo $pilot['FavoriteSingers'] ?>" size="25" maxlength="80"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Favorite_Book?></div></td>
      <td> <input name="FavoriteBooks" type="text" value="<? echo $pilot['FavoriteBooks'] ?>" size="25" maxlength="80"></td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Favorite_Movie?></div></td>
      <td> <input name="FavoriteMovies" type="text" value="<? echo $pilot['FavoriteMovies'] ?>" size="25" maxlength="80"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Favorite_Actor?></div></td>
      <td> <input name="FavoriteActors" type="text" value="<? echo $pilot['FavoriteActors'] ?>" size="25" maxlength="80"></td>
    </tr>
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right"><? echo _Favorite_Internet_Site?></div></td>
      <td> <input name="FavoriteSite" type="text" value="<? echo $pilot['FavoriteSite'] ?>" size="25" maxlength="80"></td>
      <td>&nbsp;</td>
      <td bgcolor="#E9EDF5"><div align="right"></div></td>
      <td></td>
    </tr>
    <tr> 
      <td colspan="5"><div align="center"> 
          <hr>
       
            <input type="submit" name="Submit" value="<? echo _Submit_Change_Data ?>">
      </div></td>
    </tr>
  </table>
  <input type=hidden name=updateProfile value=1>
</form>

<?
  echo "</td></tr>"; 
  close_inner_table();
?>
<script language="javascript">
		var sl0=MWJ_findObj("NACid");
		NACid= sl0.selectedIndex;    // Which menu item is selected
</script>