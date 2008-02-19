
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

	open_box($blockTitle,$blockwidth,"icon_help.png");
	require_once dirname(__FILE__)."/blocks/$thisBlock/index.php";
	close_box();
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