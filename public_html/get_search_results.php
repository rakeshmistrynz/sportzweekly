<?php

session_start();

//**********************************************************//
	//Required files
//**********************************************************//

require '../config/config.php';

require CLASS_PATH."html.class.php";

require CLASS_PATH."pdo.class.php";

require CLASS_PATH."form.class.php";

//**********************************************************//
	//Preparation
//**********************************************************//

// Instantiate required classes
$db = new Db();

$html = new makeHTML();

$search = new makeform($searchform);

$mypdo = new mypdocrud(); 

/**
 * 1.Check if comment posted
 * 2. Filter the comment.
 * 3. Put the comment back into the form if it can not be added, ie picks up a sharp bracket. 
 * 4. If passes through filter then put the comments, into the comments table with the article id and user id. 
 * 
 */

if($_POST){

	$search->filter_everything($_POST);

	$searchterm = $search->filtered_array['search'];

	$a = ""; 

	$a = '\'';

	$a.=$searchterm;

	$a.='\'';

	$search_results = $search->get_search_results($a);
	
	if(isset($search_results)){
		
		echo json_encode($search_results);
	}
	
}

