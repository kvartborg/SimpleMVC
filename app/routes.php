<?php

Route::set('/', 'HelloController');

Route::set('/hello/test', function(){
  return View::make('index');
});


Route::set('/t/:var?', function($var = 0){
  echo 'Test route!! '.$var;
});


// Route::set('/hello', 'HelloController');
Route::get('shop', 'TestController');

Route::set('add/user', function(){
  DB::table('users')->insert(array('firstname' => '<script> alert(\'test\'); </script>'));
  echo "user added!";
});

Route::set('query/test', function(){
  var_dump(DB::table('users')->where('id',)->get());
});

Route::set('/login', function(){
  echo "login";
});


Route::post('/users/edit/:user_id', function(){ 
  echo 'Updating user...<br>'; 
  echo $_SERVER['REQUEST_METHOD'].'<br>';
  var_dump($_POST);
});

Route::set('/users/edit', function(){
  echo "Hello, Frederik";
});

Route::set('form', function(){
  $html = '<form action="/hello" method="post">'
            .'<input name="test" type="text" />'
          .'</form>';

  echo $html;
});