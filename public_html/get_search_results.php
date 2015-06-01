<?php

/**
 * @author Rakesh Mistry
 * Process search input and return JS object (Ajax)
 */
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
 * 1. Check search field entered
 * 2. Filter search input
 * 3. Return JSON array (Ajax) 
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

