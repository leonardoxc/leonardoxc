<?
$debug=true;
$debug=false;

// Routine to extract a substring from a string with first and last character of substring position in the string
function parseB($str,$first,$last){
$ret="";
for ($i=$first;$i<=$last;$i++)
    $ret.=$str[$i];
return $ret;
}

//Routine to convert DMS to Degdec
function convDeg($deg,$min,$dir) {
$ret= $deg+$min/60;
//echo "deg:$deg min:$min ret:$ret <br>";
if ($dir=="W" || $dir =="S")
   $ret=$ret/-1;
return $ret;
}

//Routine to parse an IGC file
function parseIgcFile($szFilename) {
  global $debug ;
  $oFile = fopen($szFilename, "r");
  $table=array();
  $i=0;
  while($aFields = fgets($oFile, 1024)) {

      switch ($aFields[0]) {
             case 'B' :
                  $timestamp2=parseB($aFields,1,2)*3600+parseB($aFields,3,4)*60+parseB($aFields,5,6);
                  $hour=parseB($aFields,1,2)+$_POST['timeshift'];
                  $min=parseB($aFields,3,4);
                  $sec=parseB($aFields,5,6);
                  $time=$hour.":".$min;
                  $latDeg=parseB($aFields,7,8);
                  $latMin=parseB($aFields,9,10);
                  $latSec=parseB($aFields,11,13);
                  $latDir=parseB($aFields,14,14);
                  $lonDeg=parseB($aFields,15,17);
                  $lonMin=parseB($aFields,18,19);
                  $lonSec=parseB($aFields,20,22);
                  $lonDir=parseB($aFields,23,23);
                  $alt=parseB($aFields,30,34)+0;
                  $lat2=convdeg($latDeg,$latMin.".".$latSec,$latDir);
                  $lon2=convdeg($lonDeg,$lonMin.".".$lonSec,$lonDir);
                  if (!isset($lat1))
                     {
                     $lat1=$lat2;
                     $lon1=$lon2;
                     $timestamp1=$timestamp2-1;
                     $speed1=$speed0=0;
                     }
                  $speed=calcSpeed($lon1,$lat1,$timestamp1,$lon2,$lat2,$timestamp2);

                     if ($speed1>$speed0 && $speed1>$speed )
                        {
                            $speed1=($speed0+$speed)/2;
                            $table[$i]['speed']=$speed1;
//       if ($debug)  echo "****speed1:".$speed1."****";
                        }

                     $lat1=$lat2;
                     $lon1=$lon2;
                     $speed0=$speed1;
                     $speed1=$speed;
                     $timestamp1=$timestamp2;
/*
         if ($debug)         echo "lat= ".$lat2." ";
         if ($debug)         echo "lon= ".$lon2." ";
         if ($debug)         echo "alt= ".$alt."";
*/
                  $table[] = array( 'timestamp' => $timestamp2,'time' => $time, 'lon' => $lon2, 'lat' => $lat2, 'alt' => $alt, 'speed' => $speed);
                  $i++;
//         if ($debug) echo "****time:".$time.":".$sec." ";
//         if ($debug) echo "****speed:".$speed."****<BR>";
                  break;
             }
      }
  fclose($oFile);
  return $table;
  }

//Return Distance in meters between two coordinates
//earth's circumference is 40030 Km long, divided in 360 degrees, that's 111190
function calcDist($lat1,$lon1,$lat2,$lon2) {
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon1-$lon2));
  $dist = acos($dist); 
  $dist = rad2deg($dist);
  return $dist * 111190;
  }

function calcSpeed($lat1,$lon1,$time1,$lat2,$lon2,$time2) {
         $dist=calcDist($lat1,$lon1,$lat2,$lon2);
         $deltatime=$time2-$time1;
         if ($deltatime==0) $deltatime=1;
         $speed=(int)($dist*3.6/$deltatime); //Speed in  km/h
 return $speed;
}

function Point($name,$description,$coords,$icon,$scale,$visibility) {
 return '<Placemark>
    <name>'.$name.'</name>
    <description>'.$description.'</description>
    <visibility>'.$visibility.'</visibility>
    <styleUrl>root://styles#default+icon=0x307</styleUrl>
    <Style>
      <IconStyle>
        <Icon>
          <href>root://icons/palette-4.png</href>
          '.$icon.'
          <w>32</w>
          <h>32</h>
        </Icon>
      </IconStyle>
      <LabelStyle>
      <scale>'.$scale.'</scale>
      </LabelStyle>
    </Style>
    <Point>
      <altitudeMode>absolute</altitudeMode>
      <extrude>1</extrude>
      <coordinates>'.$coords.'</coordinates>
    </Point>
  </Placemark>' ;
}

function MajorPoint($name,$description,$coords,$icon) {
         return Point($name,$description,$coords,$icon,1,1);
            }
function MinorPoint($name,$description,$coords,$icon) {
         return Point($name,$description,$coords,$icon,0.5,0);
            }

function LineString($name,$description,$coords,$color,$width) {
  return '<Placemark>
    <name>'.$name.'</name>
    <description>'.$description.'</description>
    <Style>
      <LineStyle>
        <color>'.$color.'</color>
        <width>'.$width.'</width>
      </LineStyle>
    </Style>
    <LineString>
      <tessellate>1</tessellate>
      <altitudeMode>absolute</altitudeMode>
      <coordinates>
      '.$coords.'
      </coordinates>
    </LineString>
  </Placemark>';
}


function kmlGetTrackAnalysis($file) {
$str="";
$table=parseIgcFile($file);


extract($table[0]);
$lonDep=$lon;
$latDep=$lat;
$altDep=$alt;
$timeDep=$time;
$timestampDep=$timestamp;
$coordDep = "$lon,$lat,$alt\n";

$localAltMax=$alt;
$localAltMaxLat=$lat;
$localAltMaxLon=$lon;
$coordlocalAltMax="$lon,$lat,$alt\n";
$timelocalAltMax=$time;
$localAltMin=$alt;
$localAltMinLat=$lat;
$localAltMinLon=$lon;
$coordlocalAltMin="$lon,$lat,$alt\n";
$timelocalAltMin=$time;


$ext=$table[count($table)-1];
extract($ext);
$lonArr=$lon;
$latArr=$lat;
$altArr=$alt;
$timeArr=$time;
$timestampArr=$timestamp;
$coordArr = "$lon,$lat,$alt\n";

$duration=intval( ($timestampArr-$timestampDep) /60 );
if ($duration==0) $duration=1;

$bestDistance=calcDist($latDep,$lonDep,$latArr,$lonArr);
$lonBestDistance=$lon;
$latBestDistance=$lat;
$altBestDistance=$alt;
$timeBestDistance=$time;

$bestDistance2TP=$bestDistance;
$lonBestDistance2TP1=$lon;
$latBestDistance2TP1=$lat;
$altBestDistance2TP1=$alt;
$timeBestDistance2TP1=$time;
$lonBestDistance2TP2=$lon;
$latBestDistance2TP2=$lat;
$altBestDistance2TP2=$alt;
$timeBestDistance2TP2=$time;

$bestGlideRatio="";
$coordBestGlideRatio="";
$timeBestGlideRatio="";
$coordPreBestGlideRatio="";

$bestTransition=0;
$coordBestTransition="";
$timeBestTransition="";
$coordPreBestTransition="";

$bestGain=0;
$coordBestGain="";
$timeBestGain="";
$coordPreBestGain="";

$maxAlt="";
$coordMaxAlt="";
$timeMaxAlt="";

$minAlt=10000;
$coordMinAlt="";
$timeMinAlt="";

$maxSpeed="";
$coordMaxSpeed="";
$timeMaxSpeed="";

$lastchangedeltaAlt=-1;

$vario=0;
$vario1=0;
$variomin=0;
$coordvariomin="";
$timevariomin="";


$variomax=0;
$coordvariomax="";
$timevariomax="";

$curalt= "";
$curlat= "";
$curlon= "";
$curtime="";


$meanSpeed=25;
$localmeanspeed=array(25,25,25,25,25,25,25,25,25,25);
$localmeanvario=array(0,0,0,0,0,0,0,0,0,0);

$totalDist=0;
$totalDistWithoutThermal=0;

$lastchangeAlt=$table[0]['alt'];
$lastchangeLat=$table[0]['lat'];
$lastchangeLon=$table[0]['lon'];
$lastchangetimestamp=$table[0]['timestamp'];

$direction="";

$switchlevel=50;

$table2TP=array();

$wayPoints='';
$wpt=0;
$coordsWithoutThermals='';
$i=1;
//2. Transform to KML and get max alt and max speed
foreach( $table as $place ) {
         extract($place);

         if (isset($lon1)){

         //Calculate total distance run
         $totalDist+=calcDist($lat,$lon,$lat1,$lon1);

         $integ=4;
         //Calculate local mean speed
         $localmeanspeed[$i%$integ]=$speed;
//if ($debug) echo "$speed ";
         for ($j=1;$j<$integ;$j++){
                 $speed+=$localmeanspeed[($i+$integ-$j)%$integ];
//if ($debug) echo "$speed ";
                 }
             $speed=number_format($speed/$integ,0);
//if ($debug) echo " | $i : $speed  <br>";
         $localmeanspeed[$i%$integ]=$speed;


         $integ=2;
         //Calculate local mean Vz
         $deltatime=$timestamp-$timestamp1;
         if ($deltatime==0) $deltatime=1;
            $vario=($alt-$alt1)/($deltatime);

         $localmeanvario[$i%$integ]=$vario;
         for ($j=1;$j<$integ;$j++)
                 $vario+=$localmeanvario[($i+$integ-$j)%$integ];
             $vario=number_format($vario/$integ,1);
         $localmeanvario[$i%$integ]=$vario;



            //Calculate flight path color according to Vz
            $variocolormax=5;
            $variocolor=$vario;
            if ($variocolor> $variocolormax) $variocolor=$variocolormax;
            if ($variocolor< -$variocolormax) $variocolor=-$variocolormax;
            $variocolor=($variocolor/$variocolormax)*255;
            $color="FFFF00FF";
            if ($variocolor<0) $color="FFFF00".sprintf("%02X",255+$variocolor) ;
            if ($variocolor>0) $color="FF".sprintf("%02X",255-$variocolor)."00FF" ;

            $vario=number_format($vario,1);

            //Write corresponding fly path part in KML
            $str.=LineString( "$time $alt m $speed km/h $vario m/s","","$lon1,$lat1,$alt1 $lon,$lat,$alt", "$color",2);
            }

            if ($timestamp-$lastchangetimestamp > 180) // Place 1 Waypoint at least every 3 minute
               $table2TP[] = array( 'time'=> $time, 'lon' => $lon, 'lat' => $lat, 'alt' => $alt, 'speed' => $speed );

           $lon1=$lon;$lat1=$lat;$alt1=$alt;$timestamp1=$timestamp; $vario1=$vario;
           $meanSpeed+=$speed;
           $i++;

           if ($alt>$maxAlt)
              {
              $maxAlt=$alt;
              $coordMaxAlt="$lon,$lat,$alt\n";
              $timeMaxAlt=$time;
              }
           if ($speed>$maxSpeed)
              {
              $maxSpeed=$speed;
              $coordMaxSpeed="$lon,$lat,$alt\n";
              $timeMaxSpeed=$time;
              }
           if ($vario> $variomax)
              {
              $variomax=$vario;
              $coordvariomax="$lon,$lat,$alt\n";
              $timevariomax=$time;
              }
           if ($vario<$variomin)
              {
              $variomin=$vario;
              $coordvariomin="$lon,$lat,$alt\n";
              $timevariomin=$time;
              }

           //Calculate best Turnpoint for maximum distance
           $distToDep=calcDist($latDep,$lonDep,$lat,$lon);
           $distToArr=calcDist($latArr,$lonArr,$lat,$lon);
           if ($distToDep+$distToArr> $bestDistance )
               {
               $bestDistance=$distToDep+$distToArr;
               $lonBestDistance=$lon;
               $latBestDistance=$lat;
               $altBestDistance=$alt;
               $timeBestDistance=$time;

               }


           //Check if we have finished to climb or to fall ! ;)
           //And then, place a mark to give data about glide

           if ($alt>$localAltMax) {
              $localAltMax=$alt;
              $localAltMaxLat=$lat;
              $localAltMaxLon=$lon;
              $coordlocalAltMax="$lon,$lat,$alt";
              $timelocalAltMax=$time;
              }
           if ($alt<$localAltMin)
              {
              $localAltMin=$alt;
              $localAltMinLat=$lat;
              $localAltMinLon=$lon;
              $coordlocalAltMin="$lon,$lat,$alt";
              $timelocalAltMin=$time;
              }

              $deltaAlt=$alt-$lastchangeAlt;

//if ($debug) echo "<BR>direction=".$direction."alt=$alt lastchangeAlt=$lastchangeAlt deltaAlt=$deltaAlt lastchangedeltaAlt=$lastchangedeltaAlt lastchangedeltaAlt*deltaAlt=".$lastchangedeltaAlt*$deltaAlt;
//if ($debug) echo 'localAltMax='.$localAltMax.' localAltMin='.$localAltMin;//.'localAltMax-alt='.$localAltMax-$alt.' alt-localAltMin='.$alt-$localAltMin;

                  if(
                  ($direction!="up"  && $alt-$localAltMin > $switchlevel )
                  ||
                  ($direction!="down" && $localAltMax-$alt > $switchlevel )
                  )
                      {
                      if ($deltaAlt<0) {
                         $direction="down";

                         $curalt= $localAltMin;
                         $curlat= $localAltMinLat;
                         $curlon= $localAltMinLon;
                         $curtime=$timelocalAltMin;
                         }
                      else {
                           $direction="up";
                         $curalt= $localAltMax;
                         $curlat= $localAltMaxLat;
                         $curlon= $localAltMaxLon;
                         $curtime=$timelocalAltMax;
                           }
//if ($debug) echo " XXX SWITCH XXX!";

                      $deltaAlt=$curalt-$lastchangeAlt;
                      $deltaDist=calcDist($curlat,$curlon,$lastchangeLat,$lastchangeLon);
                      $totalDistWithoutThermal+=number_format($deltaDist/1000,2);
                      $deltaTime=$timestamp-$lastchangetimestamp;
                      if ($deltaTime==0) $deltaTime=1;
                      if ($deltaAlt==0) $deltaAlt=1;

                      $meanvario=number_format($deltaAlt/$deltaTime,2);
                      $glideratio=number_format(-$deltaDist/$deltaAlt,2);
                      if ($glideratio>$bestGlideRatio && $glideratio < 50) // GR>50 is quite unrealistic !
                         {
                         $bestGlideRatio=$glideratio;
                         $coordPreBestGlideRatio="$lastchangeLon,$lastchangeLat,$lastchangeAlt $curlon,$curlat,$curalt";
                         $coordBestGlideRatio=(($lastchangeLon+$curlon)/2).','.(($lastchangeLat+$curlat)/2).','.(($lastchangeAlt+$curalt)/2);
                         $timeBestGlideRatio=$curtime;
                         }
                      if ($deltaAlt>$bestGain)
                         {
                         $bestGain=$localAltMax-$localAltMin;
                         $coordPreBestGain="$coordlocalAltMin $coordlocalAltMax";
                         $coordBestGain=(($localAltMaxLon+$localAltMinLon)/2).','.(($localAltMaxLat+$localAltMinLat)/2).','.(($localAltMax+$localAltMin)/2);
                         $timeBestGain=$curtime;
                         }
                      if ($deltaDist>$bestTransition)
                         {
                         $bestTransition=$deltaDist;
                         $coordPreBestTransition="$lastchangeLon,$lastchangeLat,$lastchangeAlt $curlon,$curlat,$curalt";
                         $coordBestTransition=(($lastchangeLon+$curlon)/2).','.(($lastchangeLat+$curlat)/2).','.(($lastchangeAlt+$curalt)/2);
                         $timeBestTransition=$curtime;
                         }
                      if ($localAltMin<$minAlt)
                         {
                         $minAlt=$localAltMin;
                         $coordMinAlt=$coordlocalAltMin;
                         $timeMinAlt=$timelocalAltMin;
                         }
                      if ($deltaAlt>0) $deltaAlt="+".$deltaAlt;

                      $data="PathDistance = $totalDistWithoutThermal km
                      Straight distance to Departure = ".number_format($distToDep/1000,2)." km
                      Straight distance to Arrival =".number_format($distToArr/1000,2)." km";

                      $wayPoints.=MinorPoint('#'.$wpt.' '.$curtime.' '.$curalt.'m '.$speed.'kmh '.$deltaAlt.'m '.$meanvario.'m/s GR='.$glideratio,$data,"$curlon,$curlat,$curalt\n","<x>0</x><y>128</y>");
                      $wpt++;
                      $coordsWithoutThermals.="$curlon,$curlat,$curalt \n";

                      $lastchangeAlt=$curalt;
                      $lastchangeLat=$curlat;
                      $lastchangeLon=$curlon;
                      $lastchangetimestamp=$timestamp;
                      $lastchangedeltaAlt=$deltaAlt;

                      $localAltMax=$alt;
                      $localAltMin=$alt;


                      $table2TP[] = array( 'time'=> $curtime, 'lon' => $curlon, 'lat' => $curlat, 'alt' => $curalt, 'speed' => $speed );

                      }
        }
$meanSpeed=$meanSpeed/$i;
$totalDistWithoutThermal+=number_format(calcDist($lastchangeAlt,$lastchangeLat,$lat,$lon)/1000,2);

// Let's loop again and calculate the best distance with TWO turnpoints

if ($debug) echo "<p>Nbpoints".count($table)."<P>";
if ($debug) echo "<p>NbWpoints".count($table2TP)."<P>";
if ($debug) echo "<p>wpt".$wpt."<P>";

            $cpt=count($table2TP);
            $interv=1;
            $itermax=200;
            if ($cpt>$itermax)
               $interv=$cpt/$itermax;

              for ($i=1;$i<$cpt-1; $i+=$interv ){
                  if (isset($table2TP[$i]['lat'])){
                            $ilat=$table2TP[$i]['lat'];
                            $ilon=$table2TP[$i]['lon'];
                            $ialt=$table2TP[$i]['alt'];
                            $itime=$table2TP[$i]['time'];
                            for ($j=$i+$interv;$j<$cpt;$j+=$interv){
                  if (isset($table2TP[$j]['lat'])){
                                $jlat=$table2TP[$j]['lat'];
                                $jlon=$table2TP[$j]['lon'];
                                $jalt=$table2TP[$j]['alt'];
                                $jtime=$table2TP[$j]['time'];
                                $curDist=calcDist($ilat,$ilon,$latDep,$lonDep)
                                        +calcDist($ilat,$ilon,$jlat,$jlon)
                                        +calcDist($latArr,$lonArr,$jlat,$jlon);
if ($debug) echo "i=$i j=$j time i=$itime time j =$jtime timeTP1=$timeBestDistance2TP1 timeTP2=$timeBestDistance2TP2 bestDist= $bestDistance2TP curdist =$curDist <BR>\n";
                                if ($curDist>$bestDistance2TP)
                                   {
//if ($debug) echo "XXX bestDist !!!XXX  \n";
                                   $bestDistance2TP=$curDist;
                                   $lonBestDistance2TP1=$ilon;
                                   $latBestDistance2TP1=$ilat;
                                   $altBestDistance2TP1=$ialt;
                                   $timeBestDistance2TP1=$itime;
                                   $lonBestDistance2TP2=$jlon;
                                   $latBestDistance2TP2=$jlat;
                                   $altBestDistance2TP2=$jalt;
                                   $timeBestDistance2TP2=$jtime;
                                   }
                                   }
                                   }
                            }
              }


$flightPath='<Folder><name>Complete Flight Path</name>
<description>
Distance='.number_format($totalDist/1000,2).'km
Meanspeed='.number_format(($totalDist/1000)/($duration/60),2).'km/h
(integrated='.number_format($meanSpeed,0).'km/h)
</description>
'.$str.'
</Folder>';


// Let's Write Info about the flight and draw the trace without thermals
$name='Flight without Thermalling Path';
$pathWitoutThermals=LineString( $name,'',"$coordDep $coordsWithoutThermals $coordArr","90FFFFFF",1);
$flightWithoutThermals='<Folder>';
$flightWithoutThermals.='<name>Flight (without thermalling)</name><visibility>0</visibility>';
$flightWithoutThermals.='<description> Distance='.$totalDistWithoutThermal.'km Meanspeed='.number_format($totalDistWithoutThermal/($duration/60),2).'km/h</description>';
$flightWithoutThermals.=$pathWitoutThermals;
$flightWithoutThermals.='</Folder>';

$flightWayPoints='<Folder><name>WayPoints</name><visibility>0</visibility>'.$wayPoints.'</Folder>';


//Print best distance with 2 TurnPoints
$TP2='<Folder><name>Best distance Path with 2 Turnpoints</name>
<open>0</open>
<description> Distance ='.number_format($bestDistance2TP/1000,2).'km Meanspeed='.number_format(($bestDistance2TP/1000)/($duration/60),2).'km/h</description>';
;
$name='Flight Distance Path with 2 Turnpoints';
$nameTP1=$timeBestDistance2TP1.", bestTurnpoint 1/2";
$nameTP2=$timeBestDistance2TP2.", bestTurnpoint 2/2";
$coords2TP1= $lonBestDistance2TP1.','.$latBestDistance2TP1.','.$altBestDistance2TP1;
$coords2TP2= $lonBestDistance2TP2.','.$latBestDistance2TP2.','.$altBestDistance2TP2;
$coords2TP= "$coordDep
            $coords2TP1
            $coords2TP2
            $coordArr
            ";
$distDep= number_format(calcDist($latBestDistance2TP1,$lonBestDistance2TP1,$latDep,$lonDep)/1000,2);
$distTP= number_format(calcDist($latBestDistance2TP1,$lonBestDistance2TP1,$latBestDistance2TP2,$lonBestDistance2TP2)/1000,2);
$distArr= number_format(calcDist($latBestDistance2TP2,$lonBestDistance2TP2,$latArr,$lonArr)/1000,2);
$TP2.=LineString( $name,"","$coords2TP","F000FF00",2);
$TP2.=MajorPoint($nameTP1,"Distance to Departure =$distDep km , Distance to TP2 = $distTP km",$coords2TP1,"<x>64</x><y>128</y>");
$TP2.=MajorPoint($nameTP2,"Distance to Arrival =$distArr km",$coords2TP2,"<x>64</x><y>128</y>");
$TP2.='</Folder>';

//Print best distance 1 TurnPoint
$coordBestDistance="$lonBestDistance,$latBestDistance,$altBestDistance";
$coords1TP="$coordDep
            $coordBestDistance
            $coordArr ";
$TP1="<Folder><open>0</open>";
$TP1.='<name>Best Distance Path with 1 TurnPoint</name>
<description> Distance='.number_format($bestDistance/1000,2).'km Meanspeed='.number_format(($bestDistance/1000)/($duration/60),0).'km/h</description>';

$name='Flight Distance Path with 1 Turnpoint';
$TP1.=LineString( $name,"","$coords1TP","F000FFFF",2);
$distDep= number_format(calcDist($latBestDistance,$lonBestDistance,$latDep,$lonDep)/1000,2);
$distArr= number_format(calcDist($latBestDistance,$lonBestDistance,$latArr,$lonArr)/1000,2);
$TP1.=MajorPoint($timeBestDistance.", best single Turnpoint",
    "Distance to Departure =$distDep km , Distance to Arrival = $distArr km",
    "$coordBestDistance","<x>64</x><y>128</y>");
$TP1.='</Folder>';

// Print Best Glide Ratio
$GR="<Folder><open>0</open>";
$GR.='<name>Best GR : '.$bestGlideRatio.' </name>';
$name='Best Glide Ratio = '.$bestGlideRatio;
$GR.=LineString( $name,"","$coordPreBestGlideRatio","8000FF00",8);
$GR.=MajorPoint($timeBestGlideRatio." Best GR : ".$bestGlideRatio,"", $coordBestGlideRatio,"<x>64</x><y>128</y>");
$GR.='</Folder>';

// Print Best Transition
$bestTransition=number_format($bestTransition/1000,2);
$BT="<Folder><open>0</open>";
$BT.='<name>Best Transition : '.$bestTransition.'km </name>';
$name='Best Transition = '.$bestTransition.'km';
$BT.=LineString( $name,"","$coordPreBestTransition","80FF0000",12);
$BT.=MajorPoint($timeBestTransition." Longest Transition : ".$bestTransition."km","", $coordBestTransition,"<x>64</x><y>128</y>");
$BT.='</Folder>';

// Print Best Gain
$name='Best Gain = '.$bestGain.'m';
$BG="<Folder><open>0</open>";
$BG.='<name>'.$name.'</name>';
if ($bestGain>0)
   {
   $BG.=LineString( $name,"","$coordPreBestGain","805555FF",20);
   $BG.=MajorPoint($timeBestGain." Best Gain : ".$bestGain."m","", $coordBestGain,"<x>64</x><y>128</y>");
   }
$BG.='</Folder>';

//if ($debug) echo "<p>duree=$duration s =".intval($duration/60)."h".($duration%60)."s<P>";
// Print Flight General Informations
//$duration=number_format($duration/3600,0)."h".sprintf("%02d",number_format(($duration%3600)/60,0))."m";
$duration=intval($duration/60)."h".sprintf("%02d",$duration%60)."m";
$gain=$maxAlt-$altDep;
$FlightGeneralInformations="<Folder><open>0</open>";
$FlightGeneralInformations.='<name>Flight General Informations</name>';
$FlightGeneralInformations.=MajorPoint($timeDep." ".$altDep."m, Departure : ".$departure,"", $coordDep,"<x>160</x><y>128</y>");
$FlightGeneralInformations.=MajorPoint($timeArr." ".$altArr."m, Arrival : ".$arrival,"", $coordArr,"<x>128</x><y>128</y>");
$FlightGeneralInformations.='<Folder><name>Duration ='.$duration.'</name></Folder>';
$FlightGeneralInformations.='<Folder><name>Dep to Arr :'
  .number_format(calcDist($latDep,$lonDep,$latArr,$lonArr)/1000,2).'km straight </name></Folder>';
$FlightGeneralInformations.='<Folder><name>Height gain ='.$gain.'m</name></Folder>';
$FlightGeneralInformations.="</Folder>";

$MinMax=MajorPoint($timeMaxAlt." MaxAlt : ".$maxAlt."m","", $coordMaxAlt,"<x>32</x><y>128</y>");
$MinMax.=MajorPoint($timeMinAlt." MinAlt : ".$minAlt."m","", $coordMinAlt,"<x>32</x><y>128</y>");
$MinMax.=MajorPoint($timeMaxSpeed." MaxSpeed : ".$maxSpeed."km/h","", $coordMaxSpeed,"<x>64</x><y>128</y>");
$MinMax.=MajorPoint($timevariomax." MaxVz : ".$variomax."m/s","", $coordvariomax,"<x>64</x><y>128</y>");
$MinMax.=MajorPoint($timevariomin." MinVz : ".$variomin."m/s","", $coordvariomin,"<x>64</x><y>128</y>");


//Finally create the complete KML flow

//$str='<?xml version="1.0" encoding="UTF-8" ? >
//<kml xmlns="http://earth.google.com/kml/2.0">';

$str='<!-- converted by GPS2GE V2.0 http://www.parawing.net -->
<Folder>
  <name>'.$pilot.' '.$date.' '.$departure.' '.$arrival.'</name>
  <description>
  Log generated on http://www.parawing.net (converter by Man\'s)</description>
  <open>1</open>
      '.$FlightGeneralInformations.'
  <Folder>
  <name>Paths and Distances</name>
      '.$flightPath.'
      '.$flightWithoutThermals.'
      '.$TP2.'
      '.$TP1.'
  </Folder>
  <Folder>
  <name>MinMax Measures</name>
      '.$MinMax.'
      '.$GR.'
      '.$BG.'
      '.$BT.'
  </Folder>
      '.$flightWayPoints.'
</Folder>';


return $str;
}


?>