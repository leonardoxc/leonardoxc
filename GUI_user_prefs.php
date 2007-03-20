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
  
  if (isset($_REQUEST['updatePrefs'])) {// submit form 	   		

	$PREFS->themeName=makeSane($_POST['PREFS_themeName'],0);
	$PREFS->itemsPerPage=makeSane($_POST['PREFS_itemsPerPage'],1);
	$PREFS->metricSystem=makeSane($_POST['PREFS_metricSystem']);

	$PREFS->language=makeSane($_POST['PREFS_language']);
	$_SESSION["lng"]= $PREFS->language;

	$PREFS->viewCat=makeSane($_POST['PREFS_viewCat'],1);
	$_SESSION["cat"]= $PREFS->viewCat;

	$PREFS->viewCountry=makeSane($_POST['PREFS_viewCountry']);
	$_SESSION["country"]= $PREFS->viewCountry;

    echo "<div align=center>"._Your_settings_have_been_updated."<br><br><a href='?name=$module_name&op=list_flights'>"._RETURN_TO_FLIGHTS."</a><br><br></div>";
  }
   

?>
<form name=userPrefs  method="POST" action="?name=<? echo $module_name ?>&op=user_prefs" >
<?
  open_inner_table(_MENU_MY_SETTINGS,500,"icon_profile.png");
  
  open_tr();  
  echo "<td bgcolor='#EEF3E9'>";
?>

  <table  width="100%" border="0" bgcolor="#EEF3E9"  class=main_text>
    <tr> 
      <td colspan="3" bgcolor="006699" height=3></td>
    </tr>
	<tr> 
      <td colspan="3" >&nbsp;</td>
    </tr>
    <tr> 
      <td width="284" bgcolor="#F8F8E4"><div align="right"><? echo _THEME ?></div></td>
      <td width="236"><select name="PREFS_themeName">		
<? 
			$themes=getAvailableThemes();
			foreach ($themes as $tmpTheme) {
				if ($tmpTheme!= $PREFS->themeName )
					echo '<option value="'.$tmpTheme.'">'.$tmpTheme.'</option>';
				else
					echo '<option value="'.$tmpTheme.'" selected>'.$tmpTheme.'</option>';
			}
?>	
	  </select>
	  </td>
      <td width="1">&nbsp;</td>
    </tr>
    <tr> 
      <td width="284" bgcolor="#F8F8E4"><div align="right"><? echo _LANGUAGE ?></div></td>
      <td width="236">        <select name="PREFS_language">		
		<? foreach  ($availableLanguages as $tmpLang ) {
			if ($tmpLang!= $PREFS->language )
				echo '<option value="'.$tmpLang.'">'.$tmpLang.'</option>';
			else
				echo '<option value="'.$tmpLang.'" selected>'.$tmpLang.'</option>';

		} 
		?> 
      </select></td>
      <td width="1">&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#F8F8E4"><div align="right"><? echo _VIEW_CATEGORY ?></div></td>
      <td> 
		<select name="PREFS_viewCat">        
      	<?
			if ($PREFS->viewCat==0) $is_type_sel ="selected";
			else $is_type_sel ="";
			echo "<option $is_type_sel value=0>"._ALL."</option>\n";
			foreach ( $CONF_glider_types as $gl_id=>$gl_type) {

				if ($PREFS->viewCat==$gl_id) $is_type_sel ="selected";
				else $is_type_sel ="";
				echo "<option $is_type_sel value=$gl_id>".$gliderCatList[$gl_id]."</option>\n";
			}
		?>
	  </select>
	 </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#F8F8E4"><div align="right"><? echo _VIEW_COUNTRY ?></div></td>
      <td>      <select name="PREFS_viewCountry">
<? 
		if (!$countriesNum) {
			list($countriesCodes,$countriesNames,$countriesFlightsNum)=getCountriesList(0,0);
			$countriesNum=count($countriesNames);
		}
		//list($countriesCodes,$countriesNames,$countriesFlightsNum)=getCountriesList();
		//$countriesNum=count($countriesNames);

		if (! $PREFS->viewCountry) $is_type_sel ="selected";
		else $is_type_sel ="";
		echo "<option $is_type_sel value=0>"._ALL."</option>\n";

		$i=0;
		foreach($countriesNames as $countryName) {
			if ("$PREFS->viewCountry"=="$countriesCodes[$i]") 
				echo '<option value="'.$countriesCodes[$i++].'" selected>'.$countryName.'</option>';
			else 
				echo '<option value="'.$countriesCodes[$i++].'">'.$countryName.'</option>';
		}

?> 
        </select>	  </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#F8F8E4"><div align="right"><? echo _UNITS_SYSTEM ?></div></td>
      <td>
        <select name="PREFS_metricSystem">
          <option value="1" <? echo ($PREFS->metricSystem==1)?"selected":"" ?>><? echo _METRIC_SYSTEM ?></option>
          <option value="2" <? echo ($PREFS->metricSystem==2)?"selected":"" ?>><? echo _IMPERIAL_SYSTEM ?></option>
        </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#F8F8E4"><div align="right"><? echo _ITEMS_PER_PAGE ?></div></td>
      <td> <input name="PREFS_itemsPerPage" type="text" value="<? echo $PREFS->itemsPerPage ?>" size="5" maxlength="120"></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#F8F8E4"><div align="right"><? echo "Google Maps"?></div></td>
      <td>
        <select name="PREFS_googleMaps">
          <option value="1" <? echo ($PREFS->googleMaps==1)?"selected":"" ?>><? echo _YES ?></option>
          <option value="0" <? echo ($PREFS->googleMaps==0)?"selected":"" ?>><? echo _NO ?></option>
        </select></td>
      <td>&nbsp;</td>
    </tr>

    <tr> 
      <td colspan="3"><div align="center"> 
          <input type="submit" name="Submit" value="<? echo _Submit_Change_Data ?>">
      </div></td>
    </tr>
    <tr> 
      <td colspan="3" >&nbsp; </td>
    </tr>
    <tr> 
      <td colspan="3" bgcolor="006699" height=3></td>
    </tr>
  </table>
  <input type=hidden name=updatePrefs value=1>
</form>

<?
  echo "</td></tr>"; 
  close_inner_table();
?>