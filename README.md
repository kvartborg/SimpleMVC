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
