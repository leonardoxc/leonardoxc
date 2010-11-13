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
// $Id: GUI_EXT_flight_comments.php,v 1.2 2010/11/13 22:17:05 manolis Exp $                                                                 
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

	.comments {
		background-color:#EEECE8;
		border-bottom:#E8E9DC 1px solid;		
	}	
	
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
	
	
	

.comment_box
{
background-color:#D3E7F5; border-bottom:#ffffff solid 1px; padding-top:3px
}
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
	border:1px solid #999999;
	display:none;
}

.reply {
	font-size:14px;
	background-color:#E3DDB7;
	padding:4px;
	border:1px solid #999999;
	font-weight:bold;
	cursor:pointer;cursor:hand;
	display:block;
	width:130px;
	text-align:center;
}
</style>

<script type="text/javascript" src="<?=$moduleRelPath?>/js/jquery.js"></script>
<script type="text/javascript" src="<?=$moduleRelPath?>/js/ckeditor/ckeditor.js"></script>

</head>
<body>
<script language="javascript">

$(document).ready(function(){
	CKEDITOR.replace( 'commentBox' );

$(".Reply").click(function(f) {
		$("#submitComment").show();
	});

$(".submit").click(function(f) {

		$("#submitComment").hide();
		var oEditor = CKEDITOR.instances.commentBox;
		var commentText=oEditor.getData();
		$("#replyText").html( commentText );
		
		$.post('<?=$moduleRelPath?>/EXT_comments_functions.php', 
			{ op:"add" , flightID: <?=$flightID?>, parent: parent ,name: name , email: email, commentText: commentText } 
			function(data) {
			  $('.result').html(data);
			});

	});


});
</script>

<div id='submitComment' >
<form action="#" method="post">
<input type="text" id="name"/><span class="titles">Name</span><span class="star">*</span><br />
<input type="text" id="email"/><span class="titles">Email</span><span class="star">*</span><br />
<textarea name="commentBox" id="commentBox" cols="120" rows="10"></textarea><br />
<input type="button" class="submit" value=" Submit Comment " />
</form>
</div>

<div id='parent0' class='reply'>Reply</div>

<div id='replyText'>...</div>
<?

		$str='';
		foreach($flightComments->threads as $thread) {		
			$commentData=$flightComments->comments[$thread['id']];			
			$str.="<div class='comments depth".$thread['depth']."'>";
			$str.=$commentData['text'];
			$str.="</div>";
		}
		echo  $str;
		


?>

</body>
