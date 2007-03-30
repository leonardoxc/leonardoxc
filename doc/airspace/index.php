<? 

define("BINFILEMAGICNUMBER"		,0x4ab199f0);
define("BINFILEVERION"          ,0x00000101);
define("BINFILEHEADER" 			,"XCSoar Airspace File V1.0");

$bFillMode = false;
$bWaiting = true;

$TempString=array();


class AIRSPACE_ACK {
	var $AcknowledgedToday;
	var $AcknowledgementTime;
}
// typedef enum {abUndef, abMSL, abAGL, abFL} AirspaceAltBase_t;

class AIRSPACE_ALT {
	var $Altitude;
	var $FL;
	var $Base;  // AirspaceAltBase_t 
}

class AIRSPACE_AREA {
  var $Name;
  var $Type;
  var $Base; // AIRSPACE_ALT 
  var $Top; //AIRSPACE_ALT 
  var $FirstPoint;
  var $NumPoints;
  var $Visible;
  var $_NewWarnAckNoBrush;
  var $MinLatitude;
  var $MaxLatitude;
  var $MinLongitude;
  var $MaxLongitude;
  var $bounds; // rectObj 
  var $Ack; // AIRSPACE_ACK 
  var $WarningLevel; // 0= no warning, 1= predicted incursion, 2= entered
  var $varVisible;
}

class AIRSPACE_POINT {
	var $Latitude;
	var $Longitude;
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
$lastQNH;

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
					RESTRICT, 
					DANGER, 
					PROHIBITED, 
					CLASSA, 
					CLASSB, 
					CLASSC, 
					CTR,
					CLASSD, 
					NOGLIDER, 
					WAVE, 
					CLASSE, 
					CLASSF);

/////////////////////////////

function CheckAirspacePoint($Idx){
  global $AirspacePointSize;
  if ($Idx < 0 || $Idx >= $AirspacePointSize){
    $Idx = $Idx;
    //throw "Airspace Parser: Memory access error!";
  }
}

function DBG($str){
	echo $str."<BR>";
}

// this can now be called multiple times to load several airspaces.
// to start afresh, call CloseAirspace()

$fp = fopen(dirname(__FILE__)."/Air_Germany.txt","r");
if ($fp ) {
	ReadAirspace($fp);
}


function ReadAirspace($fp) {

  global $Rotation ,$CenterX , $CenterY ,$Radius ,$Width ,$Zoom , $LineCount;
  global $TempString;
  global $TempArea,$NumberOfAirspacePoints;
  global   $bFillMode , $bWaiting ;

  DBG("ReadAirspace");

  $Tock = 0;
  //$dwStep;
  //var	$dwPos;
  //var 	$dwOldPos = 0;
  //var	$i;
  //var	$nLineType;

  //$OldNumberOfAirspacePoints  = $NumberOfAirspacePoints;
//  $OldNumberOfAirspaceAreas   = $NumberOfAirspaceAreas;
//  $OldNumberOfAirspaceCircles = $NumberOfAirspaceCircles;

  //$NumberOfAirspacePointsPass;
 // $NumberOfAirspaceAreasPass;
  //$NumberOfAirspaceCirclesPass;

  $LineCount = 0;
  $lastQNH = $QNH;

  $CenterY = $CenterX = 0;
  $Rotation = 1;

  DBG("Loading Airspace File...");
  $TempArea->FirstPoint = $NumberOfAirspacePoints;	// JG 10-Nov-2005

  $bFillMode = true;
  $bWaiting = true;

  while( ($nLineType = GetNextLine($fp, $TempString) )  >= 0 )
  {
		// DBG("GetNextLine(outside): type: $nLineType got: $TempString");	
		if ( !ParseLine($nLineType) ){
			DBG("Error in result from ParseLine()");
		  // CloseAirspace();
		  return;
		}
  }

  // Process final area (if any). bFillMode is false.  JG 10-Nov-2005
  if (!$bWaiting) {
    $NumberOfAirspaceAreas++;    // ????
    AddArea($TempArea);
  }

  $NumberOfAirspacePointsPass[0]	= $NumberOfAirspacePoints ;
  $NumberOfAirspaceAreasPass[0] 	= $NumberOfAirspaceAreas ;
  $NumberOfAirspaceCirclesPass[0]	= $NumberOfAirspaceCircles ;

	// only do this if debugging
	// DumpAirspaceFile();
}

function ParseLine($nLineType)
{
	global $TempString,$LineCount;
	global $bFillMode,$bWaiting,$TempArea,$k_nAreaCount,$k_nAreaType,$k_strAreaStart;
	global $TempPoint, $TempArea,$NumberOfAirspaceCircles;
	// DBG("ParseLine: [$nLineType] $TempString");

	// int		nIndex;
	global $Rotation ,$NumberOfAirspaceAreas,$CenterX, $CenterY;

	switch ($nLineType)
	{
	case k_nLtAC:
		if ($bFillMode)	{
			if (!$bWaiting)	AddArea($TempArea);
			$TempArea->NumPoints = 0;
			$TempArea->Type = OTHER;
			for ($nIndex = 0; $nIndex < $k_nAreaCount; $nIndex++) {
				if (StartsWith(substr($TempString,3), $k_strAreaStart[$nIndex]))	{
					$TempArea->Type = $k_nAreaType[$nIndex];
					break;
				}
			}
    		$Rotation = +1;
		}
		else if (!$bWaiting)							// Don't count circles JG 10-Nov-2005
			$NumberOfAirspaceAreas++;

	  	$Rotation = +1;
		$bWaiting = false;
		break;

	case k_nLtAN:
		if ($bFillMode)
		{
			// $TempString[NAME_SIZE] = '\0';
			$TempArea->Name=substr($TempString,3);
		}
		break;

	case k_nLtAL:
		if ($bFillMode)
			ReadAltitude( substr($TempString,3), $TempArea->Base);
		break;

	case k_nLtAH:
		if ($bFillMode)
			ReadAltitude( substr(TempString,3),$TempArea->Top);
		break;

	case k_nLtV:
		// Need to set these while in count mode, or DB/DA will crash
		if( StartsWith(substr($TempString,2), "X=" ) || StartsWith(substr($TempString,2), "x=") )
		{
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

		DBG( sprintf("Parse Error at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $TempString) );
		return 0;

	case k_nLtDP:
		list ($res, $TempPoint->Longitude , $TempPoint->Latitude ) = ReadCoords( substr($TempString,3) );
    	if (!$res)  {
			DBG( sprintf("Parse Error at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $TempString) );
			return 0;
		}
  		$TempArea->NumPoints=AddPoint($TempPoint,$TempArea->NumPoints);
		// TempArea.NumPoints++;
		break;

	case k_nLtDB:
		CalculateArc($TempString);
		break;

	case k_nLtDA:
		CalculateSector($TempString);
		break;

	case k_nLtDC:
		if ($bFillMode)
		{
			$Radius = substr($TempString,2)+0;
			$Radius = $Radius * NAUTICALMILESTOMETRES;
			AddAirspaceCircle($TempArea, $CenterX, $CenterY, $Radius);
		}
		else
			$NumberOfAirspaceCircles++;

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
		  if ($bFillMode){
		    DBG( sprintf("Parse Error at Line: %d\r\n\"%s\"\r\nLine skiped.", $LineCount, $sTmp) );
		 	return -1;
		  }
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

  DBG("GetNextLine: type: $nLineType got: $Text");
  return $nLineType;
}

function StartsWith($Text, $LookFor)
{
	if (substr($Text,0,strlen($lookFor)) == $lookFor) return 1;
	else return 0;

/*  while(1) {
    if (!($LookFor)) return TRUE;
    if (*Text != *LookFor) return FALSE;
    Text++; LookFor++;
  }
*/
  /*
  if(_tcsstr(Text,LookFor) == Text)
    {
      return TRUE;
    }
  else
    {
      return FALSE;
    }
  */
}

function ReadCoords($Text) { 
  $Text=strtolower($Text);
  DBG("ReadCoords: Text=$Text");
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

  DBG("ReadCoords: X=$X Y=$Y");
  return array(1,$X,$Y);

}

function AddPoint($Temp, $AeraPointCount) {
  global $NumberOfAirspacePoints,$bFillMode,$AirspacePoint;
  if($bFillMode){
		CheckAirspacePoint($NumberOfAirspacePoints);
		$AirspacePoint[$NumberOfAirspacePoints]->Latitude  = $Temp->Latitude;
		$AirspacePoint[$NumberOfAirspacePoints]->Longitude = $Temp->Longitude;
		$AeraPointCount++;
  }

  return $AeraPointCount;
  $NumberOfAirspacePoints++;
}


?>