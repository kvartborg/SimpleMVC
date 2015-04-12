<?php

class Time {

  protected $format;
  protected $time;
  protected $return;


  protected function __construct(){
    $config = include __DIR__.'../../config/app.php';
    $this->format = $config['date_format'];
  }


  public function now(){
    $obj = new Time;
    $obj->time = time();
    return $obj;
  }


  public function parse($time){
    $time = str_replace('/', '-', $time);
    $obj = new Time;

    if(!is_numeric($time)){
      $obj->time = strtotime($time);
    } else {
      $obj->time = $time;
    }

    return $obj;
  }


  public function format($str){
    $this->format = $str;
    return $this;
  }


  public function int(){
    $this->return = $this->time;
    return $this->return;
  }


  public function date(){
    $this->format = explode(' ', $this->format)[0];
    return $this;
  }


  public function time(){
    $this->format = explode(' ', $this->format)[1];
    return $this;
  }


  public function addSeconds($time){
    $this->time = $this->time + $time;
    return $this;
  }


  public function addMinutes($time){
    $time = $time * 60;
    $this->time = $this->time + $time;
    return $this;
  }


  public function addHours($time){
    $time = $time * 60 * 60;
    $this->time = $this->time + $time;
    return $this;
  }


  public function addDays($time){
    $time = $time * 60 * 60 * 24;
    $this->time = $this->time + $time;
    return $this;
  }


  public function __toString() {
    if(!$this->return)
      $this->return = date($this->format, $this->time);
    return $this->return;
  }

}

class Date extends Time {
  
}