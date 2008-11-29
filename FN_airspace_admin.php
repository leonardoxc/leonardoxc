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
// $Id: FN_airspace_admin.php,v 1.7 2008/11/29 22:46:06 manolis Exp $                                                                 
//
//************************************************************************

/************************************************************************
	Airspace Code adapted from c++ from the xcsoar project 
	http://xcsoar.sourceforge.net/
************************************************************************/

require_once dirname(__FILE__)."/FN_airspace.php";


function  StoreAirspace() {
	global $AirspaceArea;
	//echo count($AirspaceArea)."#".memory_get_usage() . "\n"; 
	// print_r($AirspaceArea);

	$line1=serialize($AirspaceArea);
	$filename=dirname(__FILE__)."/airspace.dump";
    if (!$handle = fopen($filename, 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }
	if (fwrite($handle, $line1."\n") === FALSE) {
		echo "Cannot write to file ($filename)";
		exit;
	}    
	fclose($handle);
}

function putAirspaceToDB() {
	global $db,$AirspaceArea,$airspaceTable;
	
	if (count($AirspaceArea)==0) return 1;	


//$query="TRUNCATE TABLE $airspaceTable ";

	// set updated =0 so we then delete all areas not present in the new version
	$query="UPDATE TABLE $airspaceTable set updated=0 ";
	$res= $db->sql_query($query);
	
	//$query="TRUNCATE TABLE $airspaceTable ";

	// get 'Comments' and 'id' values
	$query="SELECT id,Comments,disabled, Name,serial FROM $airspaceTable ";
	$res= $db->sql_query($query);
	while ($row = mysql_fetch_assoc($res)){
		$data[$row['Name']][$row['serial']]['Comments']=$row['Comments'];
		$data[$row['Name']][$row['serial']]['disabled']=$row['disabled'];
		$data[$row['Name']][$row['serial']]['id']=$row['id'];
	}
	
	$names=array();
	
	for($i=0;$i<count($AirspaceArea);$i++) {
		
		$serial=$names[$AirspaceArea[$i]->Name]+0;
		$names[$AirspaceArea[$i]->Name]++;
	
		$id=$data[$AirspaceArea[$i]->Name][$serial]['id']+0;
		$Comments=$data[$AirspaceArea[$i]->Name][$serial]['Comments'];
		$disabled=$data[$AirspaceArea[$i]->Name][$serial]['disabled']+0;
		
	    //	print_r($AirspaceArea[$i]->Base);
		$fields=" id, Name, serial, updated,  Type, Shape, Comments, disabled, minx, miny, maxx, maxy , Base , Top, ";
		$values=" $id , '".$AirspaceArea[$i]->Name."' ,  $serial , 1, '".$AirspaceArea[$i]->Type."' , '".$AirspaceArea[$i]->Shape."', '".$Comments."', $disabled ,
					".$AirspaceArea[$i]->minx.", ".$AirspaceArea[$i]->miny.", ".$AirspaceArea[$i]->maxx.",  ".$AirspaceArea[$i]->maxy." ,
				 '".serialize($AirspaceArea[$i]->Base)."' ,'".serialize($AirspaceArea[$i]->Top)."' , ";
		if ($AirspaceArea[$i]->Shape==1) { //area
			$fields.=" Points";
			$values.=" '".serialize($AirspaceArea[$i]->Points)."' ";
		} else { // circle
			$fields.="Radius, Latitude, Longitude ";
			$values.=$AirspaceArea[$i]->Radius." , ".$AirspaceArea[$i]->Latitude." , ".$AirspaceArea[$i]->Longitude ;
		}
		$query="REPLACE into $airspaceTable ($fields) VALUES ($values) ";
		$res= $db->sql_query($query);
			
		if(!$res) {
			echo "Error in inserting airspace [$i] to DB: $query <BR>";
			print_r($AirspaceArea[$i]);
			return 0;
		}
	}
	
	// now delete areas not updated 
	$query="DELETE FROM $airspaceTable WHERE updated=0 ";
	$res= $db->sql_query($query);
	
	return 1;
}

function ReadAirspace($openairFilename) {

  global $Rotation ,$CenterX , $CenterY ,$Radius, $LineCount;
  global $NumberOfAirspaceAreas;
  global $bWaiting ;
  global $TempArea , $TempPoint, $TempString;
  
  DEBUG("checkAirspace",128,"ReadAirspace");


  $NumberOfAirspaceAreas=0;



  $TempString=array();
  $TempArea=new AIRSPACE_AREA();
  $TempPoint=new AIRSPACE_POINT();

  $LineCount = 0;
  $CenterY = $CenterX = $Radius = 0;
  $Rotation = 1;
  $bWaiting = true;

  DEBUG("checkAirspace",128,"Loading Airspace File...");


  $fp = fopen($openairFilename,"r");
  if (!$fp ) {
  	echo "Cannot read airspace file: $openairFilename<BR>";
	return 0;
  }
  
  while( ($nLineType = GetNextLine($fp, $TempString) )  >= 0 )
  {
		// DEBUG("checkAirspace",128,"GetNextLine(outside): type: $nLineType got: $TempString");	
		if ( !ParseLine($nLineType) ){
			DEBUG("checkAirspace",128,"Error in result from ParseLine()");
			return;
		}
  }
  // Process final area (if any).
  if (!$bWaiting) AddArea($TempArea);


  FindAirspaceBounds();
  // StoreAirspace();
  
}

function ParseLine($nLineType) {
	global $TempString,$LineCount;
	global $bWaiting;
	global $TempPoint, $TempArea,$NumberOfAirspaceAreas;
	global $Rotation ,$CenterX, $CenterY;
	// DEBUG("checkAirspace",128,"ParseLine: [$nLineType] $TempString");

	$k_strAreaStart = array("R",  "Q", "P", "A", "B", "C", "CTR","D", "GP", "W", "E", "F");
	$k_nAreaType = array( "RESTRICT", "DANGER", "PROHIBITED", "CLASSA", "CLASSB", "CLASSC", 
					"CTR","CLASSD", "NOGLIDER", "WAVE", "CLASSE", "CLASSF");


	switch ($nLineType)
	{
	case k_nLtAC:
		if (!$bWaiting)	AddArea();
		//unset($GLOBALS['TempArea']);
		//unset($TempArea);
		$TempArea->NumPoints = 0;
		$TempArea->Points = array();
		$TempArea->Type = OTHER;
		//echo "Set type: $TempString <BR>";
		for ($nIndex = 0; $nIndex < count($k_strAreaStart); $nIndex++) {
			if (StartsWith(substr($TempString,3), $k_strAreaStart[$nIndex]))	{
				$TempArea->Type = $k_nAreaType[$nIndex];
				break;
			}
		}
		// echo "type= ".$TempArea->Type."<BR>";
	  	$Rotation = +1;
		$bWaiting = false;
		break;

	case k_nLtAN:		
		$TempArea->Name=substr($TempString,3);
		// echo "[Name] type= ".$TempArea->Type."<BR>";
		break;

	case k_nLtAL:
		//$m1=memory_get_usage();
		ReadAltitude( substr($TempString,3) ,'Base');
		//$m2=memory_get_usage();
		//echo "ReadAltitude: mem usage: ".($m2-$m1)." AFTER: ".$m2."<BR>"; 
		//echo "[Alt base] type= ".$TempArea->Type."<BR>";
		break;

	case k_nLtAH:
		/// $TempArea->Top=ReadAltitude( substr($TempString,3) ,'Top' );
		ReadAltitude( substr($TempString,3) ,'Top' );
		break;

	case k_nLtV:
		// Need to set these while in count mode, or DB/DA will crash
		// DEBUG("checkAirspace",128,"found V");
		if( StartsWith(substr($TempString,2), "X=" ) || StartsWith(substr($TempString,2), "x=") ) {
			// DEBUG("checkAirspace",128,"will read coords");
			list ($res, $CenterX , $CenterY ) = ReadCoords( substr($TempString,4) );
			if ($res) break;
		} else if( StartsWith(substr($TempString,2),"D=-") || StartsWith(substr($TempString,2),"d=-") )	{
			$Rotation = -1;
	      break;
		} else if ( StartsWith(substr($TempString,2),"D=+") || StartsWith(substr($TempString,2),"d=+") ) {
			$Rotation = +1;
		    break;
		} else if(StartsWith(substr($TempString,2),"Z") || StartsWith(substr($TempString,2),"z") ) {
	      // ToDo Display Zool Level
	      break;
		} else if(StartsWith(substr($TempString,2),"W") || StartsWith(substr($TempString,2),"w")) {
     	  // ToDo width of an airway
		  break;
		} else if(StartsWith(substr($TempString,2),"T") || StartsWith(substr($TempString,2),"t") ) {
	      // ----- JMW THIS IS REQUIRED FOR LEGACY FILES
	      break;
		}

		DEBUG("checkAirspace",128, sprintf("Parse Error1 at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $TempString) );
		return 0;

	case k_nLtDP:
		// DEBUG("checkAirspace",128,"will read coods");
		list ($res, $TempPoint->Longitude , $TempPoint->Latitude ) = ReadCoords( substr($TempString,3) );
    	if (!$res)  {
			DEBUG("checkAirspace",128, sprintf("Parse Error2 at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $TempString) );
			return 0;
		}
  		AddPoint($TempPoint);
		break;

	case k_nLtDB:
		//$m1=memory_get_usage();
		CalculateArc($TempString);
		//$m2=memory_get_usage();
		//echo "CalculateArc: mem usage: ".($m2-$m1)." AFTER: ".$m2."<BR>"; 
		break;

	case k_nLtDA:
		CalculateSector($TempString);
		break;

	case k_nLtDC:
		$Radius = substr($TempString,2)+0;
		$Radius = $Radius * NAUTICALMILESTOMETRES;
		AddAirspaceCircle($CenterX, $CenterY, $Radius);
		$bWaiting = true;
		break;

	default:
		break;
	}

  return 1;
}

// Returns index of line type found, or -1 if end of file reached
function GetNextLine($fp, &$Text) {
	global $nLineType ;
	global $LineCount;
	$nLineType = -1;

	while ( $Text=fgets($fp, 300) ){
		$LineCount++;
		$nSize = strlen($Text);
		$sTmp=strtoupper($Text);

		// Ignore lines less than 3 characters
		// or starting with comment char
		if( $nSize < 3 || $sTmp[0] == '*' )
			continue;

		// Only return expected lines
		switch ($sTmp[0])	
		{
		case 'A':
			switch ($sTmp[1]){
				case 'C':
					$nLineType = k_nLtAC;
					break;
				case 'N':
					$nLineType = k_nLtAN;
					break;
				case 'L':
					$nLineType = k_nLtAL;
					break;
				case 'H':
					$nLineType = k_nLtAH;
					break;
				case 'T': // ignore airspace lables
							  // ToDo: adding airspace labels
				  continue;
	
				default:
					DEBUG("checkAirspace",128, sprintf("Parse Error at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $sTmp) );
					return -1;
				  continue;
			}
			break;

		case 'D':
			switch ($sTmp[1]){
				case 'A':
					$nLineType = k_nLtDA;
					break;
				case 'B':
					$nLineType = k_nLtDB;
					break;
				case 'C':
					$nLineType = k_nLtDC;
					break;
				case 'P':
					$nLineType = k_nLtDP;
					break;
					// todo DY airway segment
					// what about 'V T=' ?
				default:
					DEBUG("checkAirspace",128, sprintf("Parse Error at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $sTmp) );
					return -1;
				  continue;
			}
			break;

		case 'V':
		  $nLineType = k_nLtV;
		  break;

		case 'S':  // ignore the SB,SP ...
		  if ($sTmp[1] == 'B')
		    continue;
		  if ($sTmp[1] == 'P')
		    continue;

		default:		
		  DEBUG("checkAirspace",128, sprintf("Parse Error at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $sTmp) );
		  return -1;
		  continue;
		}

		if ($nLineType >= 0) {		// Valid line found
			$Text=trim($Text);

			if ( ($commentPos=strpos($Text,'*'))===false) { //do nothing

			} else {
				 DEBUG("checkAirspace",128,"GetNextLine: found Comment inlina at pos $commentPos<BR>");
				$Text=substr($Text,0,$commentPos);
			}
			break;
		}
    }

  //  DEBUG("checkAirspace",128,"GetNextLine: type: $nLineType got: $Text");
  return $nLineType;
}

function StartsWith($Text, $lookFor) {
	if (substr($Text,0,strlen($lookFor)) == $lookFor) return 1;
	else return 0;
}

function ReadCoords($Text) { 
  $Text=strtolower($Text);
  // DEBUG("checkAirspace",128,"ReadCoords: Text=$Text");
  // 53:26:09 N 009:45:46 E
  if ( ! preg_match("/(\d+):(\d+):(\d+) +([ns]) +(\d+):(\d+):(\d+) +([we])/",$Text,$matches) ) {
  
    if ( ! preg_match("/(\d+):(\d+)\.(\d+) +([ns]) +(\d+):(\d+)\.(\d+) +([we])/",$Text,$matches) ) {    
		DEBUG("checkAirspace",128,"ReadCoords2: #$Text# Not match ");
		return array(0,0,0);
	}
	$Ydeg=$matches[1];
	$Ymin=$matches[2];
	$Ysec=$matches[3];
	$Y =  ($Ymin+ $Ysec/pow(10,strlen($Ysec)) ) / 60 + $Ydeg;
	if ($matches[4]=='s')   $Y = -$Y ;
	
	$Xdeg=$matches[5];
	$Xmin=$matches[6];
	$Xsec=$matches[7];
	$X = ( $Xmin+ $Xsec/pow(10,strlen($Xsec) ))/60 + $Xdeg;
	if ($matches[8]=='w')   $X = -$X ;	
	// DEBUG("checkAirspace",128,"ReadCoords: Text=$Text , X=$X, Y=$Y<BR>");
	return array(1,$X,$Y);
	
  } 

  $Ydeg=$matches[1];
  $Ymin=$matches[2];
  $Ysec=$matches[3];
  $Y = $Ysec/3600 + $Ymin/60 + $Ydeg;
  if ($matches[4]=='s')   $Y = -$Y ;

  $Xdeg=$matches[5];
  $Xmin=$matches[6];
  $Xsec=$matches[7];
  $X = $Xsec/3600 + $Xmin/60 + $Xdeg;
  if ($matches[8]=='w')   $X = -$X ;

  // DEBUG("checkAirspace",128,"ReadCoords: Text=$Text , X=$X, Y=$Y");
  return array(1,$X,$Y);

}

function AddPoint($Temp) {
	global  $TempArea;
	$TempArea->Points[ $TempArea->NumPoints+0 ]->Latitude  = $Temp->Latitude;
	$TempArea->Points[ $TempArea->NumPoints+0 ]->Longitude  = $Temp->Longitude;
	$TempArea->NumPoints++;
}


function ReadAltitude($Text,$field) {
	global $TempArea;
	// DEBUG("checkAirspace",128,"ReadAltitude: $Text");

	$fHasUnit=0;
	$Text=trim(strtoupper($Text));
	$Text=str_replace("\t","",$Text);

	preg_match("/(\d*)([ =]*)([A-Z]*)([ =]*)(\d*)([ =]*)([A-Z]*)([ =]*)/",$Text,$parts);
	//print_r($parts);
	//echo "<HR>";

	$TempArea->$field->Altitude = 0;
	$TempArea->$field->FL = 0;
	$TempArea->$field->Base = abUndef;

   for ($i=1;$i<count($parts);$i++) {
    $pToken=$parts[$i];
	if (!$pToken || $pToken==' ') continue;

    if ( is_numeric($pToken) ) {
      if ($TempArea->$field->Base == abFL){
        $TempArea->$field->FL = $pToken;
        $TempArea->$field->Altitude = AltitudeToQNHAltitude(($TempArea->$field->FL * 100)/TOFEET);
      } else {
        $TempArea->$field->Altitude = $pToken;
      }
    }  else if ( $pToken=='SFC' || $pToken=='GND' ) {
      $TempArea->$field->Base = abAGL;
      $TempArea->$field->FL = 0;
      $TempArea->$field->Altitude = 0;
      $fHasUnit = 1;
    } else if ( $pToken=='FL' ){ 
      // this parses "FL=150" and "FL150"
      $TempArea->$field->Base = abFL;
      $fHasUnit = true;
    } else if ( $pToken=='FT'  || $pToken=='F' ){
      $TempArea->$field->Altitude = $TempArea->$field->Altitude/TOFEET;
      $fHasUnit = true;
    } else if ( $pToken=='M'){
      $fHasUnit = true;
    } else if ( $pToken=='MSL'){
      $TempArea->$field->Base = abMSL;
    } else if ( $pToken=='AGL'){
      $TempArea->$field->Base = abAGL;
    } else if ( $pToken=='STD'){
      if ($TempArea->$field->Base != abUndef) {
        // warning! multiple base tags
      }
      $TempArea->$field->Base = abFL;
      $TempArea->$field->FL = ($TempArea->$field->Altitude * TOFEET) / 100;
      $TempArea->$field->Altitude = AltitudeToQNHAltitude(($TempArea->$field->FL * 100)/TOFEET);
    }
  } // end while

  if (! $fHasUnit && $TempArea->$field->Base != abFL) {
    // ToDo warning! no unit defined use feet or user alt unit
    // Alt->Altitude = Units::ToSysAltitude(Alt->Altitude);
    $TempArea->$field->Altitude = $TempArea->$field->Altitude/ TOFEET;
  }

  if ($TempArea->$field->Base == abUndef) {
    // ToDo warning! no base defined use MSL
    $TempArea->$field->Base = abMSL;
  }

	// DEBUG("checkAirspace",128,"ReadAltitude: FL=". $Alt->FL.", Alt:". $Alt->Altitude.", Base:". $Alt->Base." ");
	//  return $Alt;
}


function AddArea() {
	//$m1=memory_get_usage();
	global $NumberOfAirspaceAreas,$AirspaceArea,$TempArea;

    $AirspaceArea[$NumberOfAirspaceAreas]=new AIRSPACE_AREA();
	$AirspaceArea[$NumberOfAirspaceAreas]->Name				= $TempArea->Name;
	$AirspaceArea[$NumberOfAirspaceAreas]->Type 			= $TempArea->Type;
	$AirspaceArea[$NumberOfAirspaceAreas]->Comments			= $TempArea->Comments;
	$AirspaceArea[$NumberOfAirspaceAreas]->Base->Altitude	= $TempArea->Base->Altitude ;
	$AirspaceArea[$NumberOfAirspaceAreas]->Base->FL			= $TempArea->Base->FL  ;
	$AirspaceArea[$NumberOfAirspaceAreas]->Base->Base   	= $TempArea->Base->Base;

	$AirspaceArea[$NumberOfAirspaceAreas]->Top->Altitude  	= $TempArea->Top->Altitude ;
	$AirspaceArea[$NumberOfAirspaceAreas]->Top->FL 			= $TempArea->Top->FL;
	$AirspaceArea[$NumberOfAirspaceAreas]->Top->Base   		= $TempArea->Top->Base;

	$AirspaceArea[$NumberOfAirspaceAreas]->Points 			= $TempArea->Points;
	$AirspaceArea[$NumberOfAirspaceAreas]->NumPoints 		= count($TempArea->Points);
	$AirspaceArea[$NumberOfAirspaceAreas]->Shape=1; // area

	$NumberOfAirspaceAreas++;
	//$m2=memory_get_usage();
	//echo "addArea: mem usage: ".($m2-$m1)." AFTER: ".$m2."<BR>"; 
}



function AddAirspaceCircle($CenterX, $CenterY, $Radius) { 
	//$m1=memory_get_usage();
	global $NumberOfAirspaceAreas,$AirspaceArea,$TempArea;

    $AirspaceArea[$NumberOfAirspaceAreas]=new AIRSPACE_CIRCLE();
	$AirspaceArea[$NumberOfAirspaceAreas]->Name				= $TempArea->Name;
	$AirspaceArea[$NumberOfAirspaceAreas]->Type 			= $TempArea->Type;
	$AirspaceArea[$NumberOfAirspaceAreas]->Comments			= $TempArea->Comments;
	$AirspaceArea[$NumberOfAirspaceAreas]->Base->Altitude	= $TempArea->Base->Altitude ;
	$AirspaceArea[$NumberOfAirspaceAreas]->Base->FL			= $TempArea->Base->FL  ;
	$AirspaceArea[$NumberOfAirspaceAreas]->Base->Base   	= $TempArea->Base->Base;

	$AirspaceArea[$NumberOfAirspaceAreas]->Top->Altitude  	= $TempArea->Top->Altitude ;
	$AirspaceArea[$NumberOfAirspaceAreas]->Top->FL 			= $TempArea->Top->FL;
	$AirspaceArea[$NumberOfAirspaceAreas]->Top->Base   		= $TempArea->Top->Base;

	$AirspaceArea[$NumberOfAirspaceAreas]->Latitude 		= $CenterY;
	$AirspaceArea[$NumberOfAirspaceAreas]->Longitude		= $CenterX;
	$AirspaceArea[$NumberOfAirspaceAreas]->Radius 			= $Radius;

	$AirspaceArea[$NumberOfAirspaceAreas]->Shape=2; // circle

	$NumberOfAirspaceAreas++;
	//$m2=memory_get_usage();
	//echo "addCircle: mem usage: ".($m2-$m1)." AFTER: ".$m2."<BR>"; 
}


function CalculateArc($Text) {
  global $TempArea,$TempPoint,$CenterY, $CenterX,$Rotation ;

  $parts=split(",",substr($Text,3) );
  if ( count($parts)==1 ) { echo "Wrong format in CalculateArc<BR>"; return; }
	
  list ($res, $StartLon , $StartLat) = ReadCoords( $parts[0] );
  list ($res, $EndLon  , $EndLat) = ReadCoords( $parts[1]  );

  list($Radius, $StartBearing)	= DistanceBearing($CenterY, $CenterX, $StartLat, $StartLon, 1,1);
  list($tmp1 ,  $EndBearing)	= DistanceBearing($CenterY, $CenterX, $EndLat, $EndLon,0,1);
  
  $TempPoint->Latitude  = $StartLat;
  $TempPoint->Longitude = $StartLon;
  
  AddPoint($TempPoint);

  while(abs($EndBearing-$StartBearing) > 7.5) {
	  $StartBearing += $Rotation *5 ;

	  if($StartBearing > 360)
		  $StartBearing -= 360;
	  if($StartBearing < 0)
		  $StartBearing += 360;
	
      list($TempPoint->Latitude,$TempPoint->Longitude)= FindLatitudeLongitude($CenterY, $CenterX, $StartBearing, $Radius, 1,1 );
	  
	  AddPoint($TempPoint);
  }
  $TempPoint->Latitude  = $EndLat;
  $TempPoint->Longitude = $EndLon;  
  AddPoint($TempPoint);
  
}


function ScanAirspaceCircleBounds($i, $bearing) {
  global $AirspaceArea;
  list($lat,$lon)= FindLatitudeLongitude($AirspaceArea[$i]->Latitude, 
                        $AirspaceArea[$i]->Longitude, $bearing, $AirspaceArea[$i]->Radius,1,1 );

  $AirspaceArea[$i]->minx = min($lon, $AirspaceArea[$i]->minx);
  $AirspaceArea[$i]->maxx = max($lon, $AirspaceArea[$i]->maxx);
  $AirspaceArea[$i]->miny = min($lat, $AirspaceArea[$i]->miny);
  $AirspaceArea[$i]->maxy = max($lat, $AirspaceArea[$i]->maxy);

}

function FindAirspaceBounds() {
  global $AirspaceArea,$NumberOfAirspaceAreas;
  // echo "<HR> $NumberOfAirspaceAreas <HR>";
  for($i=0; $i<$NumberOfAirspaceAreas; $i++) {
	$AirspaceArea[$i]->minx = 1000;
	$AirspaceArea[$i]->maxx = -1000;
	$AirspaceArea[$i]->miny = 1000;
	$AirspaceArea[$i]->maxy = -1000;
	// different methods for area / circle
	if ($AirspaceArea[$i]->Shape==1) { // area
		for( $j= 0; $j< $AirspaceArea[$i]->NumPoints; $j++) {
			$AirspaceArea[$i]->minx = min($AirspaceArea[$i]->Points[$j]->Longitude	,$AirspaceArea[$i]->minx);
			$AirspaceArea[$i]->maxx = max($AirspaceArea[$i]->Points[$j]->Longitude	,$AirspaceArea[$i]->maxx);
			$AirspaceArea[$i]->miny = min($AirspaceArea[$i]->Points[$j]->Latitude	,$AirspaceArea[$i]->miny);
			$AirspaceArea[$i]->maxy = max($AirspaceArea[$i]->Points[$j]->Latitude	,$AirspaceArea[$i]->maxy);
		}
	} else { // Circle
		ScanAirspaceCircleBounds($i,0);
		ScanAirspaceCircleBounds($i,90);
		ScanAirspaceCircleBounds($i,180);
		ScanAirspaceCircleBounds($i,270);
	}

  }
}

?>