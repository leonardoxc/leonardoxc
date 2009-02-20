<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<title>FAI/CIVL ID</title>
</head>
<link rel="stylesheet" href=".//templates/basic/tpl/style.css" type="text/css">
<!--[if IE]>
<style type="text/css">
/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url(".//templates/basic/tpl/formIE.css");
</style>
<![endif]-->
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

function MWJ_findSelect( oName, oDoc ) { //get a reference to the select box using its name
    
    if( !oDoc ) { oDoc = window.opener.document; }
    for( var x = 0; x < oDoc.forms.length; x++ ) { if( oDoc.forms[x][oName] ) { return oDoc.forms[x][oName]; } }
    for( var x = 0; document.layers && x < oDoc.layers.length; x++ ) { //scan layers ...
        var theOb = MWJ_findObj( oName, oDoc.layers[x].document ); if( theOb ) { return theOb; } }
    return null; 
}

function setSelect( y, v) {
    y = MWJ_findSelect( y );
    for( var x = 0; x < y.options.length; x++ ) 
    { 
        if( y.options[x].value == '' + v + '' ) 
        { 
            y.options[x].selected = true; 
            if( window.opera && document.importNode ) 
            { 
                window.setTimeout('MWJ_findSelect( \''+y.name+'\' ).options['+x+'].selected = true;',0); 
            } 
        } 
    }
}

function setField(CIVL_ID,NAME,HNATION,SEX) { 
    var nametosplit = NAME;
    if (!window.opener) {
        alert('Wrong calling of this page');
        window.close();
    } else {
        if (checknumber(CIVL_ID)) {            
            MWJ_findObj('<?=$_GET['callingfield']?>', null, window.opener.document).value=CIVL_ID;
            MWJ_findObj('name', null, window.opener.document).value=nametosplit;  
            var Nme = nametosplit.split(" ");
            var Fname,Lname;
            if(Nme.length > 0){
            Lname=Nme[Nme.length - 1];
            Fname=nametosplit.replace(Lname,'');           
            MWJ_findObj('lastname', null, window.opener.document).value=Lname; 
            MWJ_findObj('firstname', null, window.opener.document).value=Fname;
             }
            var strSex='';
            SEX=='true'?strSex='F':strSex='M';
            setSelect('gender',strSex);        
            setSelect('nation',HNATION);
            window.close();
        } else {
            return false;
        }
    }

}
</script>
<?
if(!isset($_POST['civl_name'])){
?>
       <form method="post" action=""> 
        <table width="70%"> 
          <tr class=header> 
            <td><u>Nome CIVL</u> </td><td><input type="text" name="civl_name"><font color="ff0000">*</font></td>               
             <td> <input type="submit" value="Procurar por nome">   
            </td> 
          </tr> 
        </table> 
      </form>
<?}else{?>
<table width="70%"> 
<strong>CIVL ID </strong>
<?
require_once("lib/soap/nusoap.php");
$wsdlURL = "http://civlrankings.fai.org/FL.asmx?wsdl";
$soap = new nusoap_client($wsdlURL, "wsdl");
$parameters['parameters']['name'] = trim(utf8_decode($_POST['civl_name']));
$result = $soap->call("FindPilot", $parameters);
if($result['FindPilotResult']['Person']['Name']){
    $i=0;
$person=$result['FindPilotResult']['Person'];
//print $person['Name'] ." " .$person['CIVLID']. " ".$person['ISO3166_1_a3']." ".$person['Nation']." ".$person['Female']." ".$person['Sponsor']." ".$person['Glider']." ".$person['Glider_main_colors']."<br>";
?> 
<form name="s_<?=$i;?>" action="" method="POST" target="">
<input type="hidden" name="HNATION"  value="<?=$person['ISO3166_1_a3']?>">
<input type="hidden" name="SEX"  value="<?=$person['Female'];?>">
<tr class=header>
<td><input type="text" name="NAME"  value="<?=utf8_encode($person['Name']);?>" readonly="" size="40" ></td>
<td><input type="text" name="CIVL_ID"  value="<?=$person['CIVLID']?>" readonly="" size="8" ></td> 
<td><input type="text" name="NATION"  value="<?=$person['Nation']?>" readonly="" size="15" ></td>
<td><input name="okbutton" type="button" value="Insert CIVL ID" onClick="return setField(this.form.CIVL_ID.value,this.form.NAME.value,this.form.HNATION.value,this.form.SEX.value);"></td> 
<td><input type="button" name="cancelbutton"  value="Cancel" onClick="window.close();" ></td>
</tr>
</form> 
<?
}
else{
    $i=0;
foreach($result['FindPilotResult']['Person'] as $person){
//print $person['Name'] ." " .$person['CIVLID']. " ".$person['ISO3166_1_a3']." ".$person['Nation']." ".$person['Female']." ".$person['Sponsor']." ".$person['Glider']." ".$person['Glider_main_colors']."<br>";

       // print $person['Name'] ." " .$person['CIVLID']. " ".$person['ISO3166_1_a3']." ".$person['Nation']." ".$person['Female']." ".$person['Sponsor']." ".$person['Glider']." ".$person['Glider_main_colors']."<br>";
?> 
<form name="s_<?=$i;?>" action="" method="POST" target="">
<input type="hidden" name="HNATION"  value="<?=$person['ISO3166_1_a3']?>">
<input type="hidden" name="SEX"  value="<?=$person['Female'];?>">  
<tr class=header>
<td><input type="text" name="NAME"  value="<?=utf8_encode($person['Name']);?>" readonly="" size="40" ></td>
<td><input type="text" name="CIVL_ID"  value="<?=$person['CIVLID']?>" readonly="" size="8" ></td> 
<td><input type="text" name="NATION"  value="<?=$person['Nation']?>" readonly="" size="15" ></td>
<td><input name="okbutton" type="button" value="Insert CIVL ID" onClick="return setField(this.form.CIVL_ID.value,this.form.NAME.value,this.form.HNATION.value,this.form.SEX.value);"></td> 
<td><input type="button" name="cancelbutton"  value="Cancel" onClick="window.close();" ></td>
</tr>
</form> 
<?
$i++;
    }
}
}
?>
 </table> 
</body>
</html>
