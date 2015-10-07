<?php

class Event {

  protected $queue = [];

  public function __construct(){
  
  }


  public static function run($event, $data = []){
    $e = new Event;
    if(is_array($event)){
      $e->queue = $event;
      exec('php specla '.$event[0].' > /dev/null 2>/dev/null &');
      unset($e->queue[0]);
      $e->queue = array_values($e->queue);
    } else {
      exec('php specla '.$event.' > /dev/null 2>/dev/null &');
    }
  }


  public function info($str){
    echo "\033[32m".$str."\033[0m\n";
  }


  public function error($str){
    echo "\033[31m".$str."\033[0m\n";
  }


  public function __destruct(){
    if(count($this->queue) > 0){
      $this->run($this->queue);
    }
  }

}