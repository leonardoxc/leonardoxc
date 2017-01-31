<?php
if ( $_GET["charset"] != '' )
{
	header("Content-type: text/html; charset=$_GET[charset]");
	$charset = $_GET["charset"];
}
else
{
	header("Content-type: text/html; charset=iso-8859-5");
	$charset = "iso-8859-5";
}
?>
<html>
<head>
	<title>Demo of ConvertCharset.class.php</title>
	<meta http-equiv="Content-type" content="text/html; charset=<?php echo $charset; ?>" />
</head>
<body>

<?php
require_once "../ConvertCharset.class.php";
?>
<h3>Cyrillic text can look like that with a different encodings</h3>
This is a proper cyrillic text.<br />
<img src="cyrillic.gif"><br />
Every line below should look the same way if you set
your browser to the right encoding.<br />That means if you want to see ISO version you need to 
change your browser encoding to use Cyrillic (ISO).<br /><br />
To swich to proper encoding use link below:<br />
<A href="demo.php?charset=iso-8859-5">iso-8859-5</A> | 
<a href="demo.php?charset=windows-1251">windows-1251</a> | 
<a href="demo.php?charset=cp866">cp866</a> |
<a href="demo.php?charset=cp855">cp855</a> |
<a href="demo.php?charset=koi8-r">koi8-r</a> |
<a href="demo.php?charset=x-mac-cyrillic">x-mac-cyrillic*</a> |
<a href="demo.php?charset=utf-8">utf-8</a><br />
(Unfortunately you can manualy set Mac encoding only in Mozilla or Netscape, in IE you can't just
select it from the list, it's hidden... I don't understand you Bill...)*<br>
<br /><br />

<b>This is from file with ISO-8859-5 (8859-5):</b><br>
<?php
$file1 = file("cyrillic.iso-8859-5");
$file1 = implode("",$file1);
echo $file1;
?>
 <BR><BR>
<b>This is from file with WINDOWS-1251(CP1251):</b><br>
<?php
$file2 = file("cyrillic.windows-1251");
$file2 = implode("",$file2);
echo $file2;
?>
 <BR><BR>
<b>This is from file with CP866:</b><br>
<?php
$file3 = file("cyrillic.cp866");
$file3 = implode("",$file3);
echo $file3;
?>
 <BR><BR>
<b>This is from file with (IBM-855):</b><br>
<?php
$file7 = file("cyrillic.cp855");
$file7 = implode("",$file7);
echo $file7;
?>
 <BR><BR>
<b>This is from file with KOI8-R:</b><br>
<?php
$file4 = file("cyrillic.koi8-r");
$file4 = implode("",$file4);
echo $file4;
?>
 <BR><BR>
<b>This is from file with MacCyrillic:</b><br />
<?php
$file5 = file("cyrillic.x-mac-cyrillic");
$file5 = implode("",$file5);
echo $file5;
?>
 <BR><BR>
<b>This is from file with UTF-8:</b><br />
<?php
$file6 = file("cyrillic.utf-8");
$file6 = implode("",$file6);
echo $file6;
?>
 <br /><br />
 <h4>If you understand what you ware doing on this site do a <A href="demo1.php">step forward</a></h4>
</body>
</html>