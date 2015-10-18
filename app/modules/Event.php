<?php

class Event {

  protected $queue = [];

  public function __construct(){
  
  }


  public static function run($event, $data = []){
    $e = new Event;
    if(is_array($event)){
      $command = '';
      for($i = 0; $i < count($event); $i++){
        $command .= 'php specla '.$event.' > /dev/null 2>/dev/null; ';
      }
      $command .= '&';
    } else {
      $command = 'php specla '.$event.' > /dev/null 2>/dev/null &';
    }
    
    exec($command);
  }


  public function info($str){
    echo "\033[32m".$str."\033[0m\n";
  }


  public function error($str){
    echo "\033[31m".$str."\033[0m\n";
  }

}