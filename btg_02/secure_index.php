<?php




$auth = false;

if(
isset($_SERVER['SSL_CLIENT_VERIFY']) &&
isset($_SERVER['SSL_CLIENT_S_DN_Email'])
){

//Good...
	if($_SERVER['SSL_CLIENT_VERIFY'] == 'SUCCESS'){
	//Better
		$auth = true;
		setcookie('auth',12345,time()+360);//expires infive minutes 
 		header('refresh: 2; url=app.php');		
		echo "<h1> You have been authenticated using a client certificate </h1>";

	}
}

if(!$auth ){

	echo "<h1>You do not have a certificate installed at your location, authenticating via telephone";


	$code = rand(1111,9999);//random 4 digit pin.

	echo "<h3>Momentarily you will be getting a call at your cell phone to verify your identity</h3>
		<h3>At that time you must enter the four digit code:</h3>
		<h1>$code</h1>
		<h3> in order to be further authenticated...</h3>
		<h3> Please enter your phone number (no punctionation, just numbers) then press call </h3>
		

	<form action='call.php' method='GET'>
		<input type='hidden' name='code' value='$code'>
		<input type='text' name='phone' >
		<input type='submit' value='call' >
        </form> 


		";

/*
require_once('SOAP/Client.php');

$wsdl_url = 
        "http://www.teleauth.com/phone/service.wsdl";
$WSDL     = new SOAP_WSDL($wsdl_url); 
$client   = $WSDL->getProxy(); 
$client->setOpt('timeout',360);
$params   = array(
	'DIlPuvzfdFNluB6FmEDDWhduheY3ks2c',
	'8328918311',
	'pin'
);

$tele_results    = $client->getSecret(
	'DIlPuvzfdFNluB6FmEDDWhduheY3ks2c',
	'8328918311',
	'pin'
);

var_export($tele_results);	

//$tele_code = $client->getSecret('DIlPuvzfdFNluB6FmEDDWhduheY3ks2c','8328918311',"pin");


*/



}

/* RUBY teleauth code...


#!/usr/bin/env ruby

require 'soap/wsdlDriver'
require 'cgi'

WSDL_URL = "http://teleauth.com/phone/service.wsdl"
soap_client = SOAP::WSDLDriverFactory.new(WSDL_URL).create_rpc_driver

# Log SOAP request and response
soap_client.wiredump_file_base = "soap-log.txt"

# Place the phone call
response = soap_client.getSecret( "SKJDekqQ4wUBiJEGFpkgA8Ph0bkkAXb", "15556673323", "pin")

# Display reponse
puts response.result, " / ", response.secret, " / ", response.message

*/


/*
$keys = array_keys($_SERVER);
echo "<br><br>ssl keys<br><br>";
foreach($keys as $key){

	if(stristr($key,'ssl') === FALSE){
		//do nothing, this item has nothing to do with ssl
	}else{
		echo "Server value $key is equal to " . $_SERVER[$key] . "<br>";	
	}
}
echo "<br><br>all keys<br><br>";

foreach($keys as $key){
		echo "Server value $key is equal to " . $_SERVER[$key] . "<br>";	
}
*/
?>
