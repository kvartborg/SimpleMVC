<?php
// ------------------------------------ 
//	Initialize bootstrap
// ------------------------------------

// application files
// require_once "core/App.php";
// require_once "core/BaseController.php";

// autoload core files
$dir = __DIR__.'/core';
$files = scandir($dir);
unset($files[0]);
unset($files[1]);
$files = array_values($files);
for($i = 0; $i < count($files); $i++) {
  require_once __DIR__."/core/".$files[$i];
}

// autoload models
$dir = __DIR__.'/models';
$files = scandir($dir);
unset($files[0]);
unset($files[1]);
$files = array_values($files);
for($i = 0; $i < count($files); $i++) {
  require_once __DIR__."/models/".$files[$i];
}

// Create new instance of app
$app = new App;