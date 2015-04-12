# Simple MVC

Simple MVC is a simplistic php framework, its very compact, customizable and easy to use.

## Setup

Download or copy this repository to you domain or project folder, no need for pointing into the `public` folder. But you can always do it if posible. 

#### Set the default controller
This is the equivalent of the "index page"/"homepage".
You can change the default controller `app/config/app.php`, default mehod should always be set to `index`.

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

Render views with this function.
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
















