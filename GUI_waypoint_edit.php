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

    echo "<br>";

    open_inner_table("Edit waypoint",650,"icon_pin.png");
 
  echo "<tr><td>";	
?> 

      <form name="form1" method="post" action="">

        <table width="600" border="0" align="center" cellpadding="2" class=main_text>
          <tr>
            <td width="201" bgcolor="#CFE2CF"><div align="right"><font color="#003366">Name</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="wname" type="text" id="wname" size="40" value="<? echo $waypt->name ?>" >
              <input name="waypointIDedit " type="hidden" id="waypointIDedit " value="<? echo $waypointIDedit ?>" >
              <input name="type" type="hidden" id="type" value="<? echo $waypt->type ?>" >
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">International
            Name</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="intName" type="text" id="intName" size="40" value="<? echo $waypt->intName ?>" >
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Region</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="location" type="text" id="Location" size="40" value="<? echo $waypt->location ?>" >
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">International
            Region</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="intLocation" type="text" id="intLocation" size="40" value="<? echo $waypt->intLocation ?>" >
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
          </tr>
          <tr>
            <td width="201" bgcolor="#CFE2CF">
            <div align="right"><font color="#003366">lat</font></div></td>
            <td width="385" bgcolor="#E3E7F2"><font color="#003366">
              <input name="lat" type="text" id="lat"  value="<? echo $waypt->lat ?>" >
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">lon</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="lon" type="text" id="lon"  value="<? echo $waypt->lon ?>" >
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"><font color="#003366">Relevant URL</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <input name="link" type="text" id="link"  value="<? echo $waypt->link ?>" size="60" >
            </font></td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#CFE2CF"><div align="right"><font color="#003366">Description</font></div></td>
            <td bgcolor="#E3E7F2"><font color="#003366">
              <textarea name="description" cols="60" rows="5" id="description"><? echo $waypt->description ?></textarea>
            </font></td>
          </tr>
          <tr>
            <td bgcolor="#CFE2CF"><div align="right"></div></td>
            <td bgcolor="#E3E7F2">
				<input type="submit" name="Submit" value="<? echo "APPLY CHANGES" ?>">
				<input type="hidden" name="editWaypoint" value="1">		
  	     </td>
          </tr>
        </table>
</form>
    

<?
  echo "</td></tr>";
  close_inner_table();
?>
