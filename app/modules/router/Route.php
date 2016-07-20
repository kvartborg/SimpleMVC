<?php

class Route {

  /**
   * $path the routes path
   * @var string
   */
  public $path;

  /**
   * $options contains all options for a route
   * @var array
   */
  public $options = [];

  /**
   * Prefix
   * @var string
   */
  protected static $prefix = '';


  /**
   * Register new route
   * @param string  $method     The accepted HTTP method
   * @param  string          $path         The path that should be defined
   * @param  bool|closure    $middleware   Should be true to accept the route (Optional)
   * @param  closure|null    $callback     What the route does
   * @return Router          Instance of the router
   */
  public function __construct($method, $path, $middleware, $callback = null){ 

    if(is_null($callback)){
      $callback = $middleware;
      $middleware = true;
    }

    if($path[0] !== '/')
      $path = '/'.$path;

    if(strlen($path) > 1)
      $path = rtrim($path, '/');

    $this->options['path'] = static::$prefix.$path; 
    $this->options['method'] = $method;
    $this->options['middleware'] = $middleware;
    $this->options['callback'] = $callback;

    return $this->register();
  }


  /**
   * Defined routes with HTTP methods
   * @param  string          $path         The path that should be defined
   * @param  bool|closure    $middleware   Should be true to accept the route (Optional)
   * @param  closure|null    $callback     What the route does
   * @return Router          Instance of the router
   */
  public static function all($path, $middleware, $callback = null){ return new Route('ALL', $path, $middleware, $callback); }
  public static function get($path, $middleware, $callback = null){ return new Route('GET', $path, $middleware, $callback); }
  public static function post($path, $middleware, $callback = null){return new Route('POST', $path, $middleware, $callback); }
  public static function put($path, $middleware, $callback = null){ return new Route('PUT', $path, $middleware, $callback); }
  public static function delete($path, $middleware, $callback = null){ return new Route('DELETE', $path, $middleware, $callback); }


  /**
   * Do something when nothing matched the REQUEST_URI
   * @param  closure $callback what to do
   * @return null
   */
  public static function missing($callback, $code = 404){ 
    http_response_code($code);
    Router::$missing = $callback; 
  }
  

  /**
   * Catch requests if no path was found
   * @param  closure $callback what to do
   * @return null
   */
  public static function catchAll($callback, $code = 200){
    http_response_code($code);
    Router::$missing = $callback;
  }


  public static function group($prefix, $middleware, $callback = null){
      if(is_null($callback)){
        $callback = $middleware;
        $middleware = true;
      }

      if($prefix[0] !== '/')
        $prefix = '/'.$prefix;

      if(strlen($prefix) > 1)
        $prefix = rtrim($prefix, '/');

      static::$prefix = $prefix;

      if($middleware)
        call_user_func($callback);

      static::$prefix = '';
  }


  /**
   * Add a name to the route options 
   * @param  string $str Name for the route
   * @return Route      
   */
  public function name($str){
    $this->options['name'] = $str;
    return $this->register();
  }


  /**
   * Register all changes to the route object and add it to the Router::$paths
   * @return Route
   */
  public function register(){
    Router::$paths[] = $this->options;
    return $this;
  }
}
