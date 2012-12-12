<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: CL_job.php,v 1.1 2012/01/16 07:21:23 manolis Exp $                                                                 
//
//************************************************************************


	
class leoJob {
	function leoJob() {

	}

	function addJob($args){
		global $CONF,$db,$jobsTable;

		$query="INSERT  INTO ";		
		$fl_id_1="";
		$fl_id_2="";

		$query.=" $jobsTable  ( ";
		foreach ($args as $nameStr=>$valStr) {
				$query.= $nameStr.",";	
				$query2.= "'".prep_for_DB($valStr)."',";	
		}
		$query=substr($query,0,-1);
		$query2=substr($query2,0,-1);
		$query.= " ) VALUES ( ".$query2." ) ";
		
		//echo $query;
	    $res= $db->sql_query($query);
	    if($res <= 0){
		  echo "Error adding job to queue : $query<BR>";
		  return 0;
	    }		
			
		return 1;
					
	}
	function searchJob($args) {
		global $CONF,$db,$jobsTable;

		$query="SELECT * FROM $jobsTable WHERE  ";		
		
		
		foreach ($args as $nameStr=>$valStr) {
			if (in_array($nameStr,array('jobID','jobType','param1','param2'))) {
				$query.= $nameStr."=";	
				$query.= "'".prep_for_DB($valStr)."' AND ";
			}	
		}
		$query=substr($query,0,-4);
					
		//echo $query;
	    $res= $db->sql_query($query);
	    if($res <= 0){
		  echo "Error in searchJob: $query<BR>";
		  return 0;
	    }		
		if ( $row = $db->sql_fetchrow($res) ) 			
			return $row['timeCreated'];
		else 
			return 0;
	}
	
	
	function deleteJob(){
		global $CONF,$db;
		
	}
	
	function getJobsCount() {
		global $CONF,$db,$jobsTable;
		$query="SELECT count(*) as num FROM $jobsTable WHERE status=0";
		$res= $db->sql_query($query);
	    if($res <= 0){
		  echo "Error in getJobsCount: $query<BR>";
		  return 0;
	    }		
		if ( $row = $db->sql_fetchrow($res) ) 			
			return $row['num'];
		else 
				return -1;
				
	}
	
	function updateJob($jobID) {
		global $CONF,$db,$jobsTable;
		$jobID+=0;
		$query="UPDATE $jobsTable set status=1,timeProccessed='".gmdate("Y-m-d H:i:s")."' WHERE jobID=$jobID";
		$res= $db->sql_query($query);
	    if($res <= 0){
		  echo "Error in updateJob: $query<BR>";
		  return 0;
	    }		
		return 1;
				
	}
	
	function getJobs($limit){
		global $CONF,$db,$jobsTable;
		
		if ($limit) $limitStr=" LIMIT $limit";
		else $limitStr='';
		$query="SELECT * FROM $jobsTable WHERE status=0 ORDER BY timeCreated ASC $limitStr";		
		$res= $db->sql_query($query);
		if($res <= 0){
		  echo "Error in getJobs: $query<BR>";
		  return array();
	    }		
	    
	    $jobs=array();
		while ( $row = $db->sql_fetchrow($res) ) {
			$jobs[]=$row;
		}			
		return $jobs;
		
	}
	
	function getNextJob(){
		global $CONF,$db;
		
	}
	
	function proccessJob(){
		
	}
	
}

?>
