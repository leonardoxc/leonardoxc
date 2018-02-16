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
// $Id: GUI_pilot_profile_edit.php,v 1.40 2012/06/02 08:40:12 manolis Exp $                                                                 
//
//************************************************************************

/**
 * Modifications Martin Jursa 26.04.2007
 * Enable edit login data
 * Martin Jursa 23.05.2007: FirstOlcYear added
 */
  require_once dirname(__FILE__)."/CL_image.php";
  require_once dirname(__FILE__)."/CL_NACclub.php";
  require_once dirname(__FILE__)."/CL_user.php";
  require_once dirname(__FILE__)."/lib/json/CL_json.php";

  if (!$pilotIDview && $userID>0) {
  	$pilotIDview=$userID;
	$serverID=0;
	$serverIDview=0;
  }
  
  // $serverIDview=$serverID;
  
  // edit function
  if ( ( $pilotIDview != $userID || $serverIDview!=0 ) && !L_auth::isAdmin($userID) && !L_auth::isModerator($userID ) ) { 
 	echo "<div>You dont have permission to edit this profile<br></div>";
    return;
  }
  
  if (isset($_REQUEST['updateProfile'])) {// submit form 
	   		

	if ($_REQUEST["PilotPhotoDelete"]=="1") {		// DELETE photo
		@unlink(getPilotPhotoFilename($serverIDview,$pilotIDview,1) );
		@unlink(getPilotPhotoFilename($serverIDview,$pilotIDview,0) );
		$PilotPhoto=0;

	} else if ($_FILES['PilotPhoto']['name'] ) {  // upload new
		@unlink(getPilotPhotoFilename($serverIDview,$pilotIDview,1) );
		@unlink(getPilotPhotoFilename($serverIDview,$pilotIDview,0) );

		$path=dirname(getPilotPhotoFilename($serverIDview,$pilotIDview));
		if (!is_dir($path)) makeDir($path);

		if ( move_uploaded_file($_FILES['PilotPhoto']['tmp_name'],  
				getPilotPhotoFilename($serverIDview,$pilotIDview) ) ) {
			CLimage::resizeJPG(150,150, getPilotPhotoFilename($serverIDview,$pilotIDview),
				 						getPilotPhotoFilename($serverIDview,$pilotIDview,1), 15);
			CLimage::resizeJPG(800,800, getPilotPhotoFilename($serverIDview,$pilotIDview), 
										getPilotPhotoFilename($serverIDview,$pilotIDview), 15);
			$PilotPhoto=1;
		} else { //upload not successfull
			@unlink(getPilotPhotoFilename($serverIDview,$pilotIDview,1) );
		    @unlink(getPilotPhotoFilename($serverIDview,$pilotIDview,0) );
			$PilotPhoto=0;
		}
	} else { // no change
		if (is_file(getPilotPhotoFilename($serverIDview,$pilotIDview)) )	$PilotPhoto=1;
		else $PilotPhoto=0;
	}
	
	
	if ( $CONF['userdb']['edit']['enabled']) {
		# Martin Jursa 26.04.2007
		# save password and/or email
	
		if ( $_POST['user_email'] == $_POST['user_email_old'] ) {
			$newEmail='#same_as_old#leonardo#';
		} else {
			$newEmail= $_POST['user_email'];
		}
		$changeMsg=saveLoginData($pilotIDview,$newEmail	,
			!empty($_POST['pwd1']) ? $_POST['pwd1'] : '',
			!empty($_POST['pwd2']) ? $_POST['pwd2'] : ''
		);
		if ($changeMsg!='') {
			echo '<div style="font-weight:bold;margin:10px;">'.$changeMsg.'</div>';
		}
	} # end save password
	
	
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
	

	$hideDay=$_POST['hideDay']+0;
	$hideMonth=$_POST['hideMonth']+0;
	$hideYear=$_POST['hideYear']+0;
	$hideYearLastDigit=$_POST['hideYearLastDigit']+0;

	$BirthdateHideMask=($hideDay?'xx':'##').'.'.($hideMonth?'xx':'##').'.'.
			($hideYear?'xxx':'###').($hideYearLastDigit?'x':'#');


   $query="UPDATE $pilotsTable SET
   		`FirstNameEn` = '".prep_for_DB($_POST['FirstNameEn'])."',
		`LastNameEn` = '".prep_for_DB($_POST['LastNameEn'])."',
		`FirstName` = '".prep_for_DB($_POST['FirstName'])."',
		`LastName` = '".prep_for_DB($_POST['LastName'])."',
		`countryCode` = '".prep_for_DB($_POST['countriesList'])."',
		`NACid` = $NACid,
		`NACmemberID` = $NACmemberID,
		`NACclubID` = $NACclubID,		
		`CIVL_ID` = '".prep_for_DB($_POST['CIVL_ID'])."',
		`Birthdate` = '".prep_for_DB($_POST['Birthdate'])."',
		`BirthdateHideMask` = '$BirthdateHideMask',
		`Sex` = '".prep_for_DB($_POST['Sex'])."',
		`PilotPhoto` = '".$PilotPhoto."',
		`FirstOlcYear` = $FirstOlcYear

		 WHERE `pilotID` = '$pilotIDview'  AND serverID='$serverIDview' ";

    $res= $db->sql_query( $query );
    if($res <= 0){
      echo("<H3>Error in update query:  $query</H3>\n");
      return;  
    }

	$res= $db->sql_query("REPLACE INTO $pilotsInfoTable (pilotID,serverID) VALUES($pilotIDview,$serverIDview)" );
	$res= $db->sql_query($selQuery);	

	$query="UPDATE $pilotsInfoTable SET
		`sponsor` = '".prep_for_DB($_POST['sponsor'])."',
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
		`commentsEnabled` = ".($_POST['commentsEnabled']+0).",
		`PersonalWebPage` = '".prep_for_DB($_POST['PersonalWebPage'])."'

		 WHERE `pilotID` = '$pilotIDview'  AND serverID='$serverIDview' ";
		 
	$res= $db->sql_query( $query );
    if($res <= 0){
      echo("<H3>Error in update query:  $query</H3>\n");
      return;  
    }
	
   // echo '<div style="font-weight:bold;margin:10px;">'._Your_profile_has_been_updated.'</div>';
	echo "<div style='font-weight:bold;margin:10px;'><span class='ok'>"._Your_profile_has_been_updated."
			</span></div>";
  }
  
  // $query_sel="SELECT * FROM $pilotsTable, ".$CONF['userdb']['users_table']." WHERE pilotID=".$pilotIDview ." AND pilotID=".$CONF['userdb']['user_id_field'] ;
  

  $query_sel=" SELECT * FROM $pilotsTable LEFT JOIN $pilotsInfoTable ON
				($pilotsTable.pilotID=$pilotsInfoTable.pilotID AND $pilotsTable.serverID=$pilotsInfoTable.serverID )
			WHERE 
				$pilotsTable.pilotID=$pilotIDview AND $pilotsTable.serverID=$serverIDview";
  $res= $db->sql_query($query_sel);

  if($res <= 0){
     echo("<H3>Error in pilot query</H3>\n");
     return;
  } else if ( mysql_num_rows($res)==0){
	 // echo "query: $query_sel failed, will insert values into table<BR>";
  	 $res= $db->sql_query("INSERT INTO $pilotsTable (pilotID,serverID) VALUES($pilotIDview,$serverIDview)" );
	 $res= $db->sql_query("INSERT INTO $pilotsInfoTable (pilotID,serverID) VALUES($pilotIDview,$serverIDview)" );
	 echo("<H3>No info for this pilot</H3>\n");
	 return;
  }

  $pilot = mysql_fetch_assoc($res);

	if ($CONF['userdb']['edit']['enabled']) {
		$sql="SELECT * FROM ".$CONF['userdb']['users_table']."  WHERE ".$CONF['userdb']['user_id_field']."=$pilotIDview";
		$res2= $db->sql_query($sql);
	
		if($res2 <= 0){
			echo("<H3>Error in pilot [userTable] query</H3>\n");
			return;
		} else if ( mysql_num_rows($res)==0){
			echo("<H3>No info for this pilot in userTable</H3>\n");
			return;
		}
		$pilotUser= mysql_fetch_assoc($res2);
	}	
	
	$pilotName=getPilotRealName($pilotIDview,$serverIDview,1);
 
	$legend=_Pilot_Profile.": <b>$pilotName</b>";
	$legendRight="<a href='".
		getLeonardoLink(array('op'=>'list_flights','pilotID'=>$serverIDview.'_'.$pilotIDview,'year'=>'0','country'=>''))
		."'>"._PILOT_FLIGHTS."</a>";
	$legendRight.=" | <a href='".
		getLeonardoLink(array('op'=>'pilot_profile','pilotIDview'=>$serverIDview.'_'.$pilotIDview))	
	  	."'>"._View_Profile."</a>";
	$legendRight.=" | <a href='javascript: document.pilotProfile.submit();'>"._Submit_Change_Data."</a>";


	$calLang=$lang2iso[$currentlang];
	
	if ($CONF['profile']['CIVL_ID']['enter_url'] ) {
		$CIVL_ID_enter_url=$CONF['profile']['CIVL_ID']['enter_url'];
		$CIVL_ID_window_width=$CONF['profile']['CIVL_ID']['window_width'];
		$CIVL_ID_window_height=$CONF['profile']['CIVL_ID']['window_height'];
	} else {
		$CIVL_ID_enter_url=getRelMainDir().'GUI_EXT_civl_name_search.php?CIVL_ID_field=CIVL_ID';
		$CIVL_ID_window_width=650;
		$CIVL_ID_window_height=150;
	}
?>
<script language="javascript">
	function setCIVL_ID() {
		window.open('<?=$CIVL_ID_enter_url?>', '_blank',    'scrollbars=yes,resizable=yes,WIDTH=<?=$CIVL_ID_window_width?>,HEIGHT=<?=$CIVL_ID_window_height?>,LEFT=100,TOP=100',true);	
	}

	var imgDir = '<?=moduleRelPath(); ?>/js/cal/';

	var language = '<?=$calLang?>';
	var startAt = 1;		// 0 - sunday ; 1 - monday
	var visibleOnLoad=0;
	var showWeekNumber = 1;	// 0 - don't show; 1 - show
	var hideCloseButton=0;
	var gotoString 		= {<?=$calLang?> : '<?=_Go_To_Current_Month?>'};
	var todayString 	= {<?=$calLang?> : '<?=_Today_is?>'};
	var weekString 		= {<?=$calLang?> : '<?=_Wk?>'};
	var scrollLeftMessage 	= {<?=$calLang?> : '<?=_Click_to_scroll_to_previous_month?>'};
	var scrollRightMessage 	= {<?=$calLang?>: '<?=_Click_to_scroll_to_next_month?>'};
	var selectMonthMessage 	= {<?=$calLang?> : '<?=_Click_to_select_a_month?>'};
	var selectYearMessage 	= {<?=$calLang?> : '<?=_Click_to_select_a_year?>'};
	var selectDateMessage 	= {<?=$calLang?> : '<?=_Select_date_as_date?>' };
	var	monthName 		= {<?=$calLang?> : new Array(<? foreach ($monthList as $m) echo "'$m',";?>'') };
	var	monthName2 		= {<?=$calLang?> : new Array(<? foreach ($monthListShort as $m) echo "'$m',";?>'')};
	var dayName = {<?=$calLang?> : new Array(<? foreach ($weekdaysList as $m) echo "'$m',";?>'') };

</script>
<script language='javascript' src='<? echo $moduleRelPath ?>/js/cal/popcalendar.js'></script>

<form name=pilotProfile  enctype="multipart/form-data" method="POST" >
<?

 openMain("<div style='width:50%;font-size:12px;clear:none;display:block;float:left'>$legend</div><div align='right' style='width:50%; text-align:right;clear:none;display:block;float:right' bgcolor='#eeeeee'>$legendRight</div>",0,'');


   	# Changes Martin Jursa 09.03.2007:
	# in case certain fields are set by an external tool, these fields will be set readonly
	# otherwise, they can be edited
	# $possible_readonly_fields contains all the fields for which this readonly mechanism is available
	$readonly_fields=$CONF['profile']['edit']['readonlyFields'];
	//$readonly_fields=array('LastName', 'FirstName');
	if ($CONF_use_NAC) {
		$readonly_fields=array();
		$list1=$list2=$list3='';
		$possible_readonly_fields=array('NACmemberID', 'LastName', 'FirstName', 'Birthdate', 'CIVL_ID');
		$list4="var all_readonly_fields  = '".implode(',', $possible_readonly_fields)."';\n";
		
		foreach  ($CONF_NAC_list as $NACid=>$NAC) {
		
			$NAC_input_url=$NAC['input_url'];		
			if ( preg_match_all("/#([^#]+)#/",$NAC_input_url,$matches_tmp1) ) {
				//print_r($matches_tmp1);
				foreach($matches_tmp1[1] as $paramName) {
					//echo "!!$NAC_input_url@@$paramName@@".$pilot[$paramName]."^^";
					$NAC_input_url=str_replace('#'.$paramName.'#',$pilot[$paramName],$NAC_input_url);
				}
			}
			
			$list1.="NAC_input_url[$NACid]  = '".json::prepStr($NAC_input_url)."';\n";
			$ext_input=empty($NAC['external_input']) ? 0 : 1;
			$list2.="NAC_external_input[$NACid]  = $ext_input;\n";
			$use_clubs=$NAC['use_clubs']+0;			
			$list2.="NAC_use_clubs[$NACid]  = $use_clubs;\n";

			$list2.="NAC_select_clubs[$NACid]  = ".( ( $NAC['club_change_period_active'] || 
				($NAC['add_to_club_period_active'] && !$pilot['NACclubID'] )|| 
				L_auth::isAdmin($userID)|| L_auth::isModerator($userID) )? 1 : 0).";\n";

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

  <div class='infoHeader'><?=_Personal_Stuff?></div>
  <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
    <tr>
      <td width=150 valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _First_Name ?></div></td>
      <td width="150" valign="top">
			<? 
				$firstNameReadOnly='';
				if (  strlen( str_replace(".","",trim($pilot['FirstName']) ) ) >= 2 &&
					  !L_auth::isAdmin($userID) && !L_auth::isModerator($userID)					 
				) $firstNameReadOnly='readonly="readonly"';
				if ( in_array('FirstName', $readonly_fields) && 
					!L_auth::isAdmin($userID) && !L_auth::isModerator($userID)	) $firstNameReadOnly='readonly="readonly"';
			?> 
			<input name="FirstName" type="text" value="<? echo $pilot['FirstName'] ?>" size="25" maxlength="120" <?=$firstNameReadOnly ?> >
	  </td>
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
		var NAC_select_clubs=[];
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
				if (NAC_select_clubs[NACid]) {
				  MWJ_changeDisplay("mClubLink","inline");
				}
			} else  {
				MWJ_changeDisplay("mClubSelect","none");
				MWJ_changeDisplay("mClubLink","none");
			}
	
			var flds=all_readonly_fields.split(',');
			for (var i=0; i<flds.length; i++) {
				document.forms[0].elements[flds[i]].readOnly=false;
			}
			if (NACid!=0 && NAC_external_fields[NACid]) {
				flds=NAC_external_fields[NACid].split(',');
				for (var i=0; i<flds.length; i++) {
					document.forms[0].elements[flds[i]].readOnly=true;
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
	      </script>
          <?
			echo "<select name='NACid' id='NACid' onchange='changeNAC(this)'>";
			echo "<option value='0'></option>";
			foreach  ($CONF_NAC_list as $NACid=>$NAC) {
				if ($pilot['NACid']==$NACid) $sel=" selected ";
				else $sel="";
				echo "<option $sel value='$NACid'>".
					( $NAC['localLanguage']!=$currentlang?$NAC['name']:$NAC['localName'])."</option>\n";

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
				L_auth::isAdmin($userID) || L_auth::isModerator($userID) 
			) $showChangeClubLink="inline";
			else $showChangeClubLink="none";
			echo "<div id=\"mClubLink\" style=\"display: $showChangeClubLink\">[ <a href='#' onclick=\"setClub();return false;\">"._Select_Club."</a> ]</div>";
/*
			
				echo "[ <a href='#' onclick=\"setClub();return false;\">"._Select_CLub."</a> ]";
			} else {
				echo "";
			}
*/
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
			<?
				$lastNameReadOnly='';
				if (  strlen( str_replace(".","",trim($pilot['LastName']) ) ) >= 2  &&
					  !L_auth::isAdmin($userID) && !L_auth::isModerator($userID) 
				) $lastNameReadOnly='readonly="readonly"';
				if ( in_array('LastName', $readonly_fields) && 
					!L_auth::isAdmin($userID) && !L_auth::isModerator($userID) ) $lastNameReadOnly='readonly="readonly"';
			?>
			<input name="LastName" type="text" value="<? echo $pilot['LastName'] ?>" size="25" maxlength="120" <?=$lastNameReadOnly?> >
		</td>
      <td>&nbsp;</td>
    </tr>
    
<tbody style="display:none">
    <tr>
      <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _First_Name ?> (EN)</div></td>
      <td valign="top"><input name="FirstNameEn" type="text" value="<? echo $pilot['FirstNameEn'] ?>" size="25" maxlength="120" <?=$firstNameReadOnly?> ></td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Last_Name ?> (EN)</div></td>
      <td valign="top"><input name="LastNameEn" type="text" value="<? echo $pilot['LastNameEn'] ?>" size="25" maxlength="120" <?=$lastNameReadOnly?> ></td>
      <td>&nbsp;</td>
    </tr>
</tbody>      
    <tr>
      <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _COUNTRY ?></div></td>
      <td valign="top"><? echo getNationalityDropDown($pilot['countryCode'], in_array('countriesList', $readonly_fields)) ?></td>
      <td>&nbsp;</td>
    </tr>
	
    <tr> 
      <td bgcolor="#E9EDF5"><div align="right">CIVL ID</div></td>
      <td> <input name="CIVL_ID" id="CIVL_ID" type="text" value="<? echo $pilot['CIVL_ID'] ?>" size="6" maxlength="15"> 
		<? echo "[&nbsp;<a href='#' onclick=\"setCIVL_ID();return false;\">"._EnterID."</a>&nbsp;]"; ?></td>
      <td>&nbsp;</td>
    </tr>

	<tr>
		<td valign="top" bgcolor="#E9EDF5"><div align="right"> <? echo _Sex ?></div></td>
		<td valign="top"><? echo getSexDropDown($pilot['Sex'], in_array('Sex', $readonly_fields)) ?></td>
		<td>&nbsp;</td>
	</tr>
	
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Sponsor ?></div></td>
    <td valign="top"><input name="sponsor" type="text" value="<? echo $pilot['sponsor'] ?>" size="25" maxlength="120"></td>
    <td>&nbsp;</td>
    <td width="90" colspan="2" rowspan="4" valign="top"><p align="right">
	<? 	if ($pilot['PilotPhoto']>0) 
                        if (file_exists(getPilotPhotoRelFilename($serverIDview,$pilotIDview))){
                                $cdnURL='';
                        }

			echo "<a href='".$cdnURL.getPilotPhotoRelFilename($serverIDview,$pilotIDview)."' target='_blank'><img align=right src='".$cdnURL.getPilotPhotoRelFilename($serverIDview,$pilotIDview,1)."' border=0></a>";
	?>
	<strong><? echo _Photo ?></strong>
    <? if ($pilot['PilotPhoto']>0) 
			echo "<br><BR> "._Delete_Photo. " <input type=checkbox name=PilotPhotoDelete value=1>";
	?>
    </p></td>
  </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"> <? echo _Birthdate ?><br>
          (<? echo _dd_mm_yy ?>) </div></td>
      <td valign="top">
    	  <input name="Birthdate" type="text" size="10" maxlength="10" value="<? echo $pilot['Birthdate'] ?>"  readonly>
		  <? if ( !in_array('Birthdate', $readonly_fields) ) { ?>
          <a href="javascript:showCalendar(document.pilotProfile.cal_from_button, document.pilotProfile.Birthdate, 'dd.mm.yyyy','<? echo $calLang ?>',0,-1,-1)">
          <img name='cal_from_button' src="<? echo $moduleRelPath ?>/img/cal.gif" width="16" height="16" border="0"></a>
		<? }?>
			<br>Hide: 
<? 
   // xx.xx.xxxx
	$BirthdateHideMask=$pilot['BirthdateHideMask'];
	$hideDay=0;
	$hideMonth=0;
	$hideYear=0;
	$hideYearLastDigit=0;
	if ( substr($BirthdateHideMask,0,2) == 'xx') $hideDay=1;
	if ( substr($BirthdateHideMask,3,2) == 'xx') $hideMonth=1;
	if ( substr($BirthdateHideMask,6,3) == 'xxx') $hideYear=1;
	if ( substr($BirthdateHideMask,9,1) == 'x') $hideYearLastDigit=1;

?>
			<input type="checkbox" name="hideDay" value="1" <?=($hideDay?'checked':'')?> ><?=_DAY?>
			<input type="checkbox" name="hideMonth" value="1" <?=($hideMonth?'checked':'')?> ><?=_MONTH?>
			<input type="checkbox" name="hideYear" value="1" <?=($hideYear?'checked':'')?> ><?=_YEAR?><br>
			<input type="checkbox" name="hideYearLastDigit" value="1" <?=($hideYearLastDigit?'checked':'')?> ><?=_YEAR.' '._LAST_DIGIT?>
    </td>
      <td>&nbsp;</td>
    </tr>
<tbody style="display:none">
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
</tbody>
    <tr> 
      <td style="display:none" valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Occupation?></div></td>
      <td style="display:none"> <input name="Occupation" type="text" value="<? echo $pilot['Occupation'] ?>" size="25" maxlength="120">      </td>

      <td>&nbsp;</td>
      <td colspan="2" bgcolor="#E9EDF5"><div align="right"><? echo _Upload_new_photo_or_change_old ?>
	  </div></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Web_Page ?></div></td>
      <td><input name="PersonalWebPage" type="text" value="<? echo $pilot['PersonalWebPage'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
      <td colspan="2"> 
        <div align="right">
          <input name="PilotPhoto" type="file" size="30">
          </div></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Other_Interests ?></div></td>
      <td colspan="4" valign="top"><textarea name="OtherInterests" cols="80" rows="2"><? echo $pilot['OtherInterests'] ?></textarea></td>
    </tr>
    </table>
    
<? if ( $CONF['userdb']['edit']['enabled']) {

	if ($CONF['userdb']['edit']['edit_email']) {
		$text_email='<input name="user_email" type="text" value="'.$pilotUser[$CONF['userdb']['email_field']].'" size="35" >';
		$text_email.='<input name="user_email_old" type="hidden" value="'.$pilotUser[$CONF['userdb']['email_field']].'" >';
	}else {
		$text_email=$pilotUser[$CONF['userdb']['email_field']];
	}
	
	$text_edit_pwd='
	<div class=\'infoHeader\'>'._Login_Stuff.'</div>
    <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td valign="middle" bgcolor="#E9EDF5"> <div align="right">'._USERNAME.'</div></td>
		<td valign="middle"><b>'.$pilotUser[$CONF['userdb']['username_field']].'</b></td>
		<td>&nbsp;</td>
		<td valign="top" bgcolor="#E9EDF5"> <div align="right">'._pilot_email.'</div></td>
		<td>'.$text_email.'</td>
		
	</tr>
	';
	
	if ($CONF['userdb']['edit']['edit_password']) {
		$text_edit_pwd.='
	<tr>
		<td valign="middle" bgcolor="#E9EDF5" colspan="5" aling="center" ><div align="center"><strong>'._EnterPasswordOnlyToChange.'</strong></div></td>
	</tr>
	<tr>
		<td valign="top" bgcolor="#E9EDF5"> <div align="right">'._PASSWORD.'</div></td>
		<td><input name="pwd1" type="password" value="" size="25" maxlength="32"></td>
		<td>&nbsp;</td>
		<td valign="top" bgcolor="#E9EDF5"> <div align="right">'._PASSWORD_CONFIRMATION.'</div></td>
		<td><input name="pwd2" type="password" value="" size="25" maxlength="32"></td>
	</tr>
';
	}
	
	$text_edit_pwd.='
			</table>
	';
			
	echo $text_edit_pwd;
} 

?>
  <div class='infoHeader'><?=_COMMENTS?></div>
   <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
    <tr>
      <td>
	  <label><?=_Comments_are_enabled_by_default_for_new_flights?>
  		<input type="checkbox" name="commentsEnabled" id="commentsEnabled" value="1" <?=($pilot['commentsEnabled']?'checked':'')?> />
  	  </label>
	  </td>
	  </tr>
	</table>
  
  <div class='infoHeader'><?=_Flying_Stuff." ("._note_place_and_date.")" ?></div>
  <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
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
<tbody style="display:none">
    <tr valign="top"> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Best_Flying_Memory ?></div></td>
      <td colspan="4"><textarea name="BestMemory" cols="80" rows="3"><? echo $pilot['BestMemory'] ?></textarea></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Worst_Flying_Memory ?></div></td>
      <td colspan="4" valign="top"><textarea name="WorstMemory" cols="80" rows="3"><? echo $pilot['WorstMemory'] ?></textarea></td>
    </tr>
</tbody>
  </table>

  <div class='infoHeader'><?=_Equipment_Stuff?></div>
  <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
    <tr>
      <td width='24%' bgcolor="#E9EDF5"><div align="right"><? echo _Glider?></div></td>
      <td width='25%'> <input name="glider" type="text" value="<? echo $pilot['glider'] ?>" size="25" maxlength="120"></td>
      <td width='1%'>&nbsp;</td>
      <td width='25%' bgcolor="#E9EDF5"><div align="right"><? echo _Harness?></div></td>
      <td width='25%'> <input name="Harness" type="text" value="<? echo $pilot['Harness'] ?>" size="25" maxlength="120"></td>

    </tr>

    <tr>
      <td style="display:none" width='25%' bgcolor="#E9EDF5"><div align="right"><? echo _Vario?></div></td>
      <td style="display:none" width='25%'> <input name="Vario" type="text" value="<? echo $pilot['Vario'] ?>" size="25" maxlength="120"></td>
      <td>&nbsp;</td>
      <td style="display:none" bgcolor="#E9EDF5"><div align="right"><? echo _GPS?></div></td>
      <td style="display:none"> <input name="GPS" type="text" value="<? echo $pilot['GPS'] ?>" size="25" maxlength="120"></td>
    </tr>
<tbody style="display:none">
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
</tbody>
  </table>

<!--  <div class='infoHeader'><?//=_Manouveur_Stuff.' ('._note_max_descent_rate.')'?>)</div>
-->
  <table style="display:none"  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
    <tr> 
      <td width='24%' bgcolor="#E9EDF5"><div align="right"><? echo _Spiral?></div></td>
      <td width='25%'> <input name="Spiral" type="text" value="<? echo $pilot['Spiral'] ?>" size="25" maxlength="80"></td>
      <td width='1%'>&nbsp;</td>
      <td width='25%' bgcolor="#E9EDF5"><div align="right"><? echo _Sat?></div></td>
      <td width='25%'> <input name="Sat" type="text" value="<? echo $pilot['Sat'] ?>" size="25" maxlength="80"></td>
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
  </table>
  
  
 <!-- <div class='infoHeader'><?//=_General_Stuff?></div>
-->
  <table style="display:none"  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
    <tr> 
      <td width='24%' bgcolor="#E9EDF5"><div align="right"><? echo _Favorite_Singer?></div></td>
      <td width='25%'> <input name="FavoriteSingers" type="text" value="<? echo $pilot['FavoriteSingers'] ?>" size="25" maxlength="80"></td>
      <td width='1%'>&nbsp;</td>
      <td width='25%' bgcolor="#E9EDF5"><div align="right"><? echo _Favorite_Book?></div></td>
      <td width='24%'> <input name="FavoriteBooks" type="text" value="<? echo $pilot['FavoriteBooks'] ?>" size="25" maxlength="80"></td>
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
  closeMain();

if ($CONF_use_NAC) {
?>
<script language="javascript">
		var sl0=MWJ_findObj("NACid");
		NACid= sl0.options[sl0.selectedIndex].value ;    // Which menu item is selected
</script>
<? } ?>
