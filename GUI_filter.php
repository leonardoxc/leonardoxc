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
// $Id: GUI_filter.php,v 1.32 2010/03/21 22:51:58 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__).'/CL_filter.php';

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//echo "<pre>"; print_r($_SESSION); echo "</pre>";

$filterUrl="http://".$_SERVER['SERVER_NAME'].getLeonardoLink(array('op'=>'filter','fl_url'=>'1'));
$redirectUrl="http://".$_SERVER['SERVER_NAME'].getLeonardoLink(array('op'=>'list_flights'));

require_once dirname(__FILE__).'/CL_dialogfilter.php';
$dlgfilters=array();
$dlgfilters['pilots_incl']=new dialogfilter('pilot', 'FILTER_pilots_incl');
/**
 * By suffixing _excl to the FILTER_xx variable, the dialogfilter excludes the selection from the query
 * Example:
 * $dlgfilters['pilots_excl']=new dialogfilter('pilot', 'FILTER_pilots_excl');
 */
if (!empty($CONF_use_NAC)) {
	if (!empty($CONF_NAC_list)) {
		foreach ($CONF_NAC_list as $nacid=>$nacdata) {
			if (!empty($nacdata['use_clubs'])) {
				$key='nacclubs'.$nacid.'_incl';
				$dlgfilters[$key]=new dialogfilter('nacclub', 'FILTER_'.$key, $nacid);
			}
		}
	}
}
$dlgfilters['countries_incl']=new dialogfilter('country', 'FILTER_countries_incl');
$dlgfilters['takeoffs_incl']=new dialogfilter('takeoff', 'FILTER_takeoffs_incl');
$dlgfilters['nationality_incl']=new dialogfilter('nationality', 'FILTER_nationality_incl');

if ( count($CONF['servers']['list']) ) {
	$dlgfilters['servers_incl']=new dialogfilter('server', 'FILTER_server_incl');
}

$filterkeys=array_keys($dlgfilters);

if (!$filter) {
	$filter=new LeonardoFilter();
}	
	
// echo "<pre>".print_r($filter->filterArray)."</pre>";

if (( $_REQUEST['setFilter']==1 || $_GET['fl_url']==1 ) && 0) { // form submitted

	// we have taken care of this at index.php

} else { // form not submitted
	global $filterVariables ;	
	$filter->filterExport('filterVariables');
	// print_r($filterVariables);
	if (is_array($filterVariables)) {
		foreach ($filterVariables as $key => $value ) {
			if (is_array($value) ) continue;
			if (substr($key,0,7)=="FILTER_") {		
				$$key=$value;
			}
		}
	}
	
	// put default values
	if (!isset($FILTER_dateType) ) {
		$FILTER_dateType="ALL";
		$FILTER_YEAR_select_op="=";
		$FILTER_YEAR_select=date("Y");
		$FILTER_MONTH_YEAR_select_op="=";
		$FILTER_MONTH_YEAR_select_MONTH=date("m");
		$FILTER_MONTH_YEAR_select_YEAR=date("Y");
		$FILTER_from_day_text="";
		$FILTER_to_day_text="";

		$FILTER_linear_distance_op=">=";
		$FILTER_linear_distance_select="";
		$FILTER_olc_distance_op=">=";
		$FILTER_olc_distance_select="";
		$FILTER_olc_score_op=">=";
		$FILTER_olc_score_select="";
		$FILTER_duration_op=">=";
		$FILTER_duration_hours_select="";
		$FILTER_duration_minutes_select="";
		
		$FILTER_PilotBirthdate_op=">=";
		$FILTER_PilotBirthdate_text="";
	}

}

 openMain(_FILTER_PAGE_TITLE,0,''); 
 
 if ($_REQUEST["setFilter"])  {
	echo "<div align='center'><a href='".getLeonardoLink(array('op'=>'list_flights'))."'>"._RETURN_TO_FLIGHTS."</a></div><br><br>";	
 }
 
// echo 	"<ul>".$filter->filterTextual ."</ul>";
 
if ($_SESSION["fltr"]) {
 
 $filterUrl="http://".$_SERVER['SERVER_NAME'].getLeonardoLink(array('op'=>'list_flights'));
 
	/// Martin Jursa 21.06.2007 add bookmark-javascript
 	$browser=getBrowser();
 	$agent=!empty($browser[0]) ? $browser[0] : '';
 	$is_ie=$agent=='ie';
 	$filterbasename=$_SERVER['SERVER_NAME'];
 	if ($is_ie) {
 		$js="
<script type=\"text/javascript\" language=\"JavaScript\">
<!--
function addFavorite() {
	if (document.all) {
		var url='$filterUrl';
		var title='$filterbasename Filter';
		window.external.AddFavorite(url, title);
	}
}
//   -->
</script>
";
 	}else {
 		$js='';
 	}
	if ($is_ie) {
		echo $js;
	}
	echo "<span class='ok'  style='margin-top:0;'><img src='".$moduleRelPath."/img/icon_filter.png' alinn='absmiddle' border=0> "._THE_FILTER_IS_ACTIVE."";
	if ($is_ie) {
		echo ' :: <a href="javascript:addFavorite();" title="'._Msg_AddToBookmarks_IE.'">'._Explanation_AddToBookmarks_IE.'</a>';
	}else {
		echo " :: <a href=\"".$filterUrl."\" title=\""._Msg_AddToBookmarks_nonIE."\" onclick=\"alert('".addslashes(_Msg_AddToBookmarks_nonIE)."'); return false;\">$filterbasename Filter</a> "._Explanation_AddToBookmarks_nonIE."";
	}
	
    $rss_url_base="http://".$_SERVER['SERVER_NAME'].getRelMainDir()."rss.php";
	$rss_url=$rss_url_base."?c=20&fltr=".$_SESSION['fltr'];
	echo "
	  <BR><BR><div align='left'>
	      <img src='".moduleRelPath()."/img/icons1/rss.gif' width='31' height='15'> 
          (<a id='rss_url' href='$rss_url' target='_blank'>copy paste this url to your RSS reader</a>) 

		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 <strong># of items </strong>
        <select name='rss_item_num' id='rss_item_num' onChange='updateRssURL()'>          
          <option value='10'>10</option>
          <option value='20' selected>20</option>
          <option value='30'>30</option>
          <option value='40'>40</option>
          <option value='50'>50</option>
      </select>
	  
      </div>	
	";
	
	echo "</span>";
	// end martin jursa 21.06.2007
 } else echo "<span class='note' style='margin-top:0;'>"._THE_FILTER_IS_INACTIVE."</span>";
 $calLang=$lang2iso[$currentlang];
?>
<? if ($_GET['fl_url']) { ?>

<script language='javascript'>
window.location = "<? echo  $redirectUrl ?>"
</script>

<? } ?>
<script language='javascript'>
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

var FILTER_cat=0;
var FILTER_class=0;
var FILTER_glider_cert=0;
var FILTER_start_type=0;
var FILTER_duration=0;

var fltr='<?=$filter->makeFilterString()?>';
function filterUpdateDuration() {
	FILTER_duration=$('#xFILTER_duration_hours_select').val()*60 + $('#xFILTER_duration_minutes_select').val()*1;	
	$("#FILTER_duration_select").val(FILTER_duration);

}

function filterUpdateCat() {
	FILTER_cat=0;
	$.each($("input[@name='xFILTER_cat[]']:checked"), function() {
		FILTER_cat+=($(this).val()*1);
	});
	$("#FILTER_cat").val(FILTER_cat);
}

function filterUpdateClass() {
	FILTER_class=$("input[@name='xFILTER_class_1']:checked").val();
	$("#FILTER_class").val(FILTER_class);
}

function filterUpdateGliderCert() {
	FILTER_glider_cert=0;

	var addValues=[];
	
	$.each($("input[@name='xFILTER_glider_cert[]']:checked"), function() {
		var v1=$(this).val()*1;
		if ( addValues[v1] == null ) {
			addValues[v1]=1;
			FILTER_glider_cert+=v1;
		}	
	});
	$("#FILTER_glider_cert").val(FILTER_glider_cert);
}

function filterUpdateStartType() {
	FILTER_start_type=0;
	$.each($("input[@name='xFILTER_start_type[]']:checked"), function() {
		FILTER_start_type+=($(this).val()*1);
	});
	$("#FILTER_start_type").val(FILTER_start_type);
}

function resetBirthday() {
	$("#FILTER_PilotBirthdate_text").val('');
}


function updateRssURL() {
	var	a1="?c=".concat($("#rss_item_num").val());
	var base='<?=$rss_url_base?>';
	var rss_url= base.concat(a1,'&fltr='+fltr);
	
	$("#rss_url").attr("href", rss_url);
}
 
function activateFilter() {
	filterUpdateDuration();	
	filterUpdateCat();
	filterUpdateClass();
	filterUpdateGliderCert();
	filterUpdateStartType();
	
	$("#formFilter").submit();	
}

function changeClass(gCat) {
	var val=$("input[@name='xFILTER_class_"+gCat+"']:checked").val();		
	setClass(1,val);
	setClass(2,val);	
}

function setClass(classID,val) {
	$("input[@name='xFILTER_class_"+classID+"']").attr('checked', false);
	$.each($("input[@name='xFILTER_class_"+classID+"']"), function() {
		if ( ($(this).val()*1) == val ) {
			 $(this).attr('checked', true);
		}
	});	
}	
	
</script>
<script language='javascript' src='<? echo $moduleRelPath ?>/js/cal/popcalendar.js'></script>

<form name="formFilter"  id="formFilter" method="post" action="" onsubmit="activateFilter(); return false;">
  <table class=main_text width="750"  border="0" align="center" cellpadding="3" cellspacing="3">
    <tr>
      <td colspan="2" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="6">
                <tr>
                  <td colspan="2" class='infoHeader'><div align="left"><strong><? echo _SELECT_DATE ?></strong></div></td>
                </tr>
                <tr>
                  <td width="8%"><div align="right"></div></td>
                  <td width="42%"><? echo _SHOW_FLIGHTS ?> </td>
                </tr>
                <tr>
                  <td><div align="right">
                      <input name="FILTER_dateType" type="radio" value="ALL" <? if ($FILTER_dateType=="ALL") echo "checked" ?> />
                  </div></td>
                  <td><? echo _ALL2 ?></td>
                </tr>
                <tr>
                  <td><div align="right">
                      <input name="FILTER_dateType" type="radio" value="YEAR" <? if ($FILTER_dateType=="YEAR") echo "checked" ?> />
                  </div></td>
                  <td><? echo _WITH_YEAR ?>
                      <select name="FILTER_YEAR_select_op">
                        <option value="=" <? if ($FILTER_YEAR_select_op=="=") echo "selected" ?>>=</option>
                        <option value="&gt;=" <? if ($FILTER_YEAR_select_op==">=") echo "selected" ?>>&gt;=</option>
                        <option value="&lt;=" <? if ($FILTER_YEAR_select_op=="<=") echo "selected" ?>>&lt;=</option>
                      </select>
                      <select name="FILTER_YEAR_select">
                        <?
			 for($i=$CONF_StartYear;$i<=date("Y");$i++)  {
			 	$sel=($i==$FILTER_YEAR_select)?"selected":"";
				echo  "<option value='$i' $sel>$i</option>";
			 }
		   ?>
                    </select></td>
                </tr>
                <tr>
                  <td><div align="right"> <? echo _OR ?>
                          <input name="FILTER_dateType" type="radio" value="MONTH_YEAR" <? if ($FILTER_dateType=="MONTH_YEAR") echo "checked" ?> />
                  </div></td>
                  <td><select name="FILTER_MONTH_YEAR_select_op">
                      <option value="="   <? if ($FILTER_MONTH_YEAR_select_op=="=") echo "selected" ?>>=</option>
                      <option value="&gt;="  <? if ($FILTER_MONTH_YEAR_select_op==">=") echo "selected" ?>>&gt;=</option>
                      <option value="&lt;="  <? if ($FILTER_MONTH_YEAR_select_op=="<=") echo "selected" ?>>&lt;=</option>
                    </select>
                      <? echo _MONTH ?>
                      <select name="FILTER_MONTH_YEAR_select_MONTH">
                        <? $i=1;

			 foreach ($monthList as $monthName)  {
			 $sel=($i==$FILTER_MONTH_YEAR_select_MONTH+0)?"selected":"";
			 	$k=sprintf("%02s",$i);
				echo  "<option value='$k' $sel>$monthName</option>";
				$i++;
			 }
		   ?>
                      </select>
                      <? echo _YEAR ?>
                      <select name="FILTER_MONTH_YEAR_select_YEAR">
                        <?
			 for($i=$CONF_StartYear;$i<=date("Y");$i++)  {
			 	$sel=($i==$FILTER_MONTH_YEAR_select_YEAR)?"selected":"";
				echo  "<option value='$i' $sel>$i</option>";
			 }
		   ?>
                    </select></td>
                </tr>
                <tr>
                  <td><div align="right"> <? echo _OR ?>
                          <input name="FILTER_dateType" type="radio" value="DATE_RANGE" <? if ($FILTER_dateType=="DATE_RANGE") echo "checked" ?> />
                  </div></td>
                  <td><? echo _From ; ?>
                          <input name="FILTER_from_day_text" type="text" size="10" maxlength="10" value="<?=$FILTER_from_day_text ?>" />
                      <a href="javascript:showCalendar(document.formFilter.cal_from_button, document.formFilter.FILTER_from_day_text, 'dd.mm.yyyy','<? echo $calLang ?>',0,-1,-1)"> <img src="<? echo $moduleRelPath ?>/img/cal.gif" name='cal_from_button' width="16" height="16" border="0" id="cal_from_button" /></a> <a href="javascript:showCalendar(document.formFilter.cal_to_button, document.formFilter.FILTER_to_day_text, 'dd.mm.yyyy','<? echo $calLang ?>',0,-1,-1)"> </a>
					  
					  <? echo _TO ?>
                      <input name="FILTER_to_day_text" type="text" size="10" maxlength="10" value="<?=$FILTER_to_day_text ?>" />
                    <a href="javascript:showCalendar(document.formFilter.cal_to_button, document.formFilter.FILTER_to_day_text, 'dd.mm.yyyy','<? echo $calLang ?>',0,-1,-1)"> <img src="<? echo $moduleRelPath ?>/img/cal.gif" name='cal_to_button' width="16" height="16" border="0" id="cal_to_button" /></a>					  </td>
                </tr>
                <tr>
                  <td colspan="2" class="infoHeader"><? echo _PilotBirthdate ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><select name="FILTER_PilotBirthdate_op">
                    <option value="="   <? if ($FILTER_PilotBirthdate_op=="=") echo "selected" ?>>=</option>
                    <option value="&gt;="  <? if ($FILTER_PilotBirthdate_op==">=") echo "selected" ?>>&gt;=</option>
                    <option value="&lt;="  <? if ($FILTER_PilotBirthdate_op=="<=") echo "selected" ?>>&lt;=</option>
                  </select>
                    <input name="FILTER_PilotBirthdate_text" id="FILTER_PilotBirthdate_text" type="text" size="10" maxlength="10" value="<?=$FILTER_PilotBirthdate_text ?>" />
                    <a href="javascript:showCalendar(document.formFilter.cal_b_button, document.formFilter.FILTER_PilotBirthdate_text, 'dd.mm.yyyy','<? echo $calLang ?>',0,-1,-1)"> <img src="<? echo $moduleRelPath ?>/img/cal.gif" name='cal_b_button' width="16" height="16" border="0" id="cal_b_button" /></a> 
					
					&nbsp;&nbsp;&nbsp;&nbsp;<- <a href='javascript:resetBirthday();'><?=_ALL2?></a>
					
					
					</td>
                </tr>
            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="6">                       
                <tr>
                  <td width="130" class="main_text"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <td valign="top"><div class="infoHeader"><? echo _Start_Type?> </div>
				  <input name="FILTER_start_type" id="FILTER_start_type" type="hidden" value="0" />
                      <?			
					foreach (  $CONF['startTypes'] as $fl_tmp_id=>$fl_tmp_value) {
						$checked='';
						if ($fl_tmp_id & $FILTER_start_type) $checked="checked='checked'";
						echo "<label><input type='checkbox' name='xFILTER_start_type[]' value='$fl_tmp_id' $checked />".
							$fl_tmp_value."</label><BR />\n";			
					}
				  ?>
                      <div class="infoHeader"><? echo _GLIDER_TYPE ?> </div>
				   <input type="hidden" id="FILTER_cat"  name="FILTER_cat"   value="0" />
                   <?			
					foreach (  $CONF_glider_types as $fl_tmp_id=>$fl_tmp_value) {
						$checked='';
						if ($fl_tmp_id & $FILTER_cat) $checked="checked='checked'";
						echo "<label><input type='checkbox' name='xFILTER_cat[]' value='$fl_tmp_id' $checked />".
							$gliderCatList[$fl_tmp_id]."</label><BR />\n";			
					}
				  ?>				    </td>
                      <td valign="top">
					  	  <div class="infoHeader"><? echo _GLIDER_CERT ?> </div>				 
				  <input name="FILTER_glider_cert" id="FILTER_glider_cert" type="hidden" value="0" />
                      <?			
					foreach ( $CONF_glider_certification_categories as $gl_id=>$gl_type) {
						$checked='';
						if ($gl_id & $FILTER_glider_cert) $checked="checked='checked'";
						echo "<label><input type='checkbox' name='xFILTER_glider_cert[]' value='$gl_id' $checked />".
							$CONF_glider_certification_categories[$gl_id]."</label><BR />\n";			
					}
				  ?>					  </td>
                      <td valign="top">
  					   <input name="FILTER_class" id="FILTER_class" type="hidden" value="0" />
						<?			
						foreach ( $CONF['gliderClasses'] as $gCat1 =>$catClasses ) {
							echo '<div class="infoHeader">'._Category.'<BR>[ '.$gliderCatList[$gCat1].' ]</div>';
							
							echo "<label><input onchange='changeClass(\"$gCat1\")' type='radio' name='xFILTER_class_$gCat1' value='0' checked='checked' />".
									_ALL."</label><BR />\n";		
									
							foreach ( $catClasses['classes'] as $gClassID =>$gClassName ) {
								$checked='';
								if ($gClassID == $FILTER_class) $checked="checked='checked'";
								echo "<label><input onchange='changeClass(\"$gCat1\")' type='radio' name='xFILTER_class_$gCat1' value='$gClassID' $checked />".
									$gClassName."</label><BR />\n";			
							}		
						}
					  ?>					
				  
					  </td>
                    </tr>
                  </table></td>
                </tr>

            </table></td>
          </tr>
      </table></td>
    </tr>
	 <tr>
	   <td colspan="2" valign="top" class="infoHeader"><?=_OTHER_FILTERS?></td>
    </tr>
	 <tr>
      <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td class="main_text"><div align="right"><? echo _Sex ?> </div></td>
          <td class="main_text"><select name="FILTER_sex">
              <option value=""></option>
              <option value="1" <? if ($FILTER_sex=="1") echo "selected" ?>>
              <?=_Male?>
              </option>
              <option value="2" <? if ($FILTER_sex=="2") echo "selected" ?>>
              <?=_Female?>
              </option>
            </select>          </td>
          <td class="main_text"><div align="right"><? echo _LINEAR_DISTANCE_SHOULD_BE ?> </div></td>
          <td class="main_text"><select name="FILTER_linear_distance_op">
              <option value="&gt;=" <? if ($FILTER_linear_distance_op==">=") echo "selected" ?>>&gt;=</option>
              <option value="&lt;=" <? if ($FILTER_linear_distance_op=="<=") echo "selected" ?>>&lt;=</option>
            </select>
              <input name="FILTER_linear_distance_select" type="text" size="5" value="<? echo $FILTER_linear_distance_select ?>" />
            Km</td>
        </tr>
        <tr>
          <td class="main_text"><div align="right"><? echo _OLC_SCORE_TYPE ?> </div></td>
          <td class="main_text"><select name="FILTER_olc_type">
              <option value="0"></option>
              <option value="1"   <? if ($FILTER_olc_type=="1") echo "selected" ?>>
              <?=_FREE_FLIGHT?>
              </option>
              <option value="2" <? if ($FILTER_olc_type=="2") echo "selected" ?>>
              <?=_FREE_TRIANGLE?>
              </option>
              <option value="4"  <? if ($FILTER_olc_type=="4") echo "selected" ?>>
              <?=_FAI_TRIANGLE?>
              </option>
            </select>          </td>
          <td class="main_text"><div align="right"><? echo _OLC_DISTANCE_SHOULD_BE ?> </div></td>
          <td class="main_text"><select name="FILTER_olc_distance_op">
              <option value="&gt;=" <? if ($FILTER_olc_distance_op==">=") echo "selected" ?>>&gt;=</option>
              <option value="&lt;=" <? if ($FILTER_olc_distance_op=="<=") echo "selected" ?>>&lt;=</option>
            </select>
              <input name="FILTER_olc_distance_select" type="text" size="5" value="<? echo $FILTER_olc_distance_select ?>" />
            Km</td>
        </tr>
        <tr>
          <td class="main_text"><div align="right"><? echo _DURATION_SHOULD_BE ?> </div></td>
          <td class="main_text"><input type="hidden" name="FILTER_duration_select" id="FILTER_duration_select"  value="0" />
              <select name="FILTER_duration_op" id="FILTER_duration_op">
                <option value="&gt;=" <? if ($FILTER_duration_op==">=") echo "selected" ?>>&gt;=</option>
                <option value="&lt;=" <? if ($FILTER_duration_op=="<=") echo "selected" ?>>&lt;=</option>
              </select>
              <input name="text2" type="text" id="xFILTER_duration_hours_select" value="<? echo floor($FILTER_duration_select/60) ?>" size="2"/>
              <? echo _HOURS ?> :
            <input name="text2" type="text" id="xFILTER_duration_minutes_select" value="<? echo ($FILTER_duration_select%60) ?>" size="2" />
              <? echo _MINUTES ?></td>
          <td class="main_text"><div align="right"><? echo _OLC_SCORE_SHOULD_BE ?> </div></td>
          <td class="main_text"><select name="FILTER_olc_score_op">
              <option value="&gt;=" <? if ($FILTER_olc_score_op==">=") echo "selected" ?>>&gt;=</option>
              <option value="&lt;=" <? if ($FILTER_olc_score_op=="<=") echo "selected" ?>>&lt;=</option>
            </select>
              <input name="FILTER_olc_score_select" type="text" size="5" value="<? echo $FILTER_olc_score_select ?>" /></td>
        </tr>


      </table></td>
    </tr>
	
    <tr>
      <?
		$dlgfiltersCount=count($dlgfilters);
		foreach ($dlgfilters as $filterkey=>$dlgfilter) {
			$html[$i%2].=$dlgfilters[$filterkey]->filter_html();
			$i++;
		}
	?>
      <td width='50%' valign="top"><table >
          <?=$html[0] ?>
      </table></td>
      <td width='50%' valign="top"><table >
          <?=$html[1] ?>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
          <input type="submit" name="SubmitButton" id="SubmitButton" value="<? echo _ACTIVATE_CHANGE_FILTER ?>" />
        &nbsp;
        <input type="hidden" name="clearFilter" id="clearFilter" value="0" />
        <input type="hidden" name="setFilter" id="setFilter" value="1" />
        <input type="submit" name="clearFilterButton" id="clearFilterButton" value="<? echo _DEACTIVATE_FILTER ?>" onclick="document.formFilter.clearFilter.value=1" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<?
	closeMain();
?>