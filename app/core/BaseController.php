<?php
// ------------------------------------ 
//	Base Controller
// ------------------------------------
require_once "View.php";

class BaseController extends View {

	public function notFound(){
    View::make('/error/404');
  }

  public function model($model){
    require_once '../app/models/'.$model.'.php';
    return new $model();
  }
}