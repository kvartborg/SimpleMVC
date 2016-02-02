<?php


class DB {

  protected $host;
  protected $database;
  protected $username;
  protected $password;
  protected $prefix;
  protected $driver;
  protected $connection;

  protected $operator = '';
  protected $table    = '';
  protected $select   = '';
  protected $join     = '';
  protected $where    = '';
  protected $order    = '';
  protected $group    = '';
  protected $limit    = '';
  protected $query    = '';


  function __construct(){
    $settings       = $GLOBALS['config']['database'];
    $this->host     = $settings['host'];
    $this->database = $settings['database'];
    $this->username = $settings['username'];
    $this->password = $settings['password'];
    $this->prefix   = $settings['prefix'];
    $this->driver   = $settings['driver']; 
    $this->connect();
  }


  protected function connect(){
    $str = $this->driver.':host='.$this->host.';dbname='.$this->database;
    $this->connection = new PDO($str, $this->username, $this->password);
  }


  public static function query($str){
    $db = new DB();
    $db->query = $str;

    return $db;
  }


  public static function table($name){
    $db = new DB();
    $db->table = $db->prefix.$name;
    return $db;
  }


  public function select($array){
    for($i = 0; $i < count($array); $i++){
      $this->select .= $array[$i].($i == count($array)-1 ? '' : ', ');
    }

    $this->select .= ' FROM';

    return $this;
  }


  public function join($table, $col1, $operator, $col2){
    $this->join .= 'JOIN '.$this->prefix.$table.' ON '.$col1.' '.$operator.' '.$col2.' ';
    return $this;
  }


  public function leftJoin($table, $col1, $operator, $col2){
    $this->join .= 'LEFT JOIN '.$this->prefix.$table.' ON '.$col1.' '.$operator.' '.$col2.' ';
    return $this;
  }


  public function rightJoin($table, $col1, $operator, $col2){
    $this->join .= 'RIGHT JOIN '.$this->prefix.$table.' ON '.$col1.' '.$operator.' '.$col2.' ';
    return $this;
  }


  public function where($key, $operator = '=', $value = null){
    if($value == null){
      $value = $operator;
      $operator = '=';
    }

    if(is_array($value)){
      $this->where = 'WHERE '.$key.' IN (';
      for ($i=0; $i < count($value); $i++) { 
        $this->where .= addslashes($value[$i]);
        if(($i+1) < count($value)) $this->where .= ',';
      }
      $this->where .= ')';

    } else {
      if($this->where == '')
        $this->where = 'WHERE '.$key.$operator."'".addslashes($value)."'"; 
      else 
        $this->where .= ' AND '.$key.$operator."'".addslashes($value)."'"; 
    }

    return $this;
  }


  public function orWhere($key, $operator = '=', $value = null){
    if($value == null){
      $value = $operator;
      $operator = '=';
    }

    if($this->where == '')
      $this->where = 'WHERE '.$key.$operator."'".addslashes($value)."'"; 
    else 
      $this->where .= ' OR '.$key.$operator."'".addslashes($value)."'"; 

    return $this;
  }


  public function orderBy($str, $type = 'ASC'){
    if($this->order == '')
      $this->order = 'ORDER BY '.$str.' '.$type;
    else
      $this->order .= ', '.$str.' '.$type;

    return $this;
  }


  public function groupBy($str){
    $this->group = 'GROUP BY '.$str;
    return $this;
  }


  public function limit($take, $skip = null){
    if($skip == null)
      $this->limit = 'LIMIT '.$take;
    else
      $this->limit = 'LIMIT '.$take.', '.$skip;

    return $this;
  }


  public function get(){
    if($this->select)
      $this->operator = 'SELECT';
    else
      $this->operator = 'SELECT * FROM';

    $this->query =  $this->operator.' '.
                    $this->select.' '.
                    $this->table.' '.
                    $this->join.' '.
                    $this->where.' '.
                    $this->group.' '.
                    $this->order.' '.
                    $this->limit;

    $q = $this->connection->prepare($this->query);

    if($q->execute()){
      $result = $q->fetchAll(PDO::FETCH_OBJ);
    } else {
      $result = false;
    }

    $this->connection = null;
    return $result;
  }


  public function first(){
    $this->limit = 'LIMIT 1';
    $result = $this->get();
    return $result[0];
  }


  public function getAsModels($index = 'id'){
    return Model::register($this->get(), $this->table, $index);
  }


  public function count($str = '*'){
    $this->select(['COUNT('.$str.') AS count']);
    $result = $this->get();
    return $result[0]->count;
  }

  public function sum($str){
    $this->select(['SUM('.$str.') AS sum']);
    $result = $this->get();
    return $result[0]->sum;
  }


  public function insert($array){
    $this->operator = 'INSERT INTO';

    $insert = '(';
    $values = '(';
    $n = 1;

    if(isset($array[0])){
      $tmp_array = $array;
      $array = $array[0];
    }

    foreach ($array as $key => $value) {
      if($n == count($array))
        $insert .= $key.')';
      else
        $insert .= $key.', ';

      if($n == count($array))
        $values .= "'".addslashes($value)."'".')';
      else
        $values .= "'".addslashes($value)."'".', ';

      $n++;
    }

    if(isset($tmp_array)){
      unset($tmp_array[0]);
      foreach ($tmp_array as $array) {
        $values .= ', (\''.implode('\', \'', $array).'\')';
      }
    }

    $this->query = $this->operator.' '.$this->table.' '.$insert.' VALUES'.$values;

    $q = $this->connection->prepare($this->query);
    $result = $q->execute();

    $this->connection = null;
    return $result;
  }


  public function insertGetId($array){
    $this->operator = 'INSERT INTO';

    $insert = '(';
    $values = '(';
    $n = 1;

    if(isset($array[0])){
      $tmp_array = $array;
      $array = $array[0];
    }

    foreach ($array as $key => $value) {
      if($n == count($array))
        $insert .= $key.')';
      else
        $insert .= $key.', ';

      if($n == count($array))
        $values .= "'".addslashes($value)."'".')';
      else
        $values .= "'".addslashes($value)."'".', ';

      $n++;
    }

    if(isset($tmp_array)){
      unset($tmp_array[0]);
      foreach ($tmp_array as $array) {
        $values .= ', (\''.implode('\', \'', $array).'\')';
      }
    }

    $this->query = $this->operator.' '.$this->table.' '.$insert.' VALUES'.$values;

    $q = $this->connection->prepare($this->query);
    
    if (!$q) {
      Error::set($this->connection->errorInfo(), __FILE__, __LINE__);
    } else {
      $result = $q->execute();
    }


    $result = $this->connection->lastInsertId();

    $this->connection = null;
    return $result;
  }


  public function update($array){
    $this->operator = 'UPDATE';

    $update = '';
    $n = 1;

    foreach ($array as $key => $value) {
      if(count($array) == $n)
        $update .= $key.' = \''.addslashes($value).'\'';
      else
        $update .= $key.' = \''.addslashes($value).'\', ';

      $n++;
    }

    $this->query = $this->operator.' '.$this->table.' SET '.$update.' '.$this->where;
    
    $q = $this->connection->prepare($this->query);
    $result = $q->execute();

    $this->connection = null;
    return $result;
  }


  public function delete(){
    $this->query = 'DELETE FROM '.$this->table.' '.$this->where;

    $q = $this->connection->prepare($this->query);
    $result = $q->execute();

    $this->connection = null;
    return $result;
  }


  public function debug(){
    $this->query =  $this->operator.' '.
                    $this->select.' '.
                    $this->table.' '.
                    $this->join.' '.
                    $this->where.' '.
                    $this->group.' '. 
                    $this->order.' '.
                    $this->limit;

    echo $this->query;
    return $this;
  }

}









