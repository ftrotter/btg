<?php


require_once('SOAP/Client.php');

if(isset($_GET['code'])){
	$code = $_GET['code'];
	$phone = $_GET['phone'];
}else{
	echo "Error no code:";
	exit();
}

$wsdl_url = 
        "http://www.teleauth.com/phone/service.wsdl";
$WSDL     = new SOAP_WSDL($wsdl_url); 
$client   = $WSDL->getProxy(); 
$client->setOpt('timeout',360);

$tele_results    = $client->getSecret(
        'DIlPuvzfdFNluB6FmEDDWhduheY3ks2c',
        $phone,
        'pin'
);

//var_export($tele_results);      

$tele_code = $tele_results->secret;

//echo "You were told to enter $code and you entered $tele_code";

if($tele_code == $code){

	setcookie('auth', 12345, time()+360);
	header('refresh: 2; url=cert_download.php');
	echo "<h1>You have been successfully authenticated</h1>";
}








?>
