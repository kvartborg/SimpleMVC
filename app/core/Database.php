<?php

class DB {

  protected $host;
  protected $database;
  protected $username;
  protected $password;
  protected $prefix;
  protected $con;
  protected $table;
  protected $query;


  function __construct($query = ''){
    $input = include __DIR__.'../../config/database.php';
    $this->host = $input['host'];
    $this->database = $input['database'];
    $this->username = $input['username'];
    $this->password = $input['password'];
    $this->prefix   = $input['prefix'];
    $this->connect();
    $this->query = $query;
  }


  protected function connect(){
    // Create connection
    $this->con = new mysqli($this->host, $this->username, $this->password, $this->database);
    // Check connection
    if ($this->con->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
  }


  protected function query($str){
    $object = json_decode(json_encode(mysqli_fetch_all($this->con->query($str), MYSQLI_ASSOC)), FALSE);
    return $object;
  }


  protected function table($table){
    $this->query = $table;
    return new DB($this->query);
  }


  protected function select($selects = array()){
    $n = count($selects);
    if(count($selects)){
      $result;
      foreach($selects as $key=>$select){
        $result .= $select;
        if($key < ($n-1)){
          $result .= ', ';
        }
      }
      $this->query = 'SELECT '.$result.' FROM '.$this->query;
    } 
    return new DB($this->query);
  }


  protected function where($key, $operator = '=', $value){

    if(strpos($this->query, 'WHERE') !== false){
      return new DB($this->query." AND ".$key." ".$operator." '".$value."'");
    } else {
      return new DB($this->query." WHERE ".$key." ".$operator." '".$value."'");
    }
  }


  protected function orderBy($str, $type){
    return new DB($this->query.' ORDER BY '.$str.' '.$type);
  }


  public function get(){
    $query = $this->query;
    // check for a defined select, else select *
    if(strpos($this->query, 'SELECT') !== false){
      // do nothing
    } else {
      $query = 'SELECT * FROM '.$this->query;
    }

    $object = json_decode(json_encode(mysqli_fetch_all($this->con->query($query), MYSQLI_ASSOC)), FALSE);
    $this->con->close();
    return $object;
  }


  public function first(){
    $query = $this->query.' LIMIT 1';
    // check for a defined select, else select *
    if(strpos($this->query, 'SELECT') !== false){
      // do nothing
    } else {
      $query = 'SELECT * FROM '.$this->query;
    }

    $object = json_decode(json_encode(mysqli_fetch_all($this->con->query($query), MYSQLI_ASSOC)), FALSE);
    $this->con->close();
    return $object;
  }
}