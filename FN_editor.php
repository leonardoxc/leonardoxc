<?

require_once dirname(__FILE__)."/js/fckeditor/fckeditor.php";

function createTextArea($name,$value,$toolbarSet,$width=750,$height=800) {
		global $CONF;
		if (!$CONF['editor']['use_wysiwyg']) {
			$cols=floor($width/10);
			$rows=floor($height/40);
			if ($rows<3) $rows=3;
			echo "<textarea name='$name' cols='$cols' rows='$rows'>$value</textarea>";
			return;
		}

		global $oFCKeditor;
		global $moduleRelPath;	
		global $currentlang,$lang2isoEditor;

		$sBasePath = "/$moduleRelPath/js/fckeditor/";
		$FCKEuploadPath ="/$moduleRelPath/data/files/";
		$_SESSION['FCKEuploadPath']=$FCKEuploadPath;
		
		$oFCKeditor = new FCKeditor($name);
		$oFCKeditor->Config['CustomConfigurationsPath'] ="/$moduleRelPath/site/config_editor.js";
		$oFCKeditor->Width = $width; 
		$oFCKeditor->Height = $height; 
		$oFCKeditor->ToolbarSet = $toolbarSet; 
		$oFCKeditor->Value = $value; 
		$oFCKeditor->BasePath	= $sBasePath ;

		$oFCKeditor->Config['ImageBrowserURL']=$sBasePath. 'editor/filemanager/browser/default/browser.html?Type=Image&Connector=../../connectors/php/connector.php';
		$oFCKeditor->Config['LinkBrowserURL']=$sBasePath. 'editor/filemanager/browser/default/browser.html?Connector=../../connectors/php/connector.php';

		$oFCKeditor->Config['QuickUploadLanguage']='php';
		$oFCKeditor->Config['FileBrowserLanguage']='php';
		
		$oFCKeditor->Config['AutoDetectLanguage']=false;		
		$oFCKeditor->Config['DefaultLanguage']=$lang2isoEditor[$currentlang];

		$oFCKeditor->Config['EnableXHTML']	= false;	
		$oFCKeditor->Config['EnableSourceXHTML'] = false;	
		$oFCKeditor->Config['IncludeGreekEntities'] = false;

		// office2003 silver default
		$oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/default/' ;

		$oFCKeditor->Create(); 

}

?>