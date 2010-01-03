<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_EXT_settings.php,v 1.3 2010/01/03 20:27:46 manolis Exp $                                                                 
//
//************************************************************************
  	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
 	require_once dirname(__FILE__)."/EXT_config.php";

	require_once dirname(__FILE__)."/CL_flightData.php";
	require_once dirname(__FILE__)."/FN_functions.php";	
	require_once dirname(__FILE__)."/FN_UTM.php";
	require_once dirname(__FILE__)."/FN_waypoint.php";	
	require_once dirname(__FILE__)."/FN_output.php";
	require_once dirname(__FILE__)."/FN_pilot.php";
	require_once dirname(__FILE__)."/FN_flight.php";

	$msg='';
  	if (isset($_REQUEST['updatePrefs'])) {// submit form 	   		

		$PREFS->themeName=makeSane($_REQUEST['PREFS_themeName'],0);
		$PREFS->itemsPerPage=makeSane($_REQUEST['PREFS_itemsPerPage'],1);
		$PREFS->metricSystem=makeSane($_REQUEST['PREFS_metricSystem']);
		$PREFS->googleMaps=makeSane($_REQUEST['PREFS_googleMaps'],1);
		$PREFS->nameOrder=makeSane($_REQUEST['PREFS_nameOrder'],1);
		$PREFS->useEditor=makeSane($_REQUEST['PREFS_useEditor'],1);
		$PREFS->showNews=makeSane($_REQUEST['PREFS_showNews'],1);
		
			
		$PREFS->language=makeSane($_REQUEST['PREFS_language']);
		$_SESSION["lng"]= $PREFS->language;
		$PREFS->viewCat=makeSane($_REQUEST['PREFS_viewCat'],1);
		$_SESSION["cat"]= $PREFS->viewCat;
		$PREFS->viewCountry=makeSane($_REQUEST['PREFS_viewCountry']);
		$_SESSION["country"]= $PREFS->viewCountry;
	
		if ( !is_dir(dirname(__FILE__)."/templates/".$PREFS->themeName) || !$PREFS->themeName )
			$PREFS->themeName=$CONF_defaultThemeName;
	
		$PREFS->setToCookie();
		echo "<span class='ok'>"._Your_settings_have_been_updated."</span>";
		return;	
	}
   

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  >
<html>
<head>
  <title><?=_Select_Club?></title>
  <meta http-equiv="content-type" content="text/html; charset=<?=$CONF_ENCODING?>">
</head>
<body>
<script language="javascript">

 $(function() { // onload...do
        $('#userPrefs').submit(function() {
          var inputs = [];
          $(':input', this).each(function() {
            inputs.push(this.name + '=' + escape(this.value));
          })
          jQuery.ajax({
            data: inputs.join('&'),
            url: '<?=moduleRelPath() ?>/GUI_EXT_settings.php',
            timeout: 2000,
            error: function() {
             $("#userPrefsMsg").html("<span class='alert'>Error in updating user settings</span>");
            },
            success: function(r) { 
             $("#userPrefsMsg").html(r);
            }
          }) 
          return false;
        })
      })
</script>

<div id="userPrefsMsg"></div>
<form name="userPrefs" id="userPrefs" method="POST" >
<?
 //  openMain(_MENU_MY_SETTINGS,0,"icon_profile.png"); 
?>

  <table  width="100%" border="0" bgcolor="#F4F3F1" cellpadding="3" align="left" class="box main_text" style="background-color:#F4F3F1">
  	<tr> 
      <td colspan="5" >&nbsp;</td>
    </tr>
    <tr> 
      <td width="284" bgcolor="#E0E2F0"><div align="right"><? echo _THEME ?></div></td>
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
	  </select>	  </td>
      <td width="1">&nbsp;</td>
      <td width="284" bgcolor="#E0E2F0"><div align="right"><? echo _SHOW_NEWS?></div></td>
      <td width="236"><select name="PREFS_showNews">
          <option value="1" <? echo ($PREFS->showNews==1)?"selected":"" ?>><? echo _YES ?></option>
          <option value="0" <? echo ($PREFS->showNews==0)?"selected":"" ?>><? echo _NO ?></option>
      </select>     </td>
    </tr>
    <tr> 
      <td width="284" bgcolor="#EAEDEE"><div align="right"><? echo _LANGUAGE ?></div></td>
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
      <td width="284" bgcolor="#EAEDEE">&nbsp;</td>
      <td width="236">&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#E0E2F0"><div align="right"><? echo _VIEW_CATEGORY ?></div></td>
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
	  </select>	 </td>
      <td>&nbsp;</td>
      <td bgcolor="#E0E2F0">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#EAEDEE"><div align="right"><? echo _VIEW_COUNTRY ?></div></td>
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
      </select></td>
      <td>&nbsp;</td>
      <td bgcolor="#EAEDEE">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#E0E2F0"><div align="right"><? echo _UNITS_SYSTEM ?></div></td>
      <td>
        <select name="PREFS_metricSystem">
          <option value="1" <? echo ($PREFS->metricSystem==1)?"selected":"" ?>><? echo _METRIC_SYSTEM ?></option>
          <option value="2" <? echo ($PREFS->metricSystem==2)?"selected":"" ?>><? echo _IMPERIAL_SYSTEM ?></option>
      </select></td>
      <td>&nbsp;</td>
      <td bgcolor="#E0E2F0">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#EAEDEE"><div align="right"><? echo _ITEMS_PER_PAGE ?></div></td>
      <td> <input name="PREFS_itemsPerPage" type="text" value="<? echo $PREFS->itemsPerPage ?>" size="5" maxlength="120"></td>
      <td>&nbsp;</td>
      <td bgcolor="#EAEDEE">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<? if ($CONF_google_maps_track) { ?>
    <tr> 
      <td bgcolor="#E0E2F0"><div align="right"><? echo "Google Maps"?></div></td>
      <td>
        <select name="PREFS_googleMaps">
          <option value="1" <? echo ($PREFS->googleMaps==1)?"selected":"" ?>><? echo _YES ?></option>
          <option value="0" <? echo ($PREFS->googleMaps==0)?"selected":"" ?>><? echo _NO ?></option>
      </select></td>
      <td>&nbsp;</td>
      <td bgcolor="#E0E2F0">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<? } ?>
	<? if ($CONF['editor']['use_wysiwyg']['global']) { ?>
    <tr> 
      <td bgcolor="#EAEDEE"><div align="right"><? echo "Advanced Editor"?></div></td>
      <td>
        <select name="PREFS_useEditor">
          <option value="1" <? echo ($PREFS->useEditor==1)?"selected":"" ?>><? echo _YES ?></option>
          <option value="0" <? echo ($PREFS->useEditor==0)?"selected":"" ?>><? echo _NO ?></option>
      </select></td>
      <td>&nbsp;</td>
      <td bgcolor="#EAEDEE">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<? } else { ?>
	<input type="hidden" name="PREFS_useEditor" value=0 />
	<?  } ?>
	 <tr> 
      <td bgcolor="#E0E2F0"><div align="right"><? echo _PILOT_NAME ?></div></td>
      <td>
        <select name="PREFS_nameOrder">
          <option value="1" <? echo ($PREFS->nameOrder==1)?"selected":"" ?>><? echo _First_Name.' / '._Last_Name ?></option>
          <option value="2" <? echo ($PREFS->nameOrder==2)?"selected":"" ?>><? echo _Last_Name.' / '._First_Name  ?></option>
       </select></td>
      <td>&nbsp;</td>
      <td bgcolor="#E0E2F0">&nbsp;</td>
      <td>&nbsp;</td>
	 </tr>
    <tr> 
      <td colspan="5"><div align="center"> <br />
      <input type="submit" name="Submit" value="<? echo _Submit_Change_Data ?>">
      </div></td>
    </tr>
    <tr> 
      <td colspan="5" >&nbsp; </td>
    </tr>
  </table>
  <input type="hidden" name="updatePrefs" value="1">
</form>

<?

 // closeMain();
?>
</body>
</html>