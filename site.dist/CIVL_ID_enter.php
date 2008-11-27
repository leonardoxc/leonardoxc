<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >
<html>
<head>
<title>FAI/CIVL ID</title>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">


</head>
<body style="margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:0px;">
<script language="javascript">
function MWJ_findObj( oName, oFrame, oDoc ) {
	if( !oDoc ) { if( oFrame ) { oDoc = oFrame.document; } else { oDoc = window.document; } }
	if( oDoc[oName] ) { return oDoc[oName]; } if( oDoc.all && oDoc.all[oName] ) { return oDoc.all[oName]; }
	if( oDoc.getElementById && oDoc.getElementById(oName) ) { return oDoc.getElementById(oName); }
	for( var x = 0; x < oDoc.forms.length; x++ ) { if( oDoc.forms[x][oName] ) { return oDoc.forms[x][oName]; } }
	for( var x = 0; x < oDoc.anchors.length; x++ ) { if( oDoc.anchors[x].name == oName ) { return oDoc.anchors[x]; } }
	for( var x = 0; document.layers && x < oDoc.layers.length; x++ ) {
		var theOb = MWJ_findObj( oName, null, oDoc.layers[x].document ); if( theOb ) { return theOb; } }
	if( !oFrame && window[oName] ) { return window[oName]; } if( oFrame && oFrame[oName] ) { return oFrame[oName]; }
	for( var x = 0; oFrame && oFrame.frames && x < oFrame.frames.length; x++ ) {
		var theOb = MWJ_findObj( oName, oFrame.frames[x], oFrame.frames[x].document ); if( theOb ) { return theOb; } }
	return null;
}

function checknumber(num){
	 var charpos = num.search("[^0-9]"); 
     if( num.length == 0 ||  charpos >= 0)  { 
		alert("Please enter a valid ID"); 
		return false; 
     }
	return true;
}

function setField() {
	if (!window.opener) {
		alert('Wrong calling of this page');
		window.close();
	} else {
		var CIVL_ID=MWJ_findObj('CIVL_ID').value;
		if (checknumber(CIVL_ID)) {
			MWJ_findObj('<?=$_GET['callingfield']?>', null, window.opener.document).value=CIVL_ID;
			window.close();
		} else {
			return false;
		}
	}

}
</script>

<form name="standform" action="" method="POST" target="" onSubmit="return setField();">

Please use the CIVL interface to find your CIVL ID and fill it in here
<br>
<strong>CIVL ID </strong>
<input type="text" name="CIVL_ID"  value="" >
<input name="okbutton" type="submit" value="Insert CIVL ID" >
<input type="button" name="cancelbutton"  value="Cancel"  onclick="window.close();" >
<br>
<iframe src="http://civlrankings.fai.org/FL.aspx?a=306&" width=100% height=400></iframe>
</form>

</body>
</html>
