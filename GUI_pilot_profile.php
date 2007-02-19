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
  
  open_inner_table("<table  class=main_text  width=100%><tr><td>$legend</td><td width=430 align=right bgcolor=#eeeeee>$legendRight</td></tr></table>",720,"icon_profile.png");
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
    <td colspan="2" rowspan="8" valign="top">
        <? 
	  	if ($pilot['PilotPhoto']>0) {
		?>
		 <div align="center"><strong><? echo _Photo ?>
        </strong><br>
		<?
			echo "<a href='".getPilotPhotoRelFilename($pilotIDview)."' target='_blank'><img src='".getPilotPhotoRelFilename($pilotIDview,1)."' border=0></a>";					
		?> 
		</div>
		<?		
		}
	  ?>    </td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Last_Name ?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['LastName'] ?>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _COUNTRY ?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo getNationalityDescription($pilot['countryCode']); ?>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5"><? if ($CONF_use_NAC) {?><div align="right"><? echo _MEMBER_OF ?></div><? } ?></td>
    <td valign="top" bgcolor="#F5F5F5"><? if ($CONF_use_NAC) {
			echo $CONF_NAC_list[$pilot['NACid']] ['name'];
			echo " [ MemberID: ";
			echo $pilot['NACmemberID']." ]";;
		} ?>
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"> <? echo _Birthdate ?> 
        (<? echo _dd_mm_yy ?>) </div></td>
    <td valign="top" bgcolor="#F5F5F5"><? echo $pilot['Birthdate'] ?>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Sign ?></div></td>
	<td valign="top" bgcolor="#F5F5F5"><? echo $pilot['Sign'] ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Marital_Status ?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['MartialStatus'] ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Occupation?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Occupation'] ?>    </td>
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
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Other_Interests ?></div></td>
    <td colspan="4" valign="bottom" bgcolor="#F5F5F5"><? echo $pilot['OtherInterests'] ?></td>
  </tr>
  <tr> 
    <td colspan="5" valign="top" bgcolor="006699"> <div align="left"><strong><font color="#FFA34F"><? echo _Flying_Stuff ?>
	(<? echo _note_place_and_date ?>)</font></strong></div></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Flying_Since ?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['FlyingSince'] ?>    </td>
    <td>&nbsp;</td>
    <td width="150" valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Personal_Distance_Record?></div></td>
    <td width="150" valign="top" bgcolor="#F5F5F5"><? echo $pilot['personalDistance'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Pilot_Licence?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['PilotLicence'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Personal_Height_Record?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['personalHeight'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Paragliding_training?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Training'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Hours_Flown?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['HoursFlown'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Favorite_Location?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['FavoriteLocation'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Hours_Per_Year?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['HoursPerYear'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Usual_Location?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['UsualLocation'] ?>    </td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top"> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Best_Flying_Memory ?>
    </div></td>
    <td colspan="4" bgcolor="#F5F5F5"><? echo $pilot['BestMemory'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _Worst_Flying_Memory ?>
    </div></td>
    <td colspan="4" valign="top" bgcolor="#F5F5F5"><? echo $pilot['WorstMemory'] ?></td>
  </tr>
  <tr> 
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="5" bgcolor="006699"><strong><font color="#FFA34F"><? echo _Equipment_Stuff?></font></strong></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Glider?></div></td>
    <td valign="top" bgcolor="#F5F5F5"><? echo $pilot['glider'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Vario?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Vario'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Harness?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Harness'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _GPS?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['GPS'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Reserve_chute?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Reserve'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Helmet?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Helmet'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Camera?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['camera'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Camcorder?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['camcorder'] ?></td>
  </tr>
  <tr> 
    <td colspan="5" bgcolor="006699"><strong><font color="#FFA34F"><? echo _Manouveur_Stuff ?>
      (<? echo _note_max_descent_rate?>)</font></strong></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Spiral?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Spiral'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Sat?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Sat'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Bline?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['Bline'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Asymmetric_Spiral?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['AsymmetricSpiral'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Full_Stall?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['FullStall'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Spin?></div></td>
    <td valign="top" bgcolor="#F5F5F5"><? echo $pilot['Spin'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Other_Manouveurs_Acro?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['OtherAcro'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"></div></td>
    <td valign="top" bgcolor="#F5F5F5">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="5" bgcolor="006699"><strong><font color="#FFA34F"><? echo _General_Stuff?></font></strong></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Favorite_Singer?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['FavoriteSingers'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Favorite_Book?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['FavoriteBooks'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Favorite_Movie?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['FavoriteMovies'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Favorite_Actor?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['FavoriteActors'] ?></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Favorite_Internet_Site?></div></td>
    <td valign="top" bgcolor="#F5F5F5"> <? echo $pilot['FavoriteSite'] ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5"><div align="right"></div></td>
    <td valign="top" bgcolor="#F5F5F5"></td>
  </tr>
  <tr> 
    <td colspan="5"> <hr> </td>
  </tr>
</table>
<?
  echo "</td></tr>"; 
  close_inner_table();
?>