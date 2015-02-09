<h1>Hello world!</h1>

<?php
  $test = DB::query('SELECT * FROM users');
    var_dump($test);
?>