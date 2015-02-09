<?php
  // get index
  $setting = include "app/config/app.php";
  $index = $setting['controller'];
?>
<html>
<head>
  <meta http-equiv="refresh" content="0; url=http://<?php echo $_SERVER['SERVER_NAME'].'/'.$index; ?>" />
  <base href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/public/" />
</head>

<body>
</body>
</html>