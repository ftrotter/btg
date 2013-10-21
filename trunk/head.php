<?php

	class HTMLHeader{

	private $css_array = array();
	private $javascript_array = array();
	private $body_tag = "<body>";
	private $title = "<title>QHR Lite</title>";
	private $html_tag = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>';
 
/*	private $html_tag = 
'<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';
*/

	function __construct(){

		$this->addToggleJS();

	}


	function addToggleJS(){


		$this->javascript_array[] = 
"
<script type='text/javascript'>
function toggle(obj) {
		var el = document.getElementById(obj);
		if ( el.style.display != 'none' ) {
			el.style.display = 'none';
		}
		else {
			el.style.display = '';
		}
		return false;
	}
function turn_on(obj) {
		var el = document.getElementById(obj);
		el.style.display = '';

	}
function turn_off(obj) {
		var el = document.getElementById(obj);
		el.style.display = 'none';
	}

</script>
";




	}


	function addJS($js){

		$this->javascript_array[] = $js;

	}

	function addCSS($css){

		$this->css_array[] = $css;

	}

	function addTitle($title){

		$this->title = "<title>$title</title>";

	}

	function setBodyTag($new_tag){

		$this->body_tag = $new_tag;

	}
	function getHeader(){

		$return_me = $this->html_tag ."<head>\n";

		$return_me .= $this->title."\n";

		foreach($this->css_array as $css){
			$return_me .= "$css\n";
		}

		foreach($this->javascript_array as $js){
			$return_me .= "$js\n";
		}



		$return_me .= "</head> " . $this->body_tag; 

		return($return_me);
	}

	function getFooter(){

		return("</body></html>");
	}

	}

?>
