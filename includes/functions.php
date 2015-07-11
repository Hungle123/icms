<?php
	// function check error
	function confirm_query($result, $query){
		global $dbc;
		if(!$result){
			die ('Query: {$query} \n<br/>'.mysqli_error($dbc));
		}
	}

?>