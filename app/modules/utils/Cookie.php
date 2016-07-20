<?php

class Cookie {
  
  /**
   * Set cookie
   *
   * @param string $name
   * @param mixed $value
   * @param int $expire Cookies life time in seconds
   *
   * @return null
   */

  public static function set($name, $value, $expire = 0, $path = '/', $domain = '', $secure = true, $httponly = true){
    if($expire > 0)
      $expire = 7200;

    setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
  }


  /**
   * Get cookie value
   *
   * @param string $name 
   *
   * @return mixed  
   */

  public static function get($name, $path = '/'){
    if(isset($_COOKIE[$name])){
      return $_COOKIE[$name];
    } else {
      Error::set('Cookie "'.$name.'" not found', __FILE__, __LINE__);
      return false;
    }
  }


  public static function has($name){
    return isset($_COOKIE[$name]);
  }


  /**
   * Unset cookie 
   * 
   * @param  string $name [description]
   * @param  string $path [description]
   * 
   * @return null
   */
  
  public static function forget($name, $path = '/'){
    if(isset($_COOKIE[$name])){
      unset($_COOKIE[$name]);
      setcookie($name, null, -1, $path);
    } else {
      Error::set('Couldn\'t find the Cookie "'.$name.'"', __FILE__, __LINE__);
    }
  }
}