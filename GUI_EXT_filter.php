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
// $Id: GUI_EXT_filter.php,v 1.2 2010/03/14 20:56:10 manolis Exp $                                                                 
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
	
	require_once dirname(__FILE__).'/CL_filter.php';
	
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";

	$moduleRelPath=moduleRelPath() ;
 
 

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


	setVarFromRequest("fltr",0);
	$filter=new LeonardoFilter();
	$filter->parseFilterString($fltr);
	// echo "<PRE>";	print_r($filter->filterArray);	echo "</PRE>";	
	$_SESSION['filter_clause']=$filter->makeClause();
	
// echo "<pre>".print_r($filter->filterArray)."</pre>";


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
 
 
if (! $_SESSION["fltr"]) {
	echo "<span class='note' style='margin-top:0;'>"._THE_FILTER_IS_INACTIVE."</span>";
	exit;
}	

?>

<table class=main_text width="750"  border="0" align="center" cellpadding="3" cellspacing="3">
  <tr>
    <td colspan="2" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="60%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td  width="40%" class="main_text"><div align="right"><? echo _SELECT_DATE ?></div></td>
                <td><?	if ($FILTER_dateType=="ALL"  ) {  
				echo _ALL2;
			} else  if ($FILTER_dateType=="YEAR") {  
		  		echo _WITH_YEAR ." <span class='filterValuesText'> $FILTER_YEAR_select_op  $FILTER_YEAR_select</span>";
			} else  if ($FILTER_dateType=="MONTH_YEAR") { 
				echo _WITH_YEAR ." <span class='filterValuesText'> $FILTER_MONTH_YEAR_select_op ".$monthList[$FILTER_MONTH_YEAR_select_MONTH].
						" $FILTER_MONTH_YEAR_select_YEAR</span>";
			} else  if ($FILTER_dateType=="DATE_RANGE") {  			
				 echo _From ." <span class='filterValuesText'>$FILTER_from_day_text</span> "._TO." <span class='filterValuesText'>$FILTER_to_day_text</span>";

		} ?>
                </td>
              </tr>
              <tr>
                <td class="main_text"><div align="right"><? echo _PilotBirthdate ?></div></td>
                <td><? if ($FILTER_PilotBirthdate_text) echo  "<span class='filterValuesText'>$FILTER_PilotBirthdate_op $FILTER_PilotBirthdate_text</span>"; ?>
                </td>
              </tr>
              <tr>
                <td class="main_text"><div align="right"><? echo _Sex ?></div></td>
                <td ><? if ($FILTER_sex=="1") echo "<span class='filterValuesText'>"._Male."</span>";
						  else if ($FILTER_sex=="2") echo "<span class='filterValuesText'>"._Female."</span>";
						  else echo "-";
						?>
                </td>
              </tr>
              <tr>
                <td class="main_text"><div align="right"><? echo _LINEAR_DISTANCE_SHOULD_BE ?> </div></td>
                <td ><? if ($FILTER_linear_distance_select) echo  "<span class='filterValuesText'>$FILTER_linear_distance_op $FILTER_linear_distance_select Km</span>"; ?>
                </td>
              </tr>
              <tr>
                <td class="main_text"><div align="right"><? echo _OLC_SCORE_TYPE ?> </div></td>
                <td><? if ($FILTER_olc_type==0) {
					echo "-";
					} else {
						echo "<span class='filterValuesText'>";				
						if ($FILTER_olc_type=="1") echo _FREE_FLIGHT;
						else if ($FILTER_olc_type=="2") echo _FREE_TRIANGLE;
						else if ($FILTER_olc_type=="4") echo _FAI_TRIANGLE;
						echo "</span>";
					}
				?>
                </td>
              </tr>
              <tr>
                <td class="main_text"><div align="right"><? echo _OLC_DISTANCE_SHOULD_BE ?> </div></td>
                <td><? if ($FILTER_olc_distance_select) echo  "<span class='filterValuesText'>$FILTER_olc_distance_op $FILTER_olc_distance_select Km</span>"; ?>
                </td>
              </tr>
              <tr>
                <td class="main_text"><div align="right"><? echo _DURATION_SHOULD_BE ?> </div></td>
                <td><? if ($FILTER_duration_select) echo  "<span class='filterValuesText'>$FILTER_duration_op ".
		   		sprintf("%2d:%02d",$FILTER_duration_select/60,$FILTER_duration_select%60)."</span>"; ?>
                </td>
              </tr>
              <tr>
                <td class="main_text"><div align="right"><? echo _OLC_SCORE_SHOULD_BE ?> </div></td>
                <td><? if ($FILTER_olc_score_select) echo  "<span class='filterValuesText'>$FILTER_olc_score_op $FILTER_olc_score_select</span>"; ?>
                </td>
              </tr>
              <tr>
                <td class="main_text"><div align="right"><? echo _Start_Type ?> </div></td>
                <td style='line-height:20px;'><?			
					foreach (  $CONF['startTypes'] as $fl_tmp_id=>$fl_tmp_value) {
						if ($fl_tmp_id & $FILTER_start_type) echo "<span class='filterValuesText'>$fl_tmp_value</span>&nbsp;\n";
					}
				  ?>
                </td>
              </tr>
              <tr>
                <td class="main_text"><div align="right"><? echo _GLIDER_TYPE ?> </div></td>
                <td style='line-height:20px;'><?			
					foreach (  $CONF_glider_types as $fl_tmp_id=>$fl_tmp_value) {						
						if ($fl_tmp_id & $FILTER_cat) echo "<span class='filterValuesText'>$fl_tmp_value</span>&nbsp;\n";		
					}
				  ?>
                </td>
              </tr>
              <tr>
                <td class="main_text"><div align="right"><? echo _GLIDER_CERT ?> </div></td>
                <td style='line-height:20px;'><?			
					foreach ( $CONF_glider_certification_categories as $gl_id=>$gl_type) {
						if ($gl_id & $FILTER_glider_cert) echo "<span class='filterValuesText'>$gl_type</span>&nbsp;\n";			
					}
				  ?>
                </td>
              </tr>
			<?  
			  		$dlgfiltersCount=count($dlgfilters);
		foreach ($dlgfilters as $filterkey=>$dlgfilter) {
			list($dlgkey,$html_res)=$dlgfilters[$filterkey]->filter_html_view_only();
			if ( in_array($dlgkey,array("country","nationality"))  ) {
				$html[1][]=$html_res;
			} else {
				$html[0].=$html_res;
			}	
			$i++;
		}
			?>
			  <tr>
			  <td colspan='2'>
				  <table width=100%>
				     <tr>
					  <td width=50% valign="top">
						<table width="100%">
							<?=$html[1][0];?>
						</table>
					  </td>
					  <td  valign="top">
						<table width="100%">
							<?=$html[1][1];?>
						</table>
					  </td>
					 </tr>
					</table>
				</td>	
			  </tr>
            </table></td>
          <td valign="top"><table width='100%' >
              <?
		
		echo $html[0];
	?>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body></html>