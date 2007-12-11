<?php
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

/**
 * Class to handle multi-select filter controls for GUI_filter and the related popup dialogs.
 * So the class has essentially two modes of operation, the filter- and the dialog-mode.
 * Martin Jursa, 18.05.2007
 */

class dialogfilter {

	var $datakey=''; # the data key identifying the kind of data to be handled
	var $data=array(); # an associative array with the current selection (filter-mode) or the data to select from (dialog-mode)
	var $numeric=true; # whether the underlying data type is numeric (only int supported)

	var $nacid=0; # the NAC ID; needed if $datakey==nacclub
	var $nacname='';

	var $dataelement=''; # name and id of the form element containing the list of the selected ids (usually something like FILTER_xyz)
	var $textelement=''; # name and id of the div containing the text-values of the selction

	var $datavalue='';  # value of $dataelement
	var $textvalue=''; # innerHTML of $textelement

	var $inclusive=true; # if false, the selected data will be excluded from the query, else included

	var $selecteddata_key='datastring'; # the GET variable name for the string of currently selected items
	var $selecteddatavalues=array(); # in dialog mode: the values of the currently selected items


	var $filter_initialised=false;
	var $dialog_initialised=false;

	var $dialog_width=480; # width of the dialog window

	var $errmsg=''; #

	var $msg_no_data_selected=_Filter_NoSelection;


	function dialogfilter($datakey='', $filtername='', $nacid=0) {
		$errmsg='';
		if (empty($datakey)) {
			$datakey=isset($_GET['datakey']) ? $_GET['datakey'] : '';
			if (!$datakey) {
				$errmsg='Datakey is missing.';
			}
		}
		if (!$errmsg && empty($filtername)) {
			$filtername=isset($_GET['filtername']) ? $_GET['filtername'] : '';
			if (!$filtername) {
				$errmsg='Filtername is missing.';
			}
		}
		if (!$errmsg) {
			switch ($datakey) {
				case 'pilot':
					$this->dialog_width=350;
					break;

				case 'country':
					$this->numeric=false;
					$this->dialog_width=340;
					break;
					
				case 'nationality':
					$this->numeric=false;
					$this->dialog_width=340;
					break;
					
				case 'takeoff':
					$this->dialog_width=430;
					break;

				case 'server':
					$this->dialog_width=430;
					break;
					
				case 'nacclub':
					$this->dialog_width=480;
					if (empty($nacid)) {
						$nacid=isset($_GET['NACid']) ? $_GET['NACid'] : 0;
						if (!$nacid) {
							$errmsg='NAC-ID is missing.';
						}
					}
					break;

				default:
					$errmsg='Invalid Filter Data-Key &quot;'.$datakey.'&quot; in '.__CLASS__.'.';
					break;
			}
		}
		if (!$errmsg) {
			if (substr($filtername, -4, 4)=='excl') $this->inclusive=false;
			$this->datakey=$datakey;
			$this->dataelement=$filtername;
			$this->textelement=$filtername.'_selected';
			$this->nacid=$nacid;
			if ($nacid) {
				global $CONF_NAC_list;
				$this->nacname=!empty($CONF_NAC_list[$nacid]['name']) ? $CONF_NAC_list[$nacid]['name'] : 'NAC '.$nacid;
			}
		}else {
			$this->errmsg=$errmsg;
		}
	}

/**
 * Transforms a comma delimited string of key values into a comma-delimited string that may be used in an SQL IN-Clause
 *
 * @param string $datastring
 * @return string
 */
	function to_in_string($datastring) {
		$in_string='';
		if ($datastring) {
			$parts=explode(',', $datastring);
			$newparts=array();
			foreach ($parts as $part) {
				$newpart=trim($part);
				if ($this->numeric) {
					settype($newpart, 'int');
				}else {
					$newpart=mysql_escape_string(trim($newpart, "'"));
				}
				if ($newpart) {
					$newparts[]=$this->numeric ? $newpart : "'$newpart'";
				}
			}
			if (count($newparts)>1) sort($newparts);
			$in_string=implode(',', $newparts);
		}
		return $in_string;
	}

/**
 * Management of data queries
 *
 * @param string $in_string that's a string that can be used in an SQL IN-clause like  pkfield IN (1,2,3,4)
 */
	function query_data($in_string='') {
		$this->data=array();
		switch ($this->datakey) {
			case 'pilot':
				$this->data=$this->getPilotList($in_string);
				break;

			case 'country':
				$this->data=$this->getCountriesList($in_string);
				break;

			case 'nationality':
				$this->data=$this->getNationalitiesList($in_string);
				break;
				
			case 'takeoff':
				$this->data=$this->getTakeoffList($in_string);
				break;

			case 'server':
				$this->data=$this->getServerList($in_string);
				break;
				
			case 'nacclub':
				$this->data=$this->getClubs($in_string);
				break;
		}
	}

/**
 * Initialisation for filter-mode
 */
	function init_filter() {
		if (!$this->filter_initialised) {
			if (!$this->errmsg) {
				$val=isset($GLOBALS[$this->dataelement]) ? $GLOBALS[$this->dataelement] : '';
				if ($val) {
					$in_string=$this->to_in_string($val);
					$this->query_data($in_string);
				}
				if (count($this->data)>0) {
					$this->datavalue=implode(',', array_keys($this->data));
					$this->textvalue=implode('<br/>', $this->data);
				}else {
					$this->textvalue=$this->msg_no_data_selected;
				}
			}
			$this->filter_initialised=true;
		}
	}

/**
 * Returns the where clause for use in GUI_filter.php
 * Returns an empty string in case no criteria are defined
 *
 * @return string
 */
	function filter_clause() {
		$clause='';

		$this->init_filter();
		if (!$this->errmsg && $this->datavalue) {
			$in_string=$this->to_in_string($this->datavalue);
			
			// echo $this->datavalue."#".			$in_string;
			if ($in_string) {
				global $flightsTable;
				switch ($this->datakey) {
					case 'pilot':
						$clause='userID';
						break;

					case 'country':
						$clause='countryCode';
						break;

					case 'nationality':
						global $pilotsTable;
						$clause=$pilotsTable.'.countryCode';
						break;
						
					case 'takeoff':
						$clause='takeoffID';
						break;

					case 'server':
						$in_string=str_replace('-1','0',$in_string);
						$clause=$flightsTable.'.serverID';
						break;

					case 'nacclub':
						$clause=$flightsTable.'.NACclubID';
						break;

					default:
						$this->errmsg='Filter Data-Key '.$this->datakey.' not handled by '.__FUNCTION__.'.';
						break;
				}
				if (!$this->errmsg){
					$clause.=$this->inclusive ? ' IN ' : ' NOT IN ';
					$clause.='('.$in_string.')';
					if ($this->datakey=='nacclub') {
						$clause="($flightsTable.NACid=$this->nacid AND $clause)";
					}
				}
			}
		}
		return $clause;
	}

	function filter_html() {
		$this->init_filter();
		if ($this->errmsg) {
			$html='
    <tr>
      <td bgcolor="#FF9966"><div align="right"><span class="whiteLetter"><strong>'.$this->filter_title().'</span></div></td>
      <td>ERROR: '.$this->errmsg.'</td>
    </tr>
';
		}else {
			$html='
    <tr>
      <td bgcolor="#FF9966"><div align="right"><span class="whiteLetter"><strong>'.$this->filter_title().'</strong></span></div></td>
      <td>&nbsp;'.$this->filter_js_functions().'</td>
    </tr>
    <tr>
		<td style="vertical-align:top"><input type="hidden" name="'.$this->dataelement.'" id="'.$this->dataelement.'" value="'.$this->datavalue.'"><div style="text-align:right">'._Filter_CurrentlySelected.':</div></td>
		<td style="vertical-align:top">
			<table cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td style="vertical-align:top">
					<div style="width:200px;vertical-align:top" id="'.$this->textelement.'">'.$this->textvalue.'</div>
				</td>
				<td style="vertical-align:top"><input type="button" value="'._Filter_Button_Select.'" onclick="'.$this->filter_select_js().'"></td>
				<td style="vertical-align:top"><input type="button" value="'._Filter_Button_Delete.'" onclick="'.$this->filter_delete_js().'"></td>
			</tr>
			</table>
		</td>
    </tr>
';
		}
    	return $html;
	}

	function filter_delete_js() {
		$js="
		var el1=document.getElementById('$this->textelement');
		if (el1) {
			el1.innerHTML='$this->msg_no_data_selected';
		}
		var el2=document.getElementById('$this->dataelement');
		if (el2) {
			el2.value='';
		}";

		return $js;
	}

	function filter_select_js() {
		global $moduleRelPath;
		$baseurl=$moduleRelPath.'/GUI_EXT_filterdialog.php?datakey='.$this->datakey.'&filtername='.$this->dataelement;
		if ($this->datakey=='nacclub') {
			$baseurl.='&NACid='.$this->nacid;
		}
		$js="
		var el=document.getElementById('$this->dataelement');
		if (el) {
			var url='$baseurl&$this->selecteddata_key='+el.value;
			popupwindow(url, $this->dialog_width);
		}";
		return $js;
	}

	function filter_js_functions() {
		static $callcount=0;
		if ($callcount==0) {
			$callcount++;
			$js="
<script type=\"text/javascript\">
<!--
function popupwindow(url, winwidth){
	if (url){
		var newheight=screen.availHeight*0.9;
		var newwidth=winwidth;
		var newtop=screen.availHeight*0.1;
		var newleft=screen.availWidth-winwidth;
		var optionstring='height='+Math.round(newheight);
		optionstring+=',width='+Math.round(newwidth);
		optionstring+=',top='+Math.round(newtop);
		optionstring+=',left='+Math.round(newleft);
		optionstring+=',dependent=yes,resizable=yes,scrollbars=yes,status=yes ';
		window.open(url, '_blank', optionstring, false);
		//newwin.focus()
	}
}// -->

</script>
";
		}else {
			$js='';
		}
		return $js;
	}
/**
 * Returns a lang specific designation for the kind of data queried
 *
 * @return string
 */
	function items_title() {
		$items=constant('_Filter_Items_'.$this->datakey);
		if ($this->datakey=='nacclub') {
			$items=$this->nacname.'-'.$items;
		}
		return $items;
	}

/**
 * Label-Text for filter-display
 *
 * @return string
 */
	function filter_title() {
		$items=$this->items_title();
		
		if ($this->inclusive) {
			//eval('$title="'.str_replace('[items]',$items,_Filter_FilterTitleIncluding).'";');
			$title=str_replace('[items]',$items,_Filter_FilterTitleIncluding);
		}else {
			// eval('$title="'._Filter_FilterTitleExcluding.'";');
			$title=str_replace('[items]',$items,_Filter_FilterTitleExcluding);
		}
		return $title;
	}

/**
 * Initialisation for dialog-mode
 */
	function init_dialog() {
		if (!$this->dialog_initialised) {
			if (!$this->errmsg) {
				$selecteddatastring=isset($_GET[$this->selecteddata_key]) ? urldecode($_GET[$this->selecteddata_key]) : '';
				$parts=explode(',', $selecteddatastring);
				$newparts=array();
				foreach ($parts as $part) {
					$part=trim($part);
					if ($part) $newparts[]=$part;
				}
				$this->selecteddatavalues=$newparts;
				$this->query_data();
			}
			$this->dialog_initialised=true;
		}
	}

	function dialog_html() {
		$this->init_dialog();
		if ($this->errmsg) {
			$html='ERROR: '.$this->errmsg;
 		}else {
 			$options='<option value=""></option>
';
			foreach ($this->data as $key=>$value) {
				$selected=in_array($key, $this->selecteddatavalues) ? ' selected ' : '';
				$options.='<option value="'.$key.'" '.$selected.'>'.$value.'</option>
';
			}
 			$html='
<table border="0" align="center" cellpadding="2" class="shadowBox main_text" style="height:95%;width:90%">
<tr>
	<td width="85%" bgcolor="#CFE2CF">
	<div align="center" style="height:100%">
		<select name="dialogdata" id="dialogdata" size="2" style="height:85%" multiple>
'.$options.'
		</select>
		<br>
		<br>
		<b>'._Filter_DialogMultiSelectInfo.'</b>
		<br>
		<br>
		<input type="button" value="'._Filter_Button_Accept.'" onclick="setValToMaster()"/>
		<input type="button" value="'._Filter_Button_Cancel.'"  onclick="window.close();" />
	</div>
	</td>
</tr>
</table>
';
		}
    	return $html;
	}

	function dialog_title() {
		$items=$this->items_title();
		if ($this->inclusive) {
			// eval('$title="'._Filter_DialogTitleIncluding.'";');
			$title=str_replace('[items]',$items,_Filter_DialogTitleIncluding);	
		}else {
			// eval('$title="'._Filter_DialogTitleExcluding.'";');
			$title=str_replace('[items]',$items,_Filter_DialogTitleExcluding);	
		}
		return $title;
	}

	function dialog_js_functions() {
		$js="
<script type=\"text/javascript\">
<!--
function setValToMaster(){
	if (!window.opener) {
		alert('No parent page.');
	}else {
		var el=document.getElementById('dialogdata');
		if (el) {
			var masterDoc=window.opener.document;
			var dataEl=masterDoc.getElementById('$this->dataelement');
			var textEl=masterDoc.getElementById('$this->textelement');
			if (!dataEl) {
				alert('Error: Cannot find target Element.');
			}else {
				var selData='';
				var selText='';
				for (var i=0; i<el.options.length; i++) {
					if (el.options[i].selected) {
						selData+=el.options[i].value+',';
						selText+=el.options[i].text+'<br/>';
					}
				}
				if (selData.length==0) {
					dataEl.value='';
					textEl.innerHTML='$this->msg_no_data_selected';
				}else {
					dataEl.value=selData;
					textEl.innerHTML=selText;
				}
				window.close();
			}
		}
	}
}// -->
</script>
";
		return $js;
	}


	function getPilotList($in_string='') {
		global $db;
		global $flightsTable, $pilotsTable;
		global $prefix, $PREFS;

		if ($PREFS->nameOrder==1) {
			#$nOrder='FirstName,LastName';
			$nameSql="IF(FirstName='' AND LastName='', username, IF(FirstName='', LastName, CONCAT(FirstName, ' ', LastName)))";
		}else {
			#$nOrder='LastName,FirstName';
			$nameSql="IF(LastName='' AND FirstName='', username, IF(LastName='', FirstName, CONCAT(LastName, ' ', FirstName)))";
		}

	  	$sql="SELECT DISTINCT userID, $nameSql AS Name
FROM
	{$prefix}_users u
		INNER JOIN $flightsTable f ON f.userID=u.user_id
		INNER JOIN $pilotsTable p ON p.pilotID=u.user_id
WHERE userID>0";
		if ($in_string) {
			$sql.=" AND userID IN ($in_string)";
		}
		$sql.=" GROUP BY userID, $nameSql
ORDER BY $nameSql";

		$pnames=array();

		$res=$db->sql_query($sql);
	    if($res){
			while (false!==$row=$db->sql_fetchrow($res)) {
				$pnames[$row['userID']]=$row['Name'];
			}
	    }
		return $pnames;
	}

/* Verion using getPilotRealName
	Performance very bad in case of english, but good in case of currentlang==german (??!!)
	function getPilotList($in_string='') {
		global $db;
		global $flightsTable;
		global $prefix;

	  	$sql="SELECT DISTINCT userID
FROM
	{$prefix}_users u
		INNER JOIN $flightsTable f ON f.userID=u.user_id
WHERE userID>0";
		if ($in_string) {
			$sql.=" AND userID IN ($in_string)";
		}

		$pnames=array();

		$res=$db->sql_query($sql);
	    if($res){
			while (false!==$row=$db->sql_fetchrow($res)) {
				$name=getPilotRealName($row['userID']);
				$pnames[$row['userID']]=$name;
			}
	    }
		if (!empty($pnames)) {
			asort($pnames);
		}
		return $pnames;
	}
*/
	function getCountriesList($in_string='') {
		global $db;
		global $flightsTable, $waypointsTable, $countries;

		$countriesList=array();

		$where_clause='';
		if ($in_string!='') $where_clause.=' AND countryCode IN ('.$in_string.')';

	  	$sql="SELECT DISTINCT countryCode
FROM
	$flightsTable f
		INNER JOIN $waypointsTable w ON f.takeoffID=w.ID
WHERE
	f.userID<>0 $where_clause
";

	  	$res= $db->sql_query($sql);
	    if($res){
			while (false!==$row=$db->sql_fetchrow($res)) {
				$cCode=$row['countryCode'];
				$countriesList[$cCode]=$countries[$cCode];
			}
	    }
		if (!empty($countriesList) ){
			asort($countriesList);
		}

		return $countriesList;
	}

	function getNationalitiesList($in_string='') {
		global $db;
		global $pilotsTable,  $countries;

		$countriesList=array();

		$where_clause='';
		if ($in_string!='') $where_clause.=' AND countryCode IN ('.$in_string.')';

	  	$sql="SELECT DISTINCT countryCode FROM 	$pilotsTable  WHERE countryCode<>'' $where_clause ";

	  	$res= $db->sql_query($sql);
	    if($res){
			while (false!==$row=$db->sql_fetchrow($res)) {
				$cCode=strtoupper($row['countryCode']);
				if ($cCode)
					$countriesList[$cCode]=$countries[$cCode];
			}
	    }
		if (!empty($countriesList) ){
			asort($countriesList);
		}

		return $countriesList;
	}
	
	function getServerList($in_string='') {
		global $CONF;
		// echo "$in_string";
		if ($in_string) {
			$parts=split(',',$in_string);
			// print_r($parts);
			foreach ($CONF['servers']['list'] as $serverID=>$serverName) {
				if ($serverID==0) $serverID=-1;
				if ( in_array($serverID,$parts)  ) {
					$servers[$serverID]=$serverName;
				}
			}
			return $servers;
		} else {
			foreach ($CONF['servers']['list'] as $serverID=>$serverName) {
					if ($serverID==0) $serverID=-1;
					$servers[$serverID]=$serverName;
			}
			return $servers;
		}

	}
	
	function getTakeoffList($in_string='') {
		global $db;
		global $flightsTable;

		$takeoffs=array();

		$sql="SELECT DISTINCT takeoffID FROM $flightsTable WHERE takeoffID<>0";

		if ($in_string) {
			$sql.=' AND takeoffID IN ('.$in_string.')';
		}
		$res= $db->sql_query($sql);
	    if($res){
			while (false!==$row=$db->sql_fetchrow($res)) {
		 		 $takeoffs[$row['takeoffID']]=getWaypointName($row['takeoffID'], -1, 1);
			}
			if (!empty($takeoffs)) {
				asort($takeoffs);
			}
	    }
		return $takeoffs;

	}


	function getClubs($in_string='') {
		global $db, $flightsTable, $NACclubsTable;

		$NACclubList=array();

		$sql="SELECT DISTINCT clubID, CONCAT(clubName, ' (', clubID, ')') AS NACclubName
FROM
	$flightsTable f
		INNER JOIN $NACclubsTable c ON c.NAC_ID=f.NACid AND c.clubID=f.NACclubID
WHERE f.NACid=$this->nacid";
		if ($in_string) {
			$sql.=' AND clubID IN ('.$in_string.')';
		}
		$sql.=' ORDER BY clubName';
		$res=$db->sql_query($sql);
  		if($res){
			while (false!==$row=$db->sql_fetchrow($res)) {
				$NACclubList[$row['clubID']]=$row['NACclubName'];
			}
  		}
		return $NACclubList;
    }

/* for testing only:
	function getClubs($in_string='') {
		global $db, $NACclubsTable;

		$NACclubList=array();

		$sql="SELECT clubID, CONCAT(clubName, ' (', clubID, ')') AS clubName FROM $NACclubsTable WHERE NAC_ID=$this->nacid";
		if ($in_string) {
			$sql.=' AND clubID IN ('.$in_string.')';
		}
		$sql.=' ORDER BY clubName';
		$res=$db->sql_query($sql);
  		if($res){
			while (false!==$row=$db->sql_fetchrow($res)) {
				$NACclubList[$row['clubID']]=$row['clubName'];
			}
  		}
		return $NACclubList;
    }*/
}

?>