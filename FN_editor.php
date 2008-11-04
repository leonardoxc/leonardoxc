<?

require_once dirname(__FILE__)."/js/fckeditor/fckeditor.php";
require_once dirname(__FILE__)."/CL_pilot.php";

function createTextArea($userServerID,$userID,$name,$value,
						$where,$toolbarSet,$allowUploads=false,$width=750,$height=800) {
		global $CONF,$PREFS;
		
		$useTextArea=false;

		if ( ! $CONF['editor']['use_wysiwyg'][$where] ) $useTextArea=true;
		else if ( ! $PREFS->useEditor) $useTextArea=true;
		
		
		if ( $useTextArea) {
			$cols=floor($width/10);
			$rows=floor($height/40);
			if ($rows<3) $rows=3;
			echo "<textarea name='$name' cols='$cols' rows='$rows'>$value</textarea>";
			return;
		}

		global $oFCKeditor;
		global $moduleRelPath,$baseInstallationPath;	
		global $currentlang,$lang2isoEditor;

		$sBasePath = getRelMainDir(1)."js/fckeditor/";
		if ($userServerID==0 && $userID==0) {
			$FCKEuploadPath =getRelMainDir(1)."data/files/";
		} else {
			
			// no uploads allowed
			// $thisPilot=new pilot ($userServerID,$userID);
			// $FCKEuploadPath =$thisPilot->getRelPath().'/files/';			
			// if ( !is_dir($FCKEuploadPath) ) $thisPilot->createDirs();
			$FCKEuploadPath ='';
		}
		$_SESSION['FCKEuploadPath']=$FCKEuploadPath;
		
		$oFCKeditor = new FCKeditor($name);
		$oFCKeditor->Config['CustomConfigurationsPath'] =getRelMainDir(1)."site/config_editor.js";
		$oFCKeditor->Width = $width; 
		$oFCKeditor->Height = $height; 
		$oFCKeditor->ToolbarSet = $toolbarSet; 
		$oFCKeditor->Value = $value; 
		$oFCKeditor->BasePath	= $sBasePath ;

		if (! $allowUploads) {
			$oFCKeditor->Config['LinkBrowser']=false;
			$oFCKeditor->Config['ImageBrowser']=false;
			$oFCKeditor->Config['FlashBrowser']=false;
			$oFCKeditor->Config['LinkUpload']=false;
			$oFCKeditor->Config['ImageUpload']=false;
			$oFCKeditor->Config['FlashUpload']=false;
		}

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