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
// $Id: GUI_pilot_profile_stats.php,v 1.8 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************

  $query = 'SELECT DISTINCT userID, max( FLIGHT_KM ) AS BestFreeTriangle '			
  		. ' FROM '.$flightsTable
        . ' WHERE '.$flightsTable.'.userID = '.$pilotIDview.' AND '.$flightsTable.'.userServerID = '.$serverID.$where_clause.' AND  BEST_FLIGHT_TYPE = "FREE_TRIANGLE" '
        . ' GROUP BY userID'
        . ' ';
  $res= $db->sql_query($query);
		
    if($res <= 0){
      echo("<H3> Error in pilot stats query </H3>\n");
      return;
    }  

  $row = mysql_fetch_assoc($res);
  $BestFreeTriangle=$row["BestFreeTriangle"];

  $query = 'SELECT DISTINCT userID, max( FLIGHT_KM ) AS BestFAITriangle '			
  		. ' FROM '.$flightsTable
        . ' WHERE '.$flightsTable.'.userID = '.$pilotIDview.' AND '.$flightsTable.'.userServerID = '.$serverID.$where_clause.' AND  BEST_FLIGHT_TYPE = "FAI_TRIANGLE" '
        . ' GROUP BY userID'
        . ' ';
  $res= $db->sql_query($query);
		
    if($res <= 0){
      echo("<H3> Error in pilot stats query </H3>\n");
      return;
    }  

  $row = mysql_fetch_assoc($res);
  $BestFAITriangle=$row["BestFAITriangle"];


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
        . ' FROM '.$flightsTable
        . ' WHERE '.$flightsTable.'.userID = '.$pilotIDview.' AND '.$flightsTable.'.userServerID = '.$serverID.$where_clause
        . ' GROUP BY userID'
        . ' ';

	$res= $db->sql_query($query);
		
    if($res <= 0){
      echo("<H3> Error in pilot stats query </H3>\n");
      return;
    }  

  $row = mysql_fetch_assoc($res);
  
  $realName=getPilotRealName($pilotIDview,$serverID);	
  $legend="<b>$realName</b> "._flights_stats;
  $legendRight="<a href='".
  		getLeonardoLink(array('op'=>'list_flights','pilotID'=>$serverID.'_'.$pilotIDview,'year'=>'0','country'=>''))
  		."'>"._PILOT_FLIGHTS."</a>";
  $legendRight.=" | <a href='".
  		getLeonardoLink(array('op'=>'pilot_profile','pilotIDview'=>$serverID.'_'.$pilotIDview))	
		."'>"._Pilot_Profile."</a>";
  

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

    $query = 'SELECT count(*) as flightsCount, SUM(DURATION) as sum_duration, DATE_FORMAT(DATE,"%Y-%m") as flightDate '
        . ' FROM '.$flightsTable
        . ' WHERE '.$flightsTable.'.userID = '.$pilotIDview.' AND '.$flightsTable.'.userServerID = '.$serverID.$where_clause
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
	if (!is_dir($path)) @mkdir($path,0777);


	require_once dirname(__FILE__)."/lib/graph/jpgraph_gradient.php";
	require_once dirname(__FILE__)."/lib/graph/jpgraph_plotmark.inc" ;

	require_once dirname(__FILE__)."/lib/graph/jpgraph.php";
	require_once dirname(__FILE__)."/lib/graph/jpgraph_line.php";
	require_once dirname(__FILE__)."/lib/graph/jpgraph_bar.php";

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
	$graph->Stroke( getPilotStatsFilename($pilotIDview,1) );


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
	$graph->Stroke( getPilotStatsFilename($pilotIDview,2) );

}

  open_inner_table("<table  class=main_text  width=100%><tr><td>$legend</td><td width=340 align=right bgcolor=#eeeeee>$legendRight</td></tr></table>",720,"icon_profile.png");
  open_tr();  
  echo "<td>";
?>
<table class=main_text width="100%" border="0">
  <tr bgcolor="006699">
    <td colspan="5" valign="top">
      <div align="left"><strong><font color="#FFFFFF"><? echo _Totals?></font></strong></div></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF">
    <div align="right"><? echo _First_flight_logged?></div></td>
    <td width="100" bgcolor="#F1FAE2"> <? echo $row['firstFlightDate'] ?> </td>
    <td width="5">&nbsp;</td>
    <td bgcolor="#FFFFFF"><div align="right"><? echo _Total_Distance ?>(km) </div></td>
    <td width="100" bgcolor="#F1FAE2"> <? echo formatDistanceOpen($row["totalDistance"],1) ?></td>
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
 <tr bgcolor="006699">
    <td colspan="5" valign="top">
      <div align="left"><strong><font color="#FFFFFF"><? echo _Personal_Bests?></font></strong></div></td>
  </tr>
 
  <tr>
    <td bgcolor="#FFFFFF"><div align="right"><? echo _Best_Open_Distance ?> (km) </div></td>
    <td bgcolor="#F1FAE2"> <? echo formatDistanceOpen($row["bestDistance"],1) ?></td>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF"><div align="right"><? echo _Best_OLC_score ?></div></td>
    <td bgcolor="#F1FAE2"><? echo formatOLCScore($row["bestOlcScore"]) ?></td>
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
  <tr bgcolor="006699">
    <td colspan="5" valign="top">
      <div align="left"><strong><font color="#FFFFFF"><? echo _Mean_values ?></font></strong></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="right"><? echo _Mean_distance_per_flight ?> (km) </div></td>
    <td bgcolor="#F1FAE2"><? echo formatDistanceOpen($mean_distance,1) ?></td>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF"><div align="right"><? echo _Mean_duration_per_flight ?> (<? echo _hh_mm?>)</div></td>
    <td bgcolor="#F1FAE2"> <? echo sec2Time($row["mean_duration"],1) ?></td>
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
  <tr>
    <td colspan="5" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="006699">
    <td colspan="5" valign="top"><div align="left"><strong><font color="#FFFFFF"><? echo _Total_num_of_flights ?></font></strong></div></td>
  </tr>
  <tr>
    <td colspan="5" valign="top"><img src='<? echo getPilotStatsRelFilename($pilotIDview,1) ?>' border=0></td>
  </tr>
  <tr bgcolor="006699">
    <td colspan="5" valign="top"><div align="left"><strong><font color="#FFFFFF"><? echo _Total_Hours_Flown ?></font></strong></div></td>
  </tr>
  <tr>
    <td colspan="5" valign="top"><img src='<? echo getPilotStatsRelFilename($pilotIDview,2) ?>' border=0></td>
  </tr>
</table>
<?  echo "</td></tr>"; 
  close_inner_table();
?>
