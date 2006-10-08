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
/************************************************************************/

  $flightID=$_REQUEST["flightID"];
  $confirmed=$_REQUEST["confirmed"];

  $flight=new flight();
  $flight->getFlightFromDB($flightID);

  if ($confirmed && ( $flight->userID == $userID || in_array($userID,$admin_users) )  ) {

	$flight->deleteFlight();
	echo "<div align=center><br>"._THE_FLIGHT_HAS_BEEN_DELETED."<br><br>";
	echo "<a href='?name=".$module_name."&op=list_flights'>"._RETURN."</a><br></div>";
  } else {
	  $location=formatLocation(getWaypointName($flight->takeoffID),$flight->takeoffVinicity,$takeoffRadious);
	
	  open_inner_table(_CAUTION_THE_FLIGHT_WILL_BE_DELETED,600,"delete_icon.png");
	  echo "<div align=center><br><b>"._PILOT.": ".$flight->userName." &nbsp;&nbsp; "._THE_DATE.": ".formatDate($flight->DATE)."  &nbsp;&nbsp; "._TAKEOFF_LOCATION.": ".$location."</b> ";
	  echo "<br><br><a href='?name=".$module_name."&op=delete_flight&flightID=".$flightID."&confirmed=1'>"._YES."</a> | <a href='javascript:history.go(-1)'>"._NO."</a>";
	  echo "<br></div>";
	  close_inner_table();
  }
  
?>
