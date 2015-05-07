<?php

class HelloController extends BaseController {
	
	public function index(){
    // make page
    $test = array();
    echo "test";
    return View::make('index', [
      'test' => $test
    ]);
  }


  public function test(){
    $time = Time::now();
    echo $time;
  }
}