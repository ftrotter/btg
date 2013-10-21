<?php

echo '<html><head>
<script language="JavaScript">
function Set_Cookie( name, value, expires, path, domain, secure ) 
{
// set time, its in milliseconds
var today = new Date();
today.setTime( today.getTime() );

/*
if the expires variable is set, make the correct 
expires time, the current script below will set 
it for x number of days, to make it for hours, 
delete * 24, for minutes, delete * 60 * 24
*/
if ( expires )
{
expires = expires * 1000 * 60 * 60 * 24;
}
var expires_date = new Date( today.getTime() + (expires) );

document.cookie = name + "=" +escape( value ) +
( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
( ( path ) ? ";path=" + path : "" ) + 
( ( domain ) ? ";domain=" + domain : "" ) +
( ( secure ) ? ";secure" : "" );
}
</script>
</head>
<body>
';


if(isset($_COOKIE['CACertInstalled'])){

	echo "<h1>Congratulations it looks like you have installed the CA Cert Root Certificate</h1>
		<h3> Lets make sure that it worked. </h3>
		<h3> If you visit the following page, you will get an error message </h3>
		<h3> unless you have properly configured your root certificate </h3>
		<a href='https://qhr.healthquilt.org/test/'> CA Cert test page </a>

		";

}else{

CA_Instructions();


}

echo "</body></html>";


function CA_Instructions(){

	if(stristr($_SERVER['HTTP_USER_AGENT'],'firefox') !== FALSE){
		//then the user agent is firefox.
	echo "<h1> Welcome to HealthQuilt!</h1>
		<h3>It appears that you have not installed the CACert root certificate in your browser.</h3>
		<h3>It appears that you are using Firefox.</h3>
		<h3>Follow these instructions to install the certificate on Firefox.</h3>
		<h3>Shortly, we will provide you with a link to the CACert root certificate.</h3>
		<h3>When you click it, a window with three checkboxes will appear, like this:</h3>
		<img src='ff3_CAInstall_1.jpg'>
		<h3>Check all three Checkboxes. Then click Ok, like this:</h3>
		<img src='ff3_CAInstall_2.jpg'>
		<h3>Ready? Here is the Certificate Link, click to begin.</h3>
		<a href='http://www.cacert.org/certs/root.crt'
			onclick=\"Set_Cookie('CACertInstalled',1,1,'/','','')\"
		>CACert Root Certificate</a>
		<h3>After you have installed the certificate. Reload this page, by clicking the link below.</h3>
		<a href='http://qhr.healthquilt.org'>QHR HealthQuilt</a>
	";
	}
	
	if(stristr($_SERVER['HTTP_USER_AGENT'],'msie 7.0') !== FALSE){
		//then the user agent is firefox.
	echo "<h1> Welcome to HealthQuilt!</h1>
		<h3>It appears that you have not installed the CACert root certificate in your browser.</h3>
		<h3>It appears that you are using Internet Explorer Version 7 (ie7).</h3>
		<h3>Certificate support with ie7 is much more difficult than with Firefox. </h3>
		<h3>Consider downloading firefox at the link below, and returning to this page.</h3>
		<a href='http://www.mozilla.com/en-US/firefox/'>Download Firefox</a>
		<h3>Follow these instructions to install the certificate on ie7.</h3>
		<h3>Shortly, we will provide you with a link to the CACert root certificate.</h3>
		<h3>When you click it, there will be a long series of popup window.</h3>
		<h3>You must closely follow the instructions below in order to install the certificate properly:</h3>
		<img src='ie7_CAInstall_1.jpg'>
		<br>
		<img src='ie7_CAInstall_3.jpg'>
		<br>
		<img src='ie7_CAInstall_4.jpg'>
		<br>
		<img src='ie7_CAInstall_5.jpg'>
		<br>
		<img src='ie7_CAInstall_6.jpg'>
		<br>
		<img src='ie7_CAInstall_7.jpg'>
		<br>
		<img src='ie7_CAInstall_8.jpg'>
		<br>
		<img src='ie7_CAInstall_9.jpg'>
		<br>
		<img src='ie7_CAInstall_10.jpg'>
		<br>
		<img src='ie7_CAInstall_11.jpg'>
		<br>
		<h3>Ready? Here is the Certificate Link, click to begin.</h3>
		<a href='http://www.cacert.org/certs/root.crt'
			onclick=\"Set_Cookie('CACertInstalled',1,1,'/','','')\"
		>CACert Root Certificate</a>

		<h3>After you have installed the certificate. Reload this page, by clicking the link below.</h3>
		<a href='http://qhr.healthquilt.org'>QHR HealthQuilt</a>
		";
	}



}
?>
