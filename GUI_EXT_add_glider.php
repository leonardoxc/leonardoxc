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
// $Id: GUI_EXT_set_club.php,v 1.10 2010/03/14 20:56:10 manolis Exp $                                                                 
//
//************************************************************************

/**
 * Dialog to select one NAC-club
 * Modification Martin Jursa 22.05.2007 to work with MENU_nacclubs_simple
 */
 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
 	require_once dirname(__FILE__)."/EXT_config.php";

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

	require_once dirname(__FILE__)."/CL_brands.php";

	$brandID=$_REQUEST['brandID']+0;

	// print_r($clubList);
  ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  >
<html>
<head>
  <title><?=_Add_Your_Glider?></title>
  <meta http-equiv="content-type" content="text/html; charset=<?=$CONF_ENCODING?>">

    <script type="text/javascript" src="<? echo $moduleRelPath; ?>/js/google_maps/jquery.js"></script>

<style type="text/css">
	html {
		height: 100%;
	}
	body, p, table,tr,td {
		font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;
        padding:4px;
	}
    br {
        padding:4px;
        margin:10px;
    }
	body {
		margin:0px;
		background-color:#E9E9E9;
        background-color: rgb(207, 226, 207);

        height: 100%;
	}
	.box {
	 	background-color:#F4F0D5;
        background-color: rgb(207, 226, 207);

        border:1px solid #555555;
		padding:3px;
		margin-bottom:5px;
	}
	.boxTop {margin:0; }

    .glider_warning {
        width:300px;
        background-color: rgb(226, 68, 61);
        color: #ffffff;
        border:1px solid #555555;
        padding:3px;
        margin-bottom:5px;
        margin-top:5px;
    }

    .gliderSelect {
        width:300px;
        padding:4px;
        text-align: left;
        cursor:pointer;
        border:1px solid #bfbfbf;
        background-color: #f0f0f0;
        margin-bottom:2px;
    }
</style>
<script type="text/javascript" language="javascript">

    function refreshParent() {
        topWinRef=top.location.href;
        top.window.location.href=topWinRef;
    }
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

    //function setValToMaster(glider,gliderBrandID,gliderCat,gliderCertCategorySelect,category) {
    function setValToMaster(sel) {
        if (!window.opener) {
            alert('Parent window not available');
        }else {

        /*    data-gliderID='".$glider['gliderID']."'
            data-gliderSize='".$glider['gliderSize']."'
            data-brandID='".$glider['brandID']."'
            data-gliderName='".$glider['gliderName']."'
            data-gliderCert='".$glider['gliderCert']."'
            */

            var glider=$(sel).data('glideraname');
            var gliderID=$(sel).data('gliderid');
            var gliderBrandID=$(sel).data('brandid');
            var gliderCat=1; // $(sel).data('gliderid');
            var gliderCertCategorySelect=$(sel).data('glidercert');
            var category=1; //$(sel).data('gliderid');


            var gliderBrandID0=MWJ_findObj('gliderBrandID','',window.opener.document);
            gliderBrandID0.value=gliderBrandID;

            var gliderID0=MWJ_findObj('gliderID','',window.opener.document);
            gliderID0.value=gliderID;

            window.opener.selectBrand2(gliderID);

            //var glider0=MWJ_findObj('glider','',window.opener.document);
            //glider0.value=glider;


            //window.opener.selectGlider();
            //window.opener.selectBrand();

            //var gliderCat0=MWJ_findObj('gliderCat','',window.opener.document);
            //gliderCat0.value=gliderCat;
            //window.opener.selectGliderCat();

            //var gliderCertCategorySelect0=MWJ_findObj('gliderCertCategorySelect','',window.opener.document);
            //gliderCertCategorySelect0.value=gliderCertCategorySelect;
            //window.opener.selectGliderCertCategory(category);
        }
        window.close();
    }

function findsimilar(glider) {

    $("#similarGliders").load("<? echo $moduleRelPath; ?>/AJAX_gliders.php?op=similar_glider&glider="+glider).show();

}

function submitForm() {
    var error='';
    if ( $("#gliderBrandID").val() ==0 ) {
        error+="* Please select brand\n";
        $("#gliderBrandID").addClass('highlight');
    }
    if ( ! $("#gliderName").val()  ) {
        error+="* Please provide the glider name\n";
        $("#gliderName").addClass('highlight');
    }
    if ( ! $("#gliderSize").val()  ) {
        error+="* Please select size\n";
        $("#gliderSize").addClass('highlight');
    }
    if (  $("#gliderCert").val()==0  ) {
        error+="* Please select glider certification\n";
        $("#gliderCert").addClass('highlight');
    }

    if ( error) {
        alert(error);
        return false;
    }

    $("#addGliderForm").submit();
    return true;
}
$( document ).ready(function() {

    $("body" ).on("focus",".selectFields",function() {
        $( this ).removeClass('highlight');
        $( this ).addClass('normal');
    });

    $("#gliderName").on('keyup',function() {
        findsimilar( $("#gliderName").val() );
    });

    $(document).on('click',".gliderSelect",function() {
        setValToMaster( this );
    });

});



function closeWindow() {

    window.opener.$("#gliderBrandID").val(0);



    window.close();
}

</script>
<style type="text/css">
  <!--
  .highlight {
      background-color: #df99a1;
  }
  .normal {
      background-color: none;
  }
  .errors {background-color: #df99a1;
  width:100%;
  font-weight: bold;}

  .success   {background-color: #53b920;
      width:100%;
      padding:10px;
      font-size:14px;
      font-weight: bold;}

  #similarGliders {
      display: none;
  }
  -->
</style>
</head>
<body>
<?
if ($_POST['gliderBrandID'] ) {

    //check for correct values
    $gliderBrandID=$_POST['gliderBrandID']+0;
    $gliderName=makeSane($_POST['gliderName']);
    $gliderSize=$_POST['gliderSize'];
    $gliderCert=$_POST['gliderCert']+0;

    $error='';
    if (! $gliderBrandID) {
        $error.=_Please_provide_the_Brand_of_the_Glider."<BR>";
    }
    if (! $gliderName) {
        $error.=_Please_provide_the_Name_of_the_Glider."<BR>";
    }
    $gliderSizeInt=$gliderSize+0;
    $gliderSize=strtoupper($gliderSize);
 	$gliderSizes=array("XXS","XS","S","MS","M","ML","L","XL","XLL");
    

    $isSizeOK=($gliderSizeInt >= 10 && $gliderSizeInt<= 40) || in_array( $gliderSize,$gliderSizes) ;
    if ( ! $isSizeOK ) {
        $error.=_Please_provide_the_Glider_Size."<BR>";
    }
    if (! $gliderCert) {
        $error.=_Please_provide_the_Glider_Certification_Category."<BR>";
    }
    
    if ($error) {

        echo "<div class='errors'>$error</div>";
        //echo "</body></html>";

    } else {
		//P.Wild 18.12.2014 - check for already exsisting gliders
		$query="SELECT * FROM leonardo_gliders WHERE `brandID`='$gliderBrandID' AND `gliderName`='$gliderName' AND `gliderSize`='$gliderSize' ";
    	
		$result = mysql_query($query);
		$num_rows = mysql_num_rows($result);
    	if ($num_rows) {
    		$error=_Glider_already_exists;
    		echo "<div class='errors'>$error</div>";
    		//echo $query."<br>";
    		//echo $num_rows;
    	}
    	else{
    	$today=date("Y-m-d"); 
    	$query="INSERT INTO leonardo_gliders (`gliderID`,`brandID`,`gliderName`,`gliderSize`,`gliderCert`,`DHV_ID`,`CertificationDate`)
    	VALUES ('','$gliderBrandID','$gliderName','$gliderSize','$gliderCert','9999','$today') ";
    	$res= $db->sql_query($query);
        if($res <=0 ){
            echo "<div class='errors'>Error in query $query</div>";
        } else {
            $result = mysql_query("SELECT * FROM leonardo_gliders WHERE gliderID = LAST_INSERT_ID();");
            $row = mysql_fetch_array($result);
             echo "<div class='success'>"._Glider_added."</div>";
        }
    	}
?>
   <input type='hidden' class='selectFields' name="gliderBrandID" id="gliderBrandID" value='<? echo $gliderBrandID?>' >
   <input type='hidden' class='selectFields' name="gliderName" id="gliderName" value='<? echo $gliderName?>' >
   <input type='hidden' class='selectFields' name="gliderSize" id="gliderSize" value='<? echo $gliderSize?>' >
   <input type='hidden' class='selectFields' name="gliderCert" id="gliderCert" value='<? echo $gliderCert?>' >

       <br>
       <div align='center'>
    <input type="button" name="Submit3" value="<? echo _Return?>"  onclick="closeWindow()" />
       </div>

<script type="text/javascript" language="javascript">

    $( document ).ready(function() {
     //   refreshParent();

    });

</script>
<?

        echo "</body></html>";
        return;
    }


}
?>


<form name="addGliderForm" id="addGliderForm" method="post" action="" style="height:100%;width:100%;">
	<table  height="600" border="0" align="center" cellpadding="2" class="shadowBox main_text">
	  <tr>
	    <td  bgcolor="#CFE2CF" align="center">
	      <div align="right" style="height:100%">

                  <?=_Glider_Brand ?>
                  <select class='selectFields' name="gliderBrandID" id="gliderBrandID" >
                      <option value=0></option>
                      <?
                      $brandsListFilter=brands::getBrandsList();
                      if ($_POST['gliderBrandID']) $brandID=$_POST['gliderBrandID'];
                      foreach($brandsListFilter as $brandNameFilter=>$brandIDfilter) {

                          if ($brandID==$brandIDfilter) $sel='selected';
                          else $sel='';

                          echo "<option  $sel value=$brandIDfilter>$brandNameFilter</option>";
                      }
                      ?>
                  </select>


              <BR>
                  <?=_GLIDER ?>
                  <input class='selectFields' name="gliderName"  id="gliderName" type="text" size="20" value='<? echo $gliderName?>'>

              <div id="similarGliders">


              </div>

                  <BR>

                  <?=_SIZE ?>
                  <input class='selectFields' name="gliderSize"  id="gliderSize" type="text" size="20" value='<? echo $gliderSize?>' >
                  <BR><?echo _Please_enter_the_correct_size_of_the_glider?> <BR>
                  <?echo _Use_numbers?>(22,24,26,28,30)<BR>
                  <?echo _Or_letters?>(XXS,XS,S,MS,M,ML,L,XL,XXL) 
                  <BR>

                  <?=_GLIDER_CERT ?>
                  <select  class='selectFields' name="gliderCert" id="gliderCert">
                  <?
                  echo "<option value=0></option>\n";
                  foreach ( $CONF_glider_certification_categories as $gl_id=>$gl_type) {
                      if ($gliderCert==$gl_id) $sel='selected';
                      else $sel='';
                      echo "<option $sel value=$gl_id>".$CONF_glider_certification_categories[$gl_id]."</option>\n";
                  }
                  ?>
                    </select>



		    <br>
		    <input type="button" name="Submit" value="<? echo _Add_new_glider?>" onClick="return submitForm();"/>
		    <input type="button" name="Submit2" value="<? echo _Cancel?>"  onclick="window.close();" />
		  </div>
		 </td>
	  </tr>

	</table>
</form>
</body>
</html>