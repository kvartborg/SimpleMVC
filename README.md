# Simple MVC

Simple MVC is a simplistic file structure for php projects, very compact and easy to use.

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

##### Table()

```php
// get all records from table
DB::table('users')->get();
```

##### Select()

```php
// get selected fields of all records from table
DB::table('users')->select(['firstname', 'email'])->get();
```