<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <title>Setup Error</title>
      <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
      <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>

<body>
   <h1>Setup Error</h1>
   <p>Setup Error: Ensure all cache directories are writeable by the web server process:</p>
   <ul>
      <li><?php echo $uploadDir; ?></li>
      <li><?php echo $spriteDir; ?></li>
      <li><?php echo $translationsCacheDir; ?></li>
		<li><?php echo $cssCacheDir; ?></li>
		<li><?php echo $jsCacheDir; ?></li>
   </ul>
   <p>e.g:</p>
   <pre><code>
      sudo chgrp -R www-data <?php echo $uploadDir; ?>
      
      sudo chgrp -R www-data <?php echo $spriteDir; ?>
      
      sudo chgrp -R www-data <?php echo $translationsCacheDir; ?>

		sudo chgrp -R www-data <?php echo $cssCacheDir; ?>

		sudo chgrp -R www-data <?php echo $jsCacheDir; ?>
      
      sudo chmod -R g+w <?php echo $uploadDir; ?>
      
      sudo chmod -R g+w <?php echo $spriteDir; ?>
      
      sudo chmod -R g+w <?php echo $translationsCacheDir; ?>

		sudo chmod -R g+w <?php echo $cssCacheDir; ?>

		sudo chmod -R g+w <?php echo $jsCacheDir; ?>
   </code></pre>
   <p>For more information about setting file permissions check out our <a href="http://permissions-calculator.org/">Unix Permissions Calculator</a>.</p>
</body> 
 
</html>
