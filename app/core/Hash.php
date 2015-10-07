<?php

class Hash {

  private $key;
  private $str;


  private function __construct(){
    $this->key = App::config('key');
  }


  protected function generate(){
    $hash = password_hash($this->str, PASSWORD_DEFAULT);
    return $hash;
  }


  public static function validate($str, $hash){
    return password_verify($str, $hash);
  }


  public static function make($str, $key = null){
    $hash = new self();
    $hash->str = $str;
    if(!is_null($key)) $hash->key = $key;

    return $hash->generate();
  }

}