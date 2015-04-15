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

    if(Time::now()->int() < Date::now()->addMinutes(10)->int()){
      echo "passer";
    } else {
      echo "passer ikk";
    }
    
  }
}