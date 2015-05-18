<?php

class Cookie {
  

  public static function set($name, $value, $expire = 0, $path = '/', $domain = '', $secure = true, $httponly = true){
    if($expire > 0)
      $expire = Time::now()->addHours(2)->int();

    setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
  }


  public static function get($name, $path = '/'){
    return $_COOKIE[$name];
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