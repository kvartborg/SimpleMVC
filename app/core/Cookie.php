<?php

class Cookie {
  

  public static function set($name, $value, $expire = 0, $path = '/', $domain = '', $secure = true, $httponly = true){
    if($expire > 0)
      $expire = Time::now()->addHours(2)->int();

    setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
  }


  public static function get($name, $path = '/'){
    if(isset($_COOKIE[$name])){
      return $_COOKIE[$name];
    } else {
      Error::set('Cookie "'.$name.'" not found', __FILE__, __LINE__);
      return false;
    }
  }


  public static function forget($name, $path = '/'){
    if(isset($_COOKIE[$name])){
      unset($_COOKIE[$name]);
      setcookie($name, null, -1, $path);
    } else {
      Error::set('Couldn\'t find the Cookie "'.$name.'"', __FILE__, __LINE__);
    }
  }
}