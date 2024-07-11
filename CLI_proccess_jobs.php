<?
//************************************************************************
// Leonardo XC Server, https://github.com/leonardoxc/leonardoxc
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: CLI_proccess_jobs.php,v 1.1 2012/01/16 07:21:23 manolis Exp $                                                                 
//
//************************************************************************

// modification to call thie file also from the command line,

if (count($argv) == 0 ) {
	echo "Not authorized";
	exit;
}

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
//error_reporting(0);

if (count($argv) > 1 ) {
	foreach($argv as $i=>$arg) {
		if ($i==0) continue;
			list($name,$val)=split("=",$arg);
			if ($name && $val) {
				// echo "$name=$val";
				$_GET[$name]=$val;
			}
	}
}
// var_dump($argv);

require_once dirname(__FILE__)."/EXT_config_pre.php";
require_once dirname(__FILE__)."/config.php";
require_once dirname(__FILE__)."/EXT_config.php";

require_once dirname(__FILE__)."/FN_waypoint.php";	
require_once dirname(__FILE__)."/FN_functions.php";	
require_once dirname(__FILE__).'/CL_job.php';
require_once dirname(__FILE__).'/CL_pdf.php';
require_once dirname(__FILE__).'/CL_mail.php';


if ($_GET['cleanup']) {
	
	echo "Cleaning up\n";
	
	$cmd="cd ".$CONF['pdf']['tmpPath']."; find .  -ctime -".$CONF['pdf']['daysTokeepPdfOnServer']." -name \"??*\" -type d -exec rm -rf \{\} \; &>/dev/null ";
	exec($cmd);
	
	$query="DELETE FROM $jobsTable WHERE status=1 ";		
	$res= $db->sql_query($query);
	if($res <= 0){
	   echo "Error in deleting proccessed jobs: $query\n";	
	}		
	exit;
}


$jobsNum=leoJob::getJobsCount();
echo "Found $jobsNum jobs in queue\n\n";

$jobs=leoJob::getJobs(10);

$serverID=$CONF_server_id;

$parts=split("/",$CONF['servers']['list'][$serverID]['url_base']);
$SERVER_URL="http://".$parts[0];

echo "#$SERVER_URL#";
print_r($CONF['pdf']);

foreach($jobs as $job){

	// print_r($job);
	if ($job['jobType']=='pdf') {
		echo "JobID: ".$job['jobID']." created on GMT".$job['timeCreated']." by userID: ".$job['userID']."\n";
		
		$url=$job['param1'];
		$userEmail=$job['param2'];		
		$res=fetchURL($url,300);
		
		echo "Got $url\n";
		// echo $res;
		
		$lines=split("\n",$res);
		//$lines=$res;
		
		
		if (!$CONF['pdf']['helperUrl']) {
			$pdfFile=$SERVER_URL.$lines[count($lines)-1];
		} else {
			require_once dirname(__FILE__)."/CL_pdf.php";
				
			$linesNum=count($lines);
			
			for($k=$linesNum-1;$k>0;$k--) {
				if (substr($lines[$k],0,8)=='PDF URL:') {
					$pdfUrls[]=substr($lines[$k],8);
				}
				if (substr($lines[$k],0,9)=='START PDF') {
					// echo "Found start of pdf list, breaking <br>";
					break;
				}
			}
			
			// print_r($pdfUrls);
			$tmpDir=md5($url);
			 
			$pdfFile=leoPdf::createPDFmulti($pdfUrls,$tmpDir);	
	
			// $pdfFile=$tmpDir.'/logbook.pdf';
			$helperUrl=$CONF['pdf']['helperUrl'];
			if ($helperUrl) { 
				$helperUrl=$helperUrl.'/';
			}	
							
			if ($pdfFile) {	

				$pdfFile=$helperUrl.$CONF['pdf']['tmpPathRel'].'/'.$pdfFile;
				//echo "<a href='".$helperUrl.$CONF['pdf']['tmpPathRel'].'/'.$pdfFile."' target='_blank'>PDF is ready</a>";
				// echo "\n\n".$moduleRelPath.'/'.$CONF['pdf']['tmpPathRel'].'/'.$pdfFile;
			} else {				
				// echo "ERROR: PDF creation failed";
			}
				
		}			
		
		$mailBody="PDF File is ready. <a href='$pdfFile'>Download it from here</a>\n";
		
		echo "PDF FILE: $pdfFile\n";
		
		LeonardoMail::sendMail("Your Leonardo PDF is ready",$mailBody,$userEmail,'');
		
		leoJob::updateJob($job['jobID']);
	}

}

?>