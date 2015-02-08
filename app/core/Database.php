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
  protected $select = array();


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
    $result = mysqli_fetch_all($this->con->query($str), MYSQLI_ASSOC);
    return $result;
  }


  protected function table($table){
    $this->query = $table;
    return new DB($this->query);
  }


  protected function select($select = array()){
    if(count($select)){
      $this->select = $select;
      $result;
      foreach($this->select as $select){
        $result .= $select.', ';
      }
      $this->query = 'SELECT '.$result.' FROM '.$this->query;
    } else {
      $this->query = 'SELECT * FROM '.$this->query;
    }
    return new DB($this->query);
  }

  protected function orderBy($str, $type){
    return new DB($this->query.' ORDER BY '.$str.', '.$type);
  }


  public function get(){
    return $this->query;
    echo $this->query;
  }


  public function first(){
    return $this->query.' ORDER BY id DESC LIMIT 1';
    echo $this->query;
  }
}