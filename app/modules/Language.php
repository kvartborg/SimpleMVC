<?php

class Lang {

  public static function get($str){
    $lang = App::config('language');
    if(Session::has('language')) $lang = Session::get('language');

    $file = include __DIR__."/../resources/languages/".$lang.'/'.explode('.', $str)[0].'.php';
    
    $str = explode('.', $str);
    unset($str[0]);
    $str = join('.', $str);

    return App::dotString($str, $file);
  }


  public static function set($str){
    Session::set('language', $str);
  }

}