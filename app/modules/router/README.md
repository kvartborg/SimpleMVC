# Routes

#### Define routes
```php
Route::get('/path', function(){
  
});

Route::all('/path', 'Controller@method');
Route::post('/path', 'Controller@method');
Route::put('/path', 'Controller@method');
Route::delete('/path', 'Controller@method');
```

#### Route groups
A powerful way to structure your application routes is to group them together and give them a prefix
```php
Route::group('/prefix', function(){
  Route::get('/path', 'Controller@method');
});
```

#### Route options
```php
Route::get('/create/user', 'UserController@create')->name('create.user');
```

#### Route with variable
```php
Route::get('/path/with/:variable', function($variable){
  echo $variable;
});
```

#### Route with optional variable
```php
Route::get('/path/with/:variable?', function($variable = 'default'){
  echo $variable;
});
```

#### Route middlewares
```php
Route::get('/path', middleware(), function(){
  // route exists if middleware return true
});

Route::group('/prefix', middleware(), function(){
  // group exists if middleware return true
});
```

#### Route missing
```php
Route::missing(function(){
  // is called if no route is found... 
  // response with HTTP code 404
});
```

#### Catch all routes
```php
Route::catchAll(function(){
  // is called if no route is found... 
  // response with HTTP code 200
  // should be used if your application accepts all routes
});
```








