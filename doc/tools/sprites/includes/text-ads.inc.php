<?php

function tla_ads() {

	// Number of seconds before connection to XML times out
	// (This can be left the way it is)
	$CONNECTION_TIMEOUT = 10;

	// Local file to store XML
	// This file MUST be writable by web server
	// You should create a blank file and CHMOD it to 666
	$LOCAL_XML_FILENAME = ConfigHelper::Get('/cache/tla/dir').ConfigHelper::Get('/cache/tla/file');

	if( !file_exists($LOCAL_XML_FILENAME) ) die("Script error: $LOCAL_XML_FILENAME does not exist. Please create a blank file named $LOCAL_XML_FILENAME.");
	if( !is_writable($LOCAL_XML_FILENAME) ) die("Script error: $LOCAL_XML_FILENAME is not writable. Please set write permissions on $LOCAL_XML_FILENAME.");

	if( filemtime($LOCAL_XML_FILENAME) < (time() - 3600) || filesize($LOCAL_XML_FILENAME) < 20) {
		$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "";
		$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
		tla_updateLocalXML("http://www.text-link-ads.com/xml.php?inventory_key=Z73AUCI0OTG7DAHAYCKP&referer=" . urlencode($request_uri) .  "&user_agent=" . urlencode($user_agent), $LOCAL_XML_FILENAME, $CONNECTION_TIMEOUT);
	}

	$xml = tla_getLocalXML($LOCAL_XML_FILENAME);

	$arr_xml = tla_decodeXML($xml);

	if ( is_array($arr_xml) ) {
		echo "\n<ul id=\"text-links\">\n";
		for ($i = 0; $i < count($arr_xml['URL']); $i++) {
			if( isset($arr_xml['PostID'][$i]) && $arr_xml['PostID'][$i] > 0 ) continue;
			echo "<li>".$arr_xml['BeforeText'][$i]." <a href=\"".$arr_xml['URL'][$i]."\">".$arr_xml['Text'][$i]."</a> ".$arr_xml['AfterText'][$i]."</li>\n";
		}
		echo "</ul>";
	}

}

function tla_updateLocalXML($url, $file, $time_out)
{
	if($handle = fopen($file, "a")){
			fwrite($handle, "\n");
			fclose($handle);
	}
	if($xml = file_get_contents_tla($url, $time_out)) {
		$xml = substr($xml, strpos($xml,'<?'));

		if ($handle = fopen($file, "w")) {
			fwrite($handle, $xml);
			fclose($handle);
		}
	}
}

function tla_getLocalXML($file)
{
	$contents = "";
	if($handle = fopen($file, "r")){
		$contents = fread($handle, filesize($file)+1);
		fclose($handle);
	}
	return $contents;
}

function file_get_contents_tla($url, $time_out)
{
	$result = "";
	$url = parse_url($url);

	if ($handle = @fsockopen ($url["host"], 80)) {
		if(function_exists("socket_set_timeout")) {
			socket_set_timeout($handle,$time_out,0);
		} else if(function_exists("stream_set_timeout")) {
			stream_set_timeout($handle,$time_out,0);
		}

		fwrite ($handle, "GET $url[path]?$url[query] HTTP/1.0\r\nHost: $url[host]\r\nConnection: Close\r\n\r\n");
		while (!feof($handle)) {
			$result .= @fread($handle, 40960);
		}
		fclose($handle);
	}

	return $result;
}

function tla_decodeXML($xmlstg)
{

	if( !function_exists('html_entity_decode') ){
		function html_entity_decode($string)
		{
		   // replace numeric entities
		   $string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\1"))', $string);
		   $string = preg_replace('~&#([0-9]+);~e', 'chr(\1)', $string);
		   // replace literal entities
		   $trans_tbl = get_html_translation_table(HTML_ENTITIES);
		   $trans_tbl = array_flip($trans_tbl);
		   return strtr($string, $trans_tbl);
		}
	}

	$out = "";
	$retarr = "";

	preg_match_all ("/<(.*?)>(.*?)</", $xmlstg, $out, PREG_SET_ORDER);
	$search_ar = array('&#60;', '&#62;', '&#34;');
	$replace_ar = array('<', '>', '"');
	$n = 0;
	while (isset($out[$n]))
	{
		$retarr[$out[$n][1]][] = str_replace($search_ar, $replace_ar,html_entity_decode(strip_tags($out[$n][0])));
		$n++;
	}
	return $retarr;
}

tla_ads();

?>
