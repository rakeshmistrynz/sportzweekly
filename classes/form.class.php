<?php 

/**
 *
 * @author Rakesh Mistry
 *
 * Class needs to be used with an array ($form_array) containing information about a form - see below. Write all the HTML for a custom build form.
 * Extends the security class which contains form related methods for checking and validating data.  
 *
 */

include 'security.class.php';

class makeform extends security{

	/**
	 * @param $form_array is the array of the form fields. It has two dimension. The first dimension is 
	 * the name of the form field. The second dimension contains information about the form field. For example:
	 * 	$login_form = [	
	 * 		'username'=>[
	 * 			'type' => 'text',
	 * 		 	'label' => 'USERNAME',
	 * 		  	'validation_message' => 'Sorry only letters and numbers',
	 * 		   	'required' => true
	 *
	 * Refer to makeFormRows() method below for list of possible form field types.  
	 */
	public $form_array = [];


	/**
	 * Contructor
	 * 
	 * @param boolean $form_info_array set to false by default (so class can be instantiated with or without a form array)
	 * 
	 */
	function __construct($form_info_array = false){

		if($form_info_array){

			$this->form_array = $form_info_array;
		}
	}

	/**
	 *	Writes the whole form
	 * 
	 * @return will return a string containing all of the HTML for a whole form 
	 * 
	 */
	function writeWholeForm(){

        $a='';

        $a.= $this->makeFormRows();

        $a.= $this->submitbutton();

        $a.= $this->closeForm();

        return $a;
        
    }// end of writeWholeForm
    
    /**
     * Make the form rows, as specified in the $form_array;
     *  
     * @return string with HTML form rows. 
     *   
     */
    function makeFormRows(){
        
        $a='';

        foreach($this->form_array as $fieldname => $fieldinfo){

        	switch ($fieldinfo['type']){

        		case 'open':
        			
        			$a .= $this->openForm($fieldname);

        			break;

        		case 'openEnctype':
        			
        			$a .= $this->openEnctype();

        			break;

        		case 'text':
        			
        			$a .= $this->makeInputRow($fieldname);

        			break;

        		case 'search':
        			
        			$a .= $this->makeInputRow($fieldname);

        			break;

        		case 'text_area':
        			
        			$a .= $this->makeTextarea($fieldname);

        			break;
        		
        		case 'select':

        			$a .=  $this->makeSelectRow($fieldname);

        			break;

        		case 'password':

        			$a .=  $this->makeInputRow($fieldname);

        			break;

        		case 'file_input':

        			$a .=  $this->makeFileInput();

        			break;

        	}

        }
        
       return $a;

    }// end of makeformrows

    /**
     * Method to write an opening form tag. Is used by the makeFormRows method. 
     * @param  string $fieldname is the id to assign to the form, in the form array.  
     * @return string - HTML opening form tag 
     */
    function openForm($fieldname){
       
    return '<form action="'.$_SERVER['SCRIPT_NAME'].'" method = "post" id="'.$this->form_array[$fieldname]['id'].'" novalidate class="group">'."\n";

    }

    /**
     * Method to write closing form tag
     * @return string with HTML closing form tag
     */
    function closeForm(){

       return "\t".'</form>'."\n";
    }
    // end of close form
    
    
    
    /**
     * Method to write submit button
     * @return string with submit button HTML
     */
    function submitbutton(){
       
       return "\t".'<input type="submit" name="'.$this->form_array['submit']['name'].'" value="'.$this->form_array['submit']['value'].'" class="submitButton" />'."\n";
   
    }
    // end of submit
   
   /**
    * Method to write form labels, as assigned to a form field
    * @param  string $fieldname name of the form field 
    * @return string            with HTML for a form label 
    */
   function makeLabel($fieldname)
   {
       return "\t".'<label for="'.$fieldname.'" class="col1">'.$this->form_array[$fieldname]['label'].'</label>';
   }
   // end of label
   
   
   /**
    * Method to write an input HTML field
    * @param  string $fieldname name of input field
    * @return string            with HTML for a input field
    */
   function makeInput($fieldname){

       return '<input type="'.$this->form_array[$fieldname]['type'].'" name="'.$fieldname.'" id="'.$fieldname.'" value="'.$this->filtered_array[$fieldname].'" placeholder="'.$this->form_array[$fieldname]['placeholder'].'" class="col2"/>';

   }
   // end of input
   

   /**
    * Method to write a message associated with a form field eg. 'Field required' to prompt user
    * @param  string $fieldname name of input field associated with the message for the form field.
    * @return string            with HTML to make a DIV containing text for a message.
    *  
    */
   function makeMsg($fieldname){

       return $this->form_array[$fieldname]['input_message']."\n"; 
   }
   //end of makeMsg
   
  
   /**
    * method to combine makelabel, makeinput and makemessage to make an input row.
    * @param  string $fieldname name of the input field
    * @return string            with HTML containing a label, input field and a message for that input field
    */
   function makeInputRow($fieldname){
       
       $a  = '';
       
       $a .= $this->makeLabel($fieldname);
       
       $a .= $this->makeInput($fieldname);
       
       $a .= $this->makeMsg($fieldname);
       
       return $a;
   }
   // end of makeInputRow
 

   	/**
   	 * method to make a select field using an array a list of values. 
   	 * @param  string $fieldname name of select list
   	 * @return string            with HTML for a select list
   	 */
    function makeSelect($fieldname){

        $list_values = $this->form_array[$fieldname]['list_values'];

        $a='';

        $a.= '<select name="'.$fieldname.'" id="'.$fieldname.'" class="col2">'."\n";

        foreach($list_values as $value => $name){

            $a.= "\t".'<option value="'.$value.'"';

            $selected_value = ($value == $this->filtered_array[$fieldname])?' selected="selected"':'';

            $a.=$selected_value.'>'.$name.'</option>'."\n";
        }

        $a.= "\t".'</select>';

        return $a;
    
    }
    //end of makeSelect

    /**
    * method to combine makelabel, makeselect and makemessage to make a select row.
    * @param  string $fieldname name of the input field
    * @return string            with HTML containing a label, select list and a message for the select field
    */
    function makeSelectRow($fieldName){

        $a = '';

        $a .= $this->makeLabel($fieldName);

        $a .= $this->makeSelect($fieldName);

        $a .= $this->makeMsg($fieldName);

        return $a;

    }
    // end of makeSelectRow

   /**
    * Method to write Text area HTML
    * @param  string $fieldname name of text area field
    * @return string            with HTML for a Text Area
    * 
    */
   function makeTextarea($fieldname){

   	    $a = '';

        $a .= "\t".'<label for="'.$fieldname.'" class="col1">'.$this->form_array[$fieldname]['label'].'</label>';

        $a .= '<textarea name="'.$fieldname.'" form="'.$this->form_array[$fieldname]['form'].'" col="'.$this->form_array[$fieldname]['col'].'" rows="'.$this->form_array[$fieldname]['rows'].'" class="col2">'.$this->filtered_array[$fieldname].'</textarea>';

        $a .= '<span class="col3">'.$this->form_array[$fieldname]['input_message'].'</span>'."\n"; 

        return $a;
       
   }
   // end of textarea


    function openEnctype(){

    	$a = '';

    	$a .= '<form method="post" enctype="multipart/form-data" action="" id="'.$this->form_array['enctype_open']['id'].'" class="group">'."\n";

    	return $a;
    
    }

    function makeFileInput(){

    	$a = ' ';

    	$a .= "\t".'<label class="col1">'.$this->form_array['file_input']['label'].'</label><input name="'.$this->form_array['enctype_open']['id'].'" type="file" class="col2">';

    	$a .= "\t".$this->form_array['file_input']['input_message']."\n";

    	$a .= "\t".'<input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>'."\n";

    	return $a;

    }

}//EOF - End of Form.Class