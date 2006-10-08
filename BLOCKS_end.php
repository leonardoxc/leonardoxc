</td>
    <td valign=top>
<?php

// render right side blocks
$dir=dirname(__FILE__).'/blocks';
$blocksList=array();

if ($handle=opendir($dir))
{
	while (($file=readdir($handle))!==false)
		if (is_dir("$dir/$file") && $file!='.' && $file!='..' && strtolower($file)!='cvs')
			array_push($blocksList,$file);

	closedir($handle);
}

if (count($blocksList))
{
	sort($blocksList);

	foreach ($blocksList as $thisBlock)
		renderBlock($thisBlock);
}



function renderBlock($thisBlock)
{
	global $op;

	require_once dirname(__FILE__)."/blocks/$thisBlock/config.php";

	if (!$blockActive || !in_array($op,$blockShow) && count($blockShow))
		return;

	if (!$blockwidth)
		$blockwidth=230;

	open_box($blockTitle,$blockwidth,'icon_help.png');
	require_once dirname(__FILE__)."/blocks/$thisBlock/index.php";
	close_box();
	echo '<br/>';
}

?>
</td>
  </tr>
</table>
