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
// $Id: GUI_EXT_flight_comments.php,v 1.3 2010/11/14 20:59:12 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
 	require_once dirname(__FILE__)."/EXT_config.php";

	require_once dirname(__FILE__)."/CL_flightScore.php";
	require_once dirname(__FILE__)."/CL_flightData.php";
	require_once dirname(__FILE__)."/FN_functions.php";	
	require_once dirname(__FILE__)."/FN_UTM.php";
	require_once dirname(__FILE__)."/FN_waypoint.php";	
	require_once dirname(__FILE__)."/FN_output.php";
	require_once dirname(__FILE__)."/FN_pilot.php";
	require_once dirname(__FILE__)."/FN_flight.php";
	require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";

	$flightID=makeSane($_GET['flightID'],1);
	if ($flightID<=0) exit;
		
	$flight=new flight();
	$flight->getFlightFromDB($flightID);

		
//   if (  !L_auth::isModerator($userID) ) {
//		echo "go away";
//		return;
//   }

	if (!$flight->commentsNum) {
		// no comments
		// return;
	}



	$flightComments=new flightComments($flight->flightID);
	$flightComments->getFromDB();
	// $comments=$flightComments->getThreadsOutput();
		 
	
  ?><head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?=$CONF_ENCODING?>">

<style type="text/css">
	 body, p, table,tr,td {font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;}
	 td {border:1px solid #777777; }
	 body {margin:0px; background-color:#FFFFFF}
	 
	 
	.box {
		 background-color:#F4F0D5;
		 border:1px solid #555555;
		padding:3px; 
		margin-bottom:5px;
	}
	.boxTop {margin:0; }
	
	.header1 { background-color:#E2ECF8 }
	.header2 { background-color:#F9F8E1 }
	.header3 { background-color:#E6EEE7 }


	.depth0 { margin-left:0px;}
	.depth1 { margin-left:20px;}
	.depth2 { margin-left:40px;}
	.depth3 { margin-left:60px;}
	.depth4 { margin-left:80px;}
	.depth5 { margin-left:100px;}
	.depth6 { margin-left:120px;}
	.depth7 { margin-left:140px;}
	.depth8 { margin-left:160px;}
	.depth9 { margin-left:180px;}
	
	
	



a
	{
	text-decoration:none;
	color:#d02b55;
	}
	a:hover
	{
	text-decoration:underline;
	color:#d02b55;
	}
	*{margin:0;padding:0;}
	
	
	ol.timeline
	{list-style:none;font-size:1.2em;}
	ol.timeline li{ display:none;position:relative;padding:.7em 0 .6em 0;}ol.timeline li:first-child{}
	
	#main
	{
	width:500px;  margin-left:100px;
	font-family:"Trebuchet MS";
	}
	#flash
	{
	margin-left:100px;
	
	}
	.box
	{
	height:85px;
	border-bottom:#dedede dashed 1px;
	margin-bottom:20px;
	}

#submitComment input {
	color:#000000;
	font-size:14px;
	border:#666666 solid 2px;
	height:24px;
	margin-bottom:10px;
	width:200px;	
}
	
#submitComment textarea {
	color:#000000;
	font-size:14px;
	border:#666666 solid 2px;
	height:124px;
	margin-bottom:10px;
	width:200px;	
}

#submitComment .titles{
	font-size:13px;
	padding-left:10px;
}
	
#submitComment .star{
	color:#FF0000; font-size:16px; font-weight:bold;
	padding-left:5px;
}

#submitComment {
	width:600px;
	display:block;
	position:absolute;
	top:-400px;
	left:-1000px;
	border:1px solid #999999;
	background-color:#FFFFFF;
}

.commentActions {
	font-size:11px;
	background-color:#E3DDB7;
	padding:2px;
	border:1px solid #999999;
	font-weight:normal;
	cursor:pointer;cursor:hand;
	display:block;
	width:70px;
	margin-right:3px;
	height:13px;
	text-align:center;
	float:left;
	clear:none;
}

.actionBox {
	display:block;
	margin-top:-5px;
	float:right;
	clear:both;
}

.commentBox {
		
		background-color:#EEECE8;
		border-bottom:#E8E9DC 1px solid;		
		margin-bottom: 5px;
		width:auto;
}	
	
.comment_box {
background-color:#D3E7F5; border-bottom:#ffffff solid 1px; padding-top:3px;
display:block;
position:relative;


}

.commentHeader {

display:block;

}

.commentBody {


}

.commentRowTable  , .commentRowTable td {
	border:0;
	padding:0;	
}

.commentInfo {
font-style:italic;
color:#999999;
float:left;
clear:none;
}

</style>

<link href="<?=moduleRelPath()?>js/sexy-captcha/css/styles.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--

img.brands { background: url(<?=$moduleRelPath?>img/sprite_brands.png) no-repeat left top; }
img.fl {   background: url(<?=$moduleRelPath?>img/sprite_flags.png) no-repeat left top ; }
img.icons1 {   background: url(<?=$moduleRelPath?>img/sprite_icons1.png) no-repeat left  top ; }
-->
</style>
<link rel="stylesheet" type="text/css" href="<?=moduleRelPath()?>templates/<?=$PREFS->themeName?>/sprites.css">

<script type="text/javascript" src="<?=moduleRelPath()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>js/xns.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>js/sexy-captcha/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>js/sexy-captcha/jquery.sexy-captcha-0.1.js"></script>


<script language="javascript">

var parent=0;

$(document).ready(function(){
	CKEDITOR.replace( 'commentBox' );

 	$('.myCaptcha').sexyCaptcha('<?=moduleRelPath()?>js/sexy-captcha/captcha.process.php');


	$(".cancelSubmit").click(function(f) {
		$("#submitComment").hide();
	});


	$(".reply").click(function(f) {
		$("#submitComment").css({
		
							left:$("#commentsContainer").offset().left,
							top:$(this).offset().top+$(this).height()+6
		}).show();	
		
		parent=$(this).attr('id').substring(6);			
		// $("#submitComment").show();
	});

	$(".delete").click(function(f) {
		$("#submitComment").css({
							left:$(this).offset().left,
							top:$(this).offset().top+$(this).height()+6
		}).show();	
		
		parent=$(this).attr('id').substring(6);			
		// $("#submitComment").show();
	});


$(".submit").click(function(f) {

		$("#submitComment").hide();
		var oEditor = CKEDITOR.instances.commentBox;
		var commentText=oEditor.getData();
		$("#replyText").html( commentText );
		
		// var parent=$(this).attr('id'); 
		//
		var guestName=$("#guestName").val();
		var guestEmail=$("#guestEmail").val();
		var guestPass=$("#guestPass").val();
		var userID=$("#userID").val();
		var userServerID=$("#userServerID").val();
		var languageCode=$("#languageCode").val();
		
		$.post('<?=moduleRelPath()?>EXT_comments_functions.php', 
			{ op:"add" , flightID: <?=$flightID?>, parentID: parent ,userID:userID, userServerID:userServerID, languageCode:languageCode,
							guestName: guestName , guestEmail: guestEmail, commentText: commentText } ,
			function(data) {
			  $('#replyText').html(data);
			}
		);

	});


});
</script>

<div id='submitComment' >
<form action="#" method="post">
<? if ($userID) { 

			$imgBigRel=getPilotPhotoRelFilename($userServerID,$userID);	
			$imgBig=getPilotPhotoFilename($userServerID,$userID);	
			
			list($width, $height, $type, $attr) = getimagesize($imgBig);
			list($width2, $height2)=CLimage::getJPG_NewSize($CONF['photos']['tiny']['max_width'], $CONF['photos']['tiny']['max_height'], $width, $height);
			echo "<a href='$imgBigRel' target='_blank'><img src='".getPilotPhotoRelFilename($userServerID,$userID,1)."' 
			width='$width2' height='$height2' onmouseover=\"trailOn('$imgBigRel','','','','','','1','$width','$height','','.');\" onmouseout=\"hidetrail();\" 
			 border=0></a>";
			 			 
			 
?>
<input type="hidden" id="userID" value="<?=$userID?>"/>
<input type="hidden" id="userServerID" value="<?=($userServerID+0)?>"/>

<input type="hidden" id="guestName" value=""/>
<input type="hidden" id="guestPass" value=""/>
<input type="hidden" id="guestEmail" value=""/>


<? } else { ?>
<input type="hidden" id="userID" value="0"/>
<input type="hidden" id="userServerID" value="0"/>

<input type="text" id="guestName"/><span class="titles">Name</span><span class="star">*</span><br />
<input type="text" id="guestPass"/><span class="titles">Password</span><span class="star">*</span><br />
<input type="text" id="guestEmail"/><span class="titles">Email</span><span class="star">*</span><br />
<? } ?>

<input type="hidden" id="languageCode" value="<?=$lang2iso[$currentlang]?>"/>
<textarea name="commentBox" id="commentBox" cols="120" rows="10"></textarea><br />
<div class="myCaptcha"></div>

<input type="button" class="submit" value=" Submit Comment " />&nbsp;&nbsp;
<input type="button" class="cancelSubmit" value=" Cancel" />
</form>
</div>


<div id='commentsContainer' style='width:740px'>
<div id='parent0' class='commentActions reply'>Reply</div>
<div style='clear:both'></div>

<div id='replyText'>...</div>
<?

		$str='';
		foreach($flightComments->threads as $thread) {		
			$commentData=$flightComments->comments[$thread['id']];			
			$str.="<div class='commentBox depth".$thread['depth']."'>";
			$str.="<table class='commentRowTable' width='100%'>";
			
			if ($commentData['userID']) {
				$imgBig=getPilotPhotoFilename($commentData['userServerID'],$commentData['userID']);	
				if (is_file($imgBig) ) {
					list($width, $height, $type, $attr) = getimagesize($imgBig);
				
					list($width2, $height2)=CLimage::getJPG_NewSize($CONF['photos']['tiny']['max_width'], 
																	$CONF['photos']['tiny']['max_height'], $width, $height);
																					
					$header="<img src='".getPilotPhotoRelFilename($commentData['userServerID'],$commentData['userID'],1)."' 
								width='$width2' height='$height2'  border=0>";
				}  else {
				
				
				}
					
				$str.="<tr><td rowspan='2' width='65'  valign='top'><div class='commentHeader'>$header</div></td>";
				$str.="<td valign='top'><div class='commentBody'>".$commentData['text']."</div></td></tr>";
			} else {
				$str.="<div class='commentHeaderGuest'>".$commentData['guestName']."</div>";
				$str.="<div class='commentBodyGuest'>".$commentData['text']."</div>";
			}
			
			$langName=array_search ($commentData['languageCode'], $lang2iso);
			$flagCode=$CONF['lang']['lang2countryFlag'][$langName];
			// echo "flag_code: $flagCode";
			
			$flagImg=leoHtml::img($flagCode.".gif",18,12,'absmiddle',_LANGUAGE,'fl');
			$str.="<tr><td valign='bottom'>";
			
			
			
			
			$str.="<div class='actionBox'>";
			$str.="<div class='commentInfo'>".$commentData['dateUpdated']." $flagImg</div>";
			$str.="<div id='parent".$commentData['commentID']."' class='commentActions reply'>Reply</div>";
			$str.="<div id='delete".$commentData['commentID']."' class='commentActions delete'>Delete</div>";
			$str.="<div id='edit".$commentData['commentID']."'  class='commentActions edit'>Edit</div>";
		//	$str.="<div style='clear:both'></div>";
			$str.="</div>";
			$str.="</td></tr>";
			
			$str.="</table>";
			
			$str.="</div>";
		}
		echo  $str;
		


?>
</div>
</body>
