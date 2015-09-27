<?php

if(!function_exists('view')){
  
  function view($path, $data = []){
    return View::make($path, $data);
  }
  
}