<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: BLOCKS_end.php,v 1.13 2009/03/21 00:02:49 manolis Exp $                                                                 
//
//************************************************************************
?>
	</td>
    <td valign=top>		<!-- right side blocks -->
<?
	global $CONF;
	if ($CONF['display']['blocks']['right_side']) {
		// render right side blocks
		$dir=dirname(__FILE__)."/blocks";
		$blocksList=array();
	
		if ($handle = opendir($dir)) { 
		   while (false !== ($file = readdir($handle))) { 
			   if ( is_dir("$dir/$file") && $file!="."  && $file!=".." && strtolower($file)!="cvs") {
					array_push($blocksList,$file);
			   }
		   } 
		   closedir($handle); 
		} 
		global $side_blocks_html;
		$side_blocks_html="";
	
		if (count($blocksList))	 {
			sort($blocksList);
			foreach ($blocksList as $thisBlock) {
				$side_blocks_html.= renderBlock($thisBlock);
			}
		}
		
		// echo $side_blocks_html;
	}

function renderBlock($thisBlock) {
	global $op;
	require dirname(__FILE__)."/blocks/$thisBlock/config.php";
	if (!$blockActive) return;
	if ( !in_array($op,$blockShow) && count($blockShow) ) return;

	if (!$blockwidth) $blockwidth=230;	

	ob_start();

	if (!$blockHideBox)	{
		echo "<div align=left class='main_text' style='width:".$blockwidth."px;'>
		<div style='padding:4px; border-bottom:1px solid #444444;'>$blockTitle</div>";	
	
		// open_box($blockTitle,$blockwidth,"icon_help.png");
		
	}	
	require_once dirname(__FILE__)."/blocks/$thisBlock/index.php";
	
	if (!$blockHideBox)	{
		echo"</div>";
		// close_box();
	}	
	echo "<BR>";

	$outRes = ob_get_contents();
	ob_end_clean();
	//while (@ob_end_clean()); 

	return $outRes ;
}
?>
	</td>
  </tr>
</table>