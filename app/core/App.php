<?php
//--------------------------------------------------
//	App
//--------------------------------------------------

class App {

	protected $controller;
	protected $method;
	protected $params = array();

	public function __construct(){
		$url = $this->parseUrl();

		$settings = include __DIR__."../../config/app.php";

		// set settings
		$this->sslCheck($settings);
		$this->setTimezone($settings);
		$this->controller = $settings['controller'];
		$this->method = $settings['method'];

		if(file_exists('../app/controllers/'.ucfirst($url[0]).'Controller.php')){
			$this->controller = ucfirst($url[0]).'Controller';
			unset($url[0]);
			require_once '../app/controllers/'.$this->controller.'.php';
		} else {
			$this->controller = 'BaseController';
			require_once '../app/core/BaseController.php';
		}

		$this->controller = new $this->controller;

		if(method_exists($this->controller, $url[1])){
			$this->method = $url[1];
			unset($url[1]);
		} else {
			if(!method_exists($this->controller, $this->method)){
				// method not found 404!!!
				$this->method = 'notFound';
			}
		}
		
		$this->params = $url ? array_values($url) : [];

		$obj = [$this->controller, $this->method];
		call_user_func_array($obj, $this->params);
	}


	protected function parseUrl(){
		if(isset($_GET['url'])){
			return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}


	protected function sslCheck($settings){
		// SSL
		if($_SERVER['HTTPS'] != 'on' && $settings['ssl']){
			header("Location: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
			exit();
		}
	}


	protected function setTimezone($settings){
		date_default_timezone_set($settings['timezone']);
	}
}