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
// $Id: CL_flightPhotos.php,v 1.9 2010/01/02 22:54:55 manolis Exp $                                                                 
//
//************************************************************************


class flightPhotos {
	var $flightID;
	var $photosNum;
	var $photos;

	var $valuesArray;
	var $gotValues;

	function flightPhotos($flightID="") {
		if ($flightID!="") {
			$this->flightID=$flightID;
		}

	    //$this->valuesArray=array("flightID","path","name","description");

		$this->gotValues=0;
		$this->photosNum=0;
		$this->photos=array();
	}

// pathVersion =1 -> 76/photos/2005
// pathVersion =2 -> photos/2005/76
	function getPath($path){
		global $CONF;
		list($pilotID,$fname,$year)=split("/",$path);
		// $CONF['paths']['photos']='data/flights/photos/%YEAR%/%PILOTID%';
		$newPath=$CONF['paths']['photos'];
		$newPath=str_replace("%YEAR%",$year,$newPath);
		$newPath=str_replace("%PILOTID%",$pilotID,$newPath);
		return $newPath;
	}
	
	function changeUser($id,$newUser){
		$oldPath=$this->getPhotoAbsPath($id);
		list($pilotID,$fname,$year)=split("/",$this->photos[$id]['path']);
		$this->photos[$id]['path']="$newUser/$fname/$year";
		$newPath=$this->getPhotoAbsPath($id);
		@rename($oldPath,$newPath);
		@rename($oldPath.'.icon.jpg',$newPath.'.icon.jpg');
	}
	
	function getPhotoRelPath($id) {	
		global $moduleRelPath;
		if ($id>=$this->photosNum) return '';			
		return $moduleRelPath.'/'.$this->getPath($this->photos[$id]['path']).'/'.$this->photos[$id]['name'];	
	}

	function getPhotoAbsPath($id) {
		//global $flightsAbsPath;			
		if ($id >=$this->photosNum) return '';		
		// return $flightsAbsPath."/".$this->photos[$id]['path'].'/'.$this->photos[$id]['name'];	
		return LEONARDO_ABS_PATH.'/'.$this->getPath($this->photos[$id]['path']).'/'.$this->photos[$id]['name'];
	}

	function getSafeName($path,$photoName){
		$newName=toLatin1($photoName);
		if ( !is_file($path.'/'.$newName) ) return $newName;
		
		$i=1;
		do {
			$newNameTmp=preg_replace("/(\.jpg|\.jpeg)$/i","_$i\${1}",$newName);
			$i++;
		} while ( is_file($path.'/'.$newNameTmp) );
		
		return $newNameTmp;
	}
	
	
	function addPhoto($num,$path,$name,$description,$updateFlightsTable=1) {
		global $db,$photosTable,$flightsTable;
		// $this->photos[$this->photosNum]['ID']=$row['ID'];
		$this->photos[$num]['path']=$path;
		$this->photos[$num]['name']=$name;
		$this->photos[$num]['description']=$description;
		$this->photosNum++;	

		$query="INSERT INTO $photosTable  (flightID,path,name,description) VALUES (".
			$this->flightID.",'".prep_for_DB($path)."','".
								 prep_for_DB($name)."','".
								 prep_for_DB($description)."' ) ";
	
		// echo $query;
		$res= $db->sql_query($query);
		if($res <= 0){
		  echo "Error putting photo for flight ".$this->flightID." to DB: $query<BR>";
		  return 0;
		}		

		$newID=$db->sql_nextid();
		$this->photos[$num]['ID']=$newID;

		if ($updateFlightsTable) {
			$query="UPDATE $flightsTable SET hasPhotos=".$this->photosNum." WHERE ID=".$this->flightID;
			$res= $db->sql_query($query );
			if($res <= 0){   
				 echo "Error updating hasPhotos for flight ".$this->flightID." : $query<BR>";
			}
		}	

		return $newID;	
	}

	function deletePhoto($photoNum,$updateFlightsTable=1) {
		if (!$this->gotValues) $this->getFromDB();
		
	
		$imgNormal=$this->getPhotoAbsPath($photoNum);
		$imgIcon=$imgNormal.'.icon.jpg';
		@unlink($imgNormal); 
		@unlink($imgIcon); 			
	
		
		global $db,$photosTable,$flightsTable;
		
		if ($updateFlightsTable) {
			$res= $db->sql_query("UPDATE $flightsTable SET hasPhotos=hasPhotos-1 WHERE ID=".$this->flightID );
			if($res <= 0){   
				 echo "Error updating hasPhotos for flight".$this->flightID."<BR>";
			}
		}		
		
		// echo "###".$this->photos[$photoNum]['ID'];
		$res= $db->sql_query("DELETE FROM  $photosTable WHERE ID=".$this->photos[$photoNum]['ID'] );
  		if($res <= 0){   
			 echo "Error deleting photo $photoNum for flight".$this->flightID."<BR>";
	    }
		unset($this->photos[$photoNum]);

	}

	function deleteAllPhotos($updateFlightsTable=1) {
		global $db,$photosTable,$flightsTable;

		if (!$this->gotValues) $this->getFromDB();
		
		foreach ( $this->photos as $photoNum=>$photoInfo) {
			$imgNormal=$this->getPhotoAbsPath($photoNum);
			$imgIcon=$imgNormal.'.icon.jpg';
			@unlink($imgNormal); 
			@unlink($imgIcon); 			
		}
				
		
		if ($updateFlightsTable) {
			$res= $db->sql_query("UPDATE $flightsTable SET hasPhotos=0 WHERE ID=".$this->flightID );
			if($res <= 0){   
				 echo "Error updating hasPhotos for flight ".$this->flightID."<BR>";
			}
		}		
		
		$res= $db->sql_query("DELETE FROM  $photosTable WHERE flightID=".$this->flightID );
  		if($res <= 0){   
			 echo "Error deleting photos for flight".$this->flightID."<BR>";
	    }


	}
	
	function getFromDB() {
		global $db,$photosTable;
		$res= $db->sql_query("SELECT * FROM $photosTable WHERE flightID=".$this->flightID ." ORDER BY ID ASC");
  		if($res <= 0){   
			 echo "Error getting photos from DB for flight".$this->flightID."<BR>";
		     return 0;
	    }

		$this->photosNum=0;
	    while ($row = $db->sql_fetchrow($res) ) {
			$this->photos[$this->photosNum]['ID']=$row['ID'];
			$this->photos[$this->photosNum]['path']=$row['path'];
			$this->photos[$this->photosNum]['name']=$row['name'];
			$this->photos[$this->photosNum]['description']=$row['description'];
			//print_r($this->photos[$this->photosNum]);
			$this->photosNum++;			
		}

		$this->gotValues=1;
		return 1;
    }

	function putToDB($updateFlightsTable=1) {
		global $db,$photosTable,$flightsTable;

		// if (!$this->gotValues) $this->getFromDB();
		

		
		$res= $db->sql_query("DELETE FROM  $photosTable WHERE ID=".$this->flightID );
  		if($res <= 0){   
			 echo "Error deleting photos for flight ".$this->flightID."<BR>";
	    }
		
		foreach ( $this->photos as $photoNum=>$photoInfo) {
			$query="INSERT INTO $photosTable  (flightID,path,name,description) VALUES (".
				$this->flightID.",'".prep_for_DB($photoInfo['path'])."','".
									 prep_for_DB($photoInfo['name'])."','".
									 prep_for_DB($photoInfo['description'])."' ) ";
		
			// echo $query;
			$res= $db->sql_query($query);
			if($res <= 0){
			  echo "Error putting photo for flight ".$this->flightID." to DB: $query<BR>";
			  return 0;
			}		
		}
		
		if ($updateFlightsTable) {
			$query="UPDATE $flightsTable SET hasPhotos=".$this->photosNum." WHERE ID=".$this->flightID;
			$res= $db->sql_query($query );
			if($res <= 0){   
				 echo "Error updating hasPhotos for flight ".$this->flightID." : $query<BR>";
			}
		}	
		
		$this->gotValues=1;			
		return 1;
    }

}

?>