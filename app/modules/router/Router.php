<?php

class Router {

  /**
   * $paths is a dictionary with all routes and its options
   * @var array
   */
  public static $paths = [];

  /**
   * $uri the current URI of the app
   * @var string
   */
  protected $uri;

  /**
   * $pathsWithoutVars paths without variables
   * @var array
   */
  protected static $pathsWithoutVars = [];

  /**
   * $pathsWithVars paths which contains variables
   * @var array
   */
  protected static $pathsWithVars = [];

  /**
   * $vars contains variables for routes
   * @var array
   */
  protected $vars = [];

  /**
   * Contains the missing closure
   * @var null|closure
   */
  public static $missing = null;


  /**
   * Register router
   * Get the app URI
   * Short paths
   * Find matching path
   */
  public function __construct(){
    $this->uri = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

    if($this->uri === '')
      $this->uri = '/';

    $this->shortPaths();
    $this->find();
  }

  /**
   * Short registered paths into to arrays (paths without vars, paths with vars)
   * @return null
   */
  protected function shortPaths(){
    foreach(static::$paths as $path => $options) {
      if(strpos($path, ':')){
        static::$pathsWithVars[$path] = $options;
      } else {
        static::$pathsWithoutVars[$path] = $options;
      }
    }
  }


  /**
   * Checks paths against REQUEST_URI to find a match
   * @return null
   */
  protected function find(){
    foreach(static::$pathsWithoutVars as $path => $options){
      if($this->uri === $path 
        && $options['middleware'] === true
        && ($options['method'] === $_SERVER['REQUEST_METHOD'] || $options['method'] === 'ALL')
      ){
        return $this->trigger($path, $options);
      }
    }

    $this->checkForVars();
  }


  /**
   * Iterates over paths with vars
   * @return null 
   */
  protected function checkForVars(){
    foreach(static::$pathsWithVars as $path => $options){
      if($this->uri === $this->constructURI($path) 
        && $options['middleware'] === true
        && ($options['method'] === $_SERVER['REQUEST_METHOD'] || $options['method'] === 'ALL')
      ){
        return $this->trigger($path, $options);
      }
    }

    $this->notFound();
  }


  /**
   * Constructs a real uri with variables from the REQUEST_URI
   * @param  string $path Create real URI from path with variables
   * @return string       Constructed path
   */
  protected function constructURI($path){
    $this->vars = [];
    $uri = explode('/', ltrim($this->uri, '/'));
    $pathURI = explode('/', ltrim($path, '/'));
    $constructURI = [];

    for($i = 0; $i < count($pathURI); $i++){
      if(strpos($pathURI[$i], ':') !== false && strpos($pathURI[$i], '?')){
        // optional
        if(isset($uri[$i]))
          $this->vars[] = urldecode($uri[$i]);

        $constructURI[$i] = isset($uri[$i]) ? $uri[$i] : '';
      } elseif(strpos($pathURI[$i], ':') !== false) {
        // required
        if(isset($uri[$i])){
          $this->vars[] = urldecode($uri[$i]);
          $constructURI[$i] = $uri[$i];
        } else {
          $constructURI[$i] = $pathURI[$i];
        }
      } else {
        $constructURI[$i] = $pathURI[$i];
      }
    }

    return rtrim('/'.join($constructURI, '/'), '/');
  }

  /**
   * Trigger the route callback
   * @param  string $path    The matched path
   * @param  array  $options Contains middleware, name, closure and more...
   * @return null
   */
  protected function trigger($path, $options){
    if(is_callable($options['callback'])){
      call_user_func_array($options['callback'], $this->vars);
    } else {
      $this->controller($options['callback']);
    }
  }

  /**
   * Parse the controller callback string
   * @param  string $callback Controller string
   * @return null
   */
  protected function controller($callback){
    $class = explode('@', $callback)[0];
    $method = explode('@', $callback)[1];
    $root = $_SERVER['DOCUMENT_ROOT'].str_replace(['/index.php', '/public/index.php'], '', $_SERVER['SCRIPT_NAME']);

    if(file_exists($root.'/app/controllers/'.$class.'.php')){
      require_once $root.'/app/controllers/'.$class.'.php';
    } else {
      throw new Exception('Missing the '.$class);
    }

    $controller = new $class;
    if(method_exists($controller, $method)){
      call_user_func_array([$controller, $method], $this->vars);
    } else {
      throw new Exception($class.' is missing the '.$method.' method');
    }
  }


  /**
   * If no path match the REQUEST_URI, then fire the not found
   * @return null
   */
  public function notFound(){
    if(is_null(static::$missing)){
      http_response_code(404);
      throw new Exception("Couldn't find any matching routes");
    } else {
      call_user_func(static::$missing);
    }
  }
}
