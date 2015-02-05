<?php
// ------------------------------------ 
//	App
// ------------------------------------

class App {

	protected $controller = 'Hello';
	protected $method = 'index';
	protected $params = [];

	public function __construct(){
		$url = $this->parseUrl();

		// check controller for existence
		if(file_exists('../app/controllers/'.ucfirst($url[0]).'.php')){
			$this->controller = ucfirst($url[0]);
			unset($url[0]);
			require_once '../app/controllers/'.$this->controller.'.php';
		} else {
			$this->controller = 'BaseController';
			require_once '../app/core/BaseController.php';
		}

		$this->controller = new $this->controller;

		// check for method existence within the controller
		if(method_exists($this->controller, $url[1])){
			$this->method = $url[1];
			unset($url[1]);
		} else {
			if(!method_exists($this->controller, $this->method)){
				// method not found 404!!!
				$this->method = 'notFound';
			}
		}

		// define parameters
		$this->params = $url ? array_values($url) : [];

		$obj = [$this->controller, $this->method];
		call_user_func_array($obj, $this->params);
	}

	public function parseUrl(){
		if(isset($_GET['url'])){
			return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
		/*if(isset($_SERVER['REQUEST_URI'])){
			return $url = explode('/', filter_var(rtrim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL));
		}*/
	}
}