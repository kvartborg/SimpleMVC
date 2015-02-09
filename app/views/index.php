<h1>Hello world!</h1>

<?php
  $results = DB::table('users')->where('id', '>', 0)->get();

  foreach ($results as $result) {
    echo $result->firstname.' - '.$result->email."<br>";
  }
?>