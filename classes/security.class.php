<?php

/**
 * @author Rakesh Mistry
 *
 * Class containing methods / properties to check form information and filter out unwanted data. 
 * extends pdomycrud.class to use methods to check duplicate user names in a register or update user form. 
 */

include 'mypdocrud.class.php';

require CLASS_PATH."password.php";

class security extends mypdocrud{

   	public $filtered_array = [];
	
	public $validation_array = [];

	public $test_array = [];

	public $user_list = []; 
 	

 	/**
 	 * Checks if post data exists
 	 * filters_everything filters the POST data to remove any unwanted data, ie script tags. 
 	 * Filtered values are put into this->filtered_array.
 	 * check_empty checks to see if there are empty values in each field, if it is a required field. 
 	 * A foreach loop goes through and checks the filtered_array of field values. 
 	 * If there is a value assigns a TRUE to the $test_array or FALSE to the $test_array
 	 * Return true if there are no false values in the $test_array, or false if there is a false in the $test_array.   
 	 * 
 	 * @param  Array $post_name Post Data
 	 * @return bool            true/false
 	 */
    function check_fields_entered($post_name){

		if(empty($_POST[$post_name])){

			return false;

		}else{

	    	$this->filter_everything($_POST);

			foreach ($this->filtered_array as $fieldname => $value){

				if ($this->form_array[$fieldname]['required'] == true) {
					
					$this->check_empty($this->filtered_array, $fieldname);

				}else{

					$this->test_array[$fieldname] = true;
				}
				
			}

	    	if(!in_array(false, $this->test_array)){

	    	return true;

    		}
    	}
	}

	/**
	 * Checks if the entered form field values are valid, does a check against a regular expression. Refer to the validation method - see below.
	 * If a value does not match a regular expression puts a false in the $test_array.  
	 * @param  array $regexp an array of regular expression for each field in a form - kept in config file. 
	 * @return Bool         True/False
	 */
     function check_fields_valid($regexp){

     	$this->validation($this->filtered_array,$regexp);

     	if(!in_array(false, $this->test_array)){

	    return true;
	    	
    	}
     }


    /**
     * Method to check for a duplicate username in a database
     * make_user_list - found in mypdocrud.class. Returns a flat array of users. 
     * check_users_list - checks for a value in the users array. 
     * @param  array $array     list(array(2d)) of all users from a database ie Select username from tbl_users
     * @param  string $dbcolname name of the table column
     * @param  string $fieldname value to find in array
     * @return bool            true / false 
     */
	function check_duplicate_username($array, $dbcolname, $fieldname){

    	$this->user_list = $this->make_users_list($array, $dbcolname);

    	$this->check_users_list($this->user_list, $fieldname); 

    	if(!in_array(false, $this->test_array)){

		return true;
	    	
    	}

    }
    
    //Filter (1d)array of data using php filter var, trim any whitespace. 
    function filter_everything($post_data){
    
    	foreach($post_data as $fieldname => $value){

             $this->filtered_array[$fieldname] = filter_var(trim($value),FILTER_SANITIZE_STRING);
    	}
	}


	/**
	 * Checks if a value in the $this->filtered_array is empty. 
	 * @param  string $data      name of the (1d)array to check
	 * @param  string $fieldname name of field ie $this->filtered_array[$fieldname]
	 * @return puts a false in the test array and return a fail message if feild is empty. If entered and clean puts a TRUE in $test_array.  
	 */
	function check_empty($data, $fieldname){

        	if(empty($data[$fieldname]))
        	{
            	$this->form_array[$fieldname]['input_message']='<span class="fail">This field cannot be empty</span>';

            	$this->test_array[$fieldname] = false; //
        	}            
        	
        	else
        	{
            	$this->form_array[$fieldname]['input_message']=' ';

            	$this->test_array[$fieldname] = true;
        	}

    } // end checkEmpty



    /**
     * Checks to see if entered fields are valid using php filter_var_array. filter_var_array requires two parameters - an array of values to check and an array of corresponding arguments (ie reg exp). 
     * The filter var will return an array. If the check passes it return true or if it fails a FALSE. 
     * A foreach loop then checks the validated_values_array for false values and assigns a fail message to the particular form field. It also puts a false in the test_array if it return a false in the returned filter_var_array
     * Vice versa for field that passes validation check. 
     * @param  array $data   data to check
     * @param  array $regexp list of argument to check against
     * @return  bool true / false.  
     */
    function validation($data, $regexp){

    	$validated_values_array = filter_var_array($data, $regexp);

    	foreach ($validated_values_array as $fieldname => $value){

    		if(!$value==false){

    			$this->form_array[$fieldname]['input_message']='<span class="pass">Great Thanks</span>';

    			$this->test_array[$fieldname]=true;

    		}else{

    			$this->form_array[$fieldname]['input_message']=$this->form_array[$fieldname]['validation_message'];

    			$this->test_array[$fieldname]=false;
    		}
    	}
    }

    //Make a passowrd using php password hash. Plugin included for compatibility, older version of php. 
     
    function makepassword($fieldname){

    	$hash = password_hash($this->filtered_array[$fieldname], PASSWORD_DEFAULT);

    	$this->filtered_array[$fieldname] = $hash;

    	return true; 

    } 
    
}
// end of class

