<?

function echo_red($text,$day) {
if (($day == 0) || ($day == 6)) echo "<font color=#ff0000>";
echo $text;
if (($day == 0) || ($day == 6)) echo "</font>";
}



?>
<table border="0" align="center" cellpadding="4" cellspacing="1">
	<tr>
		<td valign=top align=center>

<? 
	$query='SELECT count(  *  ) as userCount,
	 DATE_FORMAT( from_unixtime( user_regdate ) ,  "%Y-%m-%d"  ) as regDate,
	 DATE_FORMAT( from_unixtime( user_regdate ) ,  "%a"  )       as regDay,
	 DATE_FORMAT( from_unixtime( user_regdate ) ,  "%w"  )       as regDayNumber
	 FROM  `phpbb_users`  WHERE  user_id >0
	 GROUP  BY DATE_FORMAT( from_unixtime( user_regdate ) ,  "%Y-%m-%d %a"  )   
	 ORDER  BY  regDate ';

	$query1=$query.' ASC';
	$query2=$query.' DESC';

	$res1= $db->sql_query($query1);	
	$res2= $db->sql_query($query2);	
  	# Error checking
  	if($res1 <= 0){  echo("<H3> Error in registration stats query! $query </H3>\n");  return; }

    $totCount=0;
	$data_time1=array();
	$data_time2=array();
	$data_time3=array();
	$data_time4=array();
	$yvalues1=array();
	$yvalues2=array();
    $user_reg1=array();
    $user_reg2=array();
	while ($row1 = mysql_fetch_assoc($res1)) { 
	 $totCount+=$row1['userCount'];
     array_push ($data_time1  ,$row1['regDate']  ) ;
     array_push ($user_reg1 ,  $row1['userCount']  ) ;
     array_push ($yvalues1 ,$totCount );
   }

	while ($row2 = mysql_fetch_assoc($res2)) { 
	 $totCount+=$row1['userCount'];
     array_push ($data_time2  ,$row2['regDate']  ) ;
     array_push ($data_time3  ,$row2['regDay']  ) ;
     array_push ($data_time4  ,$row2['regDayNumber']  ) ;	 
     array_push ($user_reg2 ,  $row2['userCount']  ) ;
     array_push ($yvalues2 ,$totCount );
   }

	if (is_dir($moduleRelPath) ) $pre=$moduleRelPath."/";
	else $pre="";
	require_once $pre."graph/jpgraph_gradient.php";
	require_once $pre."graph/jpgraph_plotmark.inc" ;

	require_once $pre."graph/jpgraph.php";
	require_once $pre."graph/jpgraph_line.php";
	require_once $pre."graph/jpgraph_bar.php";

	$graph = new Graph(400,200,"auto");    
	$graph->SetScale("textlin");
	
	//$graph->title->SetFont(FF_ARIAL,FS_NORMAL,10); 
	//$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8); 
	//$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
	$graph->SetMarginColor("#C8C8D4");	
	$graph->img->SetMargin(40,20,20,70);
	$graph->title->Set($title);
	$graph->xaxis->SetTextTickInterval(1);
	$graph->xaxis->SetTextLabelInterval(1);
	$graph->xaxis->SetTickLabels($data_time1);
	$graph->xaxis->SetPos("min");
    $graph->xaxis->SetLabelAngle(90);
 	$graph->xaxis->SetTextLabelInterval(14);
  
	$graph->xgrid->Show();
	$graph->xgrid->SetLineStyle('dashed');
	
	$lineplot=new LinePlot($yvalues1);
	$lineplot->SetFillColor("green");

  //  $lineplot->value->Show();

//	$lineplot=new  BarPlot($yvalues);
	$graph->Add($lineplot);
	$graph->Stroke(dirname(__FILE__)."/reg_user_graph.png");



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



		<table width=90%  bgcolor="0060C1" class="main_text" border="0" align="center" cellpadding="2" cellspacing="1">
			<tr bgcolor="#0060C1">
				<td colspan=3 style="font-size:14px; font-weight:bold; color:white; text-align:center;">User Count</td>
			</tr>
			<tr bgcolor="#0060C1">
				<td colspan=3><img src="<? echo $moduleRelPath ?>/reg_user_graph.png"></td>
			</tr>
			<tr bgcolor="#0060C1">
				<td class="he">DATE</td>
				<td class="he">Users registered</td>
				<td class="he">Users total</td>
			</tr>

<?
$i=0;
	foreach ( $yvalues2 as $userCount) { 
?>
						<tr

<?
if ($i%2) { 
 echo 'bgcolor=#eeeeee'; 
} else { 
 echo 'bgcolor=#FFFFFF'; 
} 
?>
>
				<td><? echo_red($data_time2[$i] . " " . $data_time3[$i],$data_time4[$i]) ?></td>
				<td align="right"><? echo_red($user_reg2[$i],$data_time4[$i]) ?></td>
				<td align="right"><? echo_red($totCount,$data_time4[$i]) ?></td>
			</tr>

<?		
	$totCount=$totCount-$user_reg2[$i];
$i++;
	}

?>
		</table>
	</td>
<? 
	$query='SELECT count(  *  ) as postCount,
	 DATE_FORMAT( from_unixtime( post_time ) ,  "%Y-%m-%d"  ) as postDate,
	 DATE_FORMAT( from_unixtime( post_time ) ,  "%a"  )       as postDay,
	 DATE_FORMAT( from_unixtime( post_time ) ,  "%w"  )       as postDayNumber
	 
	 FROM  `phpbb_posts`  
	 GROUP  BY DATE_FORMAT( from_unixtime(  post_time ) ,  "%Y-%m-%d %a"  )   
	 ORDER  BY  postDate ';

	$query1=$query.' ASC';
	$query2=$query.' DESC';


	$res1= $db->sql_query($query1);	
	$res2= $db->sql_query($query2);	
  	# Error checking
  	if($res1 <= 0){  echo("<H3> Error in registration stats query! $query </H3>\n");  return; }

    $totCount=0;
	$data_time1=array();
	$data_time2=array();
	$data_time3=array();
	$data_time4=array();
	$yvalues1=array();
	$yvalues2=array();
    $posts_total1=array();
    $posts_total2=array();

	while ($row1 = mysql_fetch_assoc($res1)) { 
	 $totCount+=$row1['postCount'];
     array_push ($data_time1  ,$row1['postDate']  ) ;
     array_push ($posts_total1,   $totCount ) ;
     array_push ($yvalues1 ,$row1['postCount'] );
   }

	while ($row2 = mysql_fetch_assoc($res2)) { 
	 $totCount+=$row1['postCount'];
     array_push ($data_time2  ,$row2['postDate']  ) ;
     array_push ($data_time3  ,$row2['postDay']  ) ;
     array_push ($data_time4  ,$row2['postDayNumber']  ) ;	 	 
     array_push ($posts_total2,   $totCount ) ;
     array_push ($yvalues2 ,$row2['postCount'] );
   }

	if (is_dir($moduleRelPath) ) $pre=$moduleRelPath."/";
	else $pre="";
	require_once $pre."graph/jpgraph_gradient.php";
	require_once $pre."graph/jpgraph_plotmark.inc" ;

	require_once $pre."graph/jpgraph.php";
	require_once $pre."graph/jpgraph_line.php";
	require_once $pre."graph/jpgraph_bar.php";

	$graph = new Graph(400,200,"auto");    
	$graph->SetScale("textlin");
	
	//$graph->title->SetFont(FF_ARIAL,FS_NORMAL,10); 
	//$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8); 
	//$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
	$graph->SetMarginColor("#C8C8D4");	
	$graph->img->SetMargin(40,20,20,70);
	$graph->title->Set($title);
	$graph->xaxis->SetTextTickInterval(1);
	$graph->xaxis->SetTextLabelInterval(1);
	$graph->xaxis->SetTickLabels($data_time1);
	$graph->xaxis->SetPos("min");
    $graph->xaxis->SetLabelAngle(90);
 	$graph->xaxis->SetTextLabelInterval(14);
  
	$graph->xgrid->Show();
	$graph->xgrid->SetLineStyle('dashed');
	
	$lineplot=new LinePlot($yvalues1);
	$lineplot->SetFillColor("green");

  //  $lineplot->value->Show();

//	$lineplot=new  BarPlot($yvalues);
	$graph->Add($lineplot);
	$graph->Stroke(dirname(__FILE__)."/posts_graph.png");



?>

<td valign=top align=center>

		<table width=90% bgcolor="0060C1" class="main_text" border="0" align="center" cellpadding="2" cellspacing="1">
			<tr bgcolor="#0060C1">
				<td colspan=3 style="font-size:14px; font-weight:bold; color:white; text-align:center;">Post Count</td>
			</tr>
			<tr bgcolor="#0060C1">
				<td colspan=3><img src="<? echo $moduleRelPath ?>/posts_graph.png"></td>
			</tr>
			<tr bgcolor="#0060C1">
				<td class="he">DATE</td>
				<td class="he">Posts</div></td>
				<td class="he">Posts Total</div></td>
			</tr>

<?
$i=0;
	foreach ( $yvalues2 as $posts) { 
   
?>
			<tr

<?
if ($i%2) { 
 echo 'bgcolor=#eeeeee'; 
} else { 
 echo 'bgcolor=#FFFFFF'; 
} 
?>
>
				<td><? echo_red($data_time2[$i] . " " . $data_time3[$i], $data_time4[$i]) ?></td>
				<td align="right"><? echo_red($posts,$data_time4[$i]) ?></td>
				<td align="right"><? echo_red($totCount,$data_time4[$i])  ?></td>
			</tr>

<?	
	
$totCount=$totCount-$posts;
$i++;
	}

?>
		</table>
	</td>
</table>
