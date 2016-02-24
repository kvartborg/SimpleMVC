<?php

class Header {

  protected $headers = [];

  public static function custom($key, $value){
    header($key.': '.$value);
  }

  public static function get($key, $value){

  }

}