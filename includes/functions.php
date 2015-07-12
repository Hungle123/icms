<?php

	// xac dinh duong dan tuyet doi 
	define ('BASE_URL', 'http://localhost/izcms/icms/');
	// function check error
	function confirm_query($result, $query){
		global $dbc;
		if(!$result){
			die ("Query: '{$query}' \n<br/>".mysqli_error($dbc));
		}
	}

	// function redirest
	function redirest_to($page ='index.php'){
		$url = BASE_URL.$page;
		header("Location: $url");
		exit();
	}

	// function cat noi dung pages
	function the_excerpt($text){
		$sanitized = htmlentities($text, ENT_COMPAT,'UTF-8');
		if(strlen($sanitized) > 400){
			$cutString = substr($sanitized, 0, 400);
			$word = substr($sanitized, 0,strrpos($cutString, ' '));
			return $word;
		}else{
			return $sanitized;
		}
	
	}

	function validate_id($id){
		if(isset($id) && filter_var($id,FILTER_VALIDATE_INT,array('min_range' =>1))){
        	$val_id = $id;
        	return $val_id;
    	}else{
    		return NULL;
    	}
	} // end function velidate id ;

	function get_page_by_id($id){
		global $dbc;
		$q = "SELECT p.page_name, p.page_id,p.content,";
        $q .= " DATE_FORMAT(p.post_on, '%b %d %Y') AS date, ";
        $q .= " CONCAT_WS(' ',u.first_name, u.last_name) AS name,u.user_id ";
        $q .= " FROM pages as p INNER JOIN user AS u ";
        $q .= " USING(user_id) WHERE p.page_id = {$id} ";
        $q .= " ORDER BY date ASC LIMIT 1";
        $result = mysqli_query($dbc, $q);
        confirm_query($result, $q);
        return $result;
	}

	function the_content($text){
		$sanitized = htmlentities($text, ENT_COMPAT,'UTF-8');
		return str_replace(array("\r\n", "\n"), array("<p>","</p>"),$sanitized);
	}
?>