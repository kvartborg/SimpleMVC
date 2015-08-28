# Specla

#### Connect to MySQL
Go to `app/config/database.php`.
```php
return array(
  'host'      => '',
  'database'  => '',
  'username'  => '',
  'password'  => '',
  'prefix'    => '',
);
```

## Views
```php
// render index.php
View::make('index.php');
```

Parse data with view.
```php
// render index.php with data array
View::make('index.php', ['key' => 'value']);
```

## Query Builder
##### structure
```php
// This i an example of how to structure a query
DB::table('users')
  ->select(['firstname', 'email'])
  ->where('id', '<', 10)
  ->orderBy('firstname', 'ASC')
  ->get();
```

##### table()
```php
// get all records from table
DB::table('users')->get();
```

##### select()

```php
// get selected fields of all records from table
DB::table('users')->select(['firstname', 'email'])->get();
```

##### where()

```php
// Sort data by 
DB::table('users')->where('key', $value)->get();
```

##### orderBy()

```php
// Order by
DB::table('users')->orderBy('firstname', 'ASC')->get();
```

##### first()

```php
// get the first record in result
DB::table('users')->first();
```

##### query()

```php
// write normal query
DB::query("SELECT * FROM users");
```

## Time/Date handler
##### now()
```php
// Get current time 
Time::now();
Date::now();
```

##### parse()
```php
// parse a timestamp or time
Time::parse('2015-05-12');
Date::parse(1429574400);
```

##### format()
```php
// Format timestamp
Time::now()->format('d-m-Y H:i');
```

##### date()
```php
// return date only
Time::now()->date();
```

##### time()
```php
// return time only
Time::now()->time();
```

##### addSeconds()
```php
// Add seconds to time
Time::now()->addSeconds(10);
```

##### addMinutes()
```php
// Add Minutes to time
Time::now()->addMinutes(10);
```

##### addHours()
```php
// Add Hours to time
Time::now()->addHours(10);
```

##### addDays()
```php
// Add Days to time
Time::now()->addDays(10);
```

##### int()
```php
// Return time in int format
Time::now()->int();
```

##### gm()
```php
// Return time in UTC
Time::now()->gm();
```

## Routing 
##### Simple route
```php
Route::get('profile', function(){
  return View::make('profile', ['user_id' => $user_id]);
});
```

##### Route to controller method
```php
Route::get('profile', 'ProfileController@view');
```

##### Dynamic route controller
```php
Route::get('profile', 'ProfileController');
```

##### Parse variable with route
```php
Route::get('profile/:user_id', function($user_id){
  return View::make('profile', ['user_id' => $user_id]);
});

// if variable is optional then add ?
Route::get('profile/:user_id?', 'ProfileController@view');
```

##### Different request methods
```php
Route::get('profile', 'ProfileController');
Route::post('profile', 'ProfileController');
```

## Models

## Session
##### Set session
```php
Session::set('key', 'value');
```

##### forget session
```php
Session::forget('key');
```

## Cookies
##### Set cookie
```php
Cookie::set('key', 'value');
```

##### forget cookie
```php
Cookie::forget('key');
```

## Events
##### Running event from php
```php
Event::run('TestEvent', ['key' => 'value']);
```

##### Queue events
```php
Event::run([
  'FirstEvent',
  'SecondEvent',
  'ThirdEvent',
], [
  'key' => 'value'
]);
```












