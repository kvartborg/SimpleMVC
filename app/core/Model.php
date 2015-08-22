<?php

abstract class Model {


  protected $table;
  protected $index = 'id';
  protected $new = true;


  public function __construct(){
    if(is_null($this->table) || $this->table == ''){
      Error::set('Model failed because no table is defined', __FILE__, __LINE__, __DIR__);
    }
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


  public static function where($key, $operator = '=', $value = null){
    $instance = new static;

    if($value == null){
      $value = $operator;
      $operator = '=';
    }

    return DB::table($instance->table)->where($key, $operator, $value);
  }


  public static function all(){
    $instance = new static;

    return DB::table($instance->table)->get();
  }


  public function save(){
    foreach ($this as $key => $value) {
      if($key != 'index' && $key != 'table' && $key != 'new' && $key != $this->index)
        $data[$key] = $value;
    }

    if($this->new){
      $result = DB::table($this->table)->insertGetId($data, $this->index);
      $index = $this->index;
      $this->$index = $result; 
    } else {
      $result = DB::table($this->table)->where($this->index, '=', $this->id)->update($data);
    }
  }


  public static function delete($id){
    $instance = new static;
    return DB::table($instance->table)->where($instance->index, $id)->delete();
  }

}