<?php

if(!function_exists('trans')){

  function trans($str){
    return Lang::get($str);
  }
  
}