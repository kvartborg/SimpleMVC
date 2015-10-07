<?php

class Time {

  protected $format;
  protected $time;
  protected $return;


  protected function __construct(){
    $config = include __DIR__.'../../config/app.php';
    $this->format = $config['date_format'];
  }


  protected function daysInMonth($month, $year){ 
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
  } 


  protected function leapYear($year){
    return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year %400) == 0)));
  }


  public static function now(){
    $obj = new Time;
    $obj->time = time();
    return $obj;
  }


  public static function parse($time){
    $time = str_replace('/', '-', $time);
    $time = str_replace('.', '-', $time);
    $obj = new Time;

    if(!is_numeric($time)){
      $obj->time = strtotime($time);
    } else {
      $obj->time = $time;
    }

    return $obj;
  }


  public function format($str = null){
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


  public function gm(){
    $this->return = gmdate($this->format, $this->time);
    return $this;
  }


  public function addSeconds($sec){
    $this->time = $this->time + $sec;
    return $this;
  }


  public function addMinutes($min){
    $min = $min * 60;
    $this->time = $this->time + $min;
    return $this;
  }


  public function addHours($hours){
    $hours = $hours * 60 * 60;
    $this->time = $this->time + $hours;
    return $this;
  }


  public function addDays($days){
    $days = $days * 60 * 60 * 24;
    $this->time = $this->time + $days;
    return $this;
  }


  public function addWeeks($weeks){
    $weeks = $weeks * 7 * 24 * 60 * 60;
    $this->time = $this->time + $weeks;
    return $this;
  }


  public function addMonths($months){
    $n = $months;

    for ($i = 0; $i < $n; $i++) { 
      $month = intval(date('m', $this->time));
      $year = intval(date('Y', $this->time));
      $this->time = $this->time + $this->daysInMonth($month, $year) * 24 * 60 * 60;
    }

    return $this;
  }

  public function addYears($years){
    $n = $years;
    $year = intval(date('Y', $this->time));
    $years = 24 * 60 * 60;
    for ($i = 0; $i < $n; $i++) { 
      if($this->leapYear($year + $i + 1))
        $this->time += $years * (365 + 1);
      else
        $this->time += $years * 365;
    } 

    return $this;
  }


  public function subSeconds($sec){
    $this->time = $this->time - $sec;
    return $this;
  }


  public function subMinutes($min){
    $min = $min * 60;
    $this->time = $this->time - $min;
    return $this;
  }


  public function subHours($hours){
    $hours = $hours * 60 * 60;
    $this->time = $this->time - $hours;
    return $this;
  }


  public function subDays($days){
    $days = $days * 60 * 60 * 24;
    $this->time = $this->time - $days;
    return $this;
  }


  public function subWeeks($weeks){
    $weeks = $weeks * 7 * 24 * 60 * 60;
    $this->time = $this->time - $weeks;
    return $this;
  }


  public function subMonths($months){
    $n = $months;

    for ($i = 0; $i < $n; $i++) { 
      $month = intval(date('m', $this->time));
      $year = intval(date('Y', $this->time));
      $this->time = $this->time - $this->daysInMonth($month, $year) * 24 * 60 * 60;
    }

    return $this;
  }


  public function subYears($years){
    $n = $years;
    $year = intval(date('Y', $this->time));
    $years = 24 * 60 * 60;
    for ($i = 0; $i < $n; $i++) { 
      if($this->leapYear($year + $i - 1))
        $this->time -= $years * (365 + 1);
      else
        $this->time -= $years * 365;
    } 

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