<?php

/*
| ------------------------------------------------------------------
| Database
| ------------------------------------------------------------------
|
| This class is an easy way to build powerful queries. 
| 
*/

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
    $config = include __DIR__.'../config/database.php';
    $this->host = $config['host'];
    $this->database = $config['database'];
    $this->username = $config['username'];
    $this->password = $config['password'];
    $this->prefix   = $config['prefix'];
    if($this->database != '' && $this->username != '')
      $this->connect();
    $this->query = $query;
  }


  /*
  | ------------------------------------------------------------------
  | Connect to the database
  | ------------------------------------------------------------------
  |
  | This method runs as part of the construct function at every query
  | and establishes a connection to the database via the data from
  | the config file.
  | 
  */

  protected function connect(){
    // Create connection
    $this->con = new mysqli($this->host, $this->username, $this->password, $this->database);
    // Check connection
    if ($this->con->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
  }


  /*
  | ------------------------------------------------------------------
  | Raw query
  | ------------------------------------------------------------------
  |
  | This method enables the user to create a normal query.
  | But its not recommended to use.
  |
  | This method takes a string
  | 
  */

  public function query($str){
    $data = array();
    $result = $this->con->query($str);
    
    while($row = $result->fetch_assoc()){
      array_push($data, $row);
    }

    $object = json_decode(json_encode($data));
    $this->con->close();
    return $object;
  }


  /*
  | ------------------------------------------------------------------
  | Table 
  | ------------------------------------------------------------------
  |
  | This method defines the table which the other DB Methods
  | relay on. So every DB method needs this at the start
  | of a call, except the raw query method
  |
  | The table method takes a string
  | 
  */

  public static function table($table){
    $obj = new DB;
    if ($obj->prefix != '')
      $obj->query = $this->prefix.'_'.$table;
    else 
      $obj->query = $table;
    return $obj;
  }


  /*
  | ------------------------------------------------------------------
  | Select 
  | ------------------------------------------------------------------
  |
  | This method is placed after the table method and selects the
  | columns to return from the database. 
  |
  | The select method takes an array of the columns to return 
  | from DB (Array)
  | 
  */

  public function select($selects = []){
    $n = count($selects);
    if(count($selects)){
      $result = '';
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


  /*
  | ------------------------------------------------------------------
  | Where 
  | ------------------------------------------------------------------
  |
  | This method selects which data to pull from the database. The
  | where method should be placed behind the select method, and
  | to define more than one where on a query, simply add add a
  | where method more.
  |
  | The where method takes a key (String), 
  | an oprator which by default is '=' (String)
  | and the value to compare it to (String)
  | 
  */

  public function where($key, $operator = '=', $value = ''){

    if($value == ''){
      $value = $operator;
      $operator = '=';
    }

    if(strpos($this->query, 'WHERE') !== false){
      return new DB($this->query." AND ".$key." ".$operator." '".$value."'");
    } else {
      return new DB($this->query." WHERE ".$key." ".$operator." '".$value."'");
    }
  }


  /*
  | ------------------------------------------------------------------
  | Order by 
  | ------------------------------------------------------------------
  |
  | The orderBy method are includeded after the where, and return
  | the data in the order you want.
  |
  | The orderBy method takes the column to order by (String), and
  | in which way it should be ordered (String) 
  | 
  */

  public function orderBy($str, $type){
    return new DB($this->query.' ORDER BY '.$str.' '.$type);
  }


  /*
  | ------------------------------------------------------------------
  | Get the DATA!! 
  | ------------------------------------------------------------------
  |
  | This method returns the data in an object formatted form and is
  | ready to be put into a foreach loop for easy listing.
  | 
  | The get method should all ways be at the end of the database call
  | 
  */

  public function get(){
    $query = $this->query;
    // check for a defined select, else select *
    if(strpos($this->query, 'SELECT') !== false){
      // do nothing
    } else {
      $query = 'SELECT * FROM '.$this->query;
    }

    $data = array();
    $result = $this->con->query($query);
    
    if($result){
      while($row = $result->fetch_assoc()){
        array_push($data, $row);
      }
    }

    $object = json_decode(json_encode($data));
    $this->con->close();
    return $object;
  }


  /*
  | ------------------------------------------------------------------
  | Get first row of data
  | ------------------------------------------------------------------
  |
  | This method has almost the same function as get(), but it only 
  | returns the first row of a call to the database. This method 
  | should be used if you now you only are returning one row. 
  | 
  */

  public function first(){
    // check for a defined select, else select *
    if(strpos($this->query, 'SELECT') !== false){
      // do nothing
      $query = $this->query.' LIMIT 1';
    } else {
      $query = 'SELECT * FROM '.$this->query.' LIMIT 1';
    }
    
    $data = array();
    $result = $this->con->query($query);
    
    if($result){
      while($row = $result->fetch_assoc()){
        array_push($data, $row);
      }
    }

    $object = json_decode(json_encode($data));
    $this->con->close();
    return $object;
  }


  /*
  | ------------------------------------------------------------------
  | Insert a new row of data
  | ------------------------------------------------------------------
  |
  | This method is taking a dictionary where the key is the columns
  | the value pair is put into
  | 
  */

  public function insert($array = []){
    // construct query string
    $n = count($array);
    $i = 1;
    $col = '';
    $val = '';

    foreach($array as $key => $value){
      if($i < $n){
        $col .= $key.', ';
        $val .= "'".addslashes($value)."'". ', ';
      } else {
        $col .= $key;
        $val .= "'".addslashes($value)."'";
      }
      $i++;
    }

    $sql = 'INSERT INTO '.$this->query.' ('.$col.') VALUES ('.$val.')';

    // run
    $result = $this->con->query($sql);
    $this->con->close();
    
    return $result;
  }
}









