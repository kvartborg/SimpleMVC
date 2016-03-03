<?php

class App {

  /**
   * Setting up App with the correct settings and tells the routing system to search for the route
   *
   * @return null
   */
  public function __construct(){
    $this->sslCheck($GLOBALS['config']);
    $this->setTimezone($GLOBALS['config']);

    session_start();
    new Router;
  }


  /**
   * Parse the url and separate to sections by / 
   * 
   * @return array $url Which contains the URI in seperated parts
   */

  protected function parseUrl(){
    if(isset($_GET['url'])){
      return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    }
  }


  /**
   * Check for https else redirect to the correct
   * 
   * @param array $settings Takes the ssl from the app config file
   *
   * @return null Redirects to https
   */

  protected function sslCheck($config){
    // SSL
    if($config['ssl'] && $_SERVER['HTTPS'] != 'on'){
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
      exit();
    }
  }


  /**
   * Sets the correct timezone from the config file
   *
   * @param array $settings 
   *
   * @return null
   */

  protected function setTimezone($config){
    date_default_timezone_set($config['timezone']);
  }


  /**
   * Retrieve values from your config file
   *
   * @param string $str 
   *
   * @return mixed $config
   */
  
  public static function config($str = null, $value = null){
    if(is_null($value)) {
      $config = $GLOBALS['config'];
      return App::dotString($str, $config);
    } else {
      $config = $GLOBALS['config'];
      return App::dotString($str, $config, $value);
    }
  }


  public static function dotString($str, &$array, $value = null){
    if(!is_null($value)){
      $loc = &$array;
      foreach(explode('.', $str) as $step){
        $loc = &$loc[$step];
      }

      $loc = $value;
      return $GLOBALS['config'] = $array;
    }

    if(strpos($str, '.') !== false){
      foreach(explode('.', $str) as $step){
        $array = $array[$step];
      }

      return $array;
    } else {
      return $array[$str];
    }
  }
}