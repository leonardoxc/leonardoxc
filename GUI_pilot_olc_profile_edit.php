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
  if ( $pilotIDview != $userID && !in_array($userID,$admin_users)  ) {
 	echo "<div>You dont have permission to edit this profile<br></div>";
    return;
  }
  
  if (isset($_REQUEST['updateOLCProfile'])) {// submit form 
	   				
   $query="UPDATE $pilotsTable SET
   		`olcFirstName` = '".$_POST['FirstName']."',
		`olcLastName` = '".$_POST['LastName']."',
		`olcBirthDate` = '".$_POST['Birthdate']."',
		`olcCallSign` = '".$_POST['olcCallSign']."',
		`olcFilenameSuffix` = '".substr($_POST['olcFilenameSuffix'],0,4)."'
		
		 WHERE `pilotID` = '$pilotIDview' ";

    $res= $db->sql_query( $query );
    if($res <= 0){
      echo("<H3>Error in OLC data update query</H3>\n");
      return;  
    }
	
    echo "<div align=center>"._Your_profile_has_been_updated."<br></div>";
  }
  
  $res= $db->sql_query("SELECT  username, olcFirstName, olcLastName ,   olcBirthDate , olcCallSign , olcFilenameSuffix,olcAutoSubmit 
					FROM $pilotsTable, ".$prefix."_users WHERE pilotID=".$pilotIDview ." AND pilotID=user_id" );
					   
 // $res= $db->sql_query("SELECT * FROM $pilotsTable WHERE pilotID=".$pilotIDview );

  if($res <= 0){
     echo("<H3>Error in pilot query</H3>\n");
     return;
  } else if ( mysql_num_rows($res)==0){
  	 $res= $db->sql_query("INSERT INTO $pilotsTable (pilotID) VALUES($pilotIDview)" );
	 echo("<H3>No info for this pilot</H3>\n");
	 return;
  }
  
  $pilot = mysql_fetch_assoc($res);
  
  $legend=_OLC_Pilot_Info.": <b>$pilot[username]</b>";
  $legendRight="<a href='?name=$module_name'&op=list_flights>"._back_to_flights."</a>";
  $legendRight.=" | <a href='?name=".$module_name."&op=pilot_profile&pilotIDview=".$pilotIDview."'>"._View_Profile."</a>";
  $legendRight.=" | <a href='javascript: document.pilotOLCProfile.submit();'>"._Submit_Change_Data."</a>";
/*  if ( $pilotIDview == $userID || in_array($userID,$admin_users)  ) 
	  $legendRight.=" | <a href='?name=$module_name&op=pilot_profile_edit&pilotIDview=$pilotIDview'>edit profile</a>";
  else $legendRight.="";
*/ 
?>
<form name=pilotOLCProfile  enctype="multipart/form-data" method="POST" action="?name=<? echo $module_name ?>&op=pilot_olc_profile_edit&pilotIDview=<? echo $pilotIDview?>" >
<?
  open_inner_table("<table  class=main_text  width=100%><tr><td>$legend</td><td width=370 align=right bgcolor=#eeeeee>$legendRight</td></tr></table>",720,"icon_profile.png");
  
  open_tr();  
  echo "<td>";
?>

  <table  class=main_text  width="100%" border="0">
    <tr> 
      <td colspan="3" bgcolor="006699"><strong><font color="#FFA34F"><? echo _OLC_information ?></font></strong></td>
    </tr>
    <tr> 
      <td width=157 valign="top" bgcolor="#E9EDF5"> <div align="right"><? echo _First_Name ?></div></td>
      <td width="222" valign="top">
			<input name="FirstName" type="text" value="<? echo $pilot['olcFirstName'] ?>" size="25" maxlength="120"> 
	  </td>
      <td width="836" rowspan="6" valign="top" bgcolor="#FEFCEB"><? echo _OLC_EXPLAINED ?></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"><div align="right"><? echo _Last_Name ?></div></td>
      <td valign="top"> 			
			<input name="LastName" type="text" value="<? echo $pilot['olcLastName'] ?>" size="25" maxlength="120"> 		
      </td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#E9EDF5"> <div align="right"> <? echo _Birthdate ?><br>
          (<? echo _dd_mm_yy ?>) </div></td>
      <td valign="top"> <input name="Birthdate" type="text" value="<? echo $pilot['olcBirthDate'] ?>" size="25" maxlength="120"> 
      </td>
    </tr>
    <tr> 
      <td align="right" valign="top" bgcolor="#E9EDF5"><? echo _callsign ?></td>
      <td valign="top"><input name="olcCallSign" type="text" value="<? echo $pilot['olcCallSign'] ?>" size="25" maxlength="120"></td>
    </tr>
    <tr> 
      <td align="right" valign="top" bgcolor="#E9EDF5"><? echo _filename_suffix ?></td>
      <td valign="top"><input name="olcFilenameSuffix" type="text" value="<? echo $pilot['olcFilenameSuffix'] ?>" size="25" maxlength="120"></td>
    </tr>
    <tr>
      <td colspan="2" align="left" valign="top" bgcolor="#FEFCEB"><? echo _OLC_SUFFIX_EXPLAINED ?></td>
    </tr>

    <tr> 
      <td colspan="3"><div align="center"> 
          <hr>
       
            <input type="submit" name="Submit" value="<? echo _Submit_Change_Data ?>">
      </div></td>
    </tr>
  </table>
  <input type=hidden name=updateOLCProfile value=1>
</form>

<?
  echo "</td></tr>"; 
  close_inner_table();
?>