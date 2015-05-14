<?php

class App {


  public function __construct(){
    $settings = include __DIR__."../../config/app.php";

    // set settings
    $this->sslCheck($settings);
    $this->setTimezone($settings);

    Route::find();
  }


  protected function parseUrl(){
    if(isset($_GET['url'])){
      return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    }
  }


  protected function sslCheck($settings){
    // SSL
    if($_SERVER['HTTPS'] != 'on' && $settings['ssl']){
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
      exit();
    }
  }


  protected function setTimezone($settings){
    date_default_timezone_set($settings['timezone']);
  }
}