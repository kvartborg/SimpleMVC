<?php
// ------------------------------------ 
//	Initialize bootstrap
// ------------------------------------

// composer autoloader
require_once "../vendor/autoload.php";

// aplication files
require_once "core/App.php";
require_once "core/BaseController.php";

// Create new instance of app
$app = new App;