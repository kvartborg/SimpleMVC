<?php

Route::set('/', function(){
  echo "";
});


Route::set('/hello/jæs', function(){
  return View::make('index');
});


Route::set('/test/:var', function($var = 0){
  echo 'Test route!! '.$var;
});


Route::set('app/test', 'HelloController');
Route::set('shop', 'TestController');