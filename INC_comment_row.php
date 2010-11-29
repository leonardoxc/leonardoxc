<?
// called directly ?		
if (!$commentID) exit;

// we get these from the caller
//	$commentID=$thread['id'];			
//	$commentData=$flightComments->comments[$thread['id']];			
//	$commentDepth=$thread['depth'];

$str.="\n\n\n<div id='comment_$commentID' class='commentBox depth$commentDepth'>";
// helper hidden div
$str.="<span id='cid_$commentID'>
<span id='pid_".$commentData['parentID']."' class='parentFinder'></span></span>";
			
			
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

$langName=array_search ($commentData['languageCode'], $lang2isoEditor);
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
	 
	 $userInfo="<a href=\"javascript:pilotTip.newTip('inline', 0, 13, 'p_$commentID', 250, '".$commentData["userServerID"]."_".$commentData["userID"]."','".addslashes($name)."' )\"  onmouseout=\"pilotTip.hide()\">$name</a>\n";

} else {
	$userInfo="Guest: ".$commentData['guestName']." ";
}
$translateText="<span><a id='translate_".$commentData['commentID']."' href='javascript:translateComment(".$commentData['commentID'].",\"".$commentData['languageCode']."\")'>"._Translate.
				leoHtml::img("icon_arrow_down.gif",0,0,'absmiddle','','icons1')."</a></span>";

$str.="<div class='actionBox' id='p_$commentID'>";
$str.="<div class='commentInfo'>".$userInfo." @ ".$commentData['dateUpdated']." GMT $flagImg $translateText&nbsp;&nbsp;&nbsp;</div>";

if ($CONF['comments']['guestComments'] || $userID>0 ) {
	$str.="<div id='parent$commentID' class='commentActions reply'>"._Reply."</div>";
}

if ($moderatorRights || $flight->belongsToUser($userID)) { 

	$str.="<div id='edit$commentID'  class='commentActionsIcons edit'><img src='$moduleRelPath/img/change_icon.png'></div>";
	$str.="<div id='delete$commentID' class='commentActionsIcons delete'><img 
			id='deletep".$commentData['parentID']."' src='$moduleRelPath/img/delete_icon.png'></div>";

}
//	$str.="<div style='clear:both'></div>";
$str.="</div>";
$str.="</td></tr>";

$str.="</table>";

$str.="</div>\n";
		
		
?>