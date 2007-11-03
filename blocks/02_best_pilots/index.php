<?php

	global $prefix, $db, $sitename, $user, $cookie, $flightsTable;
	$count = 1;

	// Content
	$content = "<A name= \"scrollingCode\"></A>";
	// Marquee Tag
	$content .="<MARQUEE behavior= \"scroll\" align= \"center\" direction= \"up\" height=\"250\" scrollamount= \"2\" scrolldelay= \"20\" onmouseover='this.stop()' onmouseout='this.start()'>";
	$content .="<center><font color=\"#666666\"><b>Best scores for ".date("Y")."</b></font> ";
	$content .= "<br>";

global $CONF_glider_types,$gliderCatList,$module_name;

foreach ( $CONF_glider_types as $gl_id=>$gl_type) {

    $query="SELECT * FROM $flightsTable
			WHERE DATE_FORMAT( DATE, '%Y' ) =".date("Y")." AND cat =".$gl_id."
			ORDER BY flight_points DESC
			LIMIT 1 ";
	$result1 = $db->sql_query($query);

	
	// Listing Topics
	while($row= $db->sql_fetchrow($result1)) {		
		 $flightID=$row["ID"];
		 $name=getPilotRealName($row["userID"],$row["serverID"]);
		 $takeoffName=getWaypointName($row["takeoffID"]);
		 $takeoffVinicity=$row["takeoffVinicity"];
		 $takeoffNameFrm=	formatLocation($takeoffName,$takeoffVinicity,$takeoffRadious );
		 $flightDurationFrm=sec2Time($row['DURATION'],1);		

		$content .= "<font color=\"#EC782B\"><b>".$gliderCatList[$gl_id]."</b></font><br>";
		$content .= "<a href='".CONF_MODULE_ARG."&op=show_flight&flightID=$flightID' STYLE='text-decoration: none'> ";
		$content .= "<b> $name </b></a><br><font color=\"#666666\">
					<i>[ $takeoffName ] <br><b>".formatDate($row["DATE"])."</b><br>"._DURATION.": $flightDurationFrm<br>"._OLC_SCORING.":".formatOLCScore($row['FLIGHT_POINTS'])."</i></font><br><br>";
		$count = $count + 1;
	}

}
	$content .= "</center>";
	echo $content;

?>

