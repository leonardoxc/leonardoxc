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

$pilotsList=array();
$pilotsID=array();

list($takeoffs,$takeoffsID)=getTakeoffList();
list($countriesCodes,$countriesNames)=getCountriesList();

$filterUrl="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/".$CONF_mainfile."?name=".$module_name."&op=filter&fl_url=1";
$redirectUrl="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/".$CONF_mainfile."?name=".$module_name."&op=list_flights&sortOrder=DATE&year=0&month=0&pilotID=0";

if ($_REQUEST["FILTER_dateType"] || $_GET['fl_url']==1) { // form submitted

	// copy form variables to session
	foreach ($_REQUEST as $key => $value ) {
		if (substr($key,0,7)=="FILTER_") {
			$_SESSION[$key]=$value;
			if ($value) $filterUrl.="&$key=".urlencode($value);
			$$key=$value;
		}
	}
	
	$filter_clause="";
	if ($_REQUEST['clearFilter']==1) {
		$_SESSION["filter_clause"]=$filter_clause;
	} else {
	
		if ($FILTER_dateType=="YEAR") {
			$filter_clause.=" AND DATE_FORMAT(DATE,'%Y') $FILTER_YEAR_select_op $FILTER_YEAR_select ";
		} else 	if ($FILTER_dateType=="MONTH_YEAR") {
			$filter_clause.=" AND ( DATE_FORMAT(DATE,'%Y%m') $FILTER_MONTH_YEAR_select_op $FILTER_MONTH_YEAR_select_YEAR$FILTER_MONTH_YEAR_select_MONTH ) ";
		} else if ($FILTER_dateType=="DATE_RANGE"){ // RANGE
			$from=substr($FILTER_from_day_text,6,4).substr($FILTER_from_day_text,3,2).substr($FILTER_from_day_text,0,2);
			$to=substr($FILTER_to_day_text,6,4).substr($FILTER_to_day_text,3,2).substr($FILTER_to_day_text,0,2);
			$filter_clause.=" AND ( DATE_FORMAT(DATE,'%Y%m%d') >=  $from AND DATE_FORMAT(DATE,'%Y%m%d') <= $to ) ";
		}
		
		$count=0;
		for ($i=1;$i<=3;$i++) {
			$varname="FILTER_pilot".$i."_select";
			$op_varname="FILTER_pilot".$i."_select_op";
			if ( $$varname ) {
				if ($count==0) { // open ( 
					$filter_clause.=" AND ( ";
					$first_op=$$op_varname;
				} else {
					$filter_clause.=($first_op=="=")?" OR ":" AND ";
				}
				$this_op=$first_op;
				$filter_clause.=" ( userID ".$this_op." ".($$varname)." ) ";
				$count++;
			}
		}
		if ($count) $filter_clause.=" ) ";
	
		$count=0;
		for ($i=1;$i<=3;$i++) {
			$varname="FILTER_takeoff".$i."_select";
			$op_varname="FILTER_takeoff".$i."_select_op";
			if ( $$varname>0 ) {
				if ($count==0) { // open ( 
					$filter_clause.=" AND ( ";
					$first_op=$$op_varname;
				} else {
					$filter_clause.=($first_op=="=")?" OR ":" AND ";
				}
				$this_op=$first_op;
				$filter_clause.=" ( takeoffID  ".$this_op." '".($$varname)."' ) ";
				$count++;
			}
		}
		if ($count) $filter_clause.=" ) ";
	
		$count=0;
		for ($i=1;$i<=3;$i++) {
			$varname="FILTER_country".$i."_select";
			$op_varname="FILTER_country".$i."_select_op";
			if ( $$varname!='' ) {
				if ($count==0) { // open ( 
					$filter_clause.=" AND ( ";
					$first_op=$$op_varname;
				} else {
					$filter_clause.=($first_op=="=")?" OR ":" AND ";
				}
				$this_op=$first_op;
				$filter_clause.=" ( countryCode  ".$this_op." '".($$varname)."' ) ";
				$count++;
			}
		}
		if ($count) $filter_clause.=" ) ";
	

		if ($FILTER_linear_distance_select)
			$filter_clause.=" AND LINEAR_DISTANCE ".$FILTER_linear_distance_op." ".($FILTER_linear_distance_select*1000)." ";

		if ($FILTER_olc_distance_select)
			$filter_clause.=" AND FLIGHT_KM ".$FILTER_olc_distance_op." ".($FILTER_olc_distance_select*1000)." ";

		if ($FILTER_olc_score_select)
			$filter_clause.=" AND FLIGHT_POINTS ".$FILTER_olc_score_op." ".$FILTER_olc_score_select." ";

		if ($FILTER_duration_hours_select || $FILTER_duration_minutes_select ) {
			$dur=$FILTER_duration_hours_select*60*60 + $FILTER_duration_minutes_select*60;
			$filter_clause.=" AND DURATION ".$FILTER_duration_op." ".$dur." ";
		}

		$_SESSION["filter_clause"]=$filter_clause;
		// echo "#".$filter_clause."#<br>";
	}
	
} else { // form not submitted
	// copy session variables (if any) to local variables
		
}

 
// open_inner_table(_FILTER_PAGE_TITLE,760); echo "<tr><td>";

?>

<script language='javascript' src='<? echo $moduleRelPath ?>/autocomplete.js'></script>

<form name="formFilter" method="post" action="">
  <div class='tableHeader shadowBox' width=650>
   <div class='titleDiv'>Site Guide</div>
  </div>

  <table class="listTable shadowBox" style="width:650px" width="650"  border="0" align="center" cellpadding="5" cellspacing="1">
    <tr bgcolor="#CCD0E3"> 
      <td width="273" valign="top">
          <p align="left"><strong>Search Options</strong><br />
            <select name="FILTER_takeoff1_select" size="10" id="FILTER_takeoff1_select"  style="display:none">
                         
            <? 
					for($k=0;$k<count($takeoffs);$k++) {
 					    $sel=($takeoffsID[$k]==$FILTER_takeoff1_select)?"selected":"";
						echo "<option value='".$takeoffsID[$k]."' $sel>".$takeoffs[$k]."</option>\n";
					}
				?>
            </select>
        </p>
        </td>
      <td width="10">&nbsp;</td>
      <td>
	    <p><strong>Below is the list of selected sites.</strong></p>      </td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0E6"><p align="left">Search site by name<br />
  (give at least 2 letters) <br />
  <input type="text" name="input1" value="" onKeyUp="autoComplete(this,'FILTER_takeoff1_select','text',false)" />
      </p>
        <p align="left"><strong>or </strong></p>
        <p align="left">Select the sites of a specific country</p>
        <p align="left">
          <select name="country_select" id="select" onChange="selectCountry()">
            <option></option>
            <? 
					for($k=0;$k<count($countriesCodes);$k++) {
 					    $sel=($countriesCodes[$k]==$FILTER_country1_select)?"selected":"";
						echo "<option value='".$countriesCodes[$k]."' $sel>".$countriesNames[$k]." (".$countriesCodes[$k].")</option>\n";
					}
				?>
          </select>
        </p></td>
      <td>&nbsp;</td>
      <td bgcolor="#DDE3E8"><p>Click &quot;See the selected sites&quot; to open
          these sites in Google Earth </p>
        <p>
          <input type="button" name="right" value="Clear this list" onClick="removeAllOptions(document.forms[0]['copy2']);">
        </p>
        <p>
          <select name="copy2" size="10" multiple="multiple">
          </select>
        </p>
        <p>
          <input type="button" name="SubmitButton" id="SubmitButton3" value="See the selected sites"
		  onClick="seeSites('<? echo "$moduleRelPath/";?>');">
        </p></td>
    </tr>
  </table>

</form>
<? 
 // close_inner_table();  

?>
