<?php



function register_form(){


	echo " 
		<h2> Hi please register for Break the Glass</h2>	
		<form action='signup.php' method='POST'>
		<input type='hidden' name='register' value='1'>
		<fieldset>	
		<legend>
		Your Information
		</legend>
		Your Google Account (go <a href='http://gmail.com'>here</a> if you do not have one: <input type='text' name='me[email]'> <br>
		Your Salutation (like Mr, Mrs or Dr): <input type='text' name='me[salutation]'> <br>
		Your First Name: <input type='text' name='me[first_name]'> <br>
		Your Last Name: <input type='text' name='me[last_name]'> <br>
		Your Middle Name: <input type='text' name='me[middle_name]'> <br>
		Your Gender 1 (Male) 2 (Female) 3 Other: <input type='text' name='me[gender]'> <br>
		Your Date of Birth in the form YYYY-MM-DD: <input type='text' name='me[date_of_birth]'> <br>
		Your other email (if you have one) <input type='text' name='me[secondary_email]'> <br>
		Your Home Phone <input type='text' name='me_home_phone'> <br>
		Your Work Phone <input type='text' name='me_work_phone'> <br>
		Your Cell Phone <input type='text' name='me_cell_phone'> <br>
		Your Address First Line <input type='text' name='me_address[line1]'> <br>
		Your Address Second Line <input type='text' name='me_address[line2]'> <br>
		Your Address City <input type='text' name='me_address[city]'> <br>
		Your Address State (1 = TX) <input type='text' name='me_address[state]'> <br>
		Your Address Zip <input type='text' name='me_address[postal_code]'> <br>

		</fieldset>
		<br>

                <fieldset>      
                <legend>
                Your Emergency Contact
                </legend>
                Emergency Relationship 1=Spouse, 2=Parent, 3=Child, 4=Other: <input type='text' name='emergency_relationship'> <br>
                Emergency Contact Salutation (like Mr, Mrs or Dr): <input type='text' name='em[salutation]'> <br>
                Emergency Contact First Name: <input type='text' name='em[first_name]'> <br>
                Emergency Contact Last Name: <input type='text' name='em[last_name]'> <br>
                Emergency Contact Middle Name: <input type='text' name='em[middle_name]'> <br>
                Emergency Contact Gender 1 (Male) 2 (Female) 3 Other: <input type='text' name='em[gender]'> <br>
                Emergency Contact Date of Birth in the form YYYY-MM-DD: <input type='text' name='em[date_of_birth]'> <br>
                Emergency Contact email <input type='text' name='em[email]'> <br>
		Emergency Contact Home Phone <input type='text' name='em_home_phone'> <br>
		Emergency Contact Work Phone <input type='text' name='em_work_phone'> <br>
		Emergency Contact Cell Phone <input type='text' name='em_cell_phone'> <br>
		Emergency Contact Address First Line <input type='text' name='em_address[line1]'> <br>
		Emergency Contact Address Second Line <input type='text' name='em_address[line2]'> <br>
		Emergency Contact Address City <input type='text' name='em_address[city]'> <br>
		Emergency Contact Address State (1 = TX) <input type='text' name='em_address[state]'> <br>
		Emergency Contact Address Zip <input type='text' name='em_address[postal_code]'> <br>

                </fieldset>


		<input type='submit' name'Register'>
		</form>


	";

}






?>
