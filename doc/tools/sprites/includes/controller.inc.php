<?php
   class Controller {
      protected $sLanguage;
      protected $sView;
      protected $sViewPath;
      
      public function __construct() {
         require('../includes/config.inc.php');
         
         $this->SetLanguage(ConfigHelper::Get('/languages/installed'));
         
         // check validity of selected view (to prevent loading of other files from the filesystem)        
         if (
            isset($_REQUEST['view']) &&
            preg_match("/^[a-z0-9_-]+$/i", $_REQUEST['view']) &&
            file_exists('../views/'.$_REQUEST['view'].'.php')
         ) {
            // we now have a safe string
            $this->sView = $_REQUEST['view'];
            $this->sViewPath = '../views/'.$_REQUEST['view'].'.php';
         } elseif (empty($_REQUEST['view']) && file_exists('../views/home.php')) { // look for default view
   			$this->sView = 'home';
   			$this->sViewPath = '../views/home.php';
   		} else {
		      // invalid request and no default view available - quit application
            die('Invalid view specified.');
         }

         if (!in_array($this->sView, array('download'))) {
            // instantiate translations
            $oTranslations = new Translations(
					$this->sLanguage, 
					ConfigHelper::Get('/cache/translations_dir/'),
					ConfigHelper::Get('/translations/allow_show_keys')
				);

            // instantiate layout template
            if (ConfigHelper::Get('/template/paths')) {
               $oTemplate = new Template(
						'layout.php', 
						$this->sLanguage, 
						ConfigHelper::Get('/template/paths')
					);
            } else {
               $oTemplate = new Template('layout.php', $this->sLanguage);
            }

            // pass common data to template
            $oTemplate->Set('appRoot', ConfigHelper::Get('/app_root'));
            $oTemplate->Set('contactEmail', ConfigHelper::Get('/emails/contact'));
            $oTemplate->Set('languages', ConfigHelper::Get('/languages/installed'));
            $oTemplate->Set('language', $this->sLanguage);
            $oTemplate->Set(
					'missingTranslations', 
					!in_array($this->sLanguage, 
					ConfigHelper::Get('/languages/complete'))
				);
            $oTemplate->Set('languageSwitch', ConfigHelper::Get('/languages/switch'));
            $oTemplate->Set('view', $this->sView);
            $oTemplate->Set('template', $this->sView);
            $oTemplate->Set('translation', $oTranslations);
            $oTemplate->Set('assetsDir', ConfigHelper::Get('/assets_dir'));
				// add content template
            $oTemplate->Set('content', new Template(
					"$this->sView.php",
					$this->sLanguage,
					ConfigHelper::Get('/template/paths')
				));
            $oTemplate->Set('headerImageUrl', ConfigHelper::Get('/images/header/url'));
            $oTemplate->Set('headerImageAlt', ConfigHelper::Get('/images/header/alt'));
            $oTemplate->Set('headerImageWidth', ConfigHelper::Get('/images/header/width'));
            $oTemplate->Set('headerImageHeight', ConfigHelper::Get('/images/header/height'));
            $oTemplate->Set('headerHref', ConfigHelper::Get('/urls/header'));
            $oTemplate->Set('reportBugUrl', ConfigHelper::Get('/urls/report_bug'));
            $oTemplate->Set('viewsDir', '../views/');
            $oTemplate->Set(
					'toolUrl',
					str_replace(array('http://', 'https://'),
					'',
					ConfigHelper::Get('/urls/tool'))
				);

            // load view
            require($this->GetViewPath());

            // display resulting page
            echo $oTemplate->Display();
         } else {
            // load view
            require($this->GetViewPath());
         }
      }
      
      protected function SetLanguage($aLanguages) {
         if (ConfigHelper::Get('/languages/switch') == 'host') {
            $sLanguage = substr($_SERVER['SERVER_NAME'], 0, 2);
            
            if (array_key_exists($sLanguage, $aLanguages) && substr($_SERVER['SERVER_NAME'], 2, 1) == '.') {
               $this->sLanguage = $sLanguage;
            } else {
               $this->sLanguage = 'en';
            }
         } else {
            // check for request to change language
            // if not present check for cookie specifiying language
            // finally fall back to english
            if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $aLanguages)) {
               $this->sLanguage = $_GET['lang'];
               setcookie('lang', $this->sLanguage, time() + 60 * 60 * 24 * 365, '/');
               header('Location: /');
               exit;
            } elseif (isset($_COOKIE['lang']) && array_key_exists($_COOKIE['lang'], $aLanguages)) {
               $this->sLanguage = $_COOKIE['lang'];
            } else {
               $this->sLanguage = 'en';
            }
         }
      }
      
      // get currently selected language
      public function GetLanguage() {
         return $this->sLanguage;
      }
      
      // get view name
      public function GetView() {
         return $this->sView;
      }
      
      // get full path to view
      public function GetViewPath() {
         return $this->sViewPath;
      }
   }
?>
