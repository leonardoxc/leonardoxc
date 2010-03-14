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
// $Id: GUI_EXT_flight_set_bounds.php,v 1.19 2010/03/14 20:56:10 manolis Exp $                                                                 
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

	$flightID=makeSane($_GET['flightID'],1);
	if ($flightID<=0) exit;
		
	$flight=new flight();
	$flight->getFlightFromDB($flightID);

    if ( ! $flight->belongsToUser($userID) && !L_auth::isModerator($userID) ) {
		echo "go away";
		return;
    }

	if ( $_POST['setTimes']==1 ) { // set new bounds !!!
	
		$startTime=makeSane($_REQUEST['timeTextSecs1'],1); // in secs
		$endTime=makeSane($_REQUEST['timeTextSecs2'],1); 

		$flight->forceBounds=1; // must be in these time bounds
		$flight->START_TIME=$startTime;
		$flight->END_TIME=$endTime;
		
		$waypointsWebPath=moduleRelPath(0)."/".$waypointsRelPath;		

		$flight->getFlightFromIGC( $flight->getIGCFilename(), 0 );

		$flight->deleteSecondaryFiles();

		$flight->updateTakeoffLanding();		
		$flight->getMapFromServer();		
		$flight->updateCharts(1);		
		$flight->putFlightToDB(1); // 1== UPDATE
		
		$flight->computeScore();
		?>
		  <script language="javascript">
			  function refreshParent() {
				  topWinRef=top.location.href;
				  top.window.location.href=topWinRef;
			  }
		  </script>
		<?
		echo "<div align=center><BR><BR>The start/end time have been updated<BR><BR>";		
		echo "<a href='javascript:refreshParent();'>RETURN </a>"; 	
		echo "<br></div>";	
		return;
	}
		

  ?><head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?=$CONF_ENCODING?>">

<style type="text/css">
	 body, p, table,tr,td {font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;}
	 body {margin:0px; background-color:#E9E9E9}
	.box {
		 background-color:#F4F0D5;
		 border:1px solid #555555;
		padding:3px; 
		margin-bottom:5px;
	}
	.boxTop {margin:0; }
</style>
</head>
  <?


	
	$flight->updateCharts(1,1); // force update, raw charts

	if ($flight->is3D() &&  is_file($flight->getChartfilename("alt",$PREFS->metricSystem,1))) 
		$chart1= $flight->getChartRelPath("alt",$PREFS->metricSystem,1);
	if ( is_file($flight->getChartfilename("takeoff_distance",$PREFS->metricSystem,1)) )
		$chart2=$flight->getChartRelPath("takeoff_distance",$PREFS->metricSystem,1);
	
	if ( is_file($flight->getChartfilename("speed",$PREFS->metricSystem,1)) )
		$chart3=$flight->getChartRelPath("speed",$PREFS->metricSystem,1);
	
	if ($flight->is3D() &&  is_file($flight->getChartfilename("vario",$PREFS->metricSystem))) 
		$chart4=$flight->getChartRelPath("vario",$PREFS->metricSystem,1);
	
	if ($chart1) { // thereis altitude -> select alt, vario, and check for speed graph if present
		$img1=$chart1; // alt
		$title1="Height";
		$img2=$chart4; // vario
		$title2="Vario";
		if ($chart3)  {
			$img3=$chart3; // speed
			$title3="Speed";
		} else {
			$img3=$chart2; // takeoff distance
			$title3="Takeoff Distance";
		}
	} else { // no alt , no vario !!
		// if speed is present
		if ($chart3) {
			 $img1=$chart3; // speed
			 $title1="Speed";
			 $img2=$chart2; // takeoff distance
			 $title2="Takeoff Distance";
		} else { // only takeoff distance present
				 $img1=$chart2; // takeoff distance
				 $title2="Takeoff Distance";
		}
	}

	$hlines=$flight->getRawHeader();
	foreach($hlines as $line) {
		if (strlen($line) == 0) continue;	  
		eval($line);
	}
	$START_TIME=$min_time;
	$END_TIME=$max_time;
	$DURATION=$END_TIME-$START_TIME;

?> 
<script language="javascript">
function MWJ_findObj( oName, oFrame, oDoc ) {
	if( !oDoc ) { if( oFrame ) { oDoc = oFrame.document; } else { oDoc = window.document; } }
	if( oDoc[oName] ) { return oDoc[oName]; } if( oDoc.all && oDoc.all[oName] ) { return oDoc.all[oName]; }
	if( oDoc.getElementById && oDoc.getElementById(oName) ) { return oDoc.getElementById(oName); }
	for( var x = 0; x < oDoc.forms.length; x++ ) { if( oDoc.forms[x][oName] ) { return oDoc.forms[x][oName]; } }
	for( var x = 0; x < oDoc.anchors.length; x++ ) { if( oDoc.anchors[x].name == oName ) { return oDoc.anchors[x]; } }
	for( var x = 0; document.layers && x < oDoc.layers.length; x++ ) {
		var theOb = MWJ_findObj( oName, null, oDoc.layers[x].document ); if( theOb ) { return theOb; } }
	if( !oFrame && window[oName] ) { return window[oName]; } if( oFrame && oFrame[oName] ) { return oFrame[oName]; }
	for( var x = 0; oFrame && oFrame.frames && x < oFrame.frames.length; x++ ) {
		var theOb = MWJ_findObj( oName, oFrame.frames[x], oFrame.frames[x].document ); if( theOb ) { return theOb; } }
	return null;
}

function fillInForm(name,area,countrycode){
	a=MWJ_findObj("wname");
	a.value=name;
	a=MWJ_findObj("intName");
	a.value=name;
	a=MWJ_findObj("wlocation");
	a.value=area;
	a=MWJ_findObj("intLocation");
	a.value=area;
	a=MWJ_findObj("countryCode");
	a.value=countrycode;
}
 
</script>
      
<form name="form1" method="post"  >
        <table width="720" border="0" align="center" cellpadding="0"  cellspacing="1" class="shadowBox main_text">
          <tr>
            <td  width=600 bgcolor="#E3E7F2">
			 <div style="position: relative; width: 600px; height:120px;"> 
              <div style="position: absolute; top: 14px; left: 40px; z-index: 100; height:89px;  width:2px; background-color:#00FF00;" 
              id="timeLine1"></div>
			  
			  <div style="position: absolute; top: 14px; left: 579px; z-index: 100; height:89px; width:2px; background-color:#FF0000;" 
              id="timeLine2"></div>

			  <div style="position: absolute; top: 98px; left: 42px; z-index: 50; height:5px; font-size:4px; line-height:5px; width:539px; background-color:#0000ff; border:0; padding:0;" 
              id="timeBar" ></div>
			  
			  <div style="position: absolute; float:right; right:20px; top: 1px; z-index: 50; padding-right:4px; text-align:right;
						 height:12px; width:130px; border:0px solid #777777; background-color:#F2F599;" 
              id="timeBar"><?=$title1?></div>

              <img style="position: absolute; top: 0px; left:0px; z-index: 0; cursor: crosshair;" 
              id="imggraphs" src="<?=$img1?>" onclick="SetTimer(event)" alt="graphs" 
              title="Click to set Time" border="0" 
              height="120" width="600"> </div> 
			
			</td>
            <td  rowspan="3" valign="top"><div class="box boxTop"><img src="img/icon_help.png" width="16" height="16" align="absmiddle" /> You can set the start and end time of the flight by moving the green line for the start and the red for the end. </div>
              <p>&nbsp;              </p>
              <p>
              <div align="right">
                  <input name="timeSel" type="radio" value="1" checked="checked" />
                  Start Time
                  <input name="timeText1" type="text" id="timeText1" size="5" maxlength="5" onchange="setValue(this,'timeTextSecs1')" />
              </div>
             	<div align="right">
             	  <input name="timeSel" type="radio" value="2" />
             	  End Time
                  <input name="timeText2" type="text" id="timeText2" size="5" maxlength="5" onchange="setValue(this,'timeTextSecs2')" />
              </div>
               
</p>
              <input type="hidden" name="timeTextSecs1" id="timeTextSecs1" />
              <input type="hidden" name="timeTextSecs2" id="timeTextSecs2"/>
			  
              <p>
                <input type="submit" name="Submit" value="Update times" />
                <input type="hidden" name="setTimes" value="1" />
              </p></td>
          </tr>
          <tr>
            <td bgcolor="#E3E7F2">
			 <div style="position: relative; width: 600px; height:120px;"> 
			  <div style="position: absolute; float:right; right:20px; top: 1px; z-index: 50; padding-right:4px; text-align:right;
						 height:12px; width:130px; border:0px solid #777777; background-color:#F2F599;"  id="timeBar"><?=$title2?>
			  </div>
			<img src="<?=$img2?>" alt="graphs" border="0" height="120" width="600">
			</div></td>
          </tr>
          <tr>
            <td bgcolor="#E3E7F2"> <div style="position: relative; width: 600px; height:120px;"> 
			  <div style="position: absolute; float:right; right:20px; top: 1px; z-index: 50; padding-right:4px; text-align:right;
						 height:12px; width:130px; border:0px solid #777777; background-color:#F2F599;"  id="timeBar"><?=$title3?>
			  </div><img src="<?=$img3?>" alt="graphs" border="0" height="120" width="600">
			</div></td>
          </tr>
        </table>


      </form>    
	  
<script language="javascript">

	var ImgW = 600;
	var StartTime = <?=$START_TIME?> ;
	var EndTime = <?=$DURATION?> ;
	
	var timeLine=new Array();
	timeLine[1] = document.getElementById("timeLine1").style;
	timeLine[2] = document.getElementById("timeLine2").style;
	var timeBar=document.getElementById("timeBar").style;
	var timeBarObj=document.getElementById("timeBar");
	
	var marginLeft=40;
	var marginRight=19;

	function getCurrentTime(ct) {
	   ct=ct/60;
	   h=Math.floor(ct/60);
  	   if (h<10) h="0"+h;
	   m=Math.floor(ct % 60);
	   if (m<10) m="0"+m;
	   return h+":"+m;
	}
	
	function MWJ_changeSize( oName, oWidth, oHeight, oFrame ) {
		var theDiv = MWJ_findObj( oName, oFrame ); if( !theDiv ) { return; }
		if( theDiv.style ) { theDiv = theDiv.style; }
		 var oPix = document.childNodes ? 'px' : 0;		
		 if( theDiv.resizeTo ) { theDiv.resizeTo( oWidth, oHeight ); }
		theDiv.width = oWidth + oPix; theDiv.pixelWidth = oWidth;
		theDiv.height = oHeight + oPix; theDiv.pixelHeight = oHeight;
	}

  function DisplayCrosshair(i){ // i=1 for the start , 2 end 	 
	   var Temp = Math.floor( (ImgW-marginLeft-marginRight) * CurrTime[i] / EndTime)
	   timeLine[i].left = marginLeft + Temp  + "px";
	   
	   if (i==1) { 
		   	timeBar.left=marginLeft + Temp  + "px"; //timeLine[i].left;
			var newWidth=( Math.floor( (ImgW-marginLeft-marginRight) * CurrTime[2] / EndTime) - Temp  )  ;
			timeBar.width=newWidth+"px";
			//MWJ_changeSize("timeBar",newWidth,5);
	   } else {
			newWidth=( Temp - Math.floor( (ImgW-marginLeft-marginRight) * CurrTime[1] / EndTime)  )  ;
			timeBar.width=newWidth+"px";
			// MWJ_changeSize("timeBar",newWidth,5);	   
	   }

	   timeText=document.getElementById("timeText"+i);
	   timeText.value=getCurrentTime(StartTime + CurrTime[i]);

	   timeTextSecs=document.getElementById("timeTextSecs"+i);
	   timeTextSecs.value=Math.floor(StartTime + CurrTime[i]);
 }

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	for(var ii = 0; ii < radioLength; ii++) {
		if(radioObj[ii].checked) {
			return radioObj[ii].value;
		}
	}
	return "";
}

function setValue(obj,target)
{		
//	var n = obj.selectedIndex;    // Which menu item is selected
	var val = obj.value;        // Return string value of menu item

	t=MWJ_findObj(target);
	t.value=val;	
}


function SetTimer(evt) {
   i=getCheckedValue(document.forms[0].timeSel);
   if (typeof evt == "object") {
		if (evt.layerX > -1) {
		 CurrTime[i] = (evt.layerX -marginLeft) * EndTime / (ImgW-marginLeft-marginRight)
		} else if (evt.offsetX) {
		 CurrTime[i] = (evt.offsetX-marginLeft) * EndTime / (ImgW-marginLeft-marginRight)
		}
   }
   
	if (i==1) {
		if ( CurrTime[1] <0 )  { CurrTime[1] =0; }
		if ( CurrTime[1] >= CurrTime[2]-4 )  { CurrTime[1] =CurrTime[2]-5; }
	} else {
		if ( CurrTime[2] >EndTime )  { CurrTime[2] = EndTime; }
		if ( CurrTime[2] <= CurrTime[1]+4 )  { CurrTime[2] = CurrTime[1]+5; }
	}
    DisplayCrosshair(i);
  
  }

  var CurrTime=new Array();
  CurrTime[1] = 0;
  CurrTime[2] = EndTime;
  DisplayCrosshair(1);
  DisplayCrosshair(2);
    
</script>