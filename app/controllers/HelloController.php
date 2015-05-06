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
    Error::set('Couldn\'t find the route', __FILE__, __LINE__);
    Error::set('This is very cool!!', __FILE__, __LINE__);
    Error::set('This just another error', __FILE__, __LINE__);
  }
}