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

/**
 * Modifications Martin Jursa 26.04.2007
 * Enable edit login data
 * Martin Jursa 23.05.2007: FirstOlcYear added
 */

  require_once dirname(__FILE__)."/CL_NACclub.php";

  if (!$pilotIDview && $userID>0) $pilotIDview=$userID;

  // edit function
  if ( $pilotIDview != $userID && !auth::isAdmin($userID) && !auth::isModerator($userID ) ) { 
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

	# Martin Jursa 26.04.2007
	# save password and/or email
	if (!empty($CONF_edit_login)) {
		$changeMsg=saveLoginData($pilotIDview,
			!empty($_POST['user_email']) ? $_POST['user_email'] : '',
			!empty($_POST['pwd1']) ? $_POST['pwd1'] : '',
			!empty($_POST['pwd2']) ? $_POST['pwd2'] : ''
		);
		if ($changeMsg!='') {
     		echo '<div style="font-weight:bold;margin:10px;">'.$changeMsg.'</div>';
		}
	}
	# end save password

	$NACid=$_POST['NACid']+0;
	$NACmemberID=$_POST['NACmemberID']+0;
	if ($NACmemberID<=0) $NACid=0;

	$NACclubID=$_POST['NACclubID']+0;
	if ($NACid==0) $NACclubID=0;

	// echo "$NACid , $NACmemberID, $NACclubID <BR>";
	if ($NACid==0 || $CONF_NAC_list[$NACid]['use_clubs'] ) {
		// add_to_club_period_active
		// echo "updating club-flights<BR>";
		if ($CONF_NAC_list[$NACid]['club_change_period_active'] || $NACid==0)
			NACclub::updatePilotFlights($pilotIDview,$NACid,$NACclubID);
	}

	$FirstOlcYear=$_POST['FirstOlcYear']+0;
	if ($FirstOlcYear<=1995 ||  $FirstOlcYear>(date('Y')+0)) {
		$FirstOlcYear=0;
	}
	
   $query="UPDATE $pilotsTable SET
   		`FirstName` = '".prep_for_DB($_POST['FirstName'])."',
		`LastName` = '".prep_for_DB($_POST['LastName'])."',
		`countryCode` = '".prep_for_DB($_POST['countriesList'])."',
		`NACid` = $NACid,
		`NACmemberID` = $NACmemberID,
		`NACclubID` = $NACclubID,
		`sponsor` = '".prep_for_DB($_POST['sponsor'])."',
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
		`PersonalWebPage` = '".prep_for_DB($_POST['PersonalWebPage'])."',
		`FirstOlcYear` = $FirstOlcYear

		 WHERE `pilotID` = '$pilotIDview' ";

    $res= $db->sql_query( $query );
    if($res <= 0){
      echo("<H3>Error in update query:  $query</H3>\n");
      return;  
    }

    echo '<div style="font-weight:bold;margin:10px;">'._Your_profile_has_been_updated.'</div>';
  }
  
  $query_sel="SELECT * FROM $pilotsTable, ".$CONF['userdb']['users_table']." WHERE pilotID=".$pilotIDview ." AND pilotID=".$CONF['userdb']['user_id_field'] ;
  $res= $db->sql_query($query_sel);

  if($res <= 0){
     echo("<H3>Error in pilot query</H3>\n");
     return;
  } else if ( mysql_num_rows($res)==0){
	 // echo "query: $query_sel failed, will insert values into table<BR>";
  	 $res= $db->sql_query("INSERT INTO $pilotsTable (pilotID) VALUES($pilotIDview)" );
	 echo("<H3>No info for this pilot</H3>\n");
	 return;
  }

  $pilot = mysql_fetch_assoc($res);

  $legend=_Pilot_Profile.": <b>$pilot[username]</b>";
  $legendRight="<a href='?name=$module_name&op=list_flights&pilotID=$pilotIDview&year=0&country='>"._PILOT_FLIGHTS."</a>";
  $legendRight.=" | <a href='?name=".$module_name."&op=pilot_profile&pilotIDview=".$pilotIDview."'>"._View_Profile."</a>";
  # Martin Jursa 26.04.2007: place the submit() in function submitPilotProfile
  $legendRight.=" | <a href='javascript: submitPilotProfile();'>"._Submit_Change_Data."</a>";
/*  if ( $pilotIDview == $userID || in_array($userID,$admin_users) || in_array($userID,$mod_users)  )
	  $legendRight.=" | <a href='?name=$module_name&op=pilot_profile_edit&pilotIDview=$pilotIDview'>edit profile</a>";
  else $legendRight.="";
*/
?>
<form name=pilotProfile  enctype="multipart/form-data" method="POST" action="<?=CONF_MODULE_ARG?>&op=pilot_profile_edit&pilotIDview=<?=$pilotIDview?>" >
<?
  open_inner_table("<table  class=\"main_text\"  width=\"100%\"><tr><td>$legend</td><td width=\"370\" align=\"right\" bgcolor=\"#eeeeee\">$legendRight</td></tr></table>",720,"icon_profile.png");

//  open_tr();
  echo "<tr>";
  echo "<td>";
  
   	# Changes Martin Jursa 09.03.2007:
	# in case certain fields are set by an external tool, these fields will be set readonly
	# otherwise, they can be edited
	# $possible_readonly_fields contains all the fields for which this readonly mechanism is available
	# Martin Jursa, 26.04.2007, modified to handle list Birthdate and countriesList
	$readonly_fields=array();
	if ($CONF_use_NAC) {
		$list1=$list2=$list3='';
		$possible_readonly_fields=array('NACmemberID', 'LastName', 'FirstName', 'Birthdate', 'Sex', 'countriesList');
		$list4="var all_readonly_fields  = '".implode(',', $possible_readonly_fields)."';\n";

		foreach  ($CONF_NAC_list as $NACid=>$NAC) {
			$list1.="NAC_input_url[$NACid]  = '".$NAC['input_url']."';\n";
			$ext_input=empty($NAC['external_input']) ? 0 : 1;
			$list2.="NAC_external_input[$NACid]  = $ext_input;\n";
			$use_clubs=$NAC['use_clubs']+0;
			$list2.="NAC_use_clubs[$NACid]  = $use_clubs;\n";

			$externalfields=!empty($NAC['external_fields']) ? $NAC['external_fields'] : '';
			if ($ext_input && !empty($NAC['external_fields'])) {
				$list3.="NAC_external_fields[$NACid] = '$externalfields';\n";
				if ($pilot['NACid']==$NACid) {
					$tmp_fields=explode(',', $externalfields);
					foreach ($tmp_fields as $fld) {
						if (in_array($fld, $possible_readonly_fields)) $readonly_fields[]=$fld;
					}
				}
			}
		}

	}
?>

  <table  class=main_text  width="100%" border="0">
    <tr>
      <td colspan="5" bgcolor="006699"><strong><font color="#FFA34F"><? echo _Personal_Stuff ?></font></strong></td>
    </tr>
    <tr>
      <td width=150 valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _First_Name ?></div></td>
      <td width="150" valign="top">
			<? if ((strlen(str_replace(".","",trim($pilot['FirstName']))) < 2) || (in_array($userID,$admin_users)) || (in_array($userID,$mod_users)) ) { ?>
			<input name="FirstName" type="text" value="<? echo $pilot['FirstName'] ?>" size="25" maxlength="120" <? echo in_array('FirstName', $readonly_fields) ? 'readonly' : '' ?> >
			<? } else { ?>
			<input name="FirstNameD" type="text" value="<? echo $pilot['FirstName'] ?>" size="25" maxlength="120" disabled>
			<input name="FirstName" type="hidden" value="<? echo $pilot['FirstName'] ?>" >
			<? } ?></td>
      <td width =3>&nbsp;</td>
      <td colspan="2" rowspan="3" valign="top" bgcolor="#E8EBDE"><div align="left">
<? if ($CONF_use_NAC) {
		echo _MEMBER_OF.": ";

		/*foreach  ($CONF_NAC_list as $NACid=>$NAC) {
			$list1.="NAC_input_url[$NACid]  = '".$NAC['input_url']."';\n";
			$list2.="NAC_id_input_method[$NACid]  = '".$NAC['id_input_method']."';\n";
		}
		*/
?>
 <script type="text/javascript" language="javascript">
	   	var NAC_input_url= [];
		var NAC_external_input= [];
		var NAC_external_fields= [];
		var NAC_use_clubs=[];
		var NACid=0;
	   	<?=$list1.$list2.$list3.$list4 ?>
		var NAC_club_input_url="<? echo $moduleRelPath."/GUI_EXT_set_club.php"; ?>";

		function changeNAC() {
			var mid=MWJ_findObj("NACmemberID");
			mid.value="";

			var sl=MWJ_findObj("NACid");
			NACid= sl.options[sl.selectedIndex].value ;    // Which menu item is selected
			if (NACid==0) {
				MWJ_changeDisplay("mID","none");
			} else {
				MWJ_changeDisplay("mID","inline");
				if (NAC_external_input[NACid]) {
					MWJ_changeDisplay("mIDselect","block");
				}else {
					MWJ_changeDisplay("mIDselect","none");
				}
			}

			if (NAC_use_clubs[NACid]) {
				MWJ_changeDisplay("mClubSelect","block");
			} else  {
				MWJ_changeDisplay("mClubSelect","none");
			}

			var flds=all_readonly_fields.split(',');
			for (var i=0; i<flds.length; i++) {
				setReadOnly(document.forms[0].elements[flds[i]], false);
			}
			if (NACid!=0 && NAC_external_fields[NACid]) {
				flds=NAC_external_fields[NACid].split(',');
				for (var i=0; i<flds.length; i++) {
					setReadOnly(document.forms[0].elements[flds[i]], true);
				}
			}
		}

		function setReadOnly(elmt, readonly) {
			if (elmt) {
				if (elmt.type=='select-one') {
					elmt.disabled=readonly;
				}else {
					elmt.readOnly=readonly;
				}
			}
		}

		function setID() {
			if 	(NACid>0) {
				window.open(NAC_input_url[NACid], '_blank',	'scrollbars=no,resizable=yes,WIDTH=700,HEIGHT=400,LEFT=100,TOP=100',false);
			}
		}

		function setClub() {
			if 	(NACid>0) {
				var NACclubID_fld	=MWJ_findObj("NACclubID");
				var NACclubID		=NACclubID_fld.value;
				window.open(NAC_club_input_url+'?NAC_ID='+NACid+'&clubID='+NACclubID, '_blank',	'scrollbars=no,resizable=yes,WIDTH=500,HEIGHT=420,LEFT=100,TOP=100',false);
			}
		}
		// Martin Jursa 26.04.2007, submit the Form
		// remove the disabled attribute, otherwise the values dont get posted
		function submitPilotProfile() {
			document.pilotProfile.countriesList.disabled=false;
			if (document.pilotProfile.Sex) {
				if (document.pilotProfile.Sex.type=='select-one') {
					document.pilotProfile.Sex.disabled=false;
				}
			}
			document.pilotProfile.submit();
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

			echo "<div id='mID' style='display:".(($pilot['NACid']==0) ? "none" : "inline")."'> ";
			$memberid_readonly=in_array('NACmemberID', $readonly_fields) ? 'readonly' : '';
			echo "<span style='white-space:nowrap'>"._MemberID.": <input size='5' type='text' name='NACmemberID' value='".$pilot['NACmemberID']."' $memberid_readonly  /></span> ";
			echo "<div id='mIDselect' style='display:".($memberid_readonly ? "block" : "none")."'> ";
			echo "[&nbsp;<a href='#' onclick=\"setID();return false;\">"._EnterID."</a>&nbsp;]";
			echo "</div>";



			echo "<div align=left id='mClubSelect' style='display:".( $CONF_NAC_list[$pilot['NACid']]['use_clubs']?"block":"none" )."' >"._Club." ";
			$NACclub=NACclub::getClubName($pilot['NACid'],$pilot['NACclubID']);


			if ( $CONF_NAC_list[$pilot['NACid']]['club_change_period_active'] ||
				( $CONF_NAC_list[$pilot['NACid']]['add_to_club_period_active']  && !$pilot['NACclubID'] ) ||
				in_array($userID,$admin_users) || in_array($userID,$mod_users)
			) {
				echo "[ <a href='#' onclick=\"setClub();return false;\">"._Select_CLub."</a> ]";
			} else {
				echo "";
			}

			echo "<br><input  type='hidden' name='NACclubID' value='".$pilot['NACclubID']."' /> ";
			echo "<input  type='text' size='50' name='NACclub' value='".$NACclub."' readonly /></div> ";

			echo "</div>";


} else { ?>
          <input type="hidden" name="NACid" value="<?=$pilot['NACid']?>" />
          <input type="hidden" name="NACmemberID" value="<?=$pilot['NACmemberID']?>" />
          <input type="hidden" name="NACclubID" value="<?=$pilot['NACclubID']?>" />
<? }

?>


</div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Last_Name ?></div></td>
      <td valign="top">
			<? if ((strlen(str_replace(".","",trim($pilot['LastName']))) < 2) || (in_array($userID,$admin_users)) || (in_array($userID,$mod_users)) ) { ?>
			<input name="LastName" type="text" value="<? echo $pilot['LastName'] ?>" size="25" maxlength="120" <? echo in_array('LastName', $readonly_fields) ? 'readonly' : '' ?> >
			<? } else { ?>
			<input name="LastNameD" type="text" value="<? echo $pilot['LastName'] ?>" size="25" maxlength="120" disabled>
			<input name="LastName" type="hidden" value="<? echo $pilot['LastName'] ?>" >
			<? } ?>      </td>
      <td>&nbsp;</td>
    </tr>

	<tr>
		<td valign="top" bgcolor="#E9EDF5"><div align="right"> <? echo _Birthdate ?><br>
		  (<? echo _dd_mm_yy ?>) </div></td>
		<td valign="top"> <input name="Birthdate" type="text" value="<? echo $pilot['Birthdate'] ?>" size="25" maxlength="120" <? echo in_array('Birthdate', $readonly_fields) ? 'readonly' : '' ?> >      </td>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td valign="top" bgcolor="#E9EDF5"><div align="right"> <? echo _Sex ?></div></td>
		<td valign="top"><? echo getSexDropDown($pilot['Sex'], in_array('Sex', $readonly_fields)) ?></td>
		<td>&nbsp;</td>
	</tr>

    <tr>
      <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _COUNTRY ?></div></td>
      <td valign="top"><? echo getNationalityDropDown($pilot['countryCode'], in_array('countriesList', $readonly_fields)) ?></td>
      <td>&nbsp;</td>
    </tr>

    <tr>
		<td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Web_Page ?></div></td>
		<td><input name="PersonalWebPage" type="text" value="<? echo $pilot['PersonalWebPage'] ?>" size="25" maxlength="120"></td>
    </tr>

	<tr>
		<td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Sponsor ?></div></td>
		<td valign="top"><input name="sponsor" type="text" value="<? echo $pilot['sponsor'] ?>" size="25" maxlength="120"></td>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td  valign="top"><td colspan="2"><div align="left">
			<? 	if ($pilot['PilotPhoto']>0)
					echo "<a href='".getPilotPhotoRelFilename($pilotIDview)."' target='_blank'><img align=right src='".getPilotPhotoRelFilename($pilotIDview,1)."' border=0></a>";
			?>
			<? echo _Photo ?>
		    <? if ($pilot['PilotPhoto']>0)
					echo "<br><BR> "._Delete_Photo. " <input type=checkbox name=PilotPhotoDelete value=1>";
			?>
		    </div></td>
  	</tr>

    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><div align="right">
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
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _FirstOlcYear ?></div></td>
      <td colspan="4"><table cellpadding="0" cellpadding="0" border="0"><tr><td><select name="FirstOlcYear">
<?
		$curryear=(date('Y')+0);
		$ys=array(0);
		for ($y=$curryear; $y>=2000; $y--) $ys[]=$y;
		foreach ($ys as $y) {
			$selected=$y==$pilot['FirstOlcYear'] ? ' selected ' : '';
			$text=$y==0 ? '' : $y;
			echo "<option value=\"$y\"$selected>$text</option>\n";
		}

?>
      </select></td><td><div><?=_FirstOlcYearComment?><div></td></tr></table>
      </td>
    </tr>

    <tr>
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Flying_Since ?></div></td>
      <td> <input name="FlyingSince" type="text" value="<? echo $pilot['FlyingSince'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
      <td width="150" bgcolor="#E9EDF5"><div align="right"><? echo _Personal_Distance_Record?></div></td>
      <td width="150"> <input name="personalDistance" type="text" value="<? echo $pilot['personalDistance'] ?>" size="25" maxlength="120"></td>
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

<? if (!empty($CONF_edit_login)) {
	if (!empty($CONF_edit_email)) {
		$text_email='<input name="user_email" type="text" value="'.$pilot['user_email'].'" size="35" >';
	}else {
		$text_email=$pilot['user_email'];
	}
	$text_edit_pwd='
    <tr>
      <td colspan="5" bgcolor="006699"><strong><font color="#FFA34F">'._Login_Stuff.'</font></strong></td>
    </tr>
	<tr>
		<td valign="middle" bgcolor="#E9EDF5"> <div align="right">'._USERNAME.'</div></td>
		<td valign="middle"><b>'.$pilot['username'].'</b></td>
		<td>&nbsp;</td>
		<td valign="middle" bgcolor="#E9EDF5" colspan="2" >'._EnterPasswordOnlyToChange.'</td>
	</tr>
	<tr>
		<td valign="top" bgcolor="#E9EDF5"> <div align="right">'._pilot_email.'</div></td>
		<td>'.$text_email.'</td>
		<td>&nbsp;</td>
		<td valign="top" bgcolor="#E9EDF5"> <div align="right">'._PASSWORD.'</div></td>
		<td><input name="pwd1" type="password" value="" size="25" maxlength="32"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td valign="top" bgcolor="#E9EDF5"> <div align="right">'._PASSWORD_CONFIRMATION.'</div></td>
		<td><input name="pwd2" type="password" value="" size="25" maxlength="32"></td>
	</tr>
';
	echo $text_edit_pwd;
} ?>
    <tr>
      <td colspan="5"><div align="center">
          <hr>
            <input type="button" name="Submit" value="<? echo _Submit_Change_Data ?>" onclick="submitPilotProfile();">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="updateProfile" value="1">

<?
  echo "</td></tr>";
  close_inner_table();
?>
</form>

<script language="javascript">
		var sl0=MWJ_findObj("NACid");
		NACid= sl0.selectedIndex;    // Which menu item is selected
</script>