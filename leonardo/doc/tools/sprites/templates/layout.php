<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="<?php echo $language; ?>">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <title><?php echo $title; ?> | <?php echo $translation->Get('site.title'); ?></title>
   <link rel="stylesheet" href="<?php echo $assetsDir; ?>css/get.<?php require('get-css.php'); ?>.css" type="text/css">
   <!--[if IE]>
      <link rel="stylesheet" href="<?php echo $assetsDir; ?>css/get-ie.<?php require('get-css-ie.php'); ?>.css" type="text/css">
   <![endif]-->                                                                              
   
   <?php if ($view == 'home'): ?>
      <script type="text/javascript">
         var SPRITEGEN = {
            locale : {
               aspectRatio : "<?php echo $translation->Get('form.label.maintain-aspect-ratio'); ?>:"
            },
            formFields : {
               aspectRatio : '<?php if (!$formPosted || !empty($_POST['aspect-ratio'])) echo 'checked'; ?>'
            }
         };
      </script>
   <?php endif; ?>
   <meta name="robots" content="noindex, nofollow">
</head>

<body class="lang-<?php echo $language; ?>">
   <div id="header">
      <h1><?php echo $title; ?></h1>
		<p class="notice">This is a stock install of the open source version of <a href="http://spritegen.website-performance.org/">CSS Sprite Generator</a>. Please modify templates and styling to suit. You can remove this message by editing &quot;templates/layout.php&quot;.</p>
   </div>
   <div id="content">
      <ul id="nav">
         <li<?php if ($view == 'home') echo ' class="selected"'; ?>><a href="<?php echo $appRoot; ?>"><?php echo $translation->Get('menu.home'); ?></a></li>
      </ul>
      <div id="frame">
         <div id="lang-bar">
            <?php $this->IncTemplate('lang-bar.php'); ?>
         </div>
         <div id="main">
            <?php echo $content; ?>
         </div>
         <div id="sidebar">
            
         </div>
      </div>
   </div>
   <div id="footer">
      <?php $this->IncTemplate('footer.php'); ?>
   </div>
   <script type="text/javascript" src="<?php echo $assetsDir; ?>js/get.<?php require('get-js.php'); ?>.js"></script>
</body> 
 
</html>
