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
// $Id: GUI_EXT_flight_comments.php,v 1.6 2010/11/16 14:58:14 manolis Exp $                                                                 
//
//************************************************************************

// nice exmple in action 
//http://onerutter.com/open-source/jquery-facebook-like-plugin.html

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
	
	$flightComments=new flightComments($flight->flightID);
	$flightComments->getFromDB();
		 	
  ?><head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?=$CONF_ENCODING?>">
  
<link href="<?=$moduleRelPath."/templates/".$PREFS->themeName."/style.css"; ?>" rel="stylesheet" type="text/css">

<style type="text/css">
 
#commentsContainer , #commentsContainer p, #commentsContainer td, #commentsContainer div,#commentsContainer span{
	font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;
}
  
	.depth0 { margin-left:0px;  width:710px;}
	.depth1 { margin-left:20px;  width:690px;}
	.depth2 { margin-left:40px;  width:670px;}
	.depth3 { margin-left:60px;  width:650px;}
	.depth4 { margin-left:80px;  width:630px;}
	.depth5 { margin-left:100px; width:610px;}
	.depth6 { margin-left:120px; width:590px;}
	.depth7 { margin-left:140px; width:570px;}
	.depth8 { margin-left:160px; width:550px;}
	.depth9 { margin-left:180px; width:530px;}
	
	
a {	text-decoration:none; 	color:#d02b55; 	}
a:hover {  text-decoration:underline; 	color:#d02b55; 	}

*{margin:0;padding:0;}
	
#submitComment input {
	color:#000000;
	font-size:14px;
	border:#666666 solid 2px;
	height:24px;
	margin-bottom:10px;
	width:160px;	
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
	height:24px;
	padding-left:10px;
}
	
#submitComment .star{
	color:#FF0000;
	font-size:16px;
	height:24px; 
	font-weight:bold;
	padding-left:5px;
}

#deleteWindow, #editActions {
	width:710px;
	display:block;
	position:absolute;
	top:-400px;
	left:-1000px;
	border:1px solid #999999;
	border:none;
	border-top:3px solid #FF9966;
	border-bottom:3px solid #FF9966;
	background-color:#CEF775;
	padding-top:10px;
	padding-bottom:10px;
	text-align:center;
}

#editActions {z-index:0}

#submitComment {
	width:710px;
	display:block;
	position:absolute;
	top:-400px;
	left:-1000px;
	border:1px solid #999999;
	border:none;
	border-top:3px solid #FF9966;
	border-bottom:3px solid #FF9966;
	background-color:#CEF775;
}

#submitComment , #submitComment p, #submitComment td, #submitComment div,#submitComment span{
	font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;
}

.commentActions , .commentActionsIcons, .deleteConfirm, .deleteCancel, .editConfirm, .editCancel {
	font-size:11px;
	background-color:#E3DDB7;
	padding:2px;
	border:1px solid #999999;
	font-weight:normal;
	cursor:pointer;cursor:hand;
	display:block;
	width:70px;
	margin-right:3px;
	height:14px;
	text-align:center;
	float:left;
	clear:none;
}

.deleteConfirm, .deleteCancel, .editConfirm, .editCancel {
	display:inline;
	float:none;
	clear:none;
	font-size:14px;
	padding:4px;
}

.commentActionsIcons {
	width:30px;
}

.actionBox {
	display:block;
	float:right;
	clear:both;
}

.commentBox {
		background-color:#EEECE8;
		border-bottom:#E8E9DC 1px solid;		
		margin-bottom: 5px;	
}	

.commentHeader {
	display:block;
}

.commentBody {
	padding-right:8px;
}

.commentRowTable, .commentRowTable td {
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

<link href="<?=moduleRelPath()?>/js/sexy-captcha/css/styles.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--

img.brands { background: url(<?=$moduleRelPath?>/img/sprite_brands.png) no-repeat left top; }
img.fl {   background: url(<?=$moduleRelPath?>/img/sprite_flags.png) no-repeat left top ; }
img.icons1 {   background: url(<?=$moduleRelPath?>/img/sprite_icons1.png) no-repeat left  top ; }

.bookmark_list span.bookmark_icons {
	background: url(<?=$moduleRelPath?>/js/bookmark/bookmarks.gif) no-repeat center;
}

-->
</style>
<link rel="stylesheet" type="text/css" href="<?=moduleRelPath()?>/templates/<?=$PREFS->themeName?>/sprites.css">
<link rel="stylesheet" type="text/css" href="<?=moduleRelPath()?>/js/bookmark/jquery.bookmark.css">

<script type="text/javascript" src="<?=moduleRelPath()?>/js/jquery.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/xns.js"></script>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/DHTML_functions.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/sexy-captcha/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/sexy-captcha/jquery.sexy-captcha-0.1.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/jquery.translate.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/bookmark/jquery.bookmark.js"></script>

<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>


<? 
echo makePilotPopup();
?>

<script language="javascript">

var parent=0;
var submitWindowActive=false;
var commentIdtoDelete=0;
var	parentIdtoDelete=0;
var commentIDtoEdit=0;
var editorOriginalValue;
var editor;

function translateComment(commentID,srcLang){
	$("#commentText"+commentID).translate(srcLang, 'de');
}
/*
hide / make opaque flash
http://www.communitymx.com/content/article.cfm?cid=E5141
http://stackoverflow.com/questions/1825792/jquery-hide-a-div-that-contains-flash-without-resetting-it
*/
function hideSubmitWindow () {
	$("#submitComment").css({left:-1000,top:-1000});	
	$(".media_embed").show();	
	submitWindowActive=false;
}

function showSubmitWindow () {
	$(".media_embed").hide();	
	if ( editor ) {
		editor.destroy();
	}
		
	$("#submitComment").fadeIn('slow');
	submitWindowActive=true;
}


function hideEditWindow () {
	if ( editor ) {
		editor.destroy();
		editor=null;
	}	
	if (commentIDtoEdit!=0) {
		$("#commentText"+commentIDtoEdit).html(editorOriginalValue);
	}
	commentIDtoEdit=0;
	$("#editActions").fadeOut('slow');
}

function showEditWindow() {
	$("#deleteWindow").hide();
	hideSubmitWindow();
}


$(document).ready(function(){
	$("#BookmarkButton").bookmark({
		url: 'http://<?=$_SERVER['SERVER_NAME'].getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID) )?>',
		title: 'Flying',
		description:'Look at this flight',
		popup: true,
		popupText:'<img src="<?=$moduleRelPath?>/img/share.gif" border="0">',
		addEmail: true,
		compact: false,
		sites: ['facebook','delicious', 'digg','reddit','twitter','bookmarkit','myspace','stumbleupon']
	});


	CKEDITOR.replace( 'commentBox' );

 	$('.myCaptcha').sexyCaptcha('<?=moduleRelPath()?>/js/sexy-captcha/captcha.process.php');


	//---------------------------------------------------------------------
	// --------------------- REPLY ----------------------------------------
	//---------------------------------------------------------------------
	$(".reply").live('click',function(f) {
		if (submitWindowActive) {
			hideSubmitWindow();
		} else {
			$("#deleteWindow").hide();
			hideEditWindow();
			
			$("#submitComment").css({			
								left:$("#commentsContainer").offset().left,
								top:$(this).offset().top+$(this).height()+6
			});	
			showSubmitWindow();
			
			parent=$(this).attr('id').substring(6);			
			// $("#submitComment").show();
		}
	});
	
	$(".cancelSubmit").click(function(f) {
		hideSubmitWindow();
	});
	
	$(".submit").click(function(f) {
		hideSubmitWindow();

		var oEditor = CKEDITOR.instances.commentBox;
		var commentText=oEditor.getData();
		//$("#replyText").html( commentText );
		
		// var parent=$(this).attr('id'); 
		//
		var guestName=$("#guestName").val();
		var guestEmail=$("#guestEmail").val();
		var guestPass=$("#guestPass").val();
		var userID=$("#userID").val();
		var userServerID=$("#userServerID").val();
		var languageCode=$("#languageCode").val();
		
		// find the depth of this comment and add 1
		var newDepth=0;
		if (parent!=0) {
			var classList =$("#comment_"+parent).attr('class').split(/\s+/);
			$.each( classList, function(index, item){
				if (item.substring(0,5) == 'depth') {
				   newDepth=parseInt(item.substring(5))+1;
				   //$('#replyText').append("newDepth:"+newDepth+" ");
				}
				//$('#replyText').append(item);
			});
		} 
		
		var lastChild;
		if (parent) lastChild=$("#comment_"+parent);
		
		var lastChildID=0;
		// we need the LAST child of this comment to append our div after that..
		$('.parentFinder').each(function(index) {			
			if ( $(this).attr('id') == ("pid_"+parent) ) {
				// parent is cid_$commentID
				lastChildID=$(this).parent().attr('id').substring(4);
				//$('#replyText').append("found child with id "+lastChildID);
			}     		
		});
		
		if (lastChildID) { // found childs
			lastChild=$("#comment_"+lastChildID);
		}
		
		$.post('<?=moduleRelPath()?>/EXT_comments_functions.php', 
			{ op:"add" , flightID: <?=$flightID?>, parentID: parent ,
				userID:userID, userServerID:userServerID, languageCode:languageCode,
				guestName: guestName , guestEmail: guestEmail,
				depth: newDepth,
				commentText: commentText , leonardoAllowAll: 1 } ,
			function(data) {
				if (lastChild) {

					// first insert the new comment				  	
					lastChild.after(data);					
					var newCommentDiv=lastChild.next();
					// hide it 
					newCommentDiv.hide();
					
					// scroll into place 
   					var x = lastChild.offset().top - 100; // 100 provides buffer in viewport
   					$('html,body').animate({scrollTop: x}, 500);

					// now show it
					// newCommentDiv.fadeIn('slow');
					setTimeout( function() { newCommentDiv.fadeIn(1000); }, 200 );  
					

				} else { // no comments yet
					$("#replyText").after(data);
				} 
			  // $('#replyText').html(data);
			}
		);

	});
	
	//---------------------------------------------------------------------
	// --------------------- EDIT -----------------------------------------
	//---------------------------------------------------------------------
		
	$(".edit").live('click',function(f) {
		// commentIDtoEdit=0;
		hideEditWindow();
		commentIDtoEdit=$(this).attr('id').substring(4);
	 	// $('#replyText').html(commentIDtoEdit);
		showEditWindow();
		
		editorOriginalValue=$("#commentText"+commentIDtoEdit).html();
		
		editor = CKEDITOR.replace( 'commentText'+commentIDtoEdit );
		$("#editActions").css({
					left:$("#commentsContainer").offset().left,
					top:$("#comment_"+commentIDtoEdit).offset().top -45 // $("#editActions").height()
		}).fadeIn('slow');
		// $("#editActions").fadeIn('slow');	
		
	});
	
	$(".editConfirm").click(function(f) {
	
		var commentText=editor.getData();
		var commentID=commentIDtoEdit;

		commentIDtoEdit=0;
		hideEditWindow();	
		
		$.post('<?=moduleRelPath()?>/EXT_comments_functions.php', 
			{ op:"edit" , flightID: <?=$flightID?>, commentID: commentID , commentText: commentText , leonardoAllowAll: 1 } ,
			function(data) {
			  //$('#replyText').html(data);
			  $('#commentText'+commentID).html(commentText);	
			}
		);
		
	});
	
	$(".editCancel").click(function(f) {
		hideEditWindow();
	});

	//---------------------------------------------------------------------
	// --------------------- DELETE ---------------------------------------
	//---------------------------------------------------------------------	
	$(".delete").live('click',function(f) {
		hideSubmitWindow();
		hideEditWindow();
		
		commentIdtoDelete=$(this).attr('id').substring(6);
		parentIdtoDelete=$(this).children(':first-child').attr('id').substring(7);
		
		
		$("#deleteWindow").css({
					left:$("#commentsContainer").offset().left,
					top:$(this).offset().top+$(this).height()+6
		}).fadeIn('slow');
	});

	$(".deleteConfirm").click(function(f) {
		$("#deleteWindow").fadeOut('fast');	
		$.post('<?=moduleRelPath()?>/EXT_comments_functions.php', 
			{ op:"delete" , flightID: <?=$flightID?>, commentID: commentIdtoDelete , parentID: parentIdtoDelete } ,
			function(data) {
			 // $('#replyText').html(data);
			  $('#comment_'+commentIdtoDelete).fadeOut('slow');	
			}
		);
		
	});
	
	$(".deleteCancel").click(function(f) {
		commentIdtoDelete=0;
		$("#deleteWindow").fadeOut('slow');	
	});


});
</script>

<div id='submitComment' >
<form action="#" method="post">
<? 
// caching pilot names in an array
$pilotNames=array();


if ($userID) { 

			$imgBigRel=getPilotPhotoRelFilename($userServerID,$userID);	
			$imgBig=getPilotPhotoFilename($userServerID,$userID);	
			if (is_file($imgBig) ) {
					list($width, $height, $type, $attr) = getimagesize($imgBig);
					list($width2, $height2)=CLimage::getJPG_NewSize($CONF['photos']['tiny']['max_width'], $CONF['photos']['tiny']['max_height'], $width, $height);
					echo "<a href='$imgBigRel' target='_blank'><img src='".
							getPilotPhotoRelFilename($userServerID,$userID,1).
							"' width='$width2' height='$height2' align='absmiddle'  border=0></a>";
			} else {
				echo "<img src='$moduleRelPath/img/photo_no_profile_photo.jpg' width='50' height='50' align='absmiddle' border=0>";
			}		 			 
			 
			$name=$pilotNames[$userID][$userServerID];
			if (!$name) {			
					$name=getPilotRealName($userID,$userServerID+0,1,1,1);
					$pilotNames[$userID][$userServerID]=$name;
			}	 
			echo "&nbsp;Logged in as: $name";
?>
&nbsp;&nbsp;<input type="button" class="submit" value=" Submit Comment " />&nbsp;&nbsp;

<input type="hidden" id="userID" value="<?=$userID?>"/>
<input type="hidden" id="userServerID" value="<?=($userServerID+0)?>"/>

<input type="hidden" id="guestName" value=""/>
<input type="hidden" id="guestPass" value=""/>
<input type="hidden" id="guestEmail" value=""/>


<? } else { ?>
<input type="hidden" id="userID" value="0"/>
<input type="hidden" id="userServerID" value="0"/>
<table cellpadding="0" cellspacing="0" border="0" style='margin-left:5px'><tr><td width="400">
<input type="text" id="guestName"/><span class="titles">Name</span><span class="star">*</span><br />
<input type="text" id="guestPass"/><span class="titles">Password</span><span class="star">*</span><br />
<input type="text" id="guestEmail"/><span class="titles">Email</span><span class="star">*</span><br />
</td><td>
<div style='position:absolute; top:20px; left:450px;'><input type="button" class="submit" value=" Submit Comment " /></div>
<div class="myCaptcha"></div>
</td></tr>
</table>
<? } ?>

<input type="hidden" id="languageCode" value="<?=$lang2iso[$currentlang]?>"/>
<textarea name="commentBox" id="commentBox" cols="120" rows="10"></textarea><br />

<div align='right'><input type="button" class="cancelSubmit" value=" Cancel" />&nbsp;&nbsp;</div>
</form>
</div>


<div id='deleteWindow'>
Are you sure you want to delete this comment?
<span class='deleteConfirm'>yes</span> <span class='deleteCancel'>No - Cancel</span>
</div>

<div id='editActions'>
<span class='editConfirm'>Save changes</span> <span class='editCancel'>Cancel</span>
</div>


<div id='commentsContainer' style='width:720px'>

<table border='0' cellpadding=5 width='100%'><tr>
<td width="350">
	<div id='parent0' class='commentActions reply' style='width:200px; height:24px; padding-top:8px; font-size:16px;'>Leave a comment</div>
</td>
<td align="left">
	<div id="BookmarkButton" ></div>
</td>
<td>
  <?
  echo "<a href='".moduleRelPath()."/rss.php?op=comments&flightID=$flightID'>".
  		leoHtml::img("rss.gif",0,0,'','','icons1')."</a>";
 ?>		
</td>
</tr>
</table>

<div style='clear:both'></div>


<div id='replyText'></div>

<?
		// now the access rights :
		$moderatorRights=false;
		if ( ($flight->userID==$userID && $flight->userServerID==$userServerID ) || 
				L_auth::isModerator($userID)  ) {
			$moderatorRights=true;
		}


		$str='';
		foreach($flightComments->threads as $thread) {	
			$commentID=$thread['id'];
			$commentData=$flightComments->comments[$thread['id']];	
			$commentDepth=$thread['depth'];
			
			include dirname(__FILE__).'/INC_comment_row.php';
		}
		echo  $str;
		


?>
</div>
</body>
