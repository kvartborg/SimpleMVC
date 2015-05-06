<?php

class HelloController extends BaseController {
	
	public function index(){
    // make page
    $test = array();
    return View::make('index', [
      'test' => $test
    ]);
  }

  

  public function test(){
    $time = Time::parse();

    echo $time;
  }
}