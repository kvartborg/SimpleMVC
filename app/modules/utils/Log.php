<?php

class Log {

  public static function info($data){
    if(is_string($data)){
      echo $data.'<br>';
    } else {
      echo '<pre>'.str_replace('\\', '', json_encode($data, JSON_PRETTY_PRINT)).'</pre>';
    }
  }

}