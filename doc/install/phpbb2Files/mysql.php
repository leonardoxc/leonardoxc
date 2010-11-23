<?php
/***************************************************************************
 *                                 mysql.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: mysql.php,v 1.2 2010/11/23 11:41:08 manolis Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if(!defined("SQL_LAYER"))
{

// uncommnet this to activate mirror reads for leonardo tables;
// define("READ_DB_P19","1") ;
// how to add 2nd slave
// http://www.redips.net/mysql/add-new-slave/

define("SQL_LAYER","mysql");
if (! function_exists(getmicrotime) ){

	function getmicrotime() {
	   list($usec, $sec) = explode(" ", microtime());
	   return ((float)$usec + (float)$sec);
	}

}

class sql_db
{

	var $db_connect_id;
	var $query_result;
	var $row = array();
	var $rowset = array();
	var $num_queries = 0;

	//var $db_connect_id_read;
		
	var $db_slaves=array();
	var $db_slaves_config=array(
		0=>array('hostname'=>'hostname1','dbname'=>'dbname1','user'=>'user','pass'=>'pass'=>false),
		// only for leonardo queries
		1=>array('hostname'=>'hostname2','dbname'=>'dbname2','user'=>'user','pass'=>'pass','useutf'=>true),		
	);
	var $db_slaves_num;

				
	//
	// Constructor
	//
	function sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true)
	{

		$this->persistency = $persistency;
		$this->user = $sqluser;
		$this->password = $sqlpassword;
		$this->server = $sqlserver;
		$this->dbname = $database;

		if($this->persistency)
		{
			$this->db_connect_id = @mysql_pconnect($this->server, $this->user, $this->password);
		}
		else
		{
			$this->db_connect_id = @mysql_connect($this->server, $this->user, $this->password);
		}
		if($this->db_connect_id)
		{
			if($database != "")
			{
				$this->dbname = $database;
				$dbselect = @mysql_select_db($this->dbname);
				if(!$dbselect)
				{
					@mysql_close($this->db_connect_id);
					$this->db_connect_id = $dbselect;
				}
			}
			if ( !defined("READ_DB_P19") ) return $this->db_connect_id;
		}
		else
		{
			return false;
		}
		
		if ( defined("READ_DB_P19") ) {
			foreach($this->db_slaves_config as $slave_num=>$slave_config) {
			
				$this->db_slaves[$slave_num]=array();
				
				if($this->persistency) {
					$this->db_slaves[$slave_num]['db_connect_id']=
								 @mysql_pconnect($slave_config['hostname'], $slave_config['user'], $slave_config['pass']);
				} else {
					$this->db_slaves[$slave_num]['db_connect_id']=
								 @mysql_connect($slave_config['hostname'], $slave_config['user'], $slave_config['pass']);
					//$this->db_connect_id_read = @mysql_connect('mysql2.s2', 'p19mysql', 'man1821');
				}
				
				if($this->db_slaves[$slave_num]['db_connect_id']) {
					if ( $slave_config['useutf'] ) {
						@mysql_query("SET NAMES 'utf8'",  $this->db_slaves[$slave_num]['db_connect_id'] );
					}
					
					$dbselect_read = @mysql_select_db($slave_config['dbname']);
					if(!$dbselect_read)	{
						echo "Cannot connect to sql server $slave_num<HR><HR>";
						@mysql_close( $this->db_slaves[$slave_num]['db_connect_id'] );
						$this->db_slaves[$slave_num]['db_connect_id'] = false;
					}
					
				}
			} // foreach
			
			$this->db_slaves_num=count($this->db_slaves);
		}
				
		return $this->db_connect_id;
	}

	//
	// Other base methods
	//
	function sql_close()
	{
		if($this->db_connect_id)
		{
			if($this->query_result)
			{
				@mysql_free_result($this->query_result);
			}
			$result = @mysql_close($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}

	//
	// Base query method
	//
	function sql_query($query = "", $transaction = FALSE)
	{

		global $DBGlvl;				
		if ($DBGlvl) { $start=getmicrotime(); }

		$q1=strtolower(trim($query));
		
		// is is SELECT 
		if ( defined("READ_DB_P19") && 
				substr($q1,0,7) == 'select ' // && strpos($q1,"from leonardo_")
			 )  
		{		
			global $sqlSlaveQueriesNum;
			$sqlSlaveQueriesNum++;
			
			// load balance reads between available slaves			
			// $slave_num_selected = $sqlSlaveQueriesNum % $this->db_slaves_num;
			
			$slave_num_selected =0; // use the first one by default
			if ( strpos($q1,"from leonardo_") ) {
				$slave_num_selected =1;
			}
			
			$selQuery=1;
			// $cid=$this->db_connect_id_read;
			$cid=$this->db_slaves[$slave_num_selected]['db_connect_id'];
			if (!$cid) {
				echo "<HR>Problem selecting db server $slave_num_selected<HR>";
			}
			// file_put_contents(dirname(__FILE__).'/../read_queries.txt',$query);
		} else {
			$selQuery=0;
			$cid=$this->db_connect_id;
		}
		
		
		// Remove any pre-existing queries
		unset($this->query_result);
		if($query != "")
		{
			$this->num_queries++;

			$this->query_result = @mysql_query($query, $cid);
		}
		if($this->query_result)
		{
			unset($this->row[$this->query_result]);
			unset($this->rowset[$this->query_result]);
			if ($DBGlvl) {
				global $sqlQueriesTime ,$sqlQueriesNum;
				$end=getmicrotime();
				$sqlQueriesTime+=$end-$start; 
				$sqlQueriesNum++;
			}
			return $this->query_result;
		}
		else
		{
			return ( $transaction == END_TRANSACTION ) ? true : false;
		}
	}

	//
	// Other query methods
	//
	function sql_numrows($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysql_num_rows($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_affectedrows()
	{
		if($this->db_connect_id)
		{
			$result = @mysql_affected_rows($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_numfields($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysql_num_fields($query_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldname($offset, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysql_field_name($query_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldtype($offset, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysql_field_type($query_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fetchrow($query_id = 0)
	{
		//global $DBGlvl;			
		//if ($DBGlvl) { $start=getmicrotime(); }

		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$this->row[$query_id] = @mysql_fetch_array($query_id);

			if ($DBGlvl ) {
				global $sqlFetchTime,$sqlFetchNum;
				$end=getmicrotime();
				$sqlFetchTime+=$end-$start;
				$sqlFetchNum++;
			}
			return $this->row[$query_id];
		}
		else
		{
			return false;
		}
	}
	function sql_fetchrowset($query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			unset($this->rowset[$query_id]);
			unset($this->row[$query_id]);
			while($this->rowset[$query_id] = @mysql_fetch_array($query_id))
			{
				$result[] = $this->rowset[$query_id];
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fetchfield($field, $rownum = -1, $query_id = 0)
	{
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			if($rownum > -1)
			{
				$result = @mysql_result($query_id, $rownum, $field);
			}
			else
			{
				if(empty($this->row[$query_id]) && empty($this->rowset[$query_id]))
				{
					if($this->sql_fetchrow())
					{
						$result = $this->row[$query_id][$field];
					}
				}
				else
				{
					if($this->rowset[$query_id])
					{
						$result = $this->rowset[$query_id][0][$field];
					}
					else if($this->row[$query_id])
					{
						$result = $this->row[$query_id][$field];
					}
				}
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_rowseek($rownum, $query_id = 0){
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}
		if($query_id)
		{
			$result = @mysql_data_seek($query_id, $rownum);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_nextid(){
		if($this->db_connect_id)
		{
			$result = @mysql_insert_id($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_freeresult($query_id = 0){
		if(!$query_id)
		{
			$query_id = $this->query_result;
		}

		if ( $query_id )
		{
			unset($this->row[$query_id]);
			unset($this->rowset[$query_id]);

			@mysql_free_result($query_id);

			return true;
		}
		else
		{
			return false;
		}
	}
	function sql_error($query_id = 0)
	{
		$result["message"] = @mysql_error($this->db_connect_id);
		$result["code"] = @mysql_errno($this->db_connect_id);

		return $result;
	}

} // class sql_db

} // if ... define

?>