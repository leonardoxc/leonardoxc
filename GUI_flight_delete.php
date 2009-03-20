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
// $Id: GUI_flight_delete.php,v 1.11 2009/03/20 16:24:34 manolis Exp $                                                                 
//
//************************************************************************

  $flightID=makeSane($_REQUEST["flightID"],1);
  $confirmed=makeSane($_REQUEST["confirmed"]);

  $flight=new flight();
  $flight->getFlightFromDB($flightID);

  if ($confirmed && ( $flight->belongsToUser($userID) || L_auth::isAdmin($userID) )  ) {

	$flight->deleteFlight();
	echo "<br><span class='ok'>"._THE_FLIGHT_HAS_BEEN_DELETED."</span><br><br>";
	echo "<a href='".getLeonardoLink(array('op'=>'list_flights'))."'>"._RETURN."</a><br></div>";
  } else {
	  $location=formatLocation(getWaypointName($flight->takeoffID),$flight->takeoffVinicity,$takeoffRadious);
	
	  openMain(_CAUTION_THE_FLIGHT_WILL_BE_DELETED,0,"delete_icon.png");
	  echo "<div align=center><br><b>"._PILOT.": ".$flight->userName." &nbsp;&nbsp; "._THE_DATE.": ".formatDate($flight->DATE)."  &nbsp;&nbsp; "._TAKEOFF_LOCATION.": ".$location."</b> ";
	  echo "<br><br><a href='".getLeonardoLink(array('op'=>'delete_flight','flightID'=>$flightID,'confirmed'=>'1'))."'>"._YES."</a> | <a href='javascript:history.go(-1)'>"._NO."</a>";
	  echo "<br></div>";
	  closeMain();
  }
  
?>
