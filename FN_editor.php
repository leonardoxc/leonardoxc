<?

require_once dirname(__FILE__)."/js/fckeditor/fckeditor.php";

function createTextArea($name,$value,$toolbarSet,$width=750,$height=800) {
		global $oFCKeditor;

		global $moduleRelPath;
		
		global $currentlang,$lang2iso,$lang2isoGallery;

		$sBasePath = "/$moduleRelPath/js/fckeditor/";

		
		$oFCKeditor = new FCKeditor($name);
		$oFCKeditor->Config['CustomConfigurationsPath'] = $sBasePath. '/config_leonardo.js';
		$oFCKeditor->Width = $width; 
		$oFCKeditor->Height = $height; 
		$oFCKeditor->ToolbarSet = $toolbarSet; 
		$oFCKeditor->Value = $value; 
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Config['ImageBrowserURL']=$sBasePath. 'editor/filemanager/browser/default/browser.html?Type=Image&Connector=connectors/php/connector.php';
		$oFCKeditor->Config['LinkBrowserURL']=$sBasePath. 'editor/filemanager/browser/default/browser.html?Connector=connectors/php/connector.php';

		$oFCKeditor->Config['ImageUploadURL']=$sBasePath. 'editor/filemanager/upload/php/upload.php?Type=Image';
		$oFCKeditor->Config['LinkUploadURL']=$sBasePath. 'editor/filemanager/upload/php/upload.php?Type=Image';

		
		$FCKEuploadPath ="/$moduleRelPath/data/files/";
		$_SESSION['FCKEuploadPath']=$FCKEuploadPath;

		
		$oFCKeditor->Config['QuickUploadLanguage']='php';
		$oFCKeditor->Config['FileBrowserLanguage']='php';
		
		$oFCKeditor->Config['AutoDetectLanguage']=false;		
//		$oFCKeditor->Config['DefaultLanguage']=$lang2isoGallery[$currentlang];
		$oFCKeditor->Config['DefaultLanguage']='en';


		$oFCKeditor->Config['EnableXHTML']	= false;	
		$oFCKeditor->Config['EnableSourceXHTML'] = false;	
		$oFCKeditor->Config['IncludeGreekEntities'] = false;

		echo $oFCKeditor->CreateHtml(); 
}

?>