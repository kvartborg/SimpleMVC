<?php

class Hello extends BaseController {
	
	public function index(){
    
    // model
    $user = $this->model('User');

    // make view
    $this->view('/index', $user);
	}
}