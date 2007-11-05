<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                                */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

  if ( !auth::isAdmin($userID) ) { echo "go away"; return; }
  
function chmodDir($dir){
 $current_dir = opendir($dir);
 while($entryname = readdir($current_dir)){
    if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){		
	  //	echo "${dir}/${entryname}#<br>";
		chmod("${dir}/${entryname}",0777);       
		chmodDir("${dir}/${entryname}");
       
    }elseif($entryname != "." and $entryname!=".."){
	  // echo "${dir}/${entryname}@<br>";
      chmod("${dir}/${entryname}",0777);
    }
 }
 chmod($dir,0777);       
 closedir($current_dir);
}
	
  open_inner_table("ADMIN AREA",650);
  open_tr();
  echo "<td align=left>";	

	if (!auth::isAdmin($userID)) {
		echo "<br><br>You dont have access to this page<BR>";
		exitPage();
	}
	$query="SELECT ID,active from $flightsTable ";
	$res= $db->sql_query($query);
			


$prList=array(
	"MaxPunkte"		=>array("L   MaxPunkte","LXMP   MaxPunkte"),
	"CompeGPS"		=>array("LXCG","LCOMPEGPSVERSION"),
	"GpsDump"		=>array("LXGD GpsDump","LXXX GpsDump"),
	"FlyChart"		=>array("L   FlyChart",""),
	"Soaring pilot"	=>array("LXSPNSOARING"),
	"SeeYou"		=>array("LSEEYOU","AXSY"),
	"G7ToWin"		=>array("L   G7ToWin","LXGW   G7ToWin"),
	"Flymaster"		=>array("LXFM Flymaster","AFMT000Flymaster"),
	"GPSBabel"		=>array("AXXXZZZGPSBabel"),
	"Garmin tools"	=>array("AGAR"),
	"MLR tools"		=>array("AMLR"),
	"Aircotec Topnavigator"=>array("ATNA"),
	"Bräuniger Gallileo"=>array("ABRA"),
	"Renschler"			=>array("AREN"),
	"log_it RUAG Data Logger "=>array("ARUA"),

) ;
/*


LXMP MaxPunkte_4.4 
L MaxPunkte_4.2 

LXCG VERSION:5.7 
LCOMPEGPSVERSION:5.61.j 

LXGD GpsDump version 3.55 

LXSY Version 2.82 digitally signed 3/20/2005 8:45:28 PM 


AXSY
L ACTIVE LOG
LXSY Version 2.82 digitally signed 4/6/2005 9:03:33 PM 

L FlyChart® 4 for Windows
L Version 4.32.25.18, August 29th 2004 


ABRA02447 


AXSP3EL
LXSPNSOARING PILOT IGC OUTPUT 


AXSY
L ACTIVE LOG
LXSY Version 3.0 digitally signed 4/28/2005 11:48:18 AM
LCU::HPPLTPILOT:Simon Foley
LCU::HPGTYGLIDERTYPE:Sky Atis
LCU::HPGIDGLIDERID:
LCU::HPCCLCOMPETITIONCLASS:Paraglider Open
LSEEYOU PureGlider=False 
		*/	
	if($res > 0){
		 echo "<br><br>";
		 $flight=new flight();
		 $f=1;
		 while ($row = mysql_fetch_assoc($res)) { 
			 // $flight=new flight();
			 $flight->getFlightFromDB($row["ID"]);		

			 if ( is_file( $flight->getIGCFilename() ) )  { 
			 	$buffer=$flight->getIGCFilename()."<BR>";

				$lines=file($flight->getIGCFilename() );				
				$found=0;
				for ($i=count($lines)-1 ; $i>=0 ; $i--) {
					$line=&$lines[$i];
					if (strtoupper($line[0]=="L") || strtoupper($line[0]=="A") ) {
						$buffer.=$line."<BR>";
						foreach ($prList as $pr=>$str_list) {
							foreach($str_list as $str) {
								// echo "$line $pr $str<BR>";
								if (strtoupper(substr($line,0,strlen($str))) == strtoupper($str) ) {
									$pr_res[$pr]++;
									$found=1;
									if ($pr=="G7ToWin"){  echo "found : ".$flight->flightID."<BR>"; exit; }
									break;
								}
							}
							
							if ($found) break;
						}
						//exit;
						// echo $line."<BR>";
					}					
					if ($found) break;
				}
				if (!$found) {	
				
					echo "$buffer<HR>";
				}
				
			 } // end if 
			 $f++;
			 if ($f>1000) break;
		 } // end while 
	} // end if 
	
	echo "<HR>";
	foreach ($pr_res as $pr=>$pr_num) {
		echo "$pr : $pr_num<BR>";
	}
	echo "<BR><br><BR>";
	echo "</td></tr>";
    close_inner_table();

?>