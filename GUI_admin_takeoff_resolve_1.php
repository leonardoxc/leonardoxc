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
	
  
	$query="SELECT * , count(ID) as sameNum, soundex(name) as nameSoundex
	 FROM  $waypointsTable WHERE type=1000 and name<>'' AND soundex(name) <>'' GROUP BY soundex(name) HAVING count(ID) > 1  order by count(ID) DESC	 ";		
	 
	$res= $db->sql_query($query);
	$i=1;

	if($res == 0){
		echo "Error in query : $query<BR>" ;
		return;
	}

?>
<script language="javascript" src="<?=$moduleRelPath ?>/js/jquery.js"></script>

<script language="javascript">
  
function selectAll(i){
	// $(":checkbox").css({background:"yellow", border:"3px red solid"});
	$(".sel_"+i).attr("checked","checked");	
}

function unselectAll(i){
	// $(":checkbox").css({background:"yellow", border:"3px red solid"});
	$(".sel_"+i+",:checkbox").attr("checked","");	
	
}

 $(document).ready(function(){
   // Your code here

		$(":checkbox").click(function() {
		
			$("#resDiv").append("+" );
			if ( $(this).attr("checked")!="" ) {
			
				$(this).addClass("red");
/*				var rn="row_"+$(this).val();
				$("#resDiv").append("S" );
				$("#resDiv").append( $(this).val()  );
				$("#resDiv").append("A" );
	*/			
				$(this).css(  "border", "2px solid red"  );
			}

		  	if ( $(this).attr("checked")=="checked" ) {
		  
			//var id=$(this).val();
			$(this).css( "background-color","#dddddd"  );
			//$("#row_"+j+"_"+marked[i].value).css( "background-color","#dddddd"  );
		
		$("#resDiv").append("_" );
				$(this)
			  .animate({ left: -10 })
			  .animate({ left: 10 })
			  .animate({ left: -10 })
			  .animate({ left: 10 })
			  .animate({ left: 0 });
		
		  }
		  
		});

 });
 
function deleteMarked(j){
	// $(":checkbox").css({background:"yellow", border:"3px red solid"});
	// +",input:checked"
	var marked=$(".sel_"+j).get();

	$("#resDiv").html('');
	var resStr='';
	for(i=0;i<marked.length;i++) {
		if (marked[i].checked ) {
			if (resStr!='') 
				resStr+='_';
				
			resStr+=marked[i].value;
			$("#row_"+j+"_"+marked[i].value).css( "background-color","#dddddd"  );
			$("#row_"+j+"_"+marked[i].value).css( "border-width","4px"  );
			// $("#resDiv").append(marked[i].value+ "_" );
		}
	}
	
	$("#resDiv").html(resStr);
	/*
	
	$("#resDiv").html("<b>Multiple:</b> " + marked );
	
	
	 jQuery.each(marked, function(j, val) {
	      $("#" + j).attr("checked","");
		   $("#" + j).append(document.createTextNode(" - " + val));
    });
	*/
}


</script>
<div id ='resDiv'></div>
<?
	echo "<pre>";
	
	echo "<form name='actionForm'>";
	echo "<table>";
	echo "<tr><td>#</td><td>Soudex</td><td>#Same names</td><td></td></tr>\n";

	while ($row = mysql_fetch_assoc($res)) {
		if ($i>3) break;
		
		if ($row['nameSoundex']=='') continue;
		
		echo "<tr bgcolor='#FAA756'><td>$i</td><td>".$row['nameSoundex']."</td><td>".$row['sameNum'].
		
		"</td><td><a href='javascript:deleteMarked($i)'>Delete marked</a> :: <a href='javascript:selectAll($i)'>Select ALL</a> ::  <a href='javascript:unselectAll($i)'>Unselect ALL</a>".
		"</td></tr>\n";
		
		echo "<tr><td></td><td colspan=3>";
			$j=1;
			echo "<table border=1>";
			echo "<tr ><td>#</td><td>Takeoff ID</td><td>Country</td><td>Takeoff name</td><td>Int name</td><td>lat</td><td>lon</td><td>Distance in m</td><td>Select</td><td>Metric 1</td><td>Metric 2</td></tr>\n";
		
			$query2="SELECT * FROM  $waypointsTable WHERE soundex(name)='".$row['nameSoundex']."' order by lat , lon ";		

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
				echo "<tr id='row_$ij'><td>$j</td><td>".$row2['ID']."</td><td>".$row2['countryCode']."</td><td>".
				$row2['name']."</td><td>".$row2['intName']."</td><td>".$row2['lat']."</td><td>".
				$row2['lon']."</td><td>".$distanceFromPrevious."</td>
				<td><input type='checkbox' class='sel_$i' name='sel_$ij' id='sel_$ij' value='$j'><input type='hidden' name='takeoff_id_$ij' id='takeoff_id_$ij' value='".$row2['ID']."'></td>
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