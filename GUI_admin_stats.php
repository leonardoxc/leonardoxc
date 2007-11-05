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
//************************************************************************/

 
//-----------------------------------------------------------------------------------------------------------
  if ( !auth::isAdmin($userID) ) { echo "go away"; return; }
  
	require_once dirname(__FILE__)."/lib/graph/jpgraph_gradient.php";
	require_once dirname(__FILE__)."/lib/graph/jpgraph_plotmark.inc" ;

	require_once dirname(__FILE__)."/lib/graph/jpgraph.php";
	require_once dirname(__FILE__)."/lib/graph/jpgraph_line.php";
	require_once dirname(__FILE__)."/lib/graph/jpgraph_bar.php";


	$legend="Usage Statistics";
	$legendRight="";
   echo  "<div class='tableTitle shadowBox'>
   <div class='titleDiv'>$legend</div>
   <div class='pagesDiv'>$legendRight</div>
   </div>" ;
?>
<style type="text/css">
<!--
.he {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 11px;
	font-family: Arial, Helvetica, sans-serif;
	white-space:nowrap;
	text-align:center;
}
-->
</style>

<? 

  	$query="SELECT *, count(*) as num, count(DISTINCT sessionID) as sessionsNUM, count(DISTINCT visitorID) as visitorsNUM
				  FROM ".$statsTable." group by  DATE_FORMAT( FROM_UNIXTIME(tm),  '%Y-%m'  )  ORDER BY tm DESC ";	
  
   // echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){ echo "no log entries found<br>";	return ;  }

	$data_time=array();
    $hitsArray=array();
    $sessionsArray=array();
    $visitorsArray=array();
	while ($row = mysql_fetch_assoc($res)) { 
	 array_push ($data_time  , $row['month']."/".$row['year']  ) ;
     array_push ($hitsArray ,  $row['num']  ) ;
     array_push ($sessionsArray,  $row['sessionsNUM']  ) ;
     array_push ($visitorsArray,  $row['visitorsNUM']  ) ;
   }

	drawChart(1,"Month", $data_time,  array( 
		array("val_array"=>$hitsArray, "color"=>"orange","legend"=>"Hits" )  ,
		array("val_array"=>$sessionsArray, "color"=>"blue","legend"=>"Visits" )  ,
		array("val_array"=>$visitorsArray, "color"=>"green","legend"=>"Unique visitors" )  ,
		)
	);

	// last 30 days
  	$query="SELECT *, count(*) as num, count(DISTINCT sessionID) as sessionsNUM, count(DISTINCT visitorID) as visitorsNUM
				  FROM ".$statsTable." WHERE tm > ".(time()-30*24*60*60)." group by  DATE_FORMAT( FROM_UNIXTIME(tm),  '%Y-%m-%d'  )   ORDER BY tm DESC ";	
  
   // echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){ echo "no log entries found<br>";	return ;  }

	$data_time=array();
    $hitsArray=array();
    $sessionsArray=array();
    $visitorsArray=array();
	while ($row = mysql_fetch_assoc($res)) { 
	 array_push ($data_time  ,  $row['day']."/".$row['month']."/".$row['year']  ) ;
     array_push ($hitsArray ,  $row['num']  ) ;
     array_push ($sessionsArray,  $row['sessionsNUM']  ) ;
     array_push ($visitorsArray,  $row['visitorsNUM']  ) ;
   }

	drawChart(2,"Day", $data_time,  array( 
		array("val_array"=>$hitsArray, "color"=>"orange","legend"=>"Hits" )  ,
		array("val_array"=>$sessionsArray, "color"=>"blue","legend"=>"Visits" )  ,
		array("val_array"=>$visitorsArray, "color"=>"green","legend"=>"Unique visitors" )  ,
		)
	);

	// last 24 hrs
  	$query="SELECT *, count(*) as num, 
				DATE_FORMAT( FROM_UNIXTIME(tm),  '%H'  ) as hour,
					count(DISTINCT sessionID) as sessionsNUM, count(DISTINCT visitorID) as visitorsNUM
				  FROM ".$statsTable." WHERE tm> ".(time()-24*60*60)." group by  DATE_FORMAT( FROM_UNIXTIME(tm),  '%H'  )   ORDER BY tm DESC ";	
  
   // echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){ echo "no log entries found<br>";	return ;  }

	$data_time=array();
    $hitsArray=array();
    $sessionsArray=array();
    $visitorsArray=array();
	while ($row = mysql_fetch_assoc($res)) { 
	 array_push ($data_time  ,  $row['hour'] ) ;
     array_push ($hitsArray ,  $row['num']  ) ;
     array_push ($sessionsArray,  $row['sessionsNUM']  ) ;
     array_push ($visitorsArray,  $row['visitorsNUM']  ) ;
   }

	drawChart(3,"Hour", $data_time,  array( 
		array("val_array"=>$hitsArray, "color"=>"orange","legend"=>"Hits" )  ,
		array("val_array"=>$sessionsArray, "color"=>"blue","legend"=>"Visits" )  ,
		array("val_array"=>$visitorsArray, "color"=>"green","legend"=>"Unique visitors" )  ,
		)
	);


	// the ops used 
  	$query="SELECT *, count(*) as num, 
				MAX(executionTime) as maxTime, AVG(executionTime) as meanTime
				FROM ".$statsTable." group by op  ORDER BY num ASC ";	
  
   // echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){ echo "no log entries found<br>";	return ;  }

	$data_time=array();
    $hitsArray=array();
    $sessionsArray=array();
    $visitorsArray=array();
	while ($row = mysql_fetch_assoc($res)) { 
	 array_push ($data_time  ,  $row['op'] ) ;
     array_push ($hitsArray ,  $row['num']  ) ;
     array_push ($sessionsArray,  sprintf("%.5f",$row['meanTime'])  ) ;
     array_push ($visitorsArray,  sprintf("%.5f",$row['maxTime'])  ) ;
   }

	drawChart(0,"Page", $data_time,  array( 
		array("val_array"=>$hitsArray, "color"=>"orange","legend"=>"Hits" )  ,
		array("val_array"=>$sessionsArray, "color"=>"blue","legend"=>"Mean time" )  ,
		array("val_array"=>$visitorsArray, "color"=>"green","legend"=>"Max time" )  ,
		)
	);

function drawChart($chartNum,$legend, $legendarray, $args) {
	global $moduleRelPath;

	$graph = new Graph(600,230,"auto");    
	$graph->SetScale("textlin");
	
	$graph->SetMarginColor("#C8C8D4");	
	$graph->title->Set($title);
	$graph->xaxis->SetTextTickInterval(1);
	$graph->xaxis->SetTextLabelInterval(1);
	$graph->xaxis->SetTickLabels($legendarray);

	$graph->xaxis->SetPos("min");
    $graph->xaxis->SetLabelAngle(90);
 	$graph->xaxis->SetTextLabelInterval(1);
  
	$graph->xgrid->Show();
	$graph->xgrid->SetLineStyle('dashed');
	
	$graph->legend->SetLayout(LEGEND_HOR);
	$graph->legend->Pos(0.5,0.02,"center","top");
	$graph->img->SetMargin(50,20,50,60);

	$i=1;
	$grpArray=array();
	foreach($args as $arg) {
		$b{$i}= new BarPlot($arg['val_array']);
		$b{$i}->SetFillColor($arg['color']);
		$b{$i}->SetLegend($arg['legend']);
		$b{$i}->value->Show();
		array_push( $grpArray, $b{$i} );
		$tableLegend.=$arg['legend']." / ";
	}

	$gbplot  = new GroupBarPlot( $grpArray );
	$graph->Add($gbplot);

	if ($chartNum) $graph->Stroke(dirname(__FILE__)."/stats_usage_$chartNum.png");
?>

		<table width=610  bgcolor="0060C1" class="main_text" border="0" align="center" cellpadding="2" cellspacing="1">
			<tr bgcolor="#0060C1">
				<td colspan=3 style="font-size:14px; font-weight:bold; color:white; text-align:center;"> 
				 <?=$tableLegend." ".$legend?></td>
			</tr>
			<tr bgcolor="#0060C1">
				<td colspan=3><? if ($chartNum) { ?><img src="<? echo $moduleRelPath ?>/stats_usage_<?=$chartNum?>.png"><? } ?></td>
			</tr>
	<td bgcolor="#CCCCCC">
	<table width=300  bgcolor="0060C1" class="main_text" border="0" align="center" cellpadding="2" cellspacing="1">
			<tr bgcolor="#0060C1">
				<td class="he"><?=$legend?></td>
			<?
				foreach($args as $arg) {
					echo "<td class='he'>".$arg['legend']."</td>";
				}
			?>
			</tr>

<?
	$i=0;
	for($i=count($legendarray)-1;$i>=0; $i--) { 
		if ($i%2) $bg='bgcolor=#eeeeee'; 
		else $bg= 'bgcolor=#FFFFFF'; 

?>
	<tr <?=$bg ?> >
		<td><? echo $legendarray[$i] ?></td>
		<?
			foreach($args as $arg) {
				echo "<td align='right'>".$arg['val_array'][$i]."</td>";
			}
		?>
	</tr>
<?		
		$totCount=$totCount-$flightsArray[$i];
	}
?>
	</table></td>
</tr>
</table>
<BR><br>
<?
} // end of function

?>