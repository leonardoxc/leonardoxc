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
// $Id: CL_brands.php,v 1.14 2010/03/16 13:00:12 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__).'/FN_brands.php';

class brands {

	function makeWhereClause($brandID,$returnLegend=0) {
		// global $CONF;
		if ( $brandID) {
			$where_clause=' AND gliderBrandID='.$brandID ;
			$legend='';
		}	else {
			$where_clause='';
			$legend='';
		}

		if ($returnLegend) 
			return array($where_clause,$legend);
		else
			return $where_clause;
	}
	
	function getBrandText($brandID,$gliderName='',$glidetCat=0){
		global $moduleRelPath,$CONF_abs_path,$CONF;
				
		if (!$brandID) {
			$brandID=brands::guessBrandID($gliderName);	
			$brandName='';
		}
		
		if ($brandID) {
			if (!isset($brandName) ) $brandName=$CONF['brands']['list'][$brandID];
	 		$gliderBrandImg="$brandName $gliderName";
		} else 
	 		$gliderBrandImg="$gliderName";
			
		return $gliderBrandImg;
	}


	function getBrandImg($brandID,$gliderName='',$glidetCat=0){
		global $moduleRelPath,$CONF_abs_path,$CONF;
				
		if (!$brandID) {
			$brandID=brands::guessBrandID($gliderName);	
			$brandName='';
		}
		
		if ($brandID) {
			if (!isset($brandName) ) $brandName=$CONF['brands']['list'][$brandID];
			if (is_file("$CONF_abs_path/img/brands/".sprintf("%03d",$brandID).".gif") ) {
		 		$gliderBrandImg="<img align='absmiddle' src='$moduleRelPath/img/brands/".sprintf("%03d",$brandID).".gif' title='$brandName $gliderName' alt='$brandName $gliderName'  border='0' />";
				
				$gliderBrandImg=leoHtml::img(sprintf("%03d",$brandID).".gif",0,0,'absmiddle',"$brandName $gliderName",'brands');
		 		// $gliderBrandImg="<img align='absmiddle' class='brands sprite-".sprintf("%03d",$brandID)."' src='$moduleRelPath/img/space.gif' title='$brandName $gliderName' alt='$brandName $gliderName'  border='0' />";

			} else {
	 			$gliderBrandImg="<img align='absmiddle' src='$moduleRelPath/img/space.gif' width=6 height=16 title='$brandName $gliderName' alt='$brandName $gliderName'  border='0' />";
			}
		} else 
	 		$gliderBrandImg="<img align='absmiddle'  src='$moduleRelPath/img/brands/unknown_".sprintf("%03d",$glidetCat).".gif' title='$gliderName'  alt='$gliderName' border='0' />";
		return $gliderBrandImg;
	}

    static  function getGliderName($gliderID,$showBrand=0,$showCert=0,$showSize=1){
        global $db,$CONF_glider_certification_categories;


        $row=brands::getGliderInfo($gliderID);

        if ($row['gliderName']) {
            if ($showBrand) {
                $gBrand=$row['brandName'];
                if ($gBrand) $gBrand=$gBrand.' ';

            }
            if ($showSize) {
                $gSize= $row['gliderSize'];
                if ($gSize) $gSize=" - "+$gSize;
            }
            if ($showCert) {
                $gCert= $row['gliderCert'];
                if ($gCert) $gCert=" ["+$CONF_glider_certification_categories[$gCert]+"]";
            }
            return $row['gliderName']."$gSize$gCert";
        }
        return '';


    }

    static function getGliderInfo($gliderID){
        global $db,$CONF_glider_certification_categories;


        $query="SELECT * FROM  leonardo_gliders,leonardo_brands
                Where leonardo_gliders.brandID	=leonardo_brands.brandID
                    AND gliderID=$gliderID";
        $res= $db->sql_query($query);
        $rows = array();
        if($res > 0){
            if  ($row = mysql_fetch_assoc($res)) {

                $info['brandName']=$row['brandName'];
                $info['gliderSize']=$row['gliderSize'];
                $info['gliderCert']=$row['gliderCert'];
                $info['gliderName']=$row['gliderName'];
                $info['brandID']=$row['brandID'];

                return $info;
            }
        }
        return array();


    }

    function getBrandsListFromDB(){
        global $CONF,$db;
        $CONF['brands']['list']=array();
        $query="SELECT * FROM  leonardo_brands order by brandID ASC";
        $res= $db->sql_query($query);
        $rows = array();
        if($res > 0){
            while ($row = mysql_fetch_assoc($res)) {
                $CONF['brands']['list'][$row['brandID']] = $row['brandName'];
            }
        }

    }

	function getBrandsList($forFilterUse=0){
		global $CONF;
		if ($forFilterUse && ! $CONF['brands']['showAll']) {	
			foreach( $CONF['brands']['filterList'] as $id ) {
					$brandsList[ $CONF['brands']['list'][$id] ]=$id;
			}
		} else {
			foreach( $CONF['brands']['list'] as $id=>$brand ) {
					$brandsList[$brand]=$id;
			}
		}
		ksort($brandsList);
		return  $brandsList;	
	}

	function isValidBrandForFilter($brandID) {
		global $CONF;
		if (!$CONF['brands']['filter_brands']) return 0;
		
		if ( in_array($brandID,$CONF['brands']['filterList']) || $CONF['brands']['showAll']   ) return 1;
		else return 0;
	}

    function removeBrandFromName($gliderDesc,$brandID){
        global  $CONF;
        $gliderDesc=str_ireplace($CONF['brands']['list'][$brandID],'',$gliderDesc);
        return trim($gliderDesc);
    }

	function guessBrandID($gliderDesc){		
		global  $CONF;
		// if (!is_array($brandsList[$gliderType]) ) return 0;
		
		$gliderDesc=strtolower($gliderDesc);
		//$gliderDesc=str_replace(" ","",$gliderDesc);
		$gliderDesc=preg_replace('/[^\w]/','',$gliderDesc);
	
		//echo "detect for $gliderDesc : ";
		foreach($CONF['brands']['list'] as $brandID=>$brandName) {
			//echo "trying  $brandID=>$brandName <BR>";
			if (  ! ( strpos($gliderDesc,strtolower($brandName) ) === false ) ) {
				// echo "found ID $brandID<BR>";
				return $brandID;
			}
		
		}
		return 0;
	}

	function sanitizeGliderName($gliderName) {
        global $CONF;
		$gliderNameNorm=trim( preg_replace("/[\/\-\,\.]/",' ',$gliderName) );
		$gliderNameNorm=preg_replace("/( )+/",' ',$gliderNameNorm);
		
		$gliderNameNorm=preg_replace("/(III)/",'3',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/(II)/",'2',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](one)/",'1',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](two)/",'2',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](three)/",'3',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](four)/",'4',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](five)/",'5',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](six)/",'6',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](seven)/",'7',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](eight)/",'8',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](nine)/",'9',$gliderNameNorm);
		
		$gliderNameNorm=ucwords(strtolower($gliderNameNorm));
		return $gliderNameNorm;
	}


    static function find_similar_gliders($gliderName,$threshold=50) {
        global $db;
        $max_percent=0;
        $best_match_Name='';
        $best_match_id=0;

        $query="SELECT * FROM  leonardo_gliders, leonardo_brands WHERE leonardo_gliders.brandID	= leonardo_brands.brandID";
        // echo $query;
        $res= $db->sql_query($query);
        $gliderList = array();
        if($res > 0){
            while ($row = mysql_fetch_assoc($res)) {
                $gliderList[ $row['gliderID'] ] = $row;
            }
        }

        $list=array();
        foreach ( $gliderList as $gliderID=>$row) {
            $tmpName=$row['gliderName'];
            // $tmpName=$row['gliderName'];
            $similar_index = similar_text ( $gliderName, $tmpName , &$percent  );

           // echo "$percent <BR>";
            if ($percent>$threshold) {
                $row['percent']=$percent;
                $list[]=$row;
            }
/*
            if ($percent>$max_percent) {
                $max_percent=$percent;
                $best_match_id=$gliderID;
                $best_match_Name=$tmpName;
            }
*/
        }
        // echo count ($list);
        usort($list,"percent_sort_compare");
        return $list;
        // return array($best_match_Name,$max_percent, $best_match_id);
    }
}

function percent_sort_compare ($a,$b) {
    if ($a['percent'] == $b['percent']) {
        return 0;

    }
    //descending order
    return ($a['percent'] < $b['percent']) ? 1 : -1;
}

?>