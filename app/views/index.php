<h1>Hello world!</h1>

<?php
  $results = DB::table('users')->get();

  foreach ($results as $result) {
    echo $result->firstname.' - '.$result->email."<br>";
  }
?>