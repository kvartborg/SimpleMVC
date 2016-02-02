<?php

class Model {


  protected $table;
  protected $index = 'id';
  protected $new = true;


  public function __construct(){
    // if(is_null($this->table) || $this->table == ''){
    //   Error::set('Model failed because no table is defined', __FILE__, __LINE__, __DIR__);
    // }
  }


  public static function register($data = [], $table = '', $index = 'id'){
    $result = [];
    foreach($data as $item) {
      $instance = new static;
      $instance->new = false;

      if(!isset($instance->table)){
        $instance->table = $table;
        $instance->index = $index;
      }

      foreach(get_object_vars($item) as $key => $value) {
        $instance->$key = $value;
      }

      $result[] = $instance;
    }

    return $result;
  }


  public static function find($id){
    $instance = new static;
    $instance->new = false;

    $data = DB::table($instance->table)->where($instance->index, '=', $id)->first();

    foreach($data as $key => $value) {
      $instance->$key = $value;
    }

    return $instance;
  }


  public static function select($array){
    $instance = new static;
    return DB::table($instance->table)->select($array);
  }


  public static function where($key, $operator = '=', $value = null){
    $instance = new static;

    if($value == null){
      $value = $operator;
      $operator = '=';
    }

    return DB::table($instance->table)->where($key, $operator, $value);
  }


  public static function join($table, $col1, $operator, $col2){
    $instance = new static;
    return DB::table($instance->table)->join($table, $col1, $operator, $col2);
  }


  public static function leftJoin($table, $col1, $operator, $col2){
    $instance = new static;
    return DB::table($instance->table)->leftJoin($table, $col1, $operator, $col2);
  }


  public static function rightJoin($table, $col1, $operator, $col2){
    $instance = new static;
    return DB::table($instance->table)->rightJoin($table, $col1, $operator, $col2);
  }


  public static function groupBy($str){
    $instance = new static;
    return DB::table($instance->table)->groupBy($str);
  } 


  public static function orderBy($str, $type = 'ASC'){
    $instance = new static;
    return DB::table($instance->table)->orderBy($str, $type);
  }


  public static function get(){
    $instance = new static;
    return DB::table($instance->table)->getAsModels($instance->index);
  }


  public static function all(){
    $instance = new static;
    return DB::table($instance->table)->getAsModels($instance->index);
  }


  public static function count(){
    $instance = new static;
    return DB::table($instance->table)->count();
  }


  public static function first(){
    $instance = new static;

    return DB::table($instance->table)->first();
  }


  public function save(){
    foreach ($this as $key => $value) {
      if($key != 'index' && $key != 'table' && $key != 'new' && $key != $this->index)
        $data[$key] = $value;
    }

    if($this->new){
      $result = DB::table($this->table)->insertGetId($data);
      $index = $this->index;
      $this->$index = $result; 
    } else {
      $result = DB::table($this->table)->where($this->index, '=', $this->id)->update($data);
    }

  }


  public function delete(){
    return DB::table($this->table)->where($this->index, $this->id)->delete();
  }

}