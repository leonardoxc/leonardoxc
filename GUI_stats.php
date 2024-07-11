<?
//************************************************************************
// Leonardo XC Server, https://github.com/leonardoxc/leonardoxc
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_stats.php,v 1.7 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************

	$query='SELECT count(  *  ) as flightCount, DATE_FORMAT( dateAdded ,  "%Y-%m"  )   as date_Added
	 FROM  '.$flightsTable.'  WHERE  userID >0
	 GROUP  BY DATE_FORMAT( dateAdded  ,  "%Y-%m"  )
	 ORDER  BY  dateAdded ASC';

	// echo $query;
	$res= $db->sql_query($query);
  	# Error checking
  	if($res <= 0){  echo("<H3> Error in stats query! $query </H3>\n");  return; }

    $totCount=0;
	$data_time=array();
	$yvalues=array();
    $flightsArray=array();
	while ($row = mysql_fetch_assoc($res)) {
	 $totCount+=$row['flightCount'];
     array_push ($data_time  ,$row['date_Added']  ) ;
     array_push ($flightsArray ,  $row['flightCount']  ) ;
     array_push ($yvalues ,$totCount );
   }

	require_once dirname(__FILE__).'/FN_brands.php';
	// glider brands
/**
 * Martin Jursa 22.06.2008: this SQL fails on Mysql 4
 * 	$query='SELECT count(  *  ) as brandCount, gliderBrandID FROM  '.$flightsTable.'  WHERE  userID >0 AND
		( gliderBrandID !=0 )
	 GROUP  BY gliderBrandID
	 ORDER  BY   count(  *  ) DESC ';
*/
	# alternative
	$query='SELECT count(DISTINCT ID) as brandCount, gliderBrandID
	FROM '.$flightsTable.'
	WHERE userID >0 AND ( gliderBrandID !=0 )
	GROUP BY gliderBrandID
	ORDER BY brandCount DESC';

	// echo $query;
	$res= $db->sql_query($query);
  	# Error checking
  	if($res <= 0){  echo("<H3> Error in stats brands  query! $query </H3>\n");  return; }

    $brandsTotCount=0;

	$brandsCountArray=array();
    $brandsArray=array();
	while ($row = mysql_fetch_assoc($res)) {
	 $brandsTotCount+=$row['brandCount'];
	 if ($row['gliderBrandID'] ==0)
		 $brandName='Other';
	else
		 $brandName=$CONF['brands']['list'][$row['gliderBrandID'] ];

     array_push ($brandsArray  , $brandName ) ;
     array_push ($brandsCountArray ,  $row['brandCount']  ) ;

   }


	require_once dirname(__FILE__)."/lib/graph/jpgraph_gradient.php";
	require_once dirname(__FILE__)."/lib/graph/jpgraph_plotmark.inc" ;

	require_once dirname(__FILE__)."/lib/graph/jpgraph.php";
	require_once dirname(__FILE__)."/lib/graph/jpgraph_line.php";
	require_once dirname(__FILE__)."/lib/graph/jpgraph_bar.php";

	$graph = new Graph(600,300,"auto");
	$graph->SetScale("textlin");

	//$graph->title->SetFont(FF_ARIAL,FS_NORMAL,10);
	//$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
	//$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
	$graph->SetMarginColor("#C8C8D4");
	$graph->img->SetMargin(40,20,20,70);
	$graph->title->Set($title);
	$graph->xaxis->SetTextTickInterval(1);
	$graph->xaxis->SetTextLabelInterval(1);
	$graph->xaxis->SetTickLabels($data_time);
	$graph->xaxis->SetPos("min");
    $graph->xaxis->SetLabelAngle(90);
 	$graph->xaxis->SetTextLabelInterval(1);

	$graph->xgrid->Show();
	$graph->xgrid->SetLineStyle('dashed');

	$graph->legend->SetLayout(LEGEND_HOR);
	$graph->legend->Pos(0.5,0.03,"center","top");
	$graph->img->SetMargin(50,20,50,70);

	$lineplot=new LinePlot($yvalues);
	$lineplot->SetFillColor("green");
	$lineplot->SetLegend("Total");
  //  $lineplot->value->Show();

//	$lineplot=new  BarPlot($yvalues);
	// $graph->Add($lineplot);

	$bplot = new BarPlot($flightsArray);
	$bplot->SetFillColor("orange");
	$bplot->SetLegend("Per month");

	$graph->Add($bplot);
	$graph->Stroke(dirname(__FILE__)."/stats.png");


// now the brands
	$graph = new Graph(600,300,"auto");
	$graph->SetScale("textlin");

	//$graph->title->SetFont(FF_ARIAL,FS_NORMAL,10);
	//$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
	//$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
	$graph->SetMarginColor("#C8C8D4");
	$graph->img->SetMargin(40,20,20,70);
	$graph->title->Set($title);
	$graph->xaxis->SetTextTickInterval(1);
	$graph->xaxis->SetTextLabelInterval(1);
	$graph->xaxis->SetTickLabels($brandsArray);
	$graph->xaxis->SetPos("min");
    $graph->xaxis->SetLabelAngle(90);
 	$graph->xaxis->SetTextLabelInterval(1);

	$graph->xgrid->Show();
	$graph->xgrid->SetLineStyle('dashed');

	//$graph->legend->SetLayout(LEGEND_HOR);
	//$graph->legend->Pos(0.5,0.03,"center","top");
	$graph->img->SetMargin(50,20,10,70);

	$lineplot=new LinePlot($yvalues);
	$lineplot->SetFillColor("green");
	$lineplot->SetLegend("Total");
  //  $lineplot->value->Show();

//	$lineplot=new  BarPlot($yvalues);
	// $graph->Add($lineplot);

	$bplot = new BarPlot($brandsCountArray);
	$bplot->SetFillColor("orange");
	// $bplot->SetLegend("Per month");

	$graph->Add($bplot);
	$graph->Stroke(dirname(__FILE__)."/stats_brands.png");


?>
<style type="text/css">
<!--
.he {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
	white-space:nowrap;
	text-align:center;
}
-->
</style>



		<table width=610  bgcolor="0060C1" class="main_text" border="0" align="center" cellpadding="2" cellspacing="1">
			<tr bgcolor="#0060C1">
				<td colspan=3 style="font-size:14px; font-weight:bold; color:white; text-align:center;"> #
				  submitted flights</td>
			</tr>
			<tr bgcolor="#0060C1">
				<td colspan=3><img src="<? echo $moduleRelPath ?>/stats.png"></td>
			</tr>
<td bgcolor="#CCCCCC">
<table width=300  bgcolor="0060C1" class="main_text" border="0" align="center" cellpadding="2" cellspacing="1">
			<tr bgcolor="#0060C1">
				<td class="he">Month</td>
				<td class="he">Flights submitted</td>
				<td class="he">Flights total</td>
			</tr>

<?
	$i=0;
	for($i=count($data_time)-1;$i>=0; $i--) {
		if ($i%2) $bg='bgcolor=#eeeeee';
		else $bg= 'bgcolor=#FFFFFF';

?>
	<tr <?=$bg ?> >
		<td><? echo $data_time[$i] ?></td>
		<td align="right"><? echo  $flightsArray[$i]?></td>
		<td align="right"><? echo  $totCount ?></td>
	</tr>
<?
		$totCount=$totCount-$flightsArray[$i];
	}
?>
	</table></td>
</tr>
</table>


		<table width=610  bgcolor="0060C1" class="main_text" border="0" align="center" cellpadding="2" cellspacing="1">
			<tr bgcolor="#0060C1">
				<td colspan=2 style="font-size:14px; font-weight:bold; color:white; text-align:center;"> #
				  submitted flights / Brand * (Total : <?=$brandsTotCount ?>) </td>
			</tr>
			<tr bgcolor="#0060C1">
				<td colspan=3><img src="<? echo $moduleRelPath ?>/stats_brands.png"></td>
			</tr>
<td bgcolor="#CCCCCC">
<table width=300  bgcolor="0060C1" class="main_text" border="0" align="center" cellpadding="2" cellspacing="1">
			<tr bgcolor="#0060C1">
				<td class="he">Brand</td>
				<td class="he">Flights Number</td>
			</tr>

<?
	$i=0;
	for($i=0; $i<count($brandsArray); $i++) {
		if ($i%2) $bg='bgcolor=#eeeeee';
		else $bg= 'bgcolor=#FFFFFF';

?>
	<tr <?=$bg ?> >
		<td><? echo $brandsArray[$i] ?></td>
		<td align="right"><? echo  $brandsCountArray[$i]?></td>
	</tr>
<?

	}
?>
	</table></td>
</tr>
</table>
        <p align="center">* Out of the flights that had the glider brand filled in </p>
