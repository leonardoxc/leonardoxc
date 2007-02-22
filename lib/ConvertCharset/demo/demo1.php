<?php
if ( $_POST["FromCharset"] != "" )
{
	$FromCharset = $_POST["FromCharset"];
	}
	else
	{
	$FromCharset = "windows-1251";
	}

if ( $_POST["ToCharset"] != "" )
{
	$ToCharset = $_POST["ToCharset"];
	header("Content-type: text/html; charset=$_POST[ToCharset]");
	}
	else
	{
	$ToCharset = "utf-8";
	header("Content-type: text/html; charset=utf-8");
}

if ( $_POST["Entities"] == "on" )
{
	$Entities = 1;
	}
	else
	{
	$Entities = 0;
}

		$FromEnc = "From" . str_replace("-", "_", $FromCharset);
		$$FromEnc = "SELECTED"; 
		$ToEnc = "To" . str_replace("-", "_", $ToCharset);
		$$ToEnc = "SELECTED";

?>
<html>
<head>
	<title>Demo of ConvertCharset.class.php - first convertion</title>
 	<meta http-equiv="Content-type" content="text/html; charset=<?php echo $ToCharset; ?>" />
</head>
<style>
td {
	background: #99FF66;
	padding-bottom: 7px;
	padding-left: 7px;
	padding-top: 7px;
	padding-right: 7px;
}
.red {
	color: red;
}
</style>
<body>
<?php
require_once "../ConvertCharset.class.php";
?>
<h3>This is the same cyrillic text we are now going to convert</h3>
<img src="cyrillic.gif"><br /><br />
<h4>The page is now viewed in <span class="red"><?php echo $ToCharset; ?></span>!</h4>

Ok, lets say you have such a situation.<br />
You have a lot of text files, and you know that thay ware save in iso-8859-5 and you want to use them
on your web page, but you aleready have a runing service and it was built in koi8-r.
Of course changing encoding of already built pages doesn't make sence, and changeing all text files
would take too much time. Well this is a job for the ConvertCharset.class.

<form action="demo1.php" method="POST" target="_self">
Select encoding your files are save in:
<select name="FromCharset" size="1">
	<option value="iso-8859-5" <?php echo "$Fromiso_8859_5"; ?>>iso-8859-5</option>
	<option value="windows-1251" <?php echo "$Fromwindows_1251"; ?>>windows-1251</option>
	<option value="cp866" <?php echo "$Fromcp866"; ?>>cp866</option>
	<option value="cp855" <?php echo "$Fromcp855"; ?>>cp855</option>
	<option value="koi8-r" <?php echo "$Fromkoi8_r"; ?>>koi8-r</option>
	<option value="x-mac-cyrillic" <?php echo "$Fromx_mac_cyrillic"; ?>>x-mac-cyrillic</option>
	<option value="utf-8" <?php echo "$Fromutf_8"; ?>>utf-8</option>
</select><br />
And select encoding you want to get:
<select name="ToCharset" size="1">
	<option value="iso-8859-5" <?php echo "$Toiso_8859_5"; ?>>iso-8859-5</option>
	<option value="windows-1251" <?php echo "$Towindows_1251"; ?>>windows-1251</option>
	<option value="cp866" <?php echo "$Tocp866"; ?>>cp866</option>
	<option value="cp855" <?php echo "$Tocp855"; ?>>cp855</option>
	<option value="koi8-r" <?php echo "$Tokoi8_r"; ?>>koi8-r</option>
	<option value="x-mac-cyrillic" <?php echo "$Tox_mac_cyrillic"; ?>>x-mac-cyrillic</option>
	<option value="utf-8" <?php echo "$Toutf_8"; ?>>utf-8</option>
</select><br />
<input type="checkbox" name="Entities" <?php if ($Entities == 1) echo "CHECKED"; ?>> Check the box if you want numeric entities insted of regular chars.
<input type="submit" name="encode" value=" Encode string from file " />
</form>

<?php
$FileName = "cyrillic" . "." . $FromCharset;
$File = file($FileName);
$FileText = implode("",$File);

$NewEncoding = new ConvertCharset;
$NewFileOutput = $NewEncoding->Convert($FileText, $FromCharset, $ToCharset, $Entities);

echo "This is your filename \"" . $FileName . "\" encoded to ". $ToCharset. ": <BR>
<table border=\"0\"><tr><td>" . $NewFileOutput . "</td></tr></table><br />";
?>
<br />
I hope you do understand what is this class for? :) If you don't well..., that means<br />
I should never write any class again :)<br />
<h4>If you don't understand what you are doing on this site do a <A href="demo.php">step back</a></h4>
</body>
</html>