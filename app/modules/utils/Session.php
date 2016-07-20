<?php

class Session {
  
  public static function set($name, $value){
    $_SESSION[$name] = $value;
  }

  public static function get($name){
    if(isset($_SESSION[$name])){
      return $_SESSION[$name];
    } else {
      Error::set('Session "'.$name.'" not found', __FILE__, __LINE__);
      return false;
    }
  }

  public static function has($name){
    return isset($_SESSION[$name]);
  }

  public static function forget($name){
    if(isset($_SESSION[$name])){
      unset($_SESSION[$name]);
    } else {
      Error::set('Couldn\'t find the session "'.$name.'"');
    }
  }

}