<?php

$auth = $_COOKIE['auth']; 

$authenticated = false;

if($auth == 12345){//replace me

	$authenticated = true;
}

if($authenticated){ // will be replaced with random authentication system.

echo "<h1> Do you trust this computer?</h1>";
echo "<h3> You now have the option of downloading a client certificate.</h3>";
echo "<h3> if you download a client certificate, then you will not need to be called for the next login</h3>";
echo "<h3> However you should not install a client certificate on a public computer (library, or kinkos)</h3>";
echo "<h3> If this is a computer that you own, and will use to access HealthQuilt frequently then you should install a certificate.
</h3>";


echo "<h3> Click <a href='client.pem'>here</a> to install a client certificate. </h3>";
echo "<h3> Click <a href='app.php'>here</a> to use the application directly. </h3>";


}else{
	echo "<h1> You must be authenticated to use this system </h1>";
}





?>
