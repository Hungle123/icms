<?php
	// connect for database
	$dbc  = mysqli_connect('localhost','root','','izcms');

	//sessage error
	if(!$dbc){
		trigger_error("Could not connection database".mysqli_connect_error());
	}else{
		mysqli_set_charset($dbc, 'utf-8');

	}
?>