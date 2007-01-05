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


class Server {
	var $ID;

	var $isLeo ;
	var $installation_type;
	var $leonardo_version;
	var $url_base;
	var $url_op;
	var $admin_email;
	var $site_pass;
	var $is_active;
	var $gives_waypoints;
	var $waypoint_countries;

	var $valuesArray;
	var $gotValues;

	function Server($id="") {
		if ($id!="") {
			$this->ID=$id;
		}
	    $this->valuesArray=array("ID","isLeo","installation_type","leonardo_version","url_base",
			"url_op","admin_email","site_pass","is_active","gives_waypoints","waypoint_countries"
		);
		$this->gotValues=0;
	}

	function version() {
		if ($this->isLeo) {
			list($version,$sub_version,$revision)=explode(".",$this->leonardo_version);
			return array($version,$sub_version,$revision);
		} else return array(0,0,0);
    }

	function findTakeoff($lat,$lon) {
		list($version,$sub_version,$revision)=$this->version();
		if ($version>=2) { // new rpc method
			require_once dirname(__FILE__)."/lib/xml_rpc/IXR_Library.inc.php";
			require_once dirname(__FILE__)."/CL_gpsPoint.php";	
			$serverURL="http://".$this->url_op;
			$client = new IXR_Client($serverURL);
			// $client->debug=true;
		
			if ( ! $client->query('takeoffs.findTakeoff',$this->site_pass, $lat, $lon ) ) {
				echo 'findTakeoff: Error '.$client->getErrorCode()." -> ".$client->getErrorMessage();
				return array(0,-1);  // $client->getErrorCode();
			} else {
				$nearestWaypoint=new waypoint();	
				$nearestWaypoint=new gpsPoint();	
				list($nearestWaypoint,$minTakeoffDistance)= $client->getResponse();
echo "^".$nearestWaypoint->name;
				return array($nearestWaypoint,$minTakeoffDistance);
			}


		} else {


		}
		
	}
	function getServers() {
		global $db,$serversTable;
		$res= $db->sql_query("SELECT * FROM $serversTable order BY ID");
  		if($res <= 0){   
			 echo "Error getting all servers from DB<BR>";
		     return;
	    }

		$i=0;
	    while ($row= $db->sql_fetchrow($res) ) {
			$servers[$i]=new Server($row[$id]);
			foreach ($servers[$i]->valuesArray as $valStr) {
				$servers[$i]->$valStr=$row["$valStr"];
			}
			$servers[$i]->gotValues=1;
			$i++;
		}
		return $servers;
	}

	function getFromDB($id=0) {
		if (!$id) $id=$this->ID;

		global $db,$serversTable;
		$res= $db->sql_query("SELECT * FROM $serversTable WHERE ID=".$id );
  		if($res <= 0){   
			 echo "Error getting server from DB<BR>";
		     return;
	    }

	    $row= $db->sql_fetchrow($res);
		foreach ($this->valuesArray as $valStr) {
			$this->$valStr=$row["$valStr"];
		}
		$this->gotValues=1;
    }

	function putToDB($update=0) {
		global $db,$serversTable;

		if ($update) {
			$query="REPLACE INTO ";		
			$fl_id_1="ID,";
			$fl_id_2=$this->ID.", ";
		}else {
			$query="INSERT INTO ";		
			$fl_id_1="";
			$fl_id_2="";
		}


		$query.=" $serversTable  ( ";
		foreach ($this->valuesArray as $valStr) {
				$query.= $valStr.",";		
		}
		$query=substr($query,0,-1);

		$query.= " ) VALUES ( ";
		foreach ($this->valuesArray as $valStr) {
			$query.= "'".prep_for_DB($this->description)."',";
		}
		$query=substr($query,0,-1);
		$query.= " ) ";
		// echo $query;
	    $res= $db->sql_query($query);
	    if($res <= 0){
		  echo "Error putting server to DB<BR>";
		  return 0;
	    }		
		$this->gotValues=1;			
		return 1;
    }

}

?>