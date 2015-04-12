<?php

class View {
  public function make($view, $data = array()){

    // convert the $data array to variables
    extract($data);

    if($view[0] == '/'){
      // do nothing
    } else {
      $view = '/'.$view;
    }

    require_once '../app/views'.$view.'.php';
  }
}