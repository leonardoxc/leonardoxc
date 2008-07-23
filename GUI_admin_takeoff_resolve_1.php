<? 
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
//************************************************************************/

	if ( !auth::isAdmin($userID) ) { echo "go away"; return; }
	
    $countryCode=strtoupper($_GET['countryCode'] );
 	if ($countryCode) 
		$countryCodeWhere=" AND countryCode='$countryCode' ";
	else 
		$countryCodeWhere='';
		
	if ($_GET['intName'] == 1) 
		$nameField='intName';
	else 
		$nameField='name';	
		
	if ($admin_op==1)
		$groupStr=" $nameField ";
	else 
		$groupStr=" soundex($nameField) ";
		
	$query="SELECT * , count(ID) as sameNum, $groupStr as nameSoundex
	 FROM  $waypointsTable WHERE type=1000 and name<>'' AND $groupStr <>'' $countryCodeWhere GROUP BY $groupStr HAVING count(ID) > 1  order by count(ID) ASC	 ";		
	 
	$res= $db->sql_query($query);
	$i=1;

	if($res == 0){
		echo "Error in query : $query<BR>" ;
		return;
	}

?>
<style type="text/css">
<!--

tr.alt td {
	background: #ecf6fc;
}
tr.alt2 td {
	background: #FFFFFF;
}

tr.over td {
	background: #bcd4ec;
}

tr.deleted td {
	background:#F6E4E9;
	text-decoration:line-through;
}

tr.marked td {
	background:#CDECBB;
}

div#floatDiv , div#takeoffInfoDiv
{
  width: 20%;
  float: right;
  border: 1px solid #8cacbb;
  margin: 0.5em;
  background-color: #dee7ec;
  padding-bottom: 5px;
 
   position :fixed;
   right    :0.5em;
   top      :13em;
   width    :15em;
}

div#takeoffInfoDiv {
	float :left;
	left : 0.5em;
}

div#floatDiv h3, div#takeoffInfoDiv h3
{
	margin:0;
	font-size:12px;
	background-color:#336699;
	color:#FFFFFF;
}

.takeoffLink {
  cursor: pointer;
  text-decoration:underline;
} 

-->
</style>
<script language="javascript" src="<?=$moduleRelPath ?>/js/jquery.js"></script>

<script language="javascript">
  
function selectAll(i){
	$(".sel_"+i).filter(":checkbox").filter(":enabled").attr("checked","checked").parent().parent().addClass("marked");	
}

function unselectAll(i){
	$(".sel_"+i).filter(":checkbox").filter(":enabled").attr("checked","").parent().parent().removeClass("marked");;
}

$(document).ready(function(){
   // Your code here
	$('.stripeMe tr:even:gt(0)').addClass('alt');
	$('.stripeMe tr:odd').addClass('alt2');


  
	$(".takeoffLink").click(function() {		
		
	  	$("#infoDiv").load("<?=$moduleRelPath?>/EXT_takeoff_functions.php?op=getTakeoffInfo&wpID="+$(this).html() ); 
		//var x = e.pageX - this.offsetLeft;
		//var y = e.pageY - this.offsetTop;

	});
	
	$(":checkbox").click(function() {	
		if ($(this).attr("disabled")=="disabled" )  return ;
			
		if ( $(this).attr("checked")!="" ) {	
			$(this).parent().parent().addClass("marked");
		} else {
			$(this).parent().parent().removeClass("marked");
		}
	  
	});

});
 
function deleteMarked(j){
	var marked=$(".sel_"+j).filter(":checked").filter(":enabled");

	$("#resDiv").html('');
	var resStr='';
	
    jQuery.each(marked, function(c) {
			var ij=j+"_"+$(this).val();
			
			if (resStr!='') resStr+='_';
			resStr+= $("#takeoff_id_"+ij).val();
			
			$("#row_"+ij).removeClass("marked").addClass('deleted');
			$("#sel_"+ij).attr("disabled","disabled");
		});
		
	$("#resDiv").html("<img src='<?=$moduleRelPath?>/img/ajax-loader.gif'>");
	// $("#resDiv").append('<br>'+resStr);
	$("#resDiv").load("<?=$moduleRelPath?>/EXT_takeoff_functions.php?op=deleteTakeoffs&takeoffs="+resStr ); 
	
}


</script>

<div id ='takeoffInfoDiv'>
	<h3>Information</h3>
	<div id ='infoDiv'><BR /><BR /></div>
</div>

<div id ='floatDiv'>
	<h3>Results</h3>
	<div id ='resDiv'><BR /><BR /></div>
</div>
<?
	echo "<pre>";
	
	echo "<form name='actionForm'>";
	echo "<table>";
	echo "<tr><td>#</td><td>Soudex</td><td>#Same names</td><td></td></tr>\n";

	while ($row = mysql_fetch_assoc($res)) {
		// if ($i>30) break;
		
		if ($row['nameSoundex']=='') continue;
		
		echo "<tr bgcolor='#E2DFBE'><td>$i</td><td>".$row['nameSoundex']."</td><td>".$row['sameNum'].
		
		"</td><td><a href='javascript:deleteMarked($i)'>Delete marked</a> :: <a href='javascript:selectAll($i)'>Select ALL</a> ::  <a href='javascript:unselectAll($i)'>Unselect ALL</a>".
		"</td></tr>\n";
		
		echo "<tr><td></td><td colspan=3>";
			$j=1;
			echo "<table border=1 class='stripeMe'>";
			echo "<tr ><td>#</td><td>Takeoff ID</td><td>Country</td><td># of flights</td><td>Takeoff name</td><td>Int name</td><td>lat</td><td>lon</td><td>Distance in m</td><td>Select</td><td>Metric 1</td><td>Metric 2</td></tr>\n";
		
			$query2="SELECT $waypointsTable.*, count($flightsTable.ID) as flightsNum FROM  $waypointsTable LEFT JOIN $flightsTable ON ( $flightsTable.takeoffID=$waypointsTable.ID ) 
				WHERE $groupStr='".$row['nameSoundex']."'  $countryCodeWhere
				group by $waypointsTable.ID
				order by lat , lon ";		

			$lastLat=0;
			$lastLon=0; 
			$lastName='';
			
			$res2= $db->sql_query($query2);
			if($res2 == 0){
				echo "Error in query : $query2<BR>" ;
				return;
			}
			while ($row2 = mysql_fetch_assoc($res2)) {
			
				// compute distance from previous
				if ( $lastLat && $lastLon) {
					$distanceFromPrevious=gpsPoint::calc_distance($lastLat, $lastLon,$row2['lat'], $row2['lon']); 
				} else {
					$distanceFromPrevious=0;
				}
				
				$lastLat=$row2['lat'];
				$lastLon=$row2['lon']; 


				if ( $lastName) {
					$nameDistanceFromPrevious1=levenshtein (strtolower($lastIntName),strtolower($row2['intName'])); 
					similar_text (strtolower($lastIntName),strtolower($row2['intName']),&$nameDistanceFromPrevious2); 
				} else {
					$nameDistanceFromPrevious1=0;
					$nameDistanceFromPrevious2=0;
				}

				$lastName=$row2['name']; 
				$lastIntName=$row2['intName']; 
				
				if ($j==1) $distanceFromPrevious='';
				else {
					$distanceFromPrevious=floor($distanceFromPrevious);
					if ($distanceFromPrevious<5000) $distanceFromPrevious="<b>".$distanceFromPrevious."</b>";
				}
				
				$ij=$i."_".$j;
				echo "<tr id='row_$ij'><td>$j</td><td><div class='takeoffLink'>".$row2['ID']."</div></td><td>".$row2['countryCode']."</td><td>".$row2['flightsNum']."</td><td>".
				$row2['name']."</td><td>".$row2['intName']."</td><td>".$row2['lat']."</td><td>".
				(-$row2['lon'])."</td><td>".$distanceFromPrevious."</td>
				<td><input type='checkbox' class='sel_$i' name='sel_$ij' id='sel_$ij' value='$j'><input type='hidden' id='takeoff_id_$ij' value='".$row2['ID']."'></td>
				<td>$nameDistanceFromPrevious1</td><td>".sprintf("%.1f",$nameDistanceFromPrevious2)."%</td></tr>\n";

				$j++;
			}
				
			echo " </table> ";	
		
		echo "</td></tr>\n";
		$i++;
	}	
	
	echo " </table> ";
	echo "</pre>";


?>