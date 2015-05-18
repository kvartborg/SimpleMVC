<?php

class Response {
  
  public static function json($array){
    header('Content-Type: application/json');
    echo json_encode($array, JSON_PRETTY_PRINT);
  }

}