<?php

Route::set('/hello', 'HelloController');

Route::get('/', function(){
  return View::make('index', ['users' => DB::table('users')->get()]);
});

Route::set('/test', 'TestController');