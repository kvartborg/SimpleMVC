<?php

class HelloController extends BaseController {
	
	public function index(){
    
    // model
    $user = $this->model('User');
    $users = DB::table('users')->get();

    // make page
    return View::make('index', ['users' => $users]);
  }

  public function test(){

    $dir = __DIR__.'/../core';

    $files = scandir($dir);

    unset($files[0]);
    unset($files[1]);
    var_dump($files);
  }
}