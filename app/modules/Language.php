<?php

class Lang {

  public static function get($str, $vars = []){
    $lang = App::config('language');
    if(Session::has('language')) $lang = Session::get('language');

    if(!isset($GLOBALS['language'][explode('.', $str)[0]])){
      $GLOBALS['language'][explode('.', $str)[0]] = include __DIR__."/../resources/languages/".$lang.'/'.explode('.', $str)[0].'.php';
    } 

    $lang = $GLOBALS['language'][explode('.', $str)[0]];

    $str = static::dotString($str, $lang);

    if(count($vars) > 0){
      if(static::isList($vars))
        $str = static::setVarsFromList($str, $vars);
      else
        $str = static::setVarsFromArray($str, $vars);
    }

    return $str;
  }


  public static function setVarsFromList($str, $vars){
    foreach($vars as $key => $value) {
      $str = str_replace(':'.$key, $value, $str);
    }

    return $str;
  } 


  public static function setVarsFromArray($str, $vars){
    for($i = 0; $i < count($vars); $i++){
      preg_match('/(:[^\s]+)/', $str, $match);
      if(isset($match[0]))
        $str = str_replace($match[0], $vars[$i], $str);
    }

    return $str;
  } 


  public static function set($str){
    Session::set('language', $str);
  }


  public static function  isList($arr){
    return array_keys($arr) !== range(0, count($arr) - 1);
  }


  public static function dotString($str, $data){
    $tmp = explode('.', $str);
    unset($tmp[0]);
    $tmp = join('.', $tmp);

    if(strpos($str, '.') !== false){
      $tmp = explode('.', $tmp);
      foreach ($tmp as $value) {
        isset($data[$value]) ? $data = $data[$value] : $data = '';
      }

      if($data == '')
        $data = $str;
    } else {
      if(is_null($str))
        $data = $data;
      else
        $data = isset($data[$str]) ? $data[$str]: $str;
    }

    return $data;
  }

}