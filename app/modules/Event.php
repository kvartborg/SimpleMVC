<?php

class Event {

  protected $queue = [];
  protected $args  = [];
  protected $data  = [];

  public function __construct($args = []){
    $this->args = array_values($args);

    $this->data = new stdClass();
    for($i = 0; $i < count($this->args); $i++){
      if(strpos($this->args[$i], '=')){
        $item = explode('=', $this->args[$i]);
        $this->data->$item[0] = $item[1];
      }
    }
  }


  public static function run($event, $data = []){
    $e = new Event;

    $command = 'php specla '.$event.' '.join(' ', $data).' > /dev/null 2>/dev/null &';
    
    exec($command);
  }


  public function debug($str){
    if(in_array('debug', $this->args)){
      if(is_string($str)){
        echo $str."\n";
      } else {
        echo json_encode($str, JSON_PRETTY_PRINT)."\n";
      }
    }
  }

  public function info($str){
    echo "\033[32m".$str."\033[0m\n";
  }


  public function error($str){
    echo "\033[31m".$str."\033[0m\n";
  }

}