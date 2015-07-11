<?php

	// xac dinh duong dan tuyet doi 
	define ('BASE_URL', 'http://localhost/izcms/icms/');
	// function check error
	function confirm_query($result, $query){
		global $dbc;
		if(!$result){
			die ('Query: {$query} \n<br/>'.mysqli_error($dbc));
		}
	}

	// function redirest
	function redirest_to($page ='index.php'){
		$url = BASE_URL.$page;
		header("Location: $url");
		exit();
	}


?>