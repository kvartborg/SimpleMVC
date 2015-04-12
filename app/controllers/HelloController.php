<?php

class HelloController extends BaseController {
	
	public function index(){
    
    // model
    $user = $this->model('User');
    $users = DB::table('users')->get();

    // make page
    return View::make('index', ['users' => $users]);
  }
}