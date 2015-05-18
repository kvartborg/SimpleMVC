<?php

class Session {
  
  public static function set($name, $value){
    $_SESSION[$name] = $value;
  }

  public static function get($name){
    return $_SESSION[$name];
  }

  public static function forget($name){
    if(isset($_SESSION[$name]))
      unset($_SESSION[$name]);
    else
      Error::set('Couldn\'t find the session "'.$name.'"');
  }

}