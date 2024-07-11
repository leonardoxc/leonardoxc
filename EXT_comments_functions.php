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
// $Id: EXT_comments_functions.php,v 1.11 2010/11/23 15:05:42 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "CL_comments.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	require_once "FN_pilot.php";
	require_once "FN_flight.php";
	//require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();

	
	// if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }

	$op=makeSane($_POST['op']);	

	if ($op=='add'){	
		session_start();
		
		// echo "#".			 $_POST['captcha']; print_r($_SESSION);echo "<hr>";
 		// echo "000";return;
 		$commentData['userID']=makeSane($_POST['userID']);
		if ($commentData['userID']<0 ) $commentData['userID']=0;
		
		if (!$commentData['userID'] ) {
			if (substr($_POST['captcha'], 10) != $_SESSION['captchaCodes'][$_SESSION['captchaAnswer']]) {
				 echo "000";
				 return;
			}
		}
		$flightID=makeSane($_POST['flightID']);
		$commentData['flightID']=$flightID;
		$commentData['parentID']=makeSane($_POST['parentID'])+0;
		$commentData['guestName']=makeSane($_POST['guestName']);
		$commentData['guestEmail']=makeSane($_POST['guestEmail']);
		$commentData['guestPass']=makeSane($_POST['guestPass']);
		$commentData['text']=$_POST['commentText'];

		$commentData['userServerID']=makeSane($_POST['userServerID']);
		$commentData['languageCode']=makeSane($_POST['languageCode']);
		
		$newCommentDepth=makeSane($_POST['depth'])+0;
		
		$flightComments=new flightComments($flightID);
		$newCommentID=$flightComments->addComment(
				array(
					'parentID'=>$commentData['parentID'],
					'userID'=>$commentData['userID'],
					'userServerID'=>$commentData['userServerID'],
					'guestName'=>$commentData['guestName'],
					'guestPass'=>$commentData['guestPass'],
					'guestEmail'=>$commentData['guestEmail'],
					'text'=>$commentData['text'],
					'languageCode'=>$commentData['languageCode']
					)
		);			
			
		$str='';
		$now=gmdate("Y-m-d H:i:s");
		$commentData['dateUpdated']=$now;
		// $commentData['dateAdded']=
		$commentData['commentID']=$newCommentID;
		$commentID=$newCommentID;		
		$commentDepth=$newCommentDepth;
			
		$flight=new flight();
		$flight->getFlightFromDB($commentData['flightID']);
	
		if ( $flight->userID != $userID ) {
			global $LeoCodeBase;
			require_once dirname(__FILE__).'/CL_user.php';
			require_once dirname(__FILE__).'/CL_mail.php';
			// send email notification to user
			$userEmail=leoUser::getEmail($flight->userID);
			// echo " userEmail= $userEmail";
			
			$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].
				getLeonardoLink(array('op'=>'show_flight','flightID'=>$commentData['flightID'])) );
				
			$email_body=sprintf(_New_comment_email_body,
						$CONF['site']['name'],$link	,$commentData['text']														
				);		
																												
			LeonardoMail::sendMail("[Leonardo] ".$CONF['site']['name']." - ". sprintf(_You_have_a_new_comment,$_SERVER['SERVER_NAME']),
						$email_body,
						$userEmail,
						addslashes($userEmail),'','',true );
			// echo "<pre>$email_body</pre>";		
		}	
			
		include dirname(__FILE__).'/INC_comment_row.php';
		echo $str;
									 
									 
		//echo " newCommentID=$newCommentID, flightID=$flightID 
		//		parentID=$parentID, guestName=$guestName, userID=$userID,
		//		<hr> $commentText <BR>";
		//echo "OK";
	} else if ($op=='edit'){	
		$flightID=makeSane($_POST['flightID']);
		$commentID=makeSane($_POST['commentID'])+0;
		$commentText=$_POST['commentText'];
		
		$flightComments=new flightComments($flightID);
		$result=$flightComments->changeComment(
				array(
					'commentID'=>$commentID,
					'text'=>$commentText,
					)
		);			
		echo "Result: $result";						 
	} else if ($op=='delete'){	
		$flightID=makeSane($_POST['flightID']);
		$commentID=makeSane($_POST['commentID'])+0;
		$parentID=makeSane($_POST['parentID'])+0;
		
		if (!$flightID|| !$commentID) {
			echo "0:Bad paramters";
			return;		
		}
		$flightComments=new flightComments($flightID);
		$result=$flightComments->deleteComment($commentID,$parentID);
		echo "Result: $result";
	} else if ($op=='setCommentsStatus'){	
		$flightID=makeSane($_POST['flightID']);
		$enable=makeSane($_POST['enable']);
						
		$flightComments=new flightComments($flightID);		
		$result=$flightComments->setCommentsStatus($enable);	
		if ($result) {
			if ($enable) echo "<span class='green'>"._Comments_are_enabled_for_this_flight."</span>";
			else echo "<span class='red'>"._Comments_are_disabled_for_this_flight."</span>";
		}	else {	
			echo "<span class='red'>"._ERROR_in_setting_the_comments_status."</span>";	
		}	
	}
?>