<h1>Hello world!</h1>

<?php
	$users = DB::table('users')->where('id', '>', 1)->get();

	foreach ($users as $key => $user) {
		echo $user->id.' - '.$user->name.'<br>';
	}
?>