<?php


	if(isset($_GET['token'])){
		$token = $_GET['token'];
		echo "you tried to authenticate with $token";
	
	}else{
		echo "no token value";

	}



?>
