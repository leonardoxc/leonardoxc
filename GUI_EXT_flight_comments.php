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
// $Id: GUI_EXT_flight_comments.php,v 1.5 2010/11/15 22:03:13 manolis Exp $                                                                 
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
  
<link href="<?=$moduleRelPath."/templates/".$PREFS->themeName."/style.css"; ?>" rel="stylesheet" type="text/css">

<style type="text/css">
/*
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
*/
  

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
	
	
	a {
	text-decoration:none;
	color:#d02b55;
	}
	a:hover
	{
	text-decoration:underline;
	color:#d02b55;
	}
	
	*{margin:0;padding:0;}
	/*
	ol.timeline
	{list-style:none;font-size:1.2em;}
	ol.timeline li{ display:none;position:relative;padding:.7em 0 .6em 0;}ol.timeline li:first-child{}
	*/
	
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

#deleteWindow{
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

.commentActions , .commentActionsIcons, .deleteConfirm, .deleteCancel{
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

.deleteConfirm, .deleteCancel{
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
	/*margin-top:-5px;
	
	height:25px;
	*/
	float:right;
	clear:both;
}

.commentBox {
		background-color:#EEECE8;
		border-bottom:#E8E9DC 1px solid;		
		margin-bottom: 5px;
		
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

<link href="<?=moduleRelPath()?>/js/sexy-captcha/css/styles.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--

img.brands { background: url(<?=$moduleRelPath?>/img/sprite_brands.png) no-repeat left top; }
img.fl {   background: url(<?=$moduleRelPath?>/img/sprite_flags.png) no-repeat left top ; }
img.icons1 {   background: url(<?=$moduleRelPath?>/img/sprite_icons1.png) no-repeat left  top ; }
-->
</style>
<link rel="stylesheet" type="text/css" href="<?=moduleRelPath()?>/templates/<?=$PREFS->themeName?>/sprites.css">

<script type="text/javascript" src="<?=moduleRelPath()?>/js/jquery.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/xns.js"></script>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/DHTML_functions.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/sexy-captcha/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/sexy-captcha/jquery.sexy-captcha-0.1.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/jquery.translate.js"></script>


<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>


<? 
echo makePilotPopup();
?>

<script language="javascript">

var parent=0;
var submitWindowActive=false;
var commentIdtoDelete=0;
var	parentIdtoDelete=0;

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
	$("#submitComment").fadeIn('slow');
	submitWindowActive=true;
}

function editComment( ev )
{
	// Get the element which fired the event. This is not necessarily the
	// element to which the event has been attached.
	var element = ev.target || ev.srcElement;

	// Find out the div that holds this element.
	element = element.parentNode;

	if ( element.nodeName.toLowerCase() == 'div'
		 && ( element.className.indexOf( 'editable' ) != -1 ) )
		replaceDiv( element );
}

var editor;

function replaceDiv( div ) {
	if ( editor )
		editor.destroy();
	editor = CKEDITOR.replace( div );
}


$(document).ready(function(){
	CKEDITOR.replace( 'commentBox' );

 	$('.myCaptcha').sexyCaptcha('<?=moduleRelPath()?>/js/sexy-captcha/captcha.process.php');

	$(".cancelSubmit").click(function(f) {
		hideSubmitWindow();
	});


	$(".reply").click(function(f) {
		if (submitWindowActive) {
			hideSubmitWindow();
		} else {
			$("#deleteWindow").hide();
			$("#submitComment").css({			
								left:$("#commentsContainer").offset().left,
								top:$(this).offset().top+$(this).height()+6
			});	
			showSubmitWindow();
			
			parent=$(this).attr('id').substring(6);			
			// $("#submitComment").show();
		}
	});

	$(".edit").click(function(f) {
		var commentID=$(this).attr('id').substring(4);
		
		if ( editor ) {
			editor.destroy();
		}
		editor = CKEDITOR.replace( 'commentText'+commentID );
	
		return;
		/*
		if (submitWindowActive) {
			hideSubmitWindow();
		} else {
			$("#deleteWindow").hide();
			$("#submitComment").css({			
								left:$("#commentsContainer").offset().left,
								top:$(this).offset().top+$(this).height()+6
			});	
			showSubmitWindow();
			
			parent=$(this).attr('id').substring(6);			
			// $("#submitComment").show();
		}
		*/
	});
	
	$(".delete").click(function(f) {
		hideSubmitWindow();
		
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
			  $('#replyText').html(data);
			  $('#comment_'+commentIdtoDelete).fadeOut('slow');	
			}
		);
		
	});
	
	$(".deleteCancel").click(function(f) {
		commentIdtoDelete=0;
		$("#deleteWindow").fadeOut('slow');	
	});
	
	$(".submit").click(function(f) {

		hideSubmitWindow();

		
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
		
		$.post('<?=moduleRelPath()?>/EXT_comments_functions.php', 
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
<? 
// debug
//  $userID=0;
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

<div id='commentsContainer' style='width:720px'>
<div id='parent0' class='commentActions reply' style='width:200px;'>Leave a comment</div>
<div style='clear:both'></div>

<div id='replyText'>...</div>
<?
		// now the access rights :
		$moderatorRights=false;
		if ( ($flight->userID==$userID && $flight->userServerID==$userServerID ) || 
				L_auth::isModerator($userID)  ) {
			$moderatorRights=true;
		}


		$str='';
		$i=0;
		foreach($flightComments->threads as $thread) {	
			$i++;	
			$commentID=$thread['id'];
			$commentData=$flightComments->comments[$thread['id']];			
			$str.="<div id='comment_$commentID' class='commentBox depth".$thread['depth']."'>";
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
					$header="<img src='$moduleRelPath/img/photo_no_profile_photo.jpg' width='50' height='50'  border=0>";
				}
					
				$str.="<tr><td rowspan='2' width='65'  valign='top'><div class='commentHeader'>$header</div></td>";
				$str.="<td valign='top'><div id='commentText$commentID' class='commentBody'>".$commentData['text']."</div></td></tr>";
			} else {
			
				$header="<img src='$moduleRelPath/img/photo_guest.jpg' width='50' height='50'  border=0>";

				$str.="<tr><td rowspan='2' width='65'  valign='top'><div class='commentHeader'>$header</div></td>";
				$str.="<td valign='top'><div id='commentText$commentID' class='commentBody'>".$commentData['text']."</div></td></tr>";
				
				//$str.="<div class='commentHeaderGuest'>".$commentData['guestName']."</div>";
				//$str.="<div class='commentBodyGuest'>".$commentData['text']."</div>";
			}
			
			$langName=array_search ($commentData['languageCode'], $lang2iso);
			$flagCode=$CONF['lang']['lang2countryFlag'][$langName];
			// echo "flag_code: $flagCode";
			
			$flagImg=leoHtml::img($flagCode.".gif",18,12,'absmiddle',_LANGUAGE,'fl');
			$str.="<tr><td valign='bottom'>";
			
			
			if ($commentData['userID']) {
				 $name=$pilotNames[$commentData["userID"]][$commentData["userServerID"]];
				 if (!$name) {
					 $name=getPilotRealName($commentData["userID"],$commentData["userServerID"],1,1,1);
					 $pilotNames[$commentData["userID"]][$commentData["userServerID"]]=$name;
				 }	 
			     $name=prepare_for_js($name);
				 
			 	 $userInfo="<a href=\"javascript:pilotTip.newTip('inline', 0, 13, 'p_$i', 250, '".$commentData["userServerID"]."_".$commentData["userID"]."','".addslashes($name)."' )\"  onmouseout=\"pilotTip.hide()\">$name</a>\n";
		 
			} else {
				$userInfo="Guest: ".$commentData['guestName']." ";
			}
			$translateText="<span ><a href='javascript:translateComment(".$commentData['commentID'].",\"".$commentData['languageCode']."\")'>Translate</a></span>";
			
			$str.="<div class='actionBox' id='p_$i'>";
			$str.="<div class='commentInfo'>".$userInfo." @ ".$commentData['dateUpdated']." GMT $flagImg $translateText</div>";
			
			$str.="<div id='parent$commentID' class='commentActions reply'>Reply</div>";
			if ($moderatorRights || $commentData['userID']==$userID) {
				$str.="<div id='edit$commentID'  class='commentActionsIcons edit'><img src='$moduleRelPath/img/change_icon.png'></div>";
				$str.="<div id='delete$commentID' class='commentActionsIcons delete'><img 
						id='deletep".$commentData['parentID']."' src='$moduleRelPath/img/delete_icon.png'></div>";

			}
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
