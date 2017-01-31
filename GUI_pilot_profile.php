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
// $Id: GUI_pilot_profile.php,v 1.30 2012/09/12 19:41:03 manolis Exp $                                                                 
//
//************************************************************************

	if (!$pilotIDview && $userID>0) {
		$pilotIDview=$userID;
		$serverIDview=0;
	}
	
	//	$serverIDview=$serverID;
	
	//$selQuery="SELECT * FROM $pilotsTable, ".$CONF['userdb']['users_table'].
	//					" WHERE pilotID=".$pilotIDview ." AND serverID=$serverID AND pilotID=".$CONF['userdb']['user_id_field'];
						
	$selQuery="SELECT * FROM $pilotsTable LEFT JOIN $pilotsInfoTable ON
				($pilotsTable.pilotID=$pilotsInfoTable.pilotID AND $pilotsTable.serverID=$pilotsInfoTable.serverID )
			WHERE 
				$pilotsTable.pilotID=".$pilotIDview." AND $pilotsTable.serverID=$serverIDview ";
	// echo " # $selQuery # ";
    $res= $db->sql_query($selQuery);

	if($res <= 0){
		echo("<H3>Error in pilot query</H3>\n");
		return;
	} else if ( mysql_num_rows($res)==0){
		$res= $db->sql_query("INSERT INTO $pilotsTable (pilotID,serverID) VALUES($pilotIDview,$serverIDview)" );
		$res= $db->sql_query($selQuery);			
	}
  
  $pilot = mysql_fetch_assoc($res);
  
  $pilotName=getPilotRealName($pilotIDview,$serverIDview,1);

  $legend=_Pilot_Profile.": <b>$pilotName</b>";
  $legendRight="<a href='". 
  		getLeonardoLink(array('op'=>'list_flights','pilotID'=>$serverIDview.'_'.$pilotIDview,'year'=>'0','country'=>''))
		."'>"._PILOT_FLIGHTS."</a>";
  $legendRight.=" | <a href='".
 		getLeonardoLink(array('op'=>'pilot_profile_stats','pilotIDview'=>$serverIDview.'_'.$pilotIDview))		
		."'>"._pilot_stats."</a>";
  if ( $pilotIDview == $userID || L_auth::isAdmin($userID) && $serverIDview==0  ) {
	  $legendRight.=" | <a href='".
	  getLeonardoLink(array('op'=>'pilot_profile_edit','pilotIDview'=>$pilotIDview))	
	  ."'>"._edit_profile."</a>";
  }
  else $legendRight.="";
  
  if (  L_auth::isAdmin($userID) && $serverIDview!=-1  ) {
	  $legendRight.=" | <a href='javascript:getPilotInfo($serverIDview,$pilotIDview,0)'>Get Original Info</a>";
  }
 
 // openMain("<table class=\"main_text\"  width=\"90%\"><tr><td>$legend</td><td width=350 align=\"right\" bgcolor=\"#eeeeee\">$legendRight</td></tr></table>",0,"icon_profile.png");

  if (INLINE_VIEW!=1){ 
 	openMain("<div style='width:60%;font-size:12px;clear:none;display:block;float:left'>$legend</div><div align='right' style='width:40%; text-align:right;clear:none;display:block;float:right' bgcolor='#eeeeee'>$legendRight</div>",0,'');
  }

?> 

<div id="pilotInfoDivExt" style="display:none;background-color:#CCD2D9;width:100%;height:auto; padding:2px">
<a href='javascript: hidePilotDiv()'>Close</a> :: 
<a href='javascript: getPilotInfo(<?=$serverIDview.','.$pilotIDview?>,1)'>Update Local DB</a> 
<? if ( $serverIDview!=0) { ?>
:: <a href='javascript: getPilotInfo(<?=$serverIDview.','.$pilotIDview?>,2)'>Update Local DB (delete all current data)</a>
<? } ?>
<div id="pilotInfoDiv" style="display:none;background-color:#EEECBF;width:100%;height:auto;">Results HERE</div>
</div>

<?  if (  L_auth::isAdmin($userID) && $serverIDview!=-1  && INLINE_VIEW!=1) { ?>
<script language="javascript">

function hidePilotDiv() {
	$("#pilotInfoDivExt").hide();
}

function getPilotInfo(serverID,pilotID,update) {
    $("#pilotInfoDiv").html("<img src='<?=$moduleRelPath?>/img/ajax-loader.gif'>").show();	
	$.get('<?=$moduleRelPath?>/EXT_pilot_functions.php',
		{ op:"getExternalPilotInfo","serverID":serverID,"pilotID":pilotID,"updateData":update}, 
		function(result){ 
			/*var jsonData = eval('(' + result + ')');
			
			var resStr='';
			for ( varName in jsonData['log'][0]['item'] ) {  
    			resStr+=varName+' : '+jsonData['log'][0]['item'][varName]+'<br>';  
			} */ 
			$("#pilotInfoDiv").html(result).show();	
			$("#pilotInfoDivExt").show();	
			
		}
	);		
	
}
</script>
<? } ?>
<?php  if (INLINE_VIEW!=1) { ?> 
<script type='text/javascript' src='<?=$moduleRelPath ?>/js/xns.js'></script>
<?php  } ?>
<div class='infoHeader'><?=_Personal_Stuff ?></div>
<table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr> 
    <td width=150 valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _First_Name ?></div></td>
    <td width=150 valign="top" bgcolor="#F9F9F9"> <? echo $pilot['FirstName'] ?></td>
    <td width =3>&nbsp;</td>
    <td colspan="2" valign="top" bgcolor="#F5F2EB">      <div align="left">
	<? if ($CONF_use_NAC) {
		    require_once dirname(__FILE__)."/CL_NACclub.php";
			echo "<strong>"._MEMBER_OF.":</strong> ";
			echo $CONF_NAC_list[$pilot['NACid']] ['name'];
			if ($pilot['NACid']) { 
				echo " [ "._MemberID.": ";
				if ($CONF_NAC_list[$pilot['NACid']]['memberIDpublic']) echo $pilot['NACmemberID']." ]";
				else echo "***** ]";
			}
		} ?></div></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Last_Name ?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <? echo $pilot['LastName'] ?>    </td>
    <td>&nbsp;</td>
    <td colspan="2" valign="top" bgcolor="#F5F2EB"><div align="left">
	<? if ($CONF_use_NAC)  {     
		echo "<strong>"._Club.":</strong> ".NACclub::getClubName( $pilot['NACid'], $pilot['NACclubID']) ;
	} ?></div></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _COUNTRY ?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <? echo getNationalityDescription($pilot['countryCode']); ?>    </td>
    <td>&nbsp;</td>
    <td colspan="2" rowspan="8" valign="top"><? 
	
	  	if ($pilot['PilotPhoto']>0) {
		
			checkPilotPhoto($serverIDview,$pilotIDview);
		?>
      <div align="center"><strong><? echo _Photo ?> </strong><br>
          <?
			$imgBigRel=getPilotPhotoRelFilename($serverIDview,$pilotIDview);	
			$imgBig=getPilotPhotoFilename($serverIDview,$pilotIDview);	
			list($width, $height, $type, $attr) = getimagesize($imgBig);
			list($width, $height)=CLimage::getJPG_NewSize($CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height);
			echo "<a href='$imgBigRel' target='_blank'><img src='".getPilotPhotoRelFilename($serverIDview,$pilotIDview,1)."'
			onmouseover=\"trailOn('$imgBigRel','','','','','','1','$width','$height','','.');\" onmouseout=\"hidetrail();\" 
			 border=0></a>";					
		?>
                        </div>      <?		
		}
	  ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5">
    <div align="right"><? echo _Sex ?></div></td>
    <td valign="top" bgcolor="#F9F9F9"><? 
		echo getPilotSexString($pilot['Sex'] ,true);
	?>	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5">
    <div align="right"><? echo _Sponsor ?></div></td>
    <td valign="top" bgcolor="#F9F9F9"><? echo $pilot['sponsor'] ?>	</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"> <? echo _Birthdate ?> 
        (<? echo _dd_mm_yy ?>) </div></td>
    <td valign="top" bgcolor="#F9F9F9"><? 
		$BirthdateHideMask=$pilot['BirthdateHideMask'] ;
		$Birthdate=$pilot['Birthdate'] ;
		if ($Birthdate) {
			for($i=0;$i<10;$i++) {
				$Birthdate[$i]=$BirthdateHideMask[$i]=='x'?'x':$Birthdate[$i];
			}
			echo $Birthdate;
		}
		?>    </td>
    <td>&nbsp;</td>
  </tr>
<!--
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Sign ?></div></td>
	<td valign="top" bgcolor="#F9F9F9"><?// echo $pilot['Sign'] ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Marital_Status ?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['MartialStatus'] ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
-->
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Occupation?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <? echo $pilot['Occupation'] ?>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Web_Page ?></div></td>
    <td valign="top" bgcolor="#F9F9F9"><? 
		if ($pilot['PersonalWebPage']!='') {
			if ( substr($pilot['PersonalWebPage'],0,4)!='http' ) $link="http://".$pilot['PersonalWebPage'];
			else $link=$pilot['PersonalWebPage'];
			echo "<a href='".$link."' target=_blank>".$pilot['PersonalWebPage']."</a>";
		}
		else echo _N_A; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Other_Interests ?></div></td>
    <td colspan="4" valign="bottom" bgcolor="#F9F9F9"><? echo $pilot['OtherInterests'] ?></td>
  </tr>  
  </table>
  
  
  <div class='infoHeader'><?=_Flying_Stuff?></div>
  <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr> 
    <td width='24%' valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Flying_Since ?></div></td>
    <td width='25%' valign="top" bgcolor="#F9F9F9"> <? echo $pilot['FlyingSince'] ?>    </td>
    <td width='1%'>&nbsp;</td>
    <td width='25%' valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Personal_Distance_Record?></div></td>
    <td width='25%' valign="top" bgcolor="#F9F9F9"><? echo $pilot['personalDistance'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Pilot_Licence?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <? echo $pilot['PilotLicence'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Personal_Height_Record?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <? echo $pilot['personalHeight'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Paragliding_training?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <? echo $pilot['Training'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Hours_Flown?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <? echo $pilot['HoursFlown'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Favorite_Location?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <? echo $pilot['FavoriteLocation'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Hours_Per_Year?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <? echo $pilot['HoursPerYear'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Usual_Location?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <? echo $pilot['UsualLocation'] ?>    </td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"></div></td>
    <td>&nbsp;</td>
  </tr>
  <!--<tr valign="top"> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><?// echo _Best_Flying_Memory ?>
    </div></td>
    <td colspan="4" bgcolor="#F9F9F9"><?// echo $pilot['BestMemory'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><?// echo _Worst_Flying_Memory ?>
    </div></td>
    <td colspan="4" valign="top" bgcolor="#F9F9F9"><?// echo $pilot['WorstMemory'] ?></td>
  </tr>
 -->
  </table>
  
  
  <div class='infoHeader'><?=_Equipment_Stuff?></div>
  <table  class=main_text  width="100%" border="0">
  <tr> 
    <td width='24%' valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Glider?></div></td>
    <td width='25%' valign="top" bgcolor="#F9F9F9"><? echo $pilot['glider'] ?></td>
    <td width='1%'>&nbsp;</td>
    <td width='25%' valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Harness?></div></td>
    <td width='25%' valign="top" bgcolor="#F9F9F9"> <? echo $pilot['Harness'] ?></td>
    
  <!--  <td width='25%' valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Vario?></div></td>
    <td width='25%' valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['Vario'] ?></td>
  -->
  </tr>
<!--  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Harness?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['Harness'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _GPS?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['GPS'] ?></td>
-->
  </tr>
 <!-- <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Reserve_chute?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['Reserve'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Helmet?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['Helmet'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Camera?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['camera'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Camcorder?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['camcorder'] ?></td>
  </tr>  
-->
  </table>
  
 <!-- 
  <div class='infoHeader'><?//=_Manouveur_Stuff.' ('._note_max_descent_rate.')'?></div>
  <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr> 
    <td width='24%' valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Spiral?></div></td>
    <td width='25%' valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['Spiral'] ?></td>
    <td width='1%'>&nbsp;</td>
    <td width='25%' valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Sat?></div></td>
    <td width='25%' valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['Sat'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Bline?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['Bline'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Asymmetric_Spiral?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['AsymmetricSpiral'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Full_Stall?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['FullStall'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Spin?></div></td>
    <td valign="top" bgcolor="#F9F9F9"><?// echo $pilot['Spin'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Other_Manouveurs_Acro?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['OtherAcro'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"></div></td>
    <td valign="top" bgcolor="#F9F9F9">&nbsp;</td>
  </tr>
  </table>
  -->
 <!-- 
  <div class='infoHeader'><?//=_General_Stuff?></div>
  <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr> 
    <td width='24%' valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Favorite_Singer?></div></td>
    <td width='25%' valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['FavoriteSingers'] ?></td>
    <td width='1%'>&nbsp;</td>
    <td width='25%' valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Favorite_Book?></div></td>
    <td width='25%' valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['FavoriteBooks'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Favorite_Movie?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['FavoriteMovies'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Favorite_Actor?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['FavoriteActors'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><?// echo _Favorite_Internet_Site?></div></td>
    <td valign="top" bgcolor="#F9F9F9"> <?// echo $pilot['FavoriteSite'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"></div></td>
    <td valign="top" bgcolor="#F9F9F9"></td>
  </tr>
  <tr> 
    <td colspan="5"> <hr> </td>
  </tr>
  </table>
-->
<?
	if (INLINE_VIEW!=1){ 
		closeMain();
	}
?>
