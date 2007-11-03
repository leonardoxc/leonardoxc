<?php

	global $prefix, $db, $sitename, $user, $cookie, $flightsTable,$module_name;
	$count = 1;

	$numToshow=10;	
	// Content
	$content = "<A name= \"scrollingCode\"></A>";
	// Marquee Tag
	$content .="<MARQUEE behavior= \"scroll\" align= \"center\" direction= \"up\" height=\"250\" scrollamount= \"2\" scrolldelay= \"20\" onmouseover='this.stop()' onmouseout='this.start()'>";
	$content .="<center><font color=\"#666666\"><b>Latest $numToshow flights</b></font> ";
	
    $query="SELECT * ,$flightsTable.ID as ID FROM $flightsTable WHERE (1=1) ORDER BY DATE DESC LIMIT  $numToshow ";
	$result1 = $db->sql_query($query);

	$content .= "<br>";
	// Listing Topics
	while($row= $db->sql_fetchrow($result1)) {		
		 $flightID=$row["ID"];
		 $name=getPilotRealName($row["userID"],$row["serverID"]);
		 $takeoffName=getWaypointName($row["takeoffID"]);
		 $takeoffVinicity=$row["takeoffVinicity"];
		 $takeoffNameFrm=	formatLocation($takeoffName,$takeoffVinicity,$takeoffRadious );
		 $flightDurationFrm=sec2Time($row['DURATION'],1);		

		$content .= "<a href='".CONF_MODULE_ARG."&op=show_flight&flightID=$flightID' STYLE='text-decoration: none'> ";
		$content .= "<b> $name </b></a><br><font color=\"#666666\">
					<i>[ $takeoffName ] <br><b>".formatDate($row["DATE"])."</b><br>"._DURATION.": $flightDurationFrm<br>"._OLC_SCORING.":".formatOLCScore($row['FLIGHT_POINTS'])."</i></font><br><br>";
		$count = $count + 1;
	}
	$content .= "<br></center>";
	echo $content;

?>

