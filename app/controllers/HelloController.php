<?php

class HelloController extends BaseController {
	
	public function index(){
    // make page
    $users = DB::table('users')->get();
    return View::make('index', [
      'users' => $users
    ]);
  }


  public function test2(){
    $time = Time::now();
    echo $time;
  }

  public function addtest($test){
    echo $test;
  }

  public function server(){
    var_dump($_SERVER);
  }
}