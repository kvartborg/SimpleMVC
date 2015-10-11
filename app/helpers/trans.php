<?php

if(!function_exists('trans')){

  function trans($str, $vars = []){
    return Lang::get($str, $vars);
  }
  
}