<?php

Route::set('/', function(){
  return View::make('index', ['test' => 'hello']);
});


Route::set('/hello/jæs', function(){
  return View::make('index');
});


Route::set('/t/:var?', function($var = 0){
  echo 'Test route!! '.$var;
});


Route::set('/h', 'HelloController');
Route::set('shop', 'TestController');


Route::set('/login', function(){
  echo "login";
});