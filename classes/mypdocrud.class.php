<?php 

/**
 * @author Rakesh Mistry
 *
 * Class containing methods extending the existing pdo class, to create project specific methods for use in the assignment and that can be used with the form class.  
 * 
 */

class mypdocrud{

	/**
	 * Makes a flat array of users
	 * @param  array $array     flat array of users
	 * @param  string $dbcolname database col name
	 * @return array            array of users
	 */
	function make_users_list($array, $dbcolname){

		foreach ($array as $key => $value) {

			$newarray[$key] = $value[$dbcolname];

		}

		return $newarray; 
	}

	/**
	 * Checks to find a particular fieldvalue in array(users)
	 * @param  array $array     flat array of values(users)
	 * @param  string $fieldname needle to lookfor.
	 * @return boolean            true / false 
	 */
    function check_users_list($array, $fieldname){

    	if(in_array($this->filtered_array[$fieldname],$array)) {
    		
    		$this->test_array[$fieldname] = false;

    		$this->form_array[$fieldname]['input_message'] = '<span class="fail">Sorry Username Taken</span>';
    	}

	}

	/**
	 * Enters a new user into the db - table of news_users
	 * @param  string $insertquery sql insert statement
	 * @return boolean              true/false
	 */
	function enter_newuser_db($insertquery){

		array_pop($this->filtered_array);

		$db = new db();

		$db->bindMore($this->filtered_array); 

		$db->query($insertquery);

		return true; 
	}


	/**
	 * Enter updated information about user into the database 
	 * @param  string $updatequery sql query
	 * @param  string $userid      value to bind
	 * @return boolean              true/false
	 */
	function enter_updateduser_db($updatequery, $userid){

		array_pop($this->filtered_array);

		$db = new db();

		$db->bindMore($this->filtered_array);

		$db->bind("userID", $userid);

		//insert =
		$db->query($updatequery);

		return true; 
	}

	/**
	 * Find a user's password
	 * @param  string $passwordquery sql query
	 * @param  string $fieldname     the username from the login form. 
	 * @return string                contains the password hash. 
	 */
	function find_password($passwordquery, $fieldname){

		$db = new db();

		$db->bind('user', $fieldname);

		return $db->single($passwordquery);

	}

	/**
	 * Get a user information inc profile image
	 * @param  string $userID    value - (numeric id)
	 * @param  string $userquery sql statement 
	 * @return array            userinfo
	 */
	function get_user_info($userID, $userquery){

		$db = new db();

		$db->bind('userID', $userID);

		return $db->query($userquery);

	}


	//Gets the main article for index_article page - return array
	function get_sports_page_articles($artID, $artquery){

		$db = new db();

		$db->bind('id', $artID);

		return $db->query($artquery, null, PDO::FETCH_NUM);

	}

	//Gets the index page articles - returns array
	function get_sports_homepage_articles($artquery){

		$db = new db();

		return $db->query($artquery, null, PDO::FETCH_NUM);

	}

	//Gets the menu - return array 
	function get_menu($menuquery){

	$db = new db();

	return $db->query($menuquery, null, PDO::FETCH_NUM);

	}

	//Gets search result - returns array 
	function get_search_results($searchterm){

	$db = new db();

	return $db->query("SELECT id, news_category_id, date_time_created, headline,
								MATCH (article_text, headline)
								AGAINST ($searchterm) AS relevance 
									FROM news_articles
									WHERE MATCH (article_text, headline) AGAINST ($searchterm) 
									AND approval_id > 2
							ORDER BY relevance DESC", null, PDO::FETCH_NUM);

	}

	function make_options_list($array){

		foreach ($array as $key => $value) {

			$newarray[$value['id']] = $value['category_type_descp'];

		}

		return $newarray; 
	}


	function get_category($cat_query){

	$db = new db();

	return $db->query($cat_query);

	}

	function get_sports_page_article_info($artID, $artquery){

	$db = new db();

	$db->bind('id', $artID);

	return $db->query($artquery);

	}

	//Gets the main article for index_article page - return array
	function get_sports_video($artID, $artquery){

		$db = new db();

		$db->bind('id', $artID);

		return $db->query($artquery, null, PDO::FETCH_NUM);

	}

}// End of mypdocrud.class
//EOF

