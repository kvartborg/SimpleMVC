<?php
// ------------------------------------ 
//	Initialize bootstrap
// ------------------------------------

// aplication files
require_once "core/App.php";
require_once "core/BaseController.php";

$input = include __DIR__.'/config/app.php';
for($i = 0; $i < count($input['classmap']); $i++){
  echo "core/".$input['classmap'][$i].'.php<br>';
  require_once "core/".$input['classmap'][$i].'.php';
}


// Create new instance of app
$app = new App;