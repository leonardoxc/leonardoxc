<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
header('Last-Modified: ' . gmdate( "D, d M Y H:i:s" ) . 'GMT'); 
header('Cache-Control: no-cache, must-revalidate'); 
header('Pragma: no-cache');

require_once '../utf8_to_ascii.php';
$out = file_get_contents('data/utf8.txt');

if ( php_sapi_name() == 'cli' ||
        (
            isset($_SERVER['QUERY_STRING'])
            &&
            strcasecmp($_SERVER['QUERY_STRING'],'test')==0
        )
    ) {
    
    $eol = php_sapi_name() == 'cli' ? "\n" : "<br>\n";
    
    $out = utf8_to_ascii($out);
    if ( preg_match('/(?:[^\x00-\x7F])/',$out) !== 1 ) {
        print "PASS: output is all ASCII$eol";
    } else {
        print "FAIL: output still contains UTF-8$eol";
    }
    
    exit();
}
if ( isset($_GET['out']) && $_GET['out'] == 'ascii' ) {
    header('Content-Type: text/html; charset=US-ASCII');
} else {
    header('Content-Type: text/html; charset=UTF-8');
}
if ( isset($_GET['out']) && $_GET['out'] == 'ascii' ) {
    $out = utf8_to_ascii($out);
}
?>
<html>
<head>
<title>US-ASCII transliterations of Unicode text</title>
</head>
<body>
<h1>US-ASCII transliterations of Unicode text</h1>
<p><a href="?out=utf-8">Before</a> | <a href="?out=ascii">After</a> | <a href="?test">Test</a></p>
<pre>
<?php
print(htmlspecialchars($out));
?>
</pre>
</body>
</html>

