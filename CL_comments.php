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
// $Id: CL_comments.php,v 1.1 2010/10/18 14:05:21 manolis Exp $                                                                 
//
//************************************************************************


class flightComments {
	var $flightID;
	var $commentsNum;
	var $comments;

	var $valuesArray;
	var $gotValues;

	function flightComments($flightID="") {
		if ($flightID!="") {
			$this->flightID=$flightID;
		}

	    //$this->valuesArray=array("flightID","path","name","description");

		$this->gotValues=0;
		$this->commentsNum=0;
		$this->comments=array();
	}

	
	function addComment($num,$path,$name,$description,$updateFlightsTable=1) {
		global $db,$commentsTable,$flightsTable;
		// $this->comments[$this->commentsNum]['ID']=$row['ID'];
		$this->comments[$num]['path']=$path;
		$this->comments[$num]['name']=$name;
		$this->comments[$num]['description']=$description;
		$this->commentsNum++;	

		$query="INSERT INTO $commentsTable  (flightID,path,name,description) VALUES (".
			$this->flightID.",'".prep_for_DB($path)."','".
								 prep_for_DB($name)."','".
								 prep_for_DB($description)."' ) ";
	
		// echo $query;
		$res= $db->sql_query($query);
		if($res <= 0){
		  echo "Error putting comment for flight ".$this->flightID." to DB: $query<BR>";
		  return 0;
		}		

		$newID=$db->sql_nextid();
		$this->comments[$num]['ID']=$newID;

		if ($updateFlightsTable) {
			$query="UPDATE $flightsTable SET commentsNum=".$this->commentsNum." WHERE ID=".$this->flightID;
			$res= $db->sql_query($query );
			if($res <= 0){   
				 echo "Error updating hascomments for flight ".$this->flightID." : $query<BR>";
			}
		}	

		return $newID;	
	}

	function deleteComment($commentNum,$updateFlightsTable=1) {
		if (!$this->gotValues) $this->getFromDB();
		
	
		global $db,$commentsTable,$flightsTable;
		
		if ($updateFlightsTable) {
			$res= $db->sql_query("UPDATE $flightsTable SET commentsNum=commentsNum-1 WHERE ID=".$this->flightID );
			if($res <= 0){   
				 echo "Error updating hascomments for flight".$this->flightID."<BR>";
			}
		}		
		
		// echo "###".$this->comments[$commentNum]['ID'];
		$res= $db->sql_query("DELETE FROM  $commentsTable WHERE ID=".$this->comments[$commentNum]['ID'] );
  		if($res <= 0){   
			 echo "Error deleting comment $commentNum for flight".$this->flightID."<BR>";
	    }
		unset($this->comments[$commentNum]);

	}

	function deleteAllComments($updateFlightsTable=1) {
		global $db,$commentsTable,$flightsTable;

		if (!$this->gotValues) $this->getFromDB();
					
		
		if ($updateFlightsTable) {
			$res= $db->sql_query("UPDATE $flightsTable SET commentsNum=0 WHERE ID=".$this->flightID );
			if($res <= 0){   
				 echo "Error updating hascomments for flight ".$this->flightID."<BR>";
			}
		}		
		
		$res= $db->sql_query("DELETE FROM  $commentsTable WHERE flightID=".$this->flightID );
  		if($res <= 0){   
			 echo "Error deleting comments for flight".$this->flightID."<BR>";
	    }


	}
	
	function getFromDB() {
		global $db,$commentsTable;
		$res= $db->sql_query("SELECT * FROM $commentsTable WHERE flightID=".$this->flightID ." ORDER BY ID ASC");
  		if($res <= 0){   
			 echo "Error getting comments from DB for flight".$this->flightID."<BR>";
		     return 0;
	    }

		$this->commentsNum=0;
	    while ($row = $db->sql_fetchrow($res) ) {
			$this->comments[$this->commentsNum]['ID']=$row['ID'];
			$this->comments[$this->commentsNum]['path']=$row['path'];
			$this->comments[$this->commentsNum]['name']=$row['name'];
			$this->comments[$this->commentsNum]['description']=$row['description'];
			$this->comments[$this->commentsNum]['lat']=$row['lat'];
			$this->comments[$this->commentsNum]['lon']=$row['lon'];
			$this->comments[$this->commentsNum]['alt']=$row['alt'];
			$this->comments[$this->commentsNum]['tm']=$row['tm'];
			//print_r($this->comments[$this->commentsNum]);
			$this->commentsNum++;			
		}

		$this->gotValues=1;
		return 1;
    }

	function putToDB($updateFlightsTable=1) {
		global $db,$commentsTable,$flightsTable;

		// if (!$this->gotValues) $this->getFromDB();
		
		$query="DELETE FROM  $commentsTable WHERE flightID=".$this->flightID;
		//echo $query;
		$res= $db->sql_query( $query);
  		if($res <= 0){   
			 echo "Error deleting comments for flight ".$this->flightID."<BR>";
	    }
		//print_r($this->comments);
		foreach ( $this->comments as $commentNum=>$commentInfo) {
			$query="INSERT INTO $commentsTable  (flightID,path,name,lat,lon,alt,tm,description) VALUES (".
				$this->flightID.",'".prep_for_DB($commentInfo['path'])."','".
									 prep_for_DB($commentInfo['name'])."',".
									 ($commentInfo['lat']+0).",".
									 ($commentInfo['lon']+0).",".
									 ($commentInfo['alt']+0).",".
									 ($commentInfo['tm']+0).",'".
									 prep_for_DB($commentInfo['description'])."' ) ";
		
			// echo $query;
			$res= $db->sql_query($query);
			if($res <= 0){
			  echo "Error putting comment for flight ".$this->flightID." to DB: $query<BR>";
			  return 0;
			}		
		}
		
		if ($updateFlightsTable) {
			$query="UPDATE $flightsTable SET commentsNum=".$this->commentsNum." WHERE ID=".$this->flightID;
			$res= $db->sql_query($query );
			if($res <= 0){   
				 echo "Error updating hascomments for flight ".$this->flightID." : $query<BR>";
			}
		}	
		
		$this->gotValues=1;			
		return 1;
    }

}

/*
$comments = array(  array('id'=>1, 'parent_id'=>NULL,   'text'=>'Parent'),
                    array('id'=>2, 'parent_id'=>1,      'text'=>'Child'),
                    array('id'=>3, 'parent_id'=>2,      'text'=>'Child Third level'),
                    array('id'=>4, 'parent_id'=>NULL,   'text'=>'Second Parent'),
                    array('id'=>5, 'parent_id'=>4,   'text'=>'Second Child')
                );

$threaded_comments = new Threaded_comments($comments);

$threaded_comments->print_comments();

*/
class Threaded_comments
{

    public $parents  = array();
    public $children = array();

    /**
     * @param array $comments
     */
    function __construct($comments)
    {
        foreach ($comments as $comment)
        {
            if ($comment['parent_id'] === NULL)
            {
                $this->parents[$comment['id']][] = $comment;
            }
            else
            {
                $this->children[$comment['parent_id']][] = $comment;
            }
        }
    }

    /**
     * @param array $comment
     * @param int $depth
     */
    private function format_comment($comment, $depth)
    {
        for ($depth; $depth > 0; $depth--)
        {
            echo "\t";
        }

        echo $comment['text'];
        echo "\n";
    }

    /**
     * @param array $comment
     * @param int $depth
     */
    private function print_parent($comment, $depth = 0)
    {
        foreach ($comment as $c)
        {
            $this->format_comment($c, $depth);

            if (isset($this->children[$c['id']]))
            {
                $this->print_parent($this->children[$c['id']], $depth + 1);
            }
        }
    }

    public function print_comments()
    {
        foreach ($this->parents as $c)
        {
            $this->print_parent($c);
        }
    }

}

?>