<?php

class View {
  
  public static function make($view, $data = array()){

    // convert the $data array to variables
    extract($data);

    if($view[0] == '/'){
      // do nothing
    } else {
      $view = '/'.$view;
    }

    // check for any errors
    if(count($GLOBALS['errors']) == 0){
      require_once 'app/views'.$view.'.php';
    }
  }
  
}