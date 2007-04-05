<? 

define("TOFEET",3.281);
define("NAUTICALMILESTOMETRES",1851.96);
define("QNH",1013.2);
define("DEG_TO_RAD", 0.0174532925199432958);
define("RAD_TO_DEG", 57.2957795131 );
define("M_2PI", M_PI*2);
	

require_once dirname(__FILE__)."/airspace.php";
  
function AltitudeToQNHAltitude($alt) {
  $k1=0.190263;
  $ps = pow( (44330.8-$alt)/4946.54 , 1.0/$k1);
  return StaticPressureToAltitude($ps);
}

function StaticPressureToAltitude($ps) {
   // http://wahiduddin.net/calc/density_altitude.htm
  $k1=0.190263;
  $k2=8.417286e-5;
  $h_gps0 = 0;

  $Pa = pow(
                  pow($ps-(QNH-1013.25)*100.0,$k1)
                  -($k2*$h_gps0)
                  ,(1.0/$k1));

  $altitude = 44330.8-4946.54*pow($Pa,$k1);
  return $altitude;
}

$bFillMode = true;
$bWaiting = true;

$TempString=array();


class AIRSPACE_ACK {
	var $AcknowledgedToday;
	var $AcknowledgementTime;
}
// typedef enum {abUndef, abMSL, abAGL, abFL} AirspaceAltBase_t;

define("abUndef",0);
define("abMSL",1);
define("abAGL",2);
define("abFL",3);

class AIRSPACE_ALT {
	var $Altitude;
	var $FL;
	var $Base;  // AirspaceAltBase_t 
}

class rectObj {
  var $minx;
  var $miny;
  var $maxx;
  var $maxy;
} 

class AIRSPACE_POINT {
	var $Latitude;
	var $Longitude;
}

class AIRSPACE_AREA {
  var $Name;
  var $Type;
  var $Shape; // 1 => area , 2=> circle
  var $Comments;
  var $Base; // AIRSPACE_ALT 
  var $Top; //AIRSPACE_ALT 
  var $minx;
  var $miny;
  var $maxx;
  var $maxy;
  // var $bounds; // rectObj 

 //  var $FirstPoint;
  var $NumPoints;
  var $Points; // array of AIRSPACE_POINT

	function AIRSPACE_AREA (){
		$this->Shape=1;
		$this->Points=array();
	}

}

class AIRSPACE_CIRCLE {
  var $Name;
  var $Type;
  var $Shape; // 1 => area , 2=> circle
  var $Comments;
  var $Base; // AIRSPACE_ALT 
  var $Top; // AIRSPACE_ALT 
 // var $bounds; // rectObj 
  var $minx;
  var $miny;
  var $maxx;
  var $maxy;

  var $Latitude;
  var $Longitude;
  var $Radius;
	function AIRSPACE_CIRCLE (){
		$this->Shape=2;
	}
} 

$TempArea=new AIRSPACE_AREA();
$TempPoint=new AIRSPACE_POINT();

$Rotation = 1;
$CenterX = 0;
$CenterY = 0;
$Radius = 0;
$Width = 0;
$Zoom = 0;
$LineCount;


//var $AirspacePriority;

define("k_nLineTypes",9);

define("k_nLtAC",0);
define("k_nLtAN",1);
define("k_nLtAL",2);
define("k_nLtAH",3);
define("k_nLtV",4);
define("k_nLtDP",5);
define("k_nLtDB",6);
define("k_nLtDA",7);
define("k_nLtDC",8);

$k_nAreaCount = 12;
$k_strAreaStart = array(
					"R",  
					"Q", 
					"P", 
					"A", 
					"B", 
					"C", 
					"CTR",
					"D", 
					"GP", 
					"W", 
					"E", 
					"F"
);
$k_nAreaType = array( 
					"RESTRICT", 
					"DANGER", 
					"PROHIBITED", 
					"CLASSA", 
					"CLASSB", 
					"CLASSC", 
					"CTR",
					"CLASSD", 
					"NOGLIDER", 
					"WAVE", 
					"CLASSE", 
					"CLASSF");

/////////////////////////////


function DBG($str){
	// echo $str."<BR>";
}

// $openairFilename='Air_Germany.txt';
//$openairFilename="OPENAIRD.TXT";

// maxpunkte
 $openairFilename='Air_Europe 2006.txt';

$fp = fopen(dirname(__FILE__)."/$openairFilename","r");
if ($fp ) {
	ReadAirspace($fp);
}
require_once dirname(__FILE__).'/check.php';

 $igcFilename='73Phaki1.igc';
//$igcFilename='73Phaki2.igc';
// $igcFilename='2006_06_03 Profitis.IGC';
checkFile(dirname(__FILE__)."/$igcFilename");

function ReadAirspace($fp) {

  global $Rotation ,$CenterX , $CenterY ,$Radius ,$Width ,$Zoom , $LineCount;
  global $TempString;
  global $TempArea,$NumberOfAirspacePoints,$NumberOfAirspaceAreas;
  global   $bFillMode , $bWaiting ;

  
  DBG("ReadAirspace");
  $NumberOfAirspaceAreas=0;

  if ( RestoreAirspace()) {
// if ( 0 ) {
    echo "Read airspace from dump<br>";
//	global  $AirspaceArea,$AirspaceCircle,$AirspacePoint;
//	global 	$NumberOfAirspaceAreas,	$NumberOfAirspacePoints,	$NumberOfAirspaceCircles;
	global  $AirspaceArea,$NumberOfAirspaceAreas;

//print_r( $AirspaceArea);
	$NumberOfAirspaceAreas=count($AirspaceArea);
	//$NumberOfAirspacePoints=count($AirspacePoint);
	//$NumberOfAirspaceCircles=count($AirspaceCircle);
	//exit;
	return 1;
  }

  //var	$i;
  //var	$nLineType;


  $LineCount = 0;
  $CenterY = $CenterX = 0;
  $Rotation = 1;

  DBG("Loading Airspace File...");
  //  $TempArea->FirstPoint = $NumberOfAirspacePoints;	// JG 10-Nov-2005
  $TempArea->FirstPoint = 0;	

  $bFillMode = true;
  $bWaiting = true;

  while( ($nLineType = GetNextLine($fp, $TempString) )  >= 0 )
  {
		// DBG("GetNextLine(outside): type: $nLineType got: $TempString");	
		if ( !ParseLine($nLineType) ){
			DBG("Error in result from ParseLine()");
			return;
		}
  }

  // Process final area (if any). bFillMode is false.  JG 10-Nov-2005
  if (!$bWaiting) {
    AddArea($TempArea);
  }

  FindAirspaceBounds();
  StoreAirspace();
}

function ParseLine($nLineType)
{
	global $TempString,$LineCount;
	global $bFillMode,$bWaiting,$k_nAreaCount,$k_nAreaType,$k_strAreaStart;
	global $TempPoint, $TempArea,$NumberOfAirspaceCircles,$NumberOfAirspaceAreas;
	// DBG("ParseLine: [$nLineType] $TempString");

	// int		nIndex;
	global $Rotation ,$CenterX, $CenterY;

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
		for ($nIndex = 0; $nIndex < $k_nAreaCount; $nIndex++) {
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
		// $TempArea->Base= ReadAltitude( substr($TempString,3) ,'Base');
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
		// DBG("found V");
		if( StartsWith(substr($TempString,2), "X=" ) || StartsWith(substr($TempString,2), "x=") )
		{
			// DBG("will read coords");
			list ($res, $CenterX , $CenterY ) = ReadCoords( substr($TempString,4) );
			if ($res) break;
		}
		else if( StartsWith(substr($TempString,2),"D=-") || StartsWith(substr($TempString,2),"d=-") )
		{
			$Rotation = -1;
	      break;
		}
		else if ( StartsWith(substr($TempString,2),"D=+") || StartsWith(substr($TempString,2),"d=+") )
		{
			$Rotation = +1;
		    break;
		}
		else if(StartsWith(substr($TempString,2),"Z") || StartsWith(substr($TempString,2),"z") )
		{
	      // ToDo Display Zool Level
	      break;
		}
		else if(StartsWith(substr($TempString,2),"W") || StartsWith(substr($TempString,2),"w"))
		{
      // ToDo width of an airway
		  break;
		}
		else if(StartsWith(substr($TempString,2),"T") || StartsWith(substr($TempString,2),"t") )
		{
	      // ----- JMW THIS IS REQUIRED FOR LEGACY FILES
	      break;
		}

		DBG( sprintf("Parse Error1 at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $TempString) );
		return 0;

	case k_nLtDP:
		// DBG("will read coods");
		list ($res, $TempPoint->Longitude , $TempPoint->Latitude ) = ReadCoords( substr($TempString,3) );
    	if (!$res)  {
			DBG( sprintf("Parse Error2 at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $TempString) );
			return 0;
		}
  		AddPoint($TempPoint);
		//$TempArea->NumPoints++;
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
function GetNextLine($fp, &$Text)
{
	global $nLineType ;
	global $LineCount;
	global $bFillMode;

//	TCHAR	*Comment;
//	int		nSize;
	$nLineType = -1;
 //	TCHAR sTmp[128];

	while ( $Text=fgets($fp, 300) ){
		$LineCount++;
		$nSize = strlen($Text);

    // build a upercase copy of the tags
//    _tcsncpy(sTmp, Text, sizeof(sTmp)/sizeof(sTmp[0]));
//    sTmp[sizeof(sTmp)/sizeof(sTmp[0])-1] = '\0';
//    _tcsupr(sTmp);

		$sTmp=strtoupper($Text);

		// Ignore lines less than 3 characters
		// or starting with comment char
		if( $nSize < 3 || $sTmp[0] == '*' )
			continue;

		// Only return expected lines
		switch ($sTmp[0])	
		{
		case 'A':
			switch ($sTmp[1])
			{
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
			  if ($bFillMode){
			    DBG( sprintf("Parse Error at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $sTmp) );
			    return -1;
			  }
			  continue;
			}

			break;

		case 'D':
			switch ($sTmp[1])
			{
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
			  if ($bFillMode){
			    DBG( sprintf("Parse Error at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $sTmp) );
			    return -1;
			  }
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
		  DBG( sprintf("Parse Error at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $sTmp) );
		  return -1;
		  continue;
		}

		if ($nLineType >= 0)		// Valid line found
		{
			$Text=trim($Text);

			if ( $commentPos=strpos($Text,'*')===false) { //do nothing

			} else {
				$Text=substr($commentPos,0,$commentPos);
			}

			// Strip comments and newline chars from end of line
/*			$Comment = _tcschr(Text, _T('*'));
			if($Comment != NULL)
			{
				*Comment = _T('\0');		// Truncate line
				nSize = Comment - Text;		// Reset size
				if (nSize < 3)
					continue;				// Ensure newline removal won't fail
			}

			if(Text[nSize-1] == _T('\n'))
				Text[--nSize] = _T('\0');
			if(Text[nSize-1] == _T('\r'))
				Text[--nSize] = _T('\0');
*/
			break;
		}
    }

//  DBG("GetNextLine: type: $nLineType got: $Text");
  return $nLineType;
}

function StartsWith($Text, $lookFor) {
	if (substr($Text,0,strlen($lookFor)) == $lookFor) return 1;
	else return 0;
}

function ReadCoords($Text) { 
  $Text=strtolower($Text);
 // DBG("ReadCoords: Text=$Text");
  // 53:26:09 N 009:45:46 E
  if ( ! preg_match("/(\d+):(\d+):(\d+) +([ns]) +(\d+):(\d+):(\d+) +([we])/",$Text,$matches) ) {
    DBG("ReadCoords: Not match ");
	return array(0,0,0);
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

  DBG("ReadCoords: Text=$Text , X=$X, Y=$Y");
  return array(1,$X,$Y);

}

function AddPoint($Temp) {
	global  $TempArea,$NumberOfAirspacePoints,$AirspacePoint;
	$TempArea->Points[ $TempArea->NumPoints+0 ]->Latitude  = $Temp->Latitude;
	$TempArea->Points[ $TempArea->NumPoints+0 ]->Longitude  = $Temp->Longitude;
	$TempArea->NumPoints++;

	//$AirspacePoint[$NumberOfAirspacePoints+0]->Latitude  = $Temp->Latitude;
	//$AirspacePoint[$NumberOfAirspacePoints+0]->Longitude = $Temp->Longitude;
 	$NumberOfAirspacePoints++;
}


function ReadAltitude($Text,$field) {
	global $TempArea;


	// DBG("ReadAltitude: $Text");
/*
AIRSPACE_ALT *Alt
  TCHAR *Stop;
  TCHAR Text[128];
  TCHAR *pWClast = NULL;
  TCHAR *pToken;
  bool  fHasUnit=false;



  _tcsncpy(Text, Text_, sizeof(Text)/sizeof(Text[0]));
  Text[sizeof(Text)/sizeof(Text[0])-1] = '\0';

  _tcsupr(Text);
*/

// for testing 
//  $Text="FL=130ft";

  $fHasUnit=0;
  $Text=trim(strtoupper($Text));
  $Text=str_replace("\t","",$Text);

  // split string to " "
  // pToken = strtok_r(Text, TEXT(" "), &pWClast);

//  $parts=split(" ",$Text);
preg_match("/(\d*)([ =]*)([A-Z]*)([ =]*)(\d*)([ =]*)([A-Z]*)([ =]*)/",$Text,$parts);
//print_r($parts);
//echo "<HR>";
 // $Alt=new AIRSPACE_ALT();


  $TempArea->$field->Altitude = 0;
  $TempArea->$field->FL = 0;
  $TempArea->$field->Base = abUndef;

//   while(pToken != NULL && *pToken != '\0'){
   for ($i=1;$i<count($parts);$i++) {

 // foreach($parts as $pToken) {
    $pToken=$parts[$i];
	if (!$pToken || $pToken==' ') continue;

    if ( is_numeric($pToken) ) {
      if ($TempArea->$field->Base == abFL){
        $TempArea->$field->FL = $pToken;
        $TempArea->$field->Altitude = AltitudeToQNHAltitude(($TempArea->$field->FL * 100)/TOFEET);
      } else {
        $TempArea->$field->Altitude = $pToken;
      }

//      if (*Stop != '\0'){
//        pToken = Stop;
//        continue;
//      }

    }  else if ( $pToken=='SFC' || $pToken=='GND' ) {
      $TempArea->$field->Base = abAGL;
      $TempArea->$field->FL = 0;
      $TempArea->$field->Altitude = 0;
      $fHasUnit = 1;
    } else if ( $pToken=='FL' ){ 
      // this parses "FL=150" and "FL150"
      $TempArea->$field->Base = abFL;
      $fHasUnit = true;

//      $Alt->FL = $matches[2];
//      $Alt->Altitude = AltitudeToQNHAltitude(($Alt->FL * 100)/TOFEET);

		
      /*if (pToken[2] != '\0'){// no separator between FL and number
		$pToken = &pToken[2];
		continue;
      }*/
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

     // $pToken = strtok_r(NULL, TEXT(" \t"), &pWClast);

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

 // DBG("ReadAltitude: FL=". $Alt->FL.", Alt:". $Alt->Altitude.", Base:". $Alt->Base." ");


//  return $Alt;
}


function AddArea() {
	//global $NumberOfAirspaceAreas,$AirspaceArea,$AirspacePoint;
/*
	$NewArea = new AIRSPACE_AREA ();
	
	$NewArea->Name				= $Temp->Name;
	$NewArea->Type 				= $Temp->Type;
	$NewArea->Base->Altitude	= $Temp->Base->Altitude ;
	$NewArea->Base->FL			= $Temp->Base->FL  ;
	$NewArea->Base->Base   		= $Temp->Base->Base;
	$NewArea->NumPoints 		= $Temp->NumPoints;
	$NewArea->Top->Altitude  	= $Temp->Top->Altitude ;
	$NewArea->Top->FL 			= $Temp->Top->FL;
	$NewArea->Top->Base   		= $Temp->Top->Base;

	$NewArea->FirstPoint 		= $Temp->FirstPoint;

	
	$Temp->FirstPoint = $Temp->FirstPoint + $Temp->NumPoints ;
*/

//	$AirspaceArea[$NumberOfAirspaceAreas]= $NewArea ;

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

	//$TempArea->NumPoints=0;
	$NumberOfAirspaceAreas++;

//$m2=memory_get_usage();
//echo "addArea: mem usage: ".($m2-$m1)." AFTER: ".$m2."<BR>"; 
}



function AddAirspaceCircle($CenterX, $CenterY, $Radius) { // AIRSPACE_AREA $Temp
	/*global $NumberOfAirspaceCircles,$AirspaceCircle;
	
	$NewCircle=new  AIRSPACE_CIRCLE();
	$NewCircle->Name 		= $Temp->Name;
	$NewCircle->Latitude 	= $CenterY;
	$NewCircle->Longitude	= $CenterX;
	$NewCircle->Radius 		= $Radius;
	$NewCircle->Type 		= $Temp->Type;
	$NewCircle->Top->Altitude  = $Temp->Top->Altitude ;
	$NewCircle->Top->FL   	= $Temp->Top->FL;
	$NewCircle->Top->Base	= $Temp->Top->Base;
	$NewCircle->Base->Altitude  = $Temp->Base->Altitude;
	$NewCircle->Base->FL	= $Temp->Base->FL;
	$NewCircle->Base->Base	= $Temp->Base->Base;
	//      $NewCircle->Ack->AcknowledgedToday = false;
	//      $NewCircle->Ack->AcknowledgementTime = 0;
	//      $NewCircle->_NewWarnAckNoBrush = false;
	$AirspaceCircle[$NumberOfAirspaceCircles]= $NewCircle ;
	$NumberOfAirspaceCircles++;
*/
//$m1=memory_get_usage();
	global $NumberOfAirspaceAreas,$AirspaceArea,$TempArea;
//	$AirspaceArea[$NumberOfAirspaceAreas]= $Temp ;
//	$AirspaceArea[$NumberOfAirspaceAreas]->Shape=1; // area

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

	//$Temp->NumPoints=0;
	$NumberOfAirspaceAreas++;
//$m2=memory_get_usage();
//echo "addCircle: mem usage: ".($m2-$m1)." AFTER: ".$m2."<BR>"; 
}


function CalculateArc($Text) {
  global $TempArea,$TempPoint,$CenterY, $CenterX,$Rotation ;

  $parts=split(",",substr($Text,3) );
  if ( count($parts)==1 ) { echo "wrong format in CalculateArc<BR>"; return; }
	
  list ($res, $StartLon , $StartLat) = ReadCoords( $parts[0] );
  list ($res, $EndLon  , $EndLat) = ReadCoords( $parts[1]  );

  list($Radius, $StartBearing)	= DistanceBearing($CenterY, $CenterX, $StartLat, $StartLon, 1,1);
  list($tmp1 ,  $EndBearing)	= DistanceBearing($CenterY, $CenterX, $EndLat, $EndLon,0,1);
  
  $TempPoint->Latitude  = $StartLat;
  $TempPoint->Longitude = $StartLon;
  
  AddPoint($TempPoint);
  //$TempArea->NumPoints++;

  while(abs($EndBearing-$StartBearing) > 7.5) {
	  $StartBearing += $Rotation *5 ;

	  if($StartBearing > 360)
		  $StartBearing -= 360;
	  if($StartBearing < 0)
		  $StartBearing += 360;
	
      list($TempPoint->Latitude,$TempPoint->Longitude)= FindLatitudeLongitude($CenterY, $CenterX, $StartBearing, $Radius, 1,1 );
	  
	  AddPoint($TempPoint);
	  //$TempArea->NumPoints++;
  }
  $TempPoint->Latitude  = $EndLat;
  $TempPoint->Longitude = $EndLon;  
  AddPoint($TempPoint);
  //$TempArea->NumPoints++;
  
}

function FindLatitudeLongitude($Lat, $Lon, $Bearing, $Distance ,$calc_lat_out , $calc_lon_out) {

  $Lat *= DEG_TO_RAD;
  $Lon *= DEG_TO_RAD;
  $Bearing *= DEG_TO_RAD;
  $Distance = $Distance/6371000;

  $sinDistance = sin($Distance);
  $cosLat = cos($Lat);

  if ($calc_lat_out) {
    $result = asin(sin($Lat)*cos($Distance)+$cosLat*$sinDistance*cos($Bearing));
    $result *= RAD_TO_DEG;
    $lat_out = $result;
  }
  
  if ($calc_lon_out) {
    if($cosLat==0)
      $result = $Lon;
    else {
      $result = $Lon+asin(sin($Bearing)*$sinDistance/$cosLat);
      $result = fmod(($result+M_PI), M_2PI );
      $result = $result - M_PI;
    }
    $result *= RAD_TO_DEG;
    $lon_out = $result;
  }
  
  return array($lat_out, $lon_out );
}

function DistanceBearing($lat1, $lon1, $lat2, $lon2 ,$calcDistance , $calcBearing ) {

  $lat1 *= DEG_TO_RAD;
  $lat2 *= DEG_TO_RAD;
  $lon1 *= DEG_TO_RAD;
  $lon2 *= DEG_TO_RAD;

  $clat1 = cos($lat1);
  $clat2 = cos($lat2);
  $dlat  = $lat2-$lat1;
  $dlon  = $lon2-$lon1;

  if ($calcDistance) {
    $s1 = sin($dlat/2);
    $s2 = sin($dlon/2);
    $a= max(0.0,min(1.0,$s1*$s1+$clat1*$clat2*$s2*$s2));
    $c= 2.0*atan2(sqrt($a),sqrt(1.0-$a));
    $Distance = 6371000.0*$c;
  }
  
  if ($calcBearing) {
    $slat1 = sin($lat1);
    $slat2 = sin($lat2);
    $y = sin($dlon)*$clat2;
    $x = $clat1*$slat2-$slat1*$clat2*cos($dlon);

    if (abs($x)>0.00000001 && abs($y)>0.00000001){
      $theta = atan2($y,$x)*RAD_TO_DEG;
    } else {
      $theta = 0;
    }

    while ($theta>360.0) {
      $theta-= 360.0;
    }
    while ($theta<0.0) {
      $theta+= 360.0;
    }
    $Bearing = $theta;
  }

  return array($Distance, $Bearing);
}

/*
function FindAirspaceCircleBounds() {
  global $NumberOfAirspaceCircles,$AirspaceCircle;

  for($i=0; $i<$NumberOfAirspaceCircles; $i++) {
    $AirspaceCircle[$i]->minx = $AirspaceCircle[$i]->Longitude;
    $AirspaceCircle[$i]->maxx = $AirspaceCircle[$i]->Longitude;
    $AirspaceCircle[$i]->miny = $AirspaceCircle[$i]->Latitude;
    $AirspaceCircle[$i]->maxy = $AirspaceCircle[$i]->Latitude;

    ScanAirspaceCircleBounds($i,0);
    ScanAirspaceCircleBounds($i,90);
    ScanAirspaceCircleBounds($i,180);
    ScanAirspaceCircleBounds($i,270);
    // $AirspaceCircle[$i]->WarningLevel = 0; // clear warnings to initialise
  }
}
*/

function ScanAirspaceCircleBounds($i, $bearing) {
/*
  global $AirspaceCircle;

  list($lat,$lon)= FindLatitudeLongitude($AirspaceCircle[$i]->Latitude, 
                        $AirspaceCircle[$i]->Longitude, $bearing, $AirspaceCircle[$i]->Radius,1,1 );

  $AirspaceCircle[$i]->minx = min($lon, $AirspaceCircle[$i]->minx);
  $AirspaceCircle[$i]->maxx = max($lon, $AirspaceCircle[$i]->maxx);
  $AirspaceCircle[$i]->miny = min($lat, $AirspaceCircle[$i]->miny);
  $AirspaceCircle[$i]->maxy = max($lat, $AirspaceCircle[$i]->maxy);
*/
  global $AirspaceArea;
  list($lat,$lon)= FindLatitudeLongitude($AirspaceArea[$i]->Latitude, 
                        $AirspaceArea[$i]->Longitude, $bearing, $AirspaceArea[$i]->Radius,1,1 );

  $AirspaceArea[$i]->minx = min($lon, $AirspaceArea[$i]->minx);
  $AirspaceArea[$i]->maxx = max($lon, $AirspaceArea[$i]->maxx);
  $AirspaceArea[$i]->miny = min($lat, $AirspaceArea[$i]->miny);
  $AirspaceArea[$i]->maxy = max($lat, $AirspaceArea[$i]->maxy);

}


/*
function FindAirspaceAreaBounds() {
  global $AirspaceArea,$AirspacePoint,$NumberOfAirspaceAreas;

  for($i=0; $i<$NumberOfAirspaceAreas; $i++) {
	$AirspaceArea[$i]->minx = 1000;
	$AirspaceArea[$i]->maxx = -1000;
	$AirspaceArea[$i]->miny = 1000;
	$AirspaceArea[$i]->maxy = -1000;
    for( $j= $AirspaceArea[$i]->FirstPoint; $j< $AirspaceArea[$i]->FirstPoint + $AirspaceArea[$i]->NumPoints; $j++) {
        $AirspaceArea[$i]->minx = min($AirspacePoint[$j]->Longitude	,$AirspaceArea[$i]->minx);
        $AirspaceArea[$i]->maxx = max($AirspacePoint[$j]->Longitude	,$AirspaceArea[$i]->maxx);
        $AirspaceArea[$i]->miny = min($AirspacePoint[$j]->Latitude	,$AirspaceArea[$i]->miny);
        $AirspaceArea[$i]->maxy = max($AirspacePoint[$j]->Latitude	,$AirspaceArea[$i]->maxy);
    }
    // $AirspaceArea[$i]->WarningLevel = 0; // clear warnings to initialise
  }
}
*/
function FindAirspaceBounds() {
  global $AirspaceArea,$NumberOfAirspaceAreas;
echo "<HR> $NumberOfAirspaceAreas <HR>";
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

function  StoreAirspace() {
	global $AirspacePoint,$AirspaceArea,$AirspaceCircle;
	//$line1=serialize($AirspacePoint);
echo count($AirspaceArea);
echo "#";
echo strlen($AirspaceArea);
//echo "#";
//echo memory_get_usage() . "\n"; 
// print_r($AirspaceArea);

	$line1=serialize($AirspaceArea);
	//$line3=serialize($AirspaceCircle);

	$filename=dirname(__FILE__)."/airspace.dump";
    if (!$handle = fopen($filename, 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }

    // Write $somecontent to our opened file.
   // if (fwrite($handle, $line1."\n".$line2."\n".$line3."\n") === FALSE) {
	 if (fwrite($handle, $line1."\n") === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }    
    fclose($handle);

}


function   RestoreAirspace() {
	global $AirspacePoint,$AirspaceArea,$AirspaceCircle;

	$filename=dirname(__FILE__)."/airspace.dump";
	if (is_file($filename)) {
		$lines=file($filename);
		$AirspaceArea=unserialize($lines[0]);
		// print_r($AirspaceArea);
		/*list($line1,$line2,$line3)=file($filename);
		$AirspacePoint=unserialize($line1);
		$AirspaceArea=unserialize($line2);
		$AirspaceCircle=unserialize($line3);
*/
		return 1;
	}
	return 0;
}

?>