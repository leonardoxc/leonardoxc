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
 * Martin Jursa 23.05.2007: Add FirstOlcYear
 */

  // edit function
  if ( $pilotIDview == $userID || in_array($userID,$admin_users)  ) {
  }
  if (!$pilotIDview && $userID>0) $pilotIDview=$userID;

  $res= $db->sql_query("SELECT * FROM $pilotsTable, ".$prefix."_users WHERE pilotID=".$pilotIDview ." AND pilotID=user_id" );

  if($res <= 0){
     echo("<H3>Error in pilot query</H3>\n");
     return;
  } else if ( mysql_num_rows($res)==0){
  	 $res= $db->sql_query("INSERT INTO $pilotsTable (pilotID) VALUES($pilotIDview)" );
	 //echo("<H3>No info for this pilot</H3>\n");
	 //return;
  	 $res= $db->sql_query("SELECT * FROM $pilotsTable WHERE pilotID=".$pilotIDview );
  }

  $pilot = mysql_fetch_assoc($res);


  $legend=_Pilot_Profile.": <b>$pilot[username]</b>";
  $legendRight="<a href='?name=$module_name&op=list_flights&pilotID=$pilotIDview&year=0&country='>"._PILOT_FLIGHTS."</a>";
  $legendRight.=" | <a href='?name=$module_name&op=pilot_profile_stats&pilotIDview=$pilotIDview'>"._pilot_stats."</a>";
  if ( $pilotIDview == $userID || in_array($userID,$admin_users)  ) {
	  $legendRight.=" | <a href='?name=$module_name&op=pilot_profile_edit&pilotIDview=$pilotIDview'>"._edit_profile."</a>";
      if ($enableOLCsubmission) $legendRight.=" | <a href='?name=$module_name&op=pilot_olc_profile_edit&pilotIDview=$pilotIDview'>"._edit_OLC_info."</a>";
  }
  else $legendRight.="";

  open_inner_table("<table  class=\"main_text\"  width=\"100%\"><tr><td>$legend</td><td width=430 align=\"right\" bgcolor=\"#eeeeee\">$legendRight</td></tr></table>",720,"icon_profile.png");
  open_tr();
  echo "<td>";
?>
<table  class=main_text  width="100%" border="0">
  <tr>
    <td colspan="5" bgcolor="006699"><strong><font color="#FFA34F"><? echo _Personal_Stuff ?></font></strong></td>
  </tr>
  <tr>
    <td width=150 valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _First_Name ?></div></td>
    <td width=150 valign="top" bgcolor="#F5F5F5"> <? echo $pilot['FirstName'] ?></td>
    <td width =3>&nbsp;</td>
    <td colspan="2" valign="top" bgcolor="#F5F2EB">      <div align="left">
	<? if ($CONF_use_NAC) {
		    require_once dirname(__FILE__)."/CL_NACclub.php";
			echo "<strong>"._MEMBER_OF.":</strong> ";
			echo $CONF_NAC_list[$pilot['NACid']] ['name'];
                         	if ($pilot['NACid']) {
				echo " [ "._MemberID.": ";
				//if ($CONF_NAC_list[$pilot['NACid']]['memberIDpublic']) echo $pilot['NACmemberID']." ]";
				//else echo "***** ]";
                                 if ( $pilotIDview != $userID && !in_array($userID,$admin_users) && !in_array($userID,$mod_users) ){
	 echo _hidden;
         }
         else echo $pilot['NACmemberID'];
                                 }
		} ?></div></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Last_Name ?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['LastName'] ?>    </td>
    <td>&nbsp;</td>
    <td colspan="2" valign="top" bgcolor="#F5F2EB"><div align="left">
	<? if ($CONF_use_NAC)  {
		echo "<strong>"._Club.":</strong> ".NACclub::getClubName( $pilot['NACid'], $pilot['NACclubID']) ;
	} ?></div></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _COUNTRY ?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo getNationalityDescription($pilot['countryCode']); ?>    </td>
    <td>&nbsp;</td>
    <td colspan="2" rowspan="6" valign="top"><?
	  	if ($pilot['PilotPhoto']>0) {
		?>
      <div align="center"><strong><? echo _Photo ?> </strong><br>
          <?
			echo "<a href='".getPilotPhotoRelFilename($pilotIDview)."' target='_blank'><img src='".getPilotPhotoRelFilename($pilotIDview,1)."' border=0></a>";
		?>
                        </div>      <?
		}
	  ?></td>
  </tr>

	<tr>
	    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _pilot_email ?></div></td>
	    <td valign="top" bgcolor="#F5F5F5"><?
	    	if ( $pilotIDview != $userID && !in_array($userID,$admin_users) && !in_array($userID,$mod_users) ){
		 		echo _hidden;
	         }
	         else echo $pilot['user_email']; ?>
	    </td>
  	</tr>

	<tr>
		<td valign="top" bgcolor="#E9EDF5"> <div align="right"> <? echo _Birthdate ?></div></td>
		<td valign="top" bgcolor="#F5F5F5"><?
			if ( $pilotIDview != $userID && !in_array($userID, $admin_users) && !in_array($userID, $mod_users) ){
				echo _hidden;
			}else {
				echo $pilot['Birthdate'];
				/*$ts=strtotime($pilot['Birthdate']);
				if ($ts>0) {
					echo date('d.m.Y', $ts);
				}*/
			} ?>
		</td>
		<td>&nbsp;</td>
	</tr>

  <tr>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Web_Page ?></div></td>
    <td valign="top" bgcolor="#F5F5F5"><?
		if ($pilot['PersonalWebPage']!='') {
			if ( substr($pilot['PersonalWebPage'],0,4)!='http' ) $link="http://".$pilot['PersonalWebPage'];
			else $link=$pilot['PersonalWebPage'];
			echo "<a href='".$link."' target=_blank>".$pilot['PersonalWebPage']."</a>";
		}
		else echo _N_A; ?></td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Sponsor ?></div></td>
    <td valign="top" bgcolor="#F5F5F5"><? echo $pilot['sponsor'] ?>	</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Other_Interests ?></div></td>
    <td colspan="1" valign="bottom" bgcolor="#F5F5F5"><? echo $pilot['OtherInterests'] ?></td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td colspan="5" valign="top" bgcolor="006699"> <div align="left"><strong><font color="#FFA34F"><? echo _Flying_Stuff ?>
	</font></strong></div></td>
  </tr>

  <tr>
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _FirstOlcYear ?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['FirstOlcYear'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="left">&nbsp;</div></td>
    <td width="150" valign="top" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Flying_Since ?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['FlyingSince'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="left"><? echo _Personal_Distance_Record?></div></td>
    <td width="150" valign="top" bgcolor="#F5F5F5"><? echo $pilot['personalDistance'] ?></td>
  </tr>
 <td>&nbsp;</td>

  <tr>
    <td colspan="5" bgcolor="006699"><strong><font color="#FFA34F"><? echo _Equipment_Stuff?></font></strong></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Glider?></div></td>
    <td valign="top" bgcolor="#F5F5F5"><? echo $pilot['glider'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="left"><? echo _Vario?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Vario'] ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Harness?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Harness'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="left"><? echo _GPS?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['GPS'] ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Reserve_chute?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Reserve'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="left"><? echo _Helmet?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Helmet'] ?></td>
  </tr>

  <tr>
    <td colspan="5"> <hr> </td>
  </tr>
</table>
<?
  echo "</td></tr>";
  close_inner_table();
?>