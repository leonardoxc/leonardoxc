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
// $Id: EXT_helper.php,v 1.2 2012/06/02 08:40:12 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once "config.php";

	$op=makeSane($_GET['op']);
	// $CONF_use_utf=1;
	
 	require_once "EXT_config.php";
 	
	require_once "CL_flightData.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	setDEBUGfromGET();

	$op=makeSane($_GET['op1']);

	if (!in_array($op,array("create_pdf")) ) return;

	// $SERVER_URL='';

	if ($op=="create_pdf") {
		$direct=$_GET['direct']+0;
		$remote=$_GET['remote']+0;
		
		if ($userID <=0 || $remote) {
			//echo "Not valid user";
			// exit;
			$userID =makeSane($_GET['userIDnotify']);
			
			$userEmail=makeSane($_GET['userEmailNotify'],2);
			unset($_GET['userIDnotify']);
			unset($_GET['userEmailNotify']);
		} else {			
			require_once "CL_user.php";
			$userEmail=LeoUser::getEmail($userID);
		}
		
		
		
		unset($_GET['op1']);
		unset($_GET['direct']);
		unset($_GET['remote']);

		$url="http://".urldecode($_GET['url']);
		foreach($_GET as $name=>$val ) {
			if ( !in_array($name,array('print','url') )  ){
				$url.="&$name=$val";
			}
		}	
		
		if ($remote) $url.='&remote=1';
		$url.='&print';
		
		if ($direct){
			$res=fetchURL($url,300);
		
			echo "<a href='$url' target='_blank'>Printing URL</a><BR>\n";
			// echo $res;
		
			$lines=split("\n",$res);
			if (!$remote) {
				//$lines=$res;
				$pdfFile=$SERVER_URL.$moduleRelPath.$lines[count($lines)-1];
				$pdfFile=$SERVER_URL.$lines[count($lines)-1];							
			} else {
				require_once dirname(__FILE__)."/CL_pdf.php";
				
				$linesNum=count($lines);
				
				for($k=$linesNum-1;$k>0;$k--) {
					if (substr($lines[$k],0,8)=='PDF URL:') {
						$pdfUrls[$k]=substr($lines[$k],8);
					}
					if (substr($lines[$k],0,9)=='START PDF') {
						 echo "Found start of pdf list, breaking <br>";
						break;
					}
				}
				
				print_r($pdfUrls);
				$tmpDir=md5($_SERVER['REQUEST_URI']);
				 
				$pdfFile=leoPdf::createPDFmulti($pdfUrls,$tmpDir);	
		
				// $pdfFile=$tmpDir.'/logbook.pdf';
				$helperUrl=$CONF['pdf']['helperUrl'];
				if ($helperUrl) { 
					$helperUrl=$helperUrl.'/';
				}	
								
				if ($pdfFile) {				
					echo "<a href='".$helperUrl.$CONF['pdf']['tmpPathRel'].'/'.$pdfFile."' target='_blank'>PDF is ready</a>";
					// echo "\n\n".$moduleRelPath.'/'.$CONF['pdf']['tmpPathRel'].'/'.$pdfFile;
				} else {				
					echo "ERROR: PDF creation failed";
				}
				return;
			}
			
			
			echo "<BR>PDF File is ready. <a href='$pdfFile' target='_blank'>Download it from here</a><BR>\n";		
			// echo "PDF FILE: $pdfFile\n";
			
			echo "<BR><BR><a href='javascript:closePdfDiv();'>OK</a><br>";
			return;
		}
		
		
		 echo "printing $url";
		
		require_once "CL_job.php";
		$jobArgs=array('userID'=>$userID,
				'jobType'=>'pdf',
				'priority'=>(L_auth::isModerator($userID)?1:0),
				'timeCreated'=>gmdate('Y-m-d H:i:s'),
				'status'=>0,
				'param1'=>$url,
				'param2'=>$userEmail,
			);
		$previousJobTime=leoJob::searchJob($jobArgs);
		
		if ($previousJobTime) {
			echo "You have ordered the same PDF on GMT $previousJobTime<BR>";
		} else {
			leoJob::addJob($jobArgs);
			echo "PDF order has been send<BR><BR>Will send email to $userEmail when the pdf is created<BR><BR>";
	
		}
		
		// $res=file_get_contents($url);
		// echo "#<pre>".$res."</pre>#";
		
		echo "<BR><BR><a href='javascript:closePdfDiv();'>OK</a><br>";
		
		
	}


?>