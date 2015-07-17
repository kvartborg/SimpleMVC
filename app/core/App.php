<?php

class App {

  /**
   * Setting up App with the correct settings and tells the routing system to search for the route
   *
   * @return null
   */

  public function __construct(){
    $settings = include __DIR__."../../config/app.php";

    $GLOBALS['settings'] = $settings;

    $this->sslCheck($settings);
    $this->setTimezone($settings);

    session_start();
    ob_start();
    Route::find();
    ob_end_flush();
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

  protected function sslCheck($settings){
    // SSL
    if($_SERVER['HTTPS'] != 'on' && $settings['ssl']){
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

  protected function setTimezone($settings){
    date_default_timezone_set($settings['timezone']);
  }
}