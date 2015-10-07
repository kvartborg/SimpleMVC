<?php

class Route {

  protected $controller;
  protected $method;
  protected $params = array();
  protected $url;
  protected $routes = array();
  protected $baseUrl = '';


  protected function __construct(){
    if($this->parseUrl() == null){
      $this->url = '/';
    } else {
      $url = $_GET['url'];

      if(substr($url, -1, 1) == '/')
        $url = substr($url, 0, strlen($url) - 1);

      $this->url = '/'.$url;
    }

    $this->routes = $GLOBALS['routes'];
  }


  protected function parseUrl(){
    if(isset($_GET['url'])){
      return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    }
  }


  // NEEDS FIX: post to any
  public static function any($url, $func){
    Route::set($url, $func, 'ANY');
  }


  public static function delete($url, $func){
    Route::set($url, $func, 'DELETE');
  }


  public static function put($url, $func){
    Route::set($url, $func, 'PUT');
  }


  public static function post($url, $func){
    Route::set($url, $func, 'POST');
  }


  public static function get($url, $func){
    Route::set($url, $func, 'GET');
  }


  public static function set($url, $func, $method = 'GET'){
    if(substr($url, 0, 1) != '/')
      $url = '/'.$url;

    // check for vars
    if(strpos($url, ':') !== false){
      $vars = explode('/', $url);
      unset($vars[0]);
      for($i = 1; $i < (count($vars) + 1); $i++){
        if(strpos($vars[$i], ':') !== false)
          $v[] = $vars[$i];
      }

      $vars = $v;
    } else {
      $vars = [];
    }


    $GLOBALS['routes'][] = (object)[
      'method' => strtoupper($method), 
      'url' => $url,
      'func' => $func,
      'vars' => $vars,
    ];
  }


  public static function find(){
    $routes = new Route;
    $error = 1;

    foreach ($routes->routes as $route) {

      if(count($route->vars)){
        // construct url
        $url = explode('/', $route->url);
        $r_url = explode('/', $routes->url);
        unset($url[0]);
        unset($r_url[0]);
        if(count($url) >= count($r_url)){
          for($i = 1; $i < (count($r_url) + 1); $i++){
            if(strpos($url[$i], ':') !== false){
              $vars[$url[$i]] = $r_url[$i];
              $url[$i] = $r_url[$i];
            }
          }

          // check for optional vars
          for($i = 1; $i < (count($url) + 1); $i++){
            if(strpos($url[$i], ':') !== false && strpos($url[$i], '?') !== false){
              $vars[$url[$i]] = null;
              unset($url[$i]);
            }
          }

          $route->url = '/'.implode('/', $url);
        } else {
          $vars = [];
        }
      } else {
        $vars = [];
      }

      if($routes->url == $route->url && ($route->method == $_SERVER['REQUEST_METHOD'] || $route->method == 'ANY')){
        // static
        $error = 0;
        if(is_callable($route->func)){
          $func = $route->func;
          if(count($vars))
            call_user_func_array($func, $vars);
          else
            $func();
        } else {
          if(strpos($route->func, '@')){
            $str = explode('@', $route->func);
            $routes->controller = $str[0];
            $routes->method = $str[1];

            if(count($vars)){
              foreach ($vars as $var) {
                $v[] = $var;
              }
              $routes->params = $v ? array_values($v) : [];
            }

            $error = $routes->controller();
          } else {
            $error = 1;
            $routes->controller = $route->func;
            $routes->baseUrl = $route->url;
          }
        }
      } else {
        if(strpos($routes->url, $route->url) !== false && is_string($route->func) && !strpos($route->func, '@') && $route->method == $_SERVER['REQUEST_METHOD']){
          $routes->controller = $route->func;
          $routes->baseUrl = $route->url;
        }
      }
    }

    if($error == 1){
      if($routes->baseUrl != ''){
        $url = explode('/', $routes->url);
        if(('/'.$url[1]) == $routes->baseUrl){
          if(substr($routes->url, 0, strlen($routes->baseUrl)) == $routes->baseUrl){
            
            $url = substr($routes->url, strlen($routes->baseUrl));
            $url = explode('/', $url);

            unset($url[0]);
            if(count($url) > 0){
              $routes->method = $url[1];
              unset($url[1]);
              $routes->params = $url ? array_values($url) : [];
            } else {
              $routes->method = 'index';
            }

            $error = $routes->controller();
          }
        }
      }
    }

    if($error == 1 && $GLOBALS['config']['debug']){
      http_response_code(404);
      Error::set('Failed to find Route', __FILE__, __LINE__);
    } elseif($error == 1 && !$GLOBALS['config']['debug']) {
      http_response_code(404);
      return View::make('errors/404');
    }
  }


  public static function show(){
    var_dump($GLOBALS['routes']);
  }


  protected function controller(){

    if(file_exists('app/controllers/'.$this->controller.'.php')){
      require_once 'app/controllers/'.$this->controller.'.php';
    } else {
      if($GLOBALS['settings']['debug'])
        Error::set('Failed to find controller <b>'.$this->controller.'</b>', __FILE__, __LINE__);
    }

    if(strpos($this->controller, '/') !== false){
      $this->controller = explode('/', $this->controller);
      $this->controller = $this->controller[count($this->controller) - 1];
    }

    $controller = $this->controller;
    $this->controller = new $this->controller;

    $obj = [$this->controller, $this->method];

    if(method_exists($this->controller, $this->method)){
      call_user_func_array($obj, $this->params);
      return 0;
    } else {
      if($GLOBALS['settings']['debug'])
        Error::set('Failed to find method '.$this->method.', in '.$controller, __FILE__, __LINE__);
      return 1;
    }
  }
}