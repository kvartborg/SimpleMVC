<?php
// ------------------------------------ 
//	Initialize bootstrap
// ------------------------------------

// composer autoloader
require_once "../vendor/autoload.php";

// aplication files
require_once "core/App.php";
require_once "core/BaseController.php";

// custom classes
// require_once "core/cunstomClass.php";

// Create new instance of app
$app = new App;