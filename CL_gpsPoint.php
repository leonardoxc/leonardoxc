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
/************************************************************************/
require_once dirname(__FILE__)."/CL_actionLogger.php";

class gpsPoint {
	var $waypointID;
	var $name;
	var $intName;
    var $gpsTime;
	var $lat;
    var $lon;  
    var $varioAlt;  
	var $gpsAlt;  
	var $timezone;
	function gpsPoint($line="",$timezone=0) {	
		$this->timezone=$timezone;
		//echo "@".$line."@<br>";
		if ($line{0}!='B') return;
		// if ( $line{15} != '0') return; // WHY was that here ??
        if ( ($line{14} != 'N') && ($line{14} != 'S')) return;
        if ( ($line{23} != 'E') && ($line{23} != 'W')) return;
        if ( strlen($line) < 23) return;
		 
        if ($line{14}=='N') $signlat = 1.0;
        if ($line{14}=='S') $signlat = -1.0;
        if ($line{23}=='W') $signlon = 1.0;
        if ($line{23}=='E') $signlon = -1.0;

//           1         2         3
// 01234567890123456789012345678901234
// B1153374029686N02313134EA0000000912
//        *     *  *     *  #####*****        

		// get lat lon
   		$this->lat = $signlat * $this->getlatlon(substr($line,7,7) );
		$this->lon = $signlon * $this->get_lon(substr($line,15,8)); // why 16,7 should be 15,8
               
		// echo "gpsPoint (lat,lon) : ".$this->lat .",".$this->lon."<BR>";

		// get time
        $seconds = substr($line,5,2);
        $minutes = substr($line,3,2);
		$hours   = substr($line,1,2);       
		$this->gpsTime = $seconds + 60*$minutes + 3600*$hours;

		$this->varioAlt=substr($line,25,5);
		$this->gpsAlt=substr($line,30,5);			
	}		

	// because of a stupid initial degisn choice i made
	// lon is used reversed inside leonardo.
	// new code must use this function to get the correct value 
	// instread of negating lon incode.
	function lon(){
		return -$this->lon+0;
	}
	function lat(){
		return $this->lat+0;
	}
	function setLon($lon){
		$this->lon=-$lon;
	}
	function setLat($lat){
		$this->lat=$lat;
	}


	function getlatlon($str) {
      $latlon = substr($str,2) / 60000.0;
      $latlon += substr($str,0,2);
      return $latlon;
   }

	function get_lon($str) {
      $lon = substr($str,3) / 60000.0;
      $lon += substr($str,0,3);
      return $lon;
   }

	function getAlt($varioPrefered=0) {
	  if ($varioPrefered) {
		  if ($this->varioAlt>0 ) return $this->varioAlt+0;
		  else return $this->gpsAlt+0;
	  } else {
		  if ($this->gpsAlt >0 ) return $this->gpsAlt+0;
		  else return $this->varioAlt+0;
	  }
	}

	function getTime() {
	  // compute Local Time
//	  $localTime= $this->gpsTime +  ($this->timezone*60*60);
//	  if (  $localTime<0)   $localTime+=24*60*60;

	  $localTime= ( 86400 + $this->gpsTime +  ($this->timezone*60*60) ) % 86400 ;
	  return $localTime;
	}

   function calc_distance($lat1, $lon1,$lat2, $lon2) { // in metern 
	  // echo "calc_distance : ".$lat1." ".$lon1." ".$lat2." ".$lon2."<br>";
  	  $pi_div_180 = M_PI/180.0;
      $d_fak = 6371000.0;  // FAI Erdradius in Metern 
	  //  Radius nautischen Meilen: ((double)1852.0)*((double)60.0)*((double)180.0)/((double)M_PI); 
      $d2    = 2.0;
      $latx = $lat1 * $pi_div_180; 
	  $lonx = $lon1 * $pi_div_180;
      $laty = $lat2 * $pi_div_180; 
	  $lony = $lon2 * $pi_div_180;
      $sinlat = sin(($latx-$laty)/$d2);
      $sinlon = sin(($lonx-$lony)/$d2);
      return $d2*asin(sqrt( $sinlat*$sinlat + $sinlon*$sinlon*cos($latx)*cos($laty)))*$d_fak;
   }

	function calcDistance($secondPoint) {
		return $this->calc_distance($this->lat,$this->lon,$secondPoint->lat,$secondPoint->lon);
	}

	function getUTM() {
		return	utm(-$this->lon,$this->lat);
	}

	function getLatMin() {
		 // "N43:45.419"
		 $coord_tmp =$this->lat; 		
		 if ($coord_tmp >=0) $i=floor($coord_tmp); 		
		 else $i=ceil($coord_tmp); 		

		 $f=abs(($coord_tmp-$i)*60);
		 return sprintf("%s%d:%06.5f", (($i>=0)?"N":"S"),abs($i), $f);
	}

	function getLonMin() {
		 $coord_tmp=-$this->lon;
		 if ($coord_tmp >=0) $i=floor($coord_tmp); 		
		 else $i=ceil($coord_tmp); 		

		 $f=abs(($coord_tmp-$i)*60); 
		 return sprintf("%s%d:%06.5f", (($i>=0)?"E":"W"),abs($i), $f);
	}

	function getLatMinDec($compact=0) {
		 $coord_tmp =$this->lat; 		
		 if ($coord_tmp >=0) $i=floor($coord_tmp); 		
		 else $i=ceil($coord_tmp); 		

		 $f=abs(($coord_tmp-$i)*60);
		 if ($compact) 
			 return sprintf("%02d%02d%03d%s", abs($i), floor($f), floor( ($f-floor($f)) *1000 ), ($i>=0)?"N":"S");
		 else
			 return sprintf("%s %d° %06.5f'\n", (($i>=0)?"N":"S"),abs($i), $f);
	}

	function getLonMinDec($compact=0) {
		 $coord_tmp=-$this->lon;
		 if ($coord_tmp >=0) $i=floor($coord_tmp); 		
		 else $i=ceil($coord_tmp); 		

		 $f=abs(($coord_tmp-$i)*60); 
		 if ($compact) 
			 return sprintf("%03d%02d%03d%s", abs($i), floor($f), floor( ($f-floor($f)) *1000 ), ($i>=0)?"E":"W");
		 else
		 	return sprintf("%s %d° %06.5f'\n", (($i>=0)?"E":"W"),abs($i), $f);
	}

	function getLatDMS() {

		 $coord_tmp=$this->lat;
		 if ($coord_tmp >=0) $i=floor($coord_tmp); 		
		 else $i=ceil($coord_tmp); 		

		 $minutes=abs(($coord_tmp-$i)*60); 
		 $seconds=($minutes-floor($minutes)) *60;
		 return sprintf("%s %d° %02d' %02.1f\"", (($i>=0)?"N":"S"),abs($i), floor($minutes),$seconds);

	}
	function getLonDMS() {
		 $coord_tmp=-$this->lon;
		 if ($coord_tmp >=0) $i=floor($coord_tmp); 		
		 else $i=ceil($coord_tmp); 		

		 $minutes=abs(($coord_tmp-$i)*60); 
		 $seconds=abs($minutes-floor($minutes)) *60;
		 return sprintf("%s %d° %02d' %02.1f\"", (($i>=0)?"E":"W"),abs($i), floor($minutes),$seconds);

	}

	function to_IGC_Record() {
		// make this string 
		// B125651 4029151N 02310255E A00000 00486
		// from N40:29.151 E23:10.255
		$latStr=$this->getLatMinDec(1);
		$lonStr=$this->getLonMinDec(1);

		$h=floor($this->gpsTime/3600);
		$m=floor( ($this->gpsTime%3600) / 60 );
		$s=$this->gpsTime%60;

		
		$pointString=sprintf("B%02d%02d%02d%8s%8sA%05d%05d",
			$h,$m,$s,
			$latStr,$lonStr,
			$this->varioAlt, $this->gpsAlt );
	
		return $pointString;
	}		

	function fromStr($str) {
		$pointString=explode(" ",$str);
		// make this string 
		// B1256514029151N02310255EA0000000486
		// from N40:29.151 E23:10.255
		preg_match("/([NS])(\d+):(\d+)\.(\d+) ([EW])(\d+):(\d+)\.(\d+)/",$str,$matches);

		$lat=preg_replace("/[NS](\d+):(\d+)\.(\d+)/","\\1\\2\\3",$pointString[0]);
		$lon=preg_replace("/[EW](\d+):(\d+)\.(\d+)/","\\1\\2\\3",$pointString[1]);

		$pointStringFaked=sprintf("B125959%02d%02d%03d%1s%03d%02d%03d%1sA0000000500",$matches[2],$matches[3],$matches[4],$matches[1],
			$matches[6],$matches[7],$matches[8],$matches[5] );

		return new gpsPoint( $pointStringFaked , 0 );	
	}

}	 // end class gpsPoint

class waypoint extends gpsPoint {
	var $type;
	var $countryCode;
	var $name;
	var $intName;
	var $location;
	var $intLocation;
	var $link;
	var $description;
	var $modifyDate;

/* should add

Nearest city 1
distance
time
Nearest city 2
Nearest village 1
How to get there 

type of flying: mountain desert flatland ridge coastal
Launch: easy normal hard
Landing: easy normal hard

Height Difference 
Wind direction SE, S, SW
Best flying season

Local club and/or pilot 
Remarks:

required rating
access to launch (by car, foot, 4x4)
Time to launch from landing

*/
	function waypoint($id="") {
		$this->gpsPoint(); 	  
		if ($id!="") {
			$this->waypointID=$id;
		}
	}

	function fillFromArray($ar){
		foreach ($ar as $name=>$val){
			$this->{$name}=$val;
		}
	}

	function getFromDB() {
		global $db,$waypointsTable;
		# Martin Jursa 20.05.2007: avoid sql error if waypointID is not given
		if (!$this->waypointID) {
			return;
		}else {
			$res= $db->sql_query("SELECT * FROM $waypointsTable WHERE ID=".$this->waypointID );
	  		if($res <= 0){
			     return;
		    }

		    $wpInfo = $db->sql_fetchrow($res);

			$this->lat =$wpInfo['lat'];
			$this->lon =$wpInfo['lon'];
			$this->name =$wpInfo['name'];
			$this->type =$wpInfo['type'];
			$this->intName =$wpInfo['intName'];
			$this->location =$wpInfo['location'];
			$this->intLocation =$wpInfo['intLocation'];
			$this->countryCode =$wpInfo['countryCode'];
			$this->link =$wpInfo['link'];
			$this->description =$wpInfo['description'];
			$this->modifyDate=$wpInfo['modifyDate'];
		}
    }

	function exportXML() {	
		$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].getRelMainFileName()."&op=show_waypoint&waypointIDview=".$this->waypointID);
	
return "<waypoint>
<id>".htmlspecialchars($this->waypointID)."</id>
<name>".htmlspecialchars($this->name)."</name>
<intName>".htmlspecialchars($this->intName)."</intName>
<location>".htmlspecialchars($this->location)."</location>
<intLocation>".htmlspecialchars($this->intLocation)."</intLocation>
<countryCode>".htmlspecialchars($this->countryCode)."</countryCode>
<type>".htmlspecialchars($this->type)."</type>
<lat>".htmlspecialchars($this->lat)."</lat>
<lon>".htmlspecialchars(-$this->lon)."</lon>
<link>".htmlspecialchars($this->link)."</link>
<displayLink>".$link."</displayLink>
<description>".htmlspecialchars($this->description)."</description>
<modifyDate>".htmlspecialchars($this->modifyDate)."</modifyDate>
</waypoint>";
	
	}

	function delete() {
		global $userID,$CONF_server_id,$waypointsTable ,$db,$flightsTable;
		// we get the info from db in order to log it
		if (!$this->name) $this->getFromDB() ;

		$query="DELETE from $waypointsTable  WHERE ID=".$this->waypointID." ";
		$res= $db->sql_query($query);

		$log=new Logger();
		$log->userID  	=$userID;
		$log->ItemType	=4 ; // waypoint; 
		$log->ItemID	= $this->waypointID;
		$log->ServerItemID	=$CONF_server_id ;
		$log->ActionID  =4;  //4  =>delete
		$log->ActionXML	=$this->exportXML();
		$log->Modifier	= 0;
		$log->ModifierID= 0;
		$log->ServerModifierID =0;
		$log->Result = ($res<=0)?0:1;
		$log->ResultDescription ="";
		
		if (!$log->put()) { 
			echo "Problem in logger<BR>";
		}

	    if($res <= 0){
		  echo "Error deleting waypoint from DB<BR>";
		  return 0;
	    }
		

		$query="SELECT ID FROM $flightsTable WHERE takeoffID=".$this->waypointID." OR landingID=".$this->waypointID." ";
		// echo $query;
		$res= $db->sql_query($query);	
	    if($res <= 0){
		  echo "Error getting flights with deleted waypoint <BR>";
		  return 0;
	    }		
		$waypoints=getWaypoints();
		global $waypoints;
		while(  $row = $db->sql_fetchrow($res)) {
			$flightID=$row['ID'];
			$flight=new flight();
			$flight->getFlightFromDB($flightID);
			$flight->updateTakeoffLanding();
		}
		return 1;		
	}

	function putToDB($update=0) {
		global $db,$waypointsTable,$CONF_server_id,$userID;

		if ($update) {
			$query="REPLACE INTO ";		
			$fl_id_1="ID, modifyDate,";
			$this->modifyDate= date("Y-m-d H:i:s"); 
			$fl_id_2=$this->waypointID.", now(), ";
		}else {
			$query="INSERT INTO ";		
			$fl_id_1="modifyDate,";
			$fl_id_2="now(),";
			$this->modifyDate= date("Y-m-d H:i:s"); 
		}


		$query.=" $waypointsTable 
					   ( $fl_id_1 name ,intName, lat,lon, type, location ,intLocation ,countryCode , link, description ) 
				VALUES ( $fl_id_2 '".prep_for_DB($this->name)."', '".prep_for_DB($this->intName) ."', ".$this->lat .", ".$this->lon." , ".$this->type.", 
						'".prep_for_DB($this->location)."', '".prep_for_DB($this->intLocation )."', '".prep_for_DB($this->countryCode) .
						"' , '".prep_for_DB($this->link )."' , '".prep_for_DB($this->description) ."'  )";
		// echo $query;
	    $res= $db->sql_query($query);
		
		if (!$update) $this->waypointID=mysql_insert_id();

		$log=new Logger();
		$log->userID  	=$userID;
		$log->ItemType	=4 ; // waypoint; 
		$log->ItemID	= $this->waypointID;
		$log->ServerItemID	=$CONF_server_id ;
		$log->ActionID  =$update?2:1;  //1  => add  2  => edit;
		$log->ActionXML	=$this->exportXML();
		$log->Modifier	= 0;
		$log->ModifierID= 0;
		$log->ServerModifierID =0;
		$log->Result = ($res<=0)?0:1;
		$log->ResultDescription ="";
		
		if (!$log->put()) { 
			echo "Problem in logger<BR>";
		}
		
		
	    if($res <= 0){
		  echo "Error putting waypount to DB $query<BR>";
		  return 0;
	    }					
		return 1;
    }

}

?>