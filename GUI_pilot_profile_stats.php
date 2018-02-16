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
// $Id: GUI_pilot_profile_stats.php,v 1.12 2012/01/16 07:21:22 manolis Exp $                                                                 
//
//************************************************************************

	require_once dirname(__FILE__)."/lib/graph/jpgraph_gradient.php";
	require_once dirname(__FILE__)."/lib/graph/jpgraph_plotmark.inc" ;

	require_once dirname(__FILE__)."/lib/graph/jpgraph.php";
	require_once dirname(__FILE__)."/lib/graph/jpgraph_line.php";
	require_once dirname(__FILE__)."/lib/graph/jpgraph_bar.php";
	?>
	<style type="text/css">
	<!--
		.stat_totals {
			display:none;
		}
		.pilot_stats_div h1 , .pilot_stats_div h2 {
				border-bottom-width: 1px;
				border-bottom-style: solid;
				border-bottom-color: #006699;
				padding-top: 5px;
				padding-right: 5px;
				padding-bottom: 5px;
				padding-left: 5px;
				margin-bottom: 3px;
				font-weight: bold;
				font-family: Verdana,Arial,Helvetica,sans-serif;
				font-size: 16px;
				line-height: 110%;
				background-color:#FFF7DE;
				display:block;
		}
		.pilot_stats_div h2 {
			cursor:pointer;
			border:none;
			text-decoration:underline;
			font-size: 14px;
			background:none;
			line-height: 100%;
		}
	-->
	</style>
	<script language='javascript'>
		$(document).ready(
			function(){
				$(".stat_totals:first").show();
				$(".pilot_stats_div h2").click(function(){
						$(this).next().toggle();

					});

					   	   
		   }
		);
	
	</script>
	
	<?php  
		
	
		require_once dirname(__FILE__).'/SQL_list_flights.php';	
		$pilotIDview=$pilotID;
		$serverIDview=$serverID;
		
		require_once dirname(__FILE__)."/MENU_second_menu.php"; 
		
	?>
	
	
	<div class='pilot_stats_div'>
	<?php 
	// echo "#$serverIDview $pilotIDview,#";
	if (!isPrint()) {
		$realName=getPilotRealName($pilotIDview,$serverIDview);	
		$legend="<b>$realName</b> "._flights_stats;
		$legendRight="<a href='".
		  		getLeonardoLink(array('op'=>'list_flights','pilotID'=>$serverIDview.'_'.$pilotIDview,'year'=>'0','country'=>''))
		  		."'>"._PILOT_FLIGHTS."</a>";
		$legendRight.=" | <a href='".
		  		getLeonardoLink(array('op'=>'pilot_profile','pilotIDview'=>$serverIDview.'_'.$pilotIDview))	
				."'>"._Pilot_Profile."</a>";
		  
		openMain("<div style='width:60%;font-size:12px;clear:none;display:block;float:left'>$legend</div><div align='right' style='width:40%; text-align:right;clear:none;display:block;float:right' bgcolor='#eeeeee'>$legendRight</div>",0,'');
	}	
  
  	$where_clause=' '.$where_clause;

   
  
   $query = 'SELECT DISTINCT userID, max( LINEAR_DISTANCE ) AS bestDistance,
			min(DATE) as firstFlightDate,max(DATE) as lastFlightDate,
			(TO_DAYS(max(DATE)) - TO_DAYS(MIN(DATE))) as flyingPeriod,
			max( DURATION ) AS maxDuration,
			max( MAX_ALT ) AS maxAlt,
			max( MAX_ALT - TAKEOFF_ALT ) AS maxAltGain,
			
		   '
		. ' count( * ) AS totalFlights, 
			sum( LINEAR_DISTANCE ) AS totalDistance, 
			sum( DURATION ) AS totalDuration, '
		. ' sum( LINEAR_DISTANCE )/count( * ) as mean_distance, '
		. ' sum( DURATION )/count( * ) as mean_duration, '
		. ' sum( FLIGHT_KM ) as totalOlcKm, '
		. ' sum( FLIGHT_POINTS ) as totalOlcScore, '
		. ' max( FLIGHT_POINTS ) as bestOlcScore '
        . ' FROM '.$flightsTable.$extra_table_str
        . ' WHERE '.$flightsTable.'.userID = '.$pilotIDview.' AND '.$flightsTable.'.userServerID = '.$serverIDview.$where_clause
        . ' GROUP BY userID'
        . ' ';
   //echo "<hr>stats query: $query<hr>";
        
	$res= $db->sql_query($query);	
    if($res <= 0){
      echo("<H3> Error in pilot stats query  </H3>\n");
      return;
    }  
    $row = mysql_fetch_assoc($res);
    $groupBy='userID';
    showStats($row,'userID',$where_clause,'') ;
    
    if (isPrint()) {
    	return;		
    }
    
    echo "<h1> Breakdown per Takeoff</h1>";
  /*
   * Break down per takeoff
   */
    $query = 'SELECT DISTINCT takeoffID, max( LINEAR_DISTANCE ) AS bestDistance,
			min(DATE) as firstFlightDate,max(DATE) as lastFlightDate,
			(TO_DAYS(max(DATE)) - TO_DAYS(MIN(DATE))) as flyingPeriod,
			max( DURATION ) AS maxDuration,
			max( MAX_ALT ) AS maxAlt,
			max( MAX_ALT - TAKEOFF_ALT ) AS maxAltGain,
			
		   '
		. ' count( * ) AS totalFlights, 
			sum( LINEAR_DISTANCE ) AS totalDistance, 
			sum( DURATION ) AS totalDuration, '
		. ' sum( LINEAR_DISTANCE )/count( * ) as mean_distance, '
		. ' sum( DURATION )/count( * ) as mean_duration, '
		. ' sum( FLIGHT_KM ) as totalOlcKm, '
		. ' sum( FLIGHT_POINTS ) as totalOlcScore, '
		. ' max( FLIGHT_POINTS ) as bestOlcScore '
        . ' FROM '.$flightsTable.$extra_table_str
        . ' WHERE '.$flightsTable.'.userID = '.$pilotIDview.' AND '.$flightsTable.'.userServerID = '.$serverIDview.$where_clause
        . ' GROUP BY takeoffID'
        . ' ';
 	//echo "<hr>stats query: $query<hr>";
	$res= $db->sql_query($query);	
    if($res <= 0){
      echo("<H3> Error in pilot stats query </H3>\n");
      return;
    }  
    $groupBy='takeoffID';
	while(  $row = mysql_fetch_assoc($res) ) {
		
		$takeoffName=getWaypointName($row['takeoffID']);
		echo "<h2>$takeoffName</h2>";
    	showStats($row,'takeoffID',$where_clause," AND takeoffID=".$row['takeoffID'],$row['takeoffID']) ;
		//echo "<hr>";
		//print_r($row);		
	}
  
	    echo "<h1> Breakdown per Glider</h1>";
	
	/*
   * Break down per glider
   */
    $query = 'SELECT DISTINCT gliderBrandID,glider, max( LINEAR_DISTANCE ) AS bestDistance,
			min(DATE) as firstFlightDate,max(DATE) as lastFlightDate,
			(TO_DAYS(max(DATE)) - TO_DAYS(MIN(DATE))) as flyingPeriod,
			max( DURATION ) AS maxDuration,
			max( MAX_ALT ) AS maxAlt,
			max( MAX_ALT - TAKEOFF_ALT ) AS maxAltGain,
			
		   '
		. ' count( * ) AS totalFlights, 
			sum( LINEAR_DISTANCE ) AS totalDistance, 
			sum( DURATION ) AS totalDuration, '
		. ' sum( LINEAR_DISTANCE )/count( * ) as mean_distance, '
		. ' sum( DURATION )/count( * ) as mean_duration, '
		. ' sum( FLIGHT_KM ) as totalOlcKm, '
		. ' sum( FLIGHT_POINTS ) as totalOlcScore, '
		. ' max( FLIGHT_POINTS ) as bestOlcScore '
        . ' FROM '.$flightsTable.$extra_table_str
        . ' WHERE '.$flightsTable.'.userID = '.$pilotIDview.' AND '.$flightsTable.'.userServerID = '.$serverIDview.$where_clause
        . ' GROUP BY gliderBrandID,glider'
        . ' ';
 	//echo "<hr>stats query: $query<hr>";
        
	$res= $db->sql_query($query);
		
    if($res <= 0){
      echo("<H3> Error in pilot stats query </H3>\n");
      return;
    }  
 	$groupBy='gliderBrandID,glider';
	while(  $row = mysql_fetch_assoc($res) ) {
		$brandName=$CONF['brands']['list'][$row['gliderBrandID']];
		echo "<h2>$brandName ".$row['glider']."</h2>";
		
    	showStats($row,' gliderBrandID,glider',$where_clause,
    			" AND gliderBrandID=".$row['gliderBrandID']." AND glider='".$row['glider']."' ",
    			$row['gliderBrandID'].'_'.$row['glider']) ;
		//echo "<hr>";
		//print_r($row);		
	}
 
?>

	</div>

<?php 
  
function showStats($row,$groupBy,$where_clause,$where_clause2,$suffix='') {
	global $CONF,$db, $flightsTable,$pilotIDview,$serverIDview,$extra_table_str;
	   
	  
  $suffixHash=md5($groupBy.$where_clause.$where_clause2.$suffix);
  
  $query = 'SELECT DISTINCT '.$groupBy.', max( FLIGHT_KM ) AS BestFreeTriangle '			
  		. ' FROM '.$flightsTable.$extra_table_str
        . ' WHERE '.$flightsTable.'.userID = '.$pilotIDview.' AND '.$flightsTable.'.userServerID = '.$serverIDview.
        $where_clause.$where_clause2.' AND  BEST_FLIGHT_TYPE = "FREE_TRIANGLE" '
        . ' GROUP BY '.$groupBy.' '
        . ' ';
  //     echo "<hr>stats query: $query<hr>";
        
  $res= $db->sql_query($query);
		
    if($res <= 0){
      echo("<H3> Error in pilot stats query </H3>\n");
      return;
    }  

  $row0 = mysql_fetch_assoc($res);
  $BestFreeTriangle=$row0["BestFreeTriangle"];

  $query = 'SELECT DISTINCT '.$groupBy.', max( FLIGHT_KM ) AS BestFAITriangle '			
  		. ' FROM '.$flightsTable.$extra_table_str
        . ' WHERE '.$flightsTable.'.userID = '.$pilotIDview.' AND '.$flightsTable.'.userServerID = '.$serverIDview.
        	$where_clause.$where_clause2.' AND  BEST_FLIGHT_TYPE = "FAI_TRIANGLE" '
        . ' GROUP BY '.$groupBy.' '
        . ' ';
  $res= $db->sql_query($query);
		
    if($res <= 0){
      echo("<H3> Error in pilot stats query </H3>\n");
      return;
    }  

  $row0 = mysql_fetch_assoc($res);
  $BestFAITriangle=$row0["BestFAITriangle"];
	
		
	if ($row["totalFlights"]) {
	 $mean_duration=$row["totalDuration"]/$row["totalFlights"];
	 $mean_distance=$row["totalDistance"]/$row["totalFlights"];
	} else {
	 $mean_duration="N/A";
	 $mean_distance="N/A";
	}
	 list($flyingYears,$flyingMonths)=days2YearsMonths($row["flyingPeriod"]);
	
	 $flyingPeriod=$flyingMonths." months";
	 if ($flyingYears>0) $flyingPeriod=$flyingYears." years - ".$flyingPeriod;
	
	 $flyingMonthsReal=$row["flyingPeriod"]/30;
	 $flyingYearsReal=$row["flyingPeriod"]/365;
	
	 if ( $flyingMonthsReal > 1) {
	 $MeanflightsperMonth=sprintf("%.1f",$row["totalFlights"]/ $flyingMonthsReal );
	 $MeanflightsperYear=sprintf("%.1f",$row["totalFlights"] / $flyingYearsReal );
	
	 $MeanDurationPerMonth=sec2Time($row["totalDuration"]/ $flyingMonthsReal ,1);
	 $MeanDurationPerYear=sec2Time($row["totalDuration"] / $flyingYearsReal ,1);
	
	 $MeanDistancePerMonth=formatDistance($row["totalDistance"]/ $flyingMonthsReal ,1);
	 $MeanDistancePerYear=formatDistance($row["totalDistance"] / $flyingYearsReal ,1);
	 } else {
		 $MeanflightsperMonth="N/A";
		 $MeanflightsperYear="N/A";
		
		 $MeanDurationPerMonth="N/A";
		 $MeanDurationPerYear="N/A";
		
		 $MeanDistancePerMonth="N/A";
		 $MeanDistancePerYear="N/A";
	 }


	if ($row["totalFlights"]) { // MAKE some graphs

	    $query = 'SELECT count(*) as flightsCount, SUM(DURATION) as sum_duration, DATE_FORMAT(`DATE`,"%Y-%m") as flightDate '
	        . ' FROM '.$flightsTable.$extra_table_str
	        . ' WHERE '.$flightsTable.'.userID = '.$pilotIDview.' AND '.$flightsTable.'.userServerID = '.$serverIDview.
	        $where_clause.$where_clause2
	        . ' GROUP  BY DATE_FORMAT(DATE,"%Y-%m") '
	        . ' ';
	
		$query1=$query.' ASC';
	
		$res1= $db->sql_query($query1);	
	  	# Error checking
	  	if($res1 <= 0){  echo("<H3> Error in profile stats query!</H3>\n");  return; }
	
	
	    $first_month=substr($row['firstFlightDate'],0,7) ;
	    $last_month=substr($row['lastFlightDate'],0,7) ;
		$year_month_array=fill_year_month_array($first_month ,$last_month);
	
		$data_time1=array();
		$yvalues1=array();
		$yvalues2=array();
		$yval_num=array();
		$yval_dur=array();
		while ($row1 = mysql_fetch_assoc($res1)) { 
	     array_push ($data_time1  ,$row1['flightDate']  ) ;
	     array_push ($yval_num,$row1['flightsCount']);
	     array_push ($yval_dur, $row1['sum_duration']);
	
	   }
	
	   $i=0; 
	   $j=0;
	   foreach ($year_month_array as $y_m) { 
			if (in_array($y_m,$data_time1) ) { 
				$yvalues1[$i]=$yval_num[$j]; 
				$yvalues2[$i]=sprintf("%.1f",$yval_dur[$j]/3600); 
				$j++; 
			} else  {
				$yvalues1[$i]=0;
				$yvalues2[$i]="";
	
			}
			$i++;
	   }
	
		$path=dirname( getPilotStatsFilename($pilotIDview,2) );
		if (!is_dir($path)) makeDir($path);
	
	
		$graph = new Graph(680,250,"auto");    
	    $graph->SetFrame(true,"#FFBC46");
		$graph->SetScale("textlin");
		
		$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#D8E6F2@0.5');
		$graph->yaxis->HideZeroLabel();
		$graph->SetMarginColor("#FFF6DF");	
		$graph->img->SetMargin(40,40,20,70);
		$graph->title->Set($title);
		$graph->xaxis->SetTextTickInterval(1);
		$graph->xaxis->SetTextLabelInterval(1);
		$graph->xaxis->SetTickLabels($year_month_array );
		$graph->xaxis->SetPos("min");
	    $graph->xaxis->SetLabelAngle(90);
		$graph->xaxis->SetTextLabelInterval(ceil(count($year_month_array)/60) );
	
		// Create the bar plot
		$b1 = new BarPlot($yvalues1);
		$b1->SetFillColor("#FFBC46");
		$b1->SetShadow("#9C989E",2,2);
		// $b1->value->Show();
	
		$graph->Add($b1);
		$graph->Stroke( getPilotStatsFilename($pilotIDview,'1'.$suffixHash) );
	
	
		$graph = new Graph(680,250,"auto");    
	    $graph->SetFrame(true,"#FFBC46");
		$graph->SetScale("textlin");
		
		$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#D8E6F2@0.5');
		$graph->yaxis->HideZeroLabel();
		$graph->SetMarginColor("#FFF6DF");	
		$graph->img->SetMargin(40,40,20,70);
		$graph->title->Set($title);
		$graph->xaxis->SetTextTickInterval(1);
		$graph->xaxis->SetTextLabelInterval(1);
		$graph->xaxis->SetTickLabels($year_month_array );
		$graph->xaxis->SetPos("min");
	    $graph->xaxis->SetLabelAngle(90);
		$graph->xaxis->SetTextLabelInterval(ceil(count($year_month_array)/60) );
	
		// Create the bar plot
		$b1 = new BarPlot($yvalues2);
		$b1->SetFillColor("#FFBC46");
		$b1->SetShadow("#9C989E",2,2);
		$b1->value->Show();
		$b1->value->SetFormat('%0.1f h');
	
		$graph->Add($b1);
		$graph->Stroke( getPilotStatsFilename($pilotIDview,'2'.$suffixHash) );

	}




?>
<div id='stats_<?php echo $pilotIDview.$suffix;?>' class='stat_totals'>
 <div class='infoHeader'><?=_Totals?></div>
 <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr>
    <td  width='38%' valign="top" bgcolor="#FFFFFF">
    <div align="right"><? echo _First_flight_logged?></div></td>
    <td  width='12%' bgcolor="#F1FAE2"> <? echo $row['firstFlightDate'] ?> </td>
    <td  width='1%'>&nbsp;</td>
    <td  width='38%'bgcolor="#FFFFFF"><div align="right"><? echo _Total_Distance ?>(km) </div></td>
    <td  width='11%' bgcolor="#F1FAE2"> <? echo formatDistanceOpen($row["totalDistance"],1) ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5">
      <div align="right"><? echo _Last_flight_logged ?></div></td>
    <td bgcolor="#E0E0E0">
      <? echo $row['lastFlightDate'] ?></td>
    <td>&nbsp;</td>
    <td bgcolor="#E9EDF5"><div align="right"><? echo _Total_OLC_Score ?></div></td>
    <td bgcolor="#E0E0E0"><? echo formatOLCScore($row["totalOlcScore"]) ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF">
    <div align="right"><? echo _Flying_period_covered ?></div></td>
    <td bgcolor="#F1FAE2">
      <? echo $flyingPeriod ?></td>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF"><div align="right"><? echo _Total_Hours_Flown ?> (<? echo _hh_mm?>)</div></td>
    <td bgcolor="#F1FAE2"> <? echo sec2Time($row["totalDuration"],1) ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5">&nbsp;</td>
    <td bgcolor="#E0E0E0">&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#E9EDF5"><div align="right"><? echo _Total_num_of_flights ?></div></td>
    <td bgcolor="#E0E0E0"> <? echo $row['totalFlights'] ?></td>
  </tr>
  </table>
  
 <div class='infoHeader'><?=_Personal_Bests?></div>
 <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr>
    <td width='38%' bgcolor="#FFFFFF"><div align="right"><? echo _Best_Open_Distance ?> (km) </div></td>
    <td width='12%' bgcolor="#F1FAE2"> <? echo formatDistanceOpen($row["bestDistance"],1) ?></td>
    <td width='1%'>&nbsp;</td>
    <td width='38%' bgcolor="#FFFFFF"><div align="right"><? echo _Best_OLC_score ?></div></td>
    <td width='11%' bgcolor="#F1FAE2"><? echo formatOLCScore($row["bestOlcScore"]) ?></td>
  </tr>
  <tr>
    <td bgcolor="#E9EDF5"><div align="right"><? echo _Best_FAI_Triangle ?> (km)</div></td>
    <td bgcolor="#E0E0E0"> <? echo formatDistanceOpen($BestFAITriangle,1) ?></td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5">
      <div align="right"><? echo _Absolute_Height_Record ?> (m)</div></td>
    <td bgcolor="#E0E0E0"> <? echo formatAltitude($row['maxAlt'] )?> </td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF">
    <div align="right"><? echo _Best_Free_Triangle ?> (km) </div></td>
    <td bgcolor="#F1FAE2"> <? echo formatDistanceOpen($BestFreeTriangle,1) ?> </td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#FFFFFF">
    <div align="right"><? echo _Altitute_gain_Record ?> (m)</div></td>
    <td bgcolor="#F1FAE2"> <? echo formatAltitude($row['maxAltGain'] ) ?> </td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5">
      <div align="right"><? echo _Longest_Flight ?> (<? echo _hh_mm ?>)</div></td>
    <td bgcolor="#E0E0E0"> <? echo sec2Time($row['maxDuration'],1) ?> </td>
    <td>&nbsp;</td>
    <td bgcolor="#E9EDF5"><div align="right"></div></td>
    <td bgcolor="#E0E0E0">&nbsp;</td>
  </tr>
 </table>
  
 <div class='infoHeader'><?=_Mean_values?></div>
 <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr>
    <td width='38%' bgcolor="#FFFFFF"><div align="right"><? echo _Mean_distance_per_flight ?> (km) </div></td>
    <td width='12%' bgcolor="#F1FAE2"><? echo formatDistanceOpen($mean_distance,1) ?></td>
    <td width='1%'>&nbsp;</td>
    <td width='38%' bgcolor="#FFFFFF"><div align="right"><? echo _Mean_duration_per_flight ?> (<? echo _hh_mm?>)</div></td>
    <td width='11%' bgcolor="#F1FAE2"> <? echo sec2Time($row["mean_duration"],1) ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5">
      <div align="right"><? echo _Mean_flights_per_Month ?></div></td>
    <td bgcolor="#E0E0E0"> <? echo $MeanflightsperMonth ?> </td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5">
      <div align="right"><? echo _Mean_flights_per_Year?></div></td>
    <td bgcolor="#E0E0E0"> <? echo $MeanflightsperYear ?> </td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF">
    <div align="right"><? echo _Mean_distance_per_Month ?> (km) </div></td>
    <td bgcolor="#F1FAE2"> <? echo $MeanDistancePerMonth ?> </td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#FFFFFF">
    <div align="right"><? echo _Mean_distance_per_Year ?> (km) </div></td>
    <td bgcolor="#F1FAE2"> <? echo $MeanDistancePerYear ?> </td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E9EDF5">
      <div align="right"><? echo _Mean_duration_per_Month ?> (<? echo _hh_mm?>) </div></td>
    <td bgcolor="#E0E0E0"> <? echo $MeanDurationPerMonth ?> </td>
    <td>&nbsp;</td>
    <td valign="top" bgcolor="#E9EDF5">
      <div align="right"><? echo _Mean_duration_per_Year ?> (<? echo _hh_mm?>)</div></td>
    <td bgcolor="#E0E0E0"> <? echo $MeanDurationPerYear ?> </td>
  </tr>
  </table>
  
 <div class='infoHeader'><?=_Total_num_of_flights?></div>
 <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr>
<?	
//	if (file_exists(getPilotStatsRelFilename($pilotIDview,'1'.$suffixHash))){
//		$cdnURL='';
//	else{
//		$cdnURL='https://files.leonardo.pgxc.pl';
//	}	
?>
    <td colspan="5" valign="top"><img src='<? echo getPilotStatsRelFilename($pilotIDview,'1'.$suffixHash); ?>' border=0></td>
  </tr>
  </table>
  
 <div class='infoHeader'><?=_Total_Hours_Flown?></div>
 <table  class=main_text  width="100%" border="0" cellpadding="3" cellspacing="3">
  <tr>
    <td colspan="5" valign="top"><img src='<? echo getPilotStatsRelFilename($pilotIDview,'2'.$suffixHash); ?>' border=0></td>
  </tr>
</table>

</div>

<?php  } // end function show stats ?>

<?
	// closeMain();
?>
