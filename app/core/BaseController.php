<?php
// ------------------------------------ 
//	Base Controller
// ------------------------------------

class BaseController {

	public function notFound(){
    View::make('/error/404');
  }

  // public function model($model){
  //   require_once '../app/models/'.$model.'.php';
  //   return new $model();
  // }
}