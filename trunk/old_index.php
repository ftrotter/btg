<?php

	require_once('head.php');//where the head and tail functions are defined



    session_start();
	if(isset($_SESSION['key'])){
		$key = $_SESSION['key'];
	}
	if(isset($_GET['key'])){
		$key = $_GET['key'];
		$_SESSION['key'] = $key;
	}


	//a change


	if(!isset($key)){	//if there is no key then they are not trying to actually access a particular record
				//send them to the main page and offer a demo!!
		head();
		main_page();
		tail();
		exit();
	}else{
		$GLOBALS['key'] = $key;
	}	


    if( isset($_GET['action'])){
		authorized_view();
		exit();
	}


    if( isset($_SESSION['auth'])){
		if(isset($_GET['auth'])){
			head();
			tab('authenticate');
			authenticate();
			tail();
			exit();
		}
	
		if(isset($_GET['break'])){
			break_the_glass();
			exit();
		}
		
	
		
	}

head();	

    if(count($_POST)>0){

        if((isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] ==  $_POST['keystring']) ){
	 	 $_SESSION['auth'] = '1234512345';	     			
  		 break_the_glass_question();
					
        }else{
            human_test_fail();
        }
    }else{

	warning();
    }

	


	tail();


function main_page(){

echo "<h2> Hi, this is a website for distributing Personal Health Information in a secure way. </h2>
Currently this a research project. click <a href='123456789abc'> here </a> to view the demo.

";


}

function authorized_view (){

if($GLOBALS['key'] == '123456789abc'){
/*	echo "
<h2>Patient Name: Kim Dunn</h2>
<img src='kdunn.jpg'>
<ul>
<li>Allergies: <font color='red'>Penicillin</font>, Cheese, Strawberries</li>
<li>Medications: Lipitor</li>
<li>Conditions: Unbridled Enthusiasm</li>
<li>Emergency Contact: Ignacio Valdes (713)111-2222</li>
<li>Home Phone: (713)111-3333</li>
<li>Work Phone: (713)111-3333</li>
<li>Address: 101 Dunn way, Houston, TX 77000</li>
</ul>


";
*/

include_once('pub.html');

}else{
head();
echo "<h3> You have incorrectly entered the URL. I am sorry but for security reasons you must start completely over </h3>";
tail();
}


}
function break_the_glass(){

if($GLOBALS['key'] == '123456789abc'){

/*	echo "
<h2>Patient First Name: Kim </h2>
<img src='kdunn.jpg'>
<ul>
<li>Allergies: <font color='red'>Penicillin</font>, Cheese, Strawberries</li>
<li>Medications: Lipitor</li>
<li>Conditions: Unbridled Enthusiasm</li>
</ul>

";


*/

include_once('priv.html');

}else{
head();
echo "<h3> You have incorrectly entered the URL. I am sorry but for security reasons you must start completely over </h3>";
tail();
}


}


function authenticate(){


echo "<h1>Phone and Fax Authentication Go Here </h1>";
echo "For now you can just skip to the <a href='index.php?action=authview'>Authenticated View</a>";


}

function break_the_glass_question(){

if(!isset($_POST['npi'])){

	echo "you must enter an npi <a href='index.php'>Try Again</a>";

}

$npi = $_POST['npi'];

echo "

<h1> You must choose. </h2>
<table width='100%'>
<tr>
<td width='50%' class='left'>
<h1>Authenticate yourself</h1>
<p> You are claiming to be the clinician with an NPI of $npi. We can send you a fax with a special code, that can prove to use that you are this provider. We can also give you an automated telephone call to your main number, to verify that you have access to the phone for provider number $npi. If you do this, then we will provide you with a username and password, as well as a client certificate, to access this site in the future. This is the preferred method to access this data. There is some information that you can only get by authenticating in this manner, things like the patients last name, the patients emergency contact information, other phone numbers and addresses. These are no help in an emergency and so there is no reason to distribute this information without full authentication. <p>
</td>
<td width='50%' class='right'>

<h1>Break the glass</h1>
<p> Because you are reading this, you already have a link to a patients secret website. You probably got this information from a wristband or card. Because you know this secret you can 'break the glass' and access basic health information about this patient. You will be able to see critical information like medications, allergies and conditions. You will still need to authenticate using a fax or phone call, but you can do this later. You will not get any information that you could use to 'steal the identity' of this patient. You will not even get their last name. However, this is potentially very personal information. If you are not absolutly certain that the patient would want you to see this information, then please do not choose this option. <p>
<p>It is possible that you found the link to this website in a naughty way. Let us be clear, if you are not a clinician treating this patient, then accessing this website is a crime. We will inform the patient about this access attempt, and we are recording this access. If we find that you are trying to access something you should not, we will do everything we can to put you in jail. We will contact the owner of the $npi npi and attempt to authenticate that person within the week. If we cannot authenticate that the person with the npi $npi actually had the right to access this patient, we will turn the matter over to the FBI</p>
</td>
</tr>
<tr>
<td width='50%' class='left'>
<h1><a href='index.php?auth=$npi'>Authenticate yourself</a></h1>
</td>
<td width='50%' class='right'>
<h1><a href='index.php?break=$npi'>Break the glass</a></h1>
</td>

</tr>
</table>


";






}



function human_test_fail(){


echo "
<h1>You have failed the human test</h1>
<p>The image can be hard to read, click <a href='index.php'>here</a> to try again. If you continue to fail, this site will begin to enforce timeouts, to prevent a 'brute force' attack. If you are attempting to crack this site, your attempt has been logged. </p>
";




}



function warning(){

	$IP = $_SERVER['REMOTE_ADDR'];

	$session_name = session_name();
	$session_id = session_id();
	$key = $GLOBALS['key'];

echo "
<h1 class='warning'> You are attempting to access Personal Health Information.</h1>
<p> If you do not have the right to do this, you must leave immediately. If you continue without the right to access this information, you are commiting a crime. Access to this website is logged. You are not anonymous. Here is a list of the information that we are recording about you. You would be accessing patient data at key $key</p>
<ul>
<li>Your IP Address: $IP</li>
</ul>

<p>This system is only available to Clinicians who are registered in the NPI database. You must prove you are human by typing below.</p>

    <form action='index.php' method='post'>
    <p><img src='captcha_image.php?$session_name=$session_id'></p>
    <p>Enter the Captcha: <input type='text' name='keystring'></p>
    <p>Enter your NPI <input type='text' name='npi'></p>
    <p><input type='submit' value='I am Human and I am in the NPI database'></p>
    </form>

";

}



?>
