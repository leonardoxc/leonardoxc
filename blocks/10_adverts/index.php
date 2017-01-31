<?php
 /* <!-- OpenX XML-RPC Tag v2.4.5 -->
  *
  * As the PHP script below tries to set cookies, it must be called
  * before any output is sent to the user's browser. Once the script
  * has finished running, the HTML code needed to display the ad is
  * stored in the $adArray array (so that multiple ads can be obtained
  * by using mulitple tags). Once all ads have been obtained, and all
  * cookies set, then you can send output to the user's browser, and
  * print out the contents of $adArray where appropriate.
  *
  * Example code for printing from $adArray is at the end of the tag -
  * you will need to remove this before using the tag in production.
  * Remember to ensure that the PEAR::XML-RPC package is installed
  * and available to this script, and to copy over the
  * lib/xmlrpc/php/openads-xmlrpc.inc.php library file. You may need to
  * alter the 'include_path' value immediately below.
  */

    //ini_set('include_path', '.:/usr/local/lib');

	$adsNum=5;

    require 'openads-xmlrpc.inc.php';

    if (!isset($OA_context)) $OA_context = array();

    $oaXmlRpc = new OA_XmlRpc('ads.paraglidingforum.com', '/www/delivery/axmlrpc.php', 0, false, 15);
	for($i=0;$i<$adsNum;$i++) {
	    $adArray[$i] = $oaXmlRpc->view('zone:3', 0, '', '', 0, $OA_context);
	    $OA_context[] = array('!=' => 'bannerid:'.$adArray[$i]['bannerid']);
	}

	for($i=0;$i<$adsNum;$i++) {
		//echo "<div class=ads>";
		echo $adArray[$i]['html'];
		//echo "</div>";
		if ($adArray[$i]['html']) 
			echo "<div style='margin:10px;'></div>";
	}

?>
