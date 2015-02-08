<?php

class Hello extends BaseController {
	
	public function index(){
    
    // model
    $user = $this->model('User');

    $test = DB::query('SELECT * FROM users');
    var_dump($test);

    // make page
    View::make('index', $user);
  }
}