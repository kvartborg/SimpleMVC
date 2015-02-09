# Simple MVC

Simple MVC is a simplistic file structure for php projects, very compact and easy to use.

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