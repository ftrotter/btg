<?php

	// First we login!!!


        require_once('/var/simplesamlphp_sp/www/_include.php');
        require_once('SimpleSAML/Utilities.php');
        require_once('SimpleSAML/Session.php');
        require_once('SimpleSAML/XHTML/Template.php');


        /* Load simpleSAMLphp, configuration and metadata */
        $config = SimpleSAML_Configuration::getInstance();
        $session = SimpleSAML_Session::getInstance();

        /* Check if valid local session exists.. */
        if (!isset($session) || !$session->isValid('saml2') ) {
          SimpleSAML_Utilities::redirect(
            '/' . $config->getBaseURL() .
            'saml2/sp/initSSO.php',
            array('RelayState' => SimpleSAML_Utilities::selfURL())
            );
        }



define('HEALTH_PRIVATE_KEY', '/etc/pki/tls/private/fred.synseer.net.key');

require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata_Health');
Zend_Loader::loadClass('Zend_Gdata_Health_Query');


// Google H9 Sandbox AuthSub/OAuth scope
define('SCOPE', 'https://www.google.com/h9/feeds/');


	require_once 'reg_mysql.php';
	require_once 'head.php';

	$head = new HTMLHeader();





	if(!isset($_GET['key'])){

		if(!isset($_SESSION['key'])){
	
			echo "need a key!!";
			exit();
		}else{
			$key = $_SESSION['key'];
		}
	}else{
		$key = $_GET['key'];
	}


	$sql = "SELECT count(*) as count FROM `user` WHERE `key` = '$key'";
	$result = mysql_query($sql) or die("error looking up key" . mysql_error());
	$row = mysql_fetch_array($result);
	$count = $row['count'];
	if($count == 0){
		echo "Hey sneaky person... thats not a real key!!";
		exit();
	}

	$sql = "SELECT * FROM `user` WHERE `key` = '$key'";
        $result = mysql_query($sql) or die("error looking up key" . mysql_error());
        $row = mysql_fetch_array($result);
	$sessionToken = $row['google_auth'];
	$person_id = $row['id'];
	$_SESSION['sessionToken'] = $sessionToken;

try {
  // Setup the HTTP client and fetch an AuthSub token for H9
  $client = authenticate(@$_GET['token']);
  $useH9 = true;
  $healthService = new Zend_Gdata_Health($client, 'google-HealthPHPSample-v1.0', $useH9);
} catch(Zend_Gdata_App_Exception $e) {
  echo 'Error: ' . $e->getMessage();
}

	$head->addJS('<script src="js/prototype.js" type="text/javascript"></script>
			<script src="js/scriptaculous.js" type="text/javascript"></script>');
	$head->addCSS('<link href="css/plone.css" rel="stylesheet" type="text/css">');
	$head->addCSS("
<style type='text/css'>
  div#droppable_container {
    height: 140px;
    width: 400px; }
  .draggable {
    width: 100px;
    height: 20px;
    cursor: move;
    background: #9fcfba;
    border: 1px solid #666;
    text-align: center;
    position: relative;
}
  .dropable {
    width: 160px;
    height: 120px;
    background: #fff;
    border: 5px solid #ccc;
    text-align: center;
    line-height: 100px; }
  .dropable.hover {
    border: 5px dashed #aaa;
    background:#efefef; }
</style>");


	echo $head->getHeader();




    $query = new Zend_Gdata_Health_Query();
    $query->setDigest("true");
    $profileFeed = $healthService->getHealthProfileFeed($query);




$entry = $profileFeed->entry[0];

$medications = $entry->getCcr()->getMedications();
$procedures = $entry->getCcr()->getProcedures();

// An example of using the medications data
/*
foreach ($medications as $med) {
  $xmlStr = $med->ownerDocument->saveXML($med);
  echo '<pre>' . $xmlStr . '</pre>';
}
*/


// Or, you can use XPath to extract just the names of each medication
$meds = $entry->getCcr()->getMedications()->item(0);
$xpath = new DOMXpath($meds->ownerDocument);
$elements = $xpath->query("//ccr:Medications/ccr:Medication/ccr:Product/ccr:ProductName/ccr:Text");
foreach ($elements as $element) {
  $meds_array[] = $element->nodeValue;
}



$person_sql = "SELECT  *
FROM `person`
LEFT JOIN person_address ON person.person_id = person_address.person_id
LEFT JOIN address ON person_address.address_id = address.address_id
LEFT JOIN person_number ON person.person_id = person_number.person_id
LEFT JOIN number ON person_number.number_id = number.number_id
WHERE person.person_id = $person_id";

	$result = mysql_query($person_sql);
	while($row = mysql_fetch_array($result)){
		$person_first_name = $row['first_name'];
		$person_last_name = $row['last_name'];
		$date_of_birth = $row['date_of_birth'];

		$address_array[$row['line1']] = array(
			'city' => $row['city'],
			'zip' => $row['postal_code'],
		);

		$phone_array[$row['number']] = $row['number'];

	}
	echo "<h1 style='font-size: 40pt'>$person_last_name, $person_first_name </h1>";
	echo "<fieldset id='person' style='width: 45%; float: left'><legend>Personal Information</legend>";
		echo "First Name: $person_first_name <br>";
		echo "Last Name: $person_last_name <br>";
		echo "DOB: $date_of_birth <br>";
		foreach($address_array as $line1 => $address_info){
			echo "Address: $line1 <br>";
			echo "&nbsp;";
			echo "&nbsp;";
			echo "&nbsp;";
			echo "&nbsp;";
			echo $address_info['city'] . " " . $address_info['zip'] . "<br>";	
		}

		foreach($phone_array as $phone){
			echo "Phone: $phone<br>";

		}

	echo "</fieldset>";

$em_person_id = $person_id + 1;

$phone_array = array();

$person_sql = "SELECT  *
FROM `person`
LEFT JOIN person_address ON person.person_id = person_address.person_id
LEFT JOIN address ON person_address.address_id = address.address_id
LEFT JOIN person_number ON person.person_id = person_number.person_id
LEFT JOIN number ON person_number.number_id = number.number_id
WHERE person.person_id = $em_person_id";

        $result = mysql_query($person_sql);
        while($row = mysql_fetch_array($result)){
                $person_first_name = $row['first_name'];
                $person_last_name = $row['last_name'];
                $date_of_birth = $row['date_of_birth'];

                $address_array[$row['line1']] = array(
                        'city' => $row['city'],
                        'zip' => $row['postal_code'],
                );      
        
                $phone_array[$row['number']] = $row['number'];

        }

        echo "<fieldset id='em_person' style='width: 45%; float: left'><legend>Emergency Contact</legend>";
                echo "First Name: $person_first_name <br>";
                echo "Last Name: $person_last_name <br>";
                echo "DOB: $date_of_birth <br>";
                foreach($address_array as $line1 => $address_info){
                        echo "Address: $line1 <br>";
                        echo "&nbsp;";
                        echo "&nbsp;";
                        echo "&nbsp;";
                        echo "&nbsp;";
                        echo $address_info['city'] . " " . $address_info['zip'] . "<br>";
                }

                foreach($phone_array as $phone){
                        echo "Phone: $phone<br>";

                }

        echo "</fieldset>";




        echo "<fieldset id='meds' style='width: 35%;  float: left'><legend>Medications</legend> ";

	$count = 0;
        foreach($meds_array as $med){
		$count++;
                echo "<div id='med_$count' class='draggable'>$med</div><br> ";
                echo "<script type='text/javascript'>
  new Draggable('med_$count', { 
    scroll: window  
  });
</script>";

        }
        echo "</fieldset>";

        $results = array();
        $count = 0;




    $query = new Zend_Gdata_Health_Query(SCOPE . "profile/default");
    $query->setCategory("allergy");
    $query->setGrouped("true");
    $profileFeed = $healthService->getHealthProfileFeed($query);



    foreach ($profileFeed->getEntries() as $entry) {


	$allergies = $entry->getCcr()->getAllergies()->item(0);
	$xpath = new DOMXpath($allergies->ownerDocument);
	$elements = $xpath->query("//ccr:Alerts/ccr:Alert/*");
	foreach($elements as $element){
	//	echo $element->nodeName . " " . $element->textContent . "<br>";

		if(strcmp($element->nodeName,'Type')== 0){
			$count++;
		}

		$results[$count][$element->nodeName] = $element->textContent;
 
	}

    }
	
	foreach($results as $result_array){
		$allergy_array[$result_array['Description']] = $result_array;
	}


	echo "<fieldset id='allergies' style='width: 35%; float: left'  ><legend>Allergies</legend> <ul>";

	foreach($allergy_array as $allergy => $al_info_array){
		echo "<li> $allergy:  ".$al_info_array['Reaction'] . "</li>"; 

	}
	echo "</ul></fieldset>";

	$results = array();
	$count = 0;

    $query = new Zend_Gdata_Health_Query(SCOPE . "profile/default");
    $query->setCategory("condition");
    $query->setGrouped("true");
    $profileFeed = $healthService->getHealthProfileFeed($query);
    foreach ($profileFeed->getEntries() as $entry) {


        $problems = $entry->getCcr()->getProblems()->item(0);
        $xpath = new DOMXpath($problems->ownerDocument);
        $elements = $xpath->query("//ccr:Problems/ccr:Problem/ccr:Description/*");
        foreach($elements as $element){
        //      echo $element->nodeName . " " . $element->textContent . "<br>";

                if(strcmp($element->nodeName,'Text')== 0){
                        $count++;
                }

                $results[$count][$element->nodeName] = $element->textContent;

        }

    }

        foreach($results as $result_array){
                $problem_array[$result_array['Text']] = $result_array;
        }

        echo "<h3 style='clear: left'>Plans</h3> <table class='grid' id='problems' style='clear: left'>";
        echo "<tr>";
	echo "<th>Problems</th>";
	echo "<th>Notes</th>";
	echo "<th>Medications</th>";
        echo "</tr>";

	$count = 0;
        foreach($problem_array as $problem => $pr_info_array){
		$count++;
		if($count % 2 == 0){
			$class = 'class="alt"';
		} else{
			$class = '';
		}
               echo "<tr $class> <td> $problem:  </td> ";
		echo "<td><textarea rows='10' columns='40'></textarea> <br> <input type='submit' value='Save'></td>";
		echo "<td><div id='da_$count'> </div> <div id='drop_$count' class='dropable'> Add Medication Here </div>
		</td>";

		echo "</tr>"; 
        }
        echo "</table>";


	$attributes = $session->getAttributes();
	/*
	echo "<br> Atrributes <br>";

	foreach($attributes as $key => $value){
			echo "top key = $key<br>";
			foreach($value as $another_key => $a_deeper_value){
				echo "under key $another_key<br>";
				echo "value $a_deeper_value<br>";
			
			}
		
	}
*/

	echo $head->getFooter();









function getCurrentUrl() {
  $phpRequestUri =
    htmlentities(substr($_SERVER['REQUEST_URI'], 0, strcspn($_SERVER['REQUEST_URI'], "\n\r")), ENT_QUOTES);

  if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
    $protocol = 'https://';
  } else {
    $protocol = 'http://';
  }
  $host = $_SERVER['HTTP_HOST'];
  if ($_SERVER['SERVER_PORT'] != '' &&
     (($protocol == 'http://' && $_SERVER['SERVER_PORT'] != '80') ||
     ($protocol == 'https://' && $_SERVER['SERVER_PORT'] != '443'))) {
    $port = ':' . $_SERVER['SERVER_PORT'];
  } else {
    $port = '';
  }
  return $protocol . $host . $port . $phpRequestUri;
}

function authenticate($singleUseToken=null) {
  $sessionToken = isset($_SESSION['sessionToken']) ? $_SESSION['sessionToken'] : null;

  // If there is no AuthSub session or one-time token waiting for us,
  // redirect the user to Google Health's AuthSub handler to get one.
  if (!$sessionToken && !$singleUseToken) {
    $next = getCurrentUrl();
    $secure = 1;
    $session = 1;
    $authSubHandler = 'https://www.google.com/h9/authsub';
    $permission = 1;  // 1 - allows reading of the profile && posting notices
    $authSubURL =
      Zend_Gdata_AuthSub::getAuthSubTokenUri($next, SCOPE, $secure, $session,
                                             $authSubHandler);
    $authSubURL .= '&permission=' . $permission;
    echo '<a href="' . $authSubURL . '">Link your Google Health Account</a>';
    exit();
  }

  $client = new Zend_Gdata_HttpClient();
  $client->setAuthSubPrivateKeyFile(HEALTH_PRIVATE_KEY, null, true);

  // Convert an AuthSub one-time token into a session token if needed
  if ($singleUseToken && !$sessionToken) {
    $sessionToken =
      Zend_Gdata_AuthSub::getAuthSubSessionToken($singleUseToken, $client);
    $_SESSION['sessionToken'] = $sessionToken;
  }
  $client->setAuthSubToken($sessionToken);
  return $client;
}

function getTokenInfo($client) {
  $sessionToken = $client->getAuthSubToken();
  return Zend_Gdata_AuthSub::getAuthSubTokenInfo($sessionToken, $client);
}

function revokeToken($client) {
  $sessionToken = $client->getAuthSubToken();
  return Zend_Gdata_AuthSub::AuthSubRevokeToken($sessionToken, $client);
}

/** Prettifies an XML string into a human-readable and indented work of art
 *  @param string $xml The XML as a string
 *  @param boolean $html_output True if the output should be escaped (for use in HTML)
 */
function xmlpp($xml, $html_output=true) {
  $xml_obj = new SimpleXMLElement($xml);
  $level = 4;
  $indent = 0; // current indentation level
  $pretty = array();

  // get an array containing each XML element
  $xml = explode("\n", preg_replace('/>\s*</', ">\n<", $xml_obj->asXML()));

  // shift off opening XML tag if present
  if (count($xml) && preg_match('/^<\?\s*xml/', $xml[0])) {
    $pretty[] = array_shift($xml);
  }

  foreach ($xml as $el) {
    if (preg_match('/^<([\w])+[^>\/]*>$/U', $el)) {
      // opening tag, increase indent
      $pretty[] = str_repeat(' ', $indent) . $el;
      $indent += $level;
    } else {
      if (preg_match('/^<\/.+>$/', $el)) {
        $indent -= $level;  // closing tag, decrease indent
      }
      if ($indent < 0) {
        $indent += $level;
      }
      $pretty[] = str_repeat(' ', $indent) . $el;
    }
  }
  $xml = implode("\n", $pretty);
  return ($html_output) ? htmlentities($xml) : $xml;
}
?>
