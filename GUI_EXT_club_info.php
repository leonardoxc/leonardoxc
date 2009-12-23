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
// $Id: GUI_EXT_club_info.php,v 1.1 2009/12/23 14:02:17 manolis Exp $                                                                 
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
	require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";

	$clubID=$_GET['clubid']+0;
	if (!$clubID)  {
		return;
	}	
	
	if ($CONF_use_utf) {		
		$CONF_ENCODING='utf-8';
	} else  {		
		$CONF_ENCODING=$langEncodings[$currentlang];
	}

	header('Content-type: application/text; charset="'.$CONF_ENCODING.'"',true);
	
 
   
  echo "<div class='infoHeader'>".$clubsList[$clubID]['desc']."</div>";
  
  
?> 


<table  class="main_text"  width="100%" border="0">
<? if ($clubsList[$clubID]['adminName']) { ?>
  <tr> 
    <td width="110" bgcolor="#E9EDF5" valign="top"><div align="right"><?="Admin"?></div></td>
    <td valign="top"><?=$clubsList[$clubID]['adminName'] ?></td>
  </tr>
<? } ?>
<? if ($clubsList[$clubID]['website']) { ?>
   <tr> 
    <td width="110" bgcolor="#E9EDF5" valign="top"><div align="right"><?=_RELEVANT_PAGE?></div></td>
    <td valign="top"><a target='_blank' href='http://<?=$clubsList[$clubID]['website'] ?>'>http://<?=$clubsList[$clubID]['website']?></a></td>
  </tr>
<? } ?>
  <tr> 
    <td width="110" bgcolor="#E9EDF5" valign="top"><div align="right"><?=_GLIDER_TYPE?></div></td>
    <td valign="top">
    <? 
    	if ( !is_array($clubsList[$clubID]['gliderCat'])  ) {
			echo _All_glider_types;
		} else {
			$i=0;
			foreach($clubsList[$clubID]['gliderCat'] as $gcatid){
				if ($i>0) echo ", ";
				echo $gliderCatList[$gcatid];
				$i++;
			}	
		}
	
	?>
    </td>
   </tr>
<? if ($clubsList[$clubID]['noSpecificMembers'] ) { ?>

    <tr> 
    <td width="110" bgcolor="#E9EDF5" valign="top"><div align="right"><?=_COUNTRY?></div></td>
    <td valign="top">
    <? 
    	if ( !is_array($clubsList[$clubID]['countryCodes'])  ) {
			echo _WORLD_WIDE;
		} else {
			$i=0;
			foreach($clubsList[$clubID]['countryCodes'] as $cid){
				if ($i>0) echo ", ";
				echo $countries[strtoupper($cid)];
				$i++;
			}	
		}
	
	?>
    </td>
  </tr>
  <tr> 
    <td width="110" bgcolor="#E9EDF5" valign="top"><div align="right"><?=_Filter_Items_nationality?></div></td>
    <td valign="top">
    <? 
    	if ( !is_array($clubsList[$clubID]['pilotNationality'])  ) {
			echo _WORLD_WIDE;
		} else {
			$i=0;
			foreach($clubsList[$clubID]['pilotNationality'] as $cid){
				if ($i>0) echo ", ";
				echo $countries[strtoupper($cid)];
				$i++;
			}	
		}
	
	?>
    </td>
  </tr>
    
  
<? } else { ?>
  </tr>
    <tr> 
    <td width="110" bgcolor="#E9EDF5" valign="top"><div align="right"><?=_MENU_SHOW_PILOTS?></div></td>
    <td valign="top">
   	 <a href="<?=getLeonardoLink(array('op'=>'list_pilots','comp'=>0) )?>"><?=_MENU_SHOW_PILOTS ?></a>

    </td>
  </tr>
  

  
<? } ?>

</table>

<? 
	$infoFile=LEONARDO_ABS_PATH."/data/clubs/$clubID/info.html";
	if (is_file($infoFile) ){
		echo "<div class='infoHeader'>Info</div>";
		@include $infoFile;
	}	
		