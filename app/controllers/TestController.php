<?php

class TestController extends BaseController {
  
  public function test($test, $var){
    echo "test: ".$test.' '.$var;
  } 
}