<?php

	$i= 11111;
//build a base...	
	while($i < 99999){
		$i++;
		for($j=0;$j<2;$j++){
		$rand_tier = rand(1,3);
		$my_guy = random_tier_assurer($rand_tier) ;
		$people[$i][$j] = $my_guy;
		if(!isset($people[$my_guy]['count'])){
			$people[$my_guy]['count'] = 1;
		}else{
			$people[$my_guy]['count']++;
		}
		}
	}
$count = array();
foreach($people as $person_id => $person_array){
	$count[$person_array['count']]++; ;
}
ksort($count);
var_export($count);

function random_tier_assurer($tier){

	if($tier == 1){
		return(rand(11111,11111+rand(0,50)));
	}

	if($tier == 2){
		return(rand(11111,11111+rand(0,500)));
	}

	if($tier == 3){
		return(rand(11111,11111+rand(0,5000)));
	}

	if($tier > 4){
		return(rand(11111,99999));
	}
}





?>
