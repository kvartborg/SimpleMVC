<?php
require_once "Database.php";

class View Extends DB {
  public function make($view, $data = array()){

    if($view[0] == '/'){
      // do nothing
    } else {
      $view = '/'.$view;
    }

    require_once '../app/views'.$view.'.php';
  }
}