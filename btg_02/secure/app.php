<?php

$auth = $_COOKIE['auth']; 

$authenticated = false;

if($auth == 12345){//replace me

	$authenticated = true;
}

echo "<h1> This is where the application lives</h1>";
if($authenticated){ // will be replaced with random authentication system.

	echo "<h1> AND you have access!!</h1>";

}else{
	echo "<h1> BUT you do not have access!!! </h1>";
}





?>
