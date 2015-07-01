<?php

class Response {
  
  /**
   * Return data in json format
   * 
   * @param  mixed $data
   * 
   * @return null 
   */
  
  public static function json($data){
    header('Content-Type: application/json');
    echo json_encode($data, JSON_NUMERIC_CHECK); // JSON_NUMERIC_CHECK JSON_PRETTY_PRINT
  }

}