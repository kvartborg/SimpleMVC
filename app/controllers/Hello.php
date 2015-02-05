<?php

class Hello extends BaseController {
	
	public function index(){
    
    $user = $this->model('User');

    $this->view('/index', $user);
	}

}