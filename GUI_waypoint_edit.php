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

    if (! auth::isAdmin($userID)) {
		return;
    }

	$waypointIDedit=makeSane($_REQUEST['waypointIDedit'],1);

	if ( $_POST['editWaypoint']==1 ) { // CHANGE waypoint
		$waypt=new waypoint($waypointIDedit);
		
		$waypt->name=$_POST['wname'];
		$waypt->intName=$_POST['intName'];
		$waypt->type=$_POST['type'];
		$waypt->lat=$_POST['lat'];
		$waypt->lon=$_POST['lon'];
		$waypt->location=$_POST['location'];
		$waypt->intLocation=$_POST['intLocation'];
		$waypt->countryCode=$_POST['countryCode'];
		$waypt->link=$_POST['link'];
		$waypt->description=$_POST['description'];

		if ( $waypt->putToDB(1) ) {
			 echo "<center>"._THE_CHANGES_HAVE_BEEN_APPLIED."<br>";
			 echo "<a href='".CONF_MODULE_ARG."&op=show_waypoint&waypointIDview=".$waypointIDedit."'>RETURN to view mode</a> or "; 
			 echo "<a href='".CONF_MODULE_ARG."&op=list_flights'>RETURN to flights</a>"; 
			 echo "<br></center>";
		} else echo("<H3> Error in puting waypoint info into DB! </H3>\n");			
	}

  
	$waypt=new waypoint($waypointIDedit);
	$waypt->getFromDB();

	require_once dirname(__FILE__).'/FN_editor.php';

    echo "<br>";

    open_inner_table("Edit waypoint",760,"icon_pin.png");
 
  echo "<tr><td>";	
?> 

      <form name="form1" method="post" action="">

        <table width="725" border="0" align="center" cellpadding="2" class=main_text>
          <tr>
            <td width="104" bgcolor="#CFE2CF"><div align="right"><font color="#003366">Name</font></div></td>
            <td width="212" bgcolor="#E3E7F2"><font color="#003366">
              <input name="wname" type="text" id="wname" size="30" value="<? echo $waypt->name ?>" >
              <input name="waypointIDedit " type="hidden" id="waypointIDedit " value="<? echo $waypointIDedit ?>" >
              <input name="type" type="hidden" id="type" value="<? echo $waypt->type ?>" >
            </font></td>
            <td width="143" bgcolor="#CFE2CF"><div align="right"><font color="#003366">Name in English <img src="<?=$moduleRelPath?>/language/flag-english.png" width="18" height="12" /></font></div></td>
            <td width="240" bgcolor="#E3E7F2"><font color="#003366">
              <input name="intName" type="text" id="intName" size="30" value="<? echo $waypt->intName ?>" />
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Region</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="location" type="text" id="Location" size="30" value="<? echo $waypt->location ?>" >
            </font></td>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Region in English <img src="<?=$moduleRelPath?>/language/flag-english.png" width="18" height="12" /></font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="intLocation" type="text" id="intLocation" size="30" value="<? echo $waypt->intLocation ?>" />
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Country
            Code</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
		    <select name="countryCode">
				<? 				
					foreach ($countries as $key => $value) {
						if ($waypt->countryCode==$key) $sel=" selected ";
						else $sel="";		
						echo '<option value="'.$key.'" '.$sel.' >'.$key.' - '.$value.'</option>';
					}
								
				?>
		    </select>
            </font></td>
            <td colspan="2" bgcolor="#CFE2CF"><font color="#003366">lat
              <input name="lat" type="text" id="lat"  size="10" value="<? echo $waypt->lat ?>" />
            lon
            <input name="lon" type="text" id="lon" size="10" value="<? echo $waypt->lon ?>" />
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Relevant URL</font></div></td>
            <td colspan="3" bgcolor="#E3E7F2"><font color="#003366">
              <input name="link" type="text" id="link"  value="<? echo $waypt->link ?>" size="60" >
              <input type="submit" name="Submit2" value="<? echo "APPLY CHANGES" ?>" />
            </font></td>
          </tr>
          <tr>
            <td colspan="4" bgcolor="#E7E6CB"><div align="center"><strong><font color="#003366">Description</font></strong></div></td>
          </tr>
          <tr>
            <td colspan="4" valign="top" bgcolor="#CFE2CF">
			  <? createTextArea('description',$waypt->description ,'Leonardo',710,600);
			?>            </td>
          </tr>
          <tr>
            <td colspan="4"><div align="right"></div>
				<div align="center">
				  <input type="submit" name="Submit" value="<? echo "APPLY CHANGES" ?>">
				  <input type="hidden" name="editWaypoint" value="1">  	     
		        </div></td>
          </tr>
        </table>
</form>
    

<?
  echo "</td></tr>";
  close_inner_table();
?>
