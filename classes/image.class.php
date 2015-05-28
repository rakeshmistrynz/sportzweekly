<?php 

/**
 * @author Rakesh Mistry
 *
 * Class containing methods / properties to verify image uploads and save them to designated directory
 * Class also contain images manipulation methods to resize images, crop etc. 
 */
class imageupload {

	/**
	 * White list of accepted image file types
	 * @var array of acceptable image file types
	 */
	public $acceptable = [

	'jpg',

	'jpeg',

	'gif',

	'png'

	];

	/**
	 * File upload directory on server
	 * @var string
	 */

	public $dir;


	/**
	 * New File name for uploaded image.
	 * @var string
	 */
	public $newfilename;


	/**
	 * An array to carry information about image file being handled. 
	 * @var array
	 */
	public $the_file_array = [];
	
	/**
	 * Constructor
	 * @param array $uploaded_file an array passed in containing information about the image file being handled (a->filtered($_FILES) array)
	 */
	function __construct($uploaded_file, $directory)
	{

		$this->the_file_array = $uploaded_file;

		$this->dir = $directory;

	}
	

	/**
	 * Method to check if file is an image.
	 *
	 *instantiate a new file info object. Use it to find the the file type ie. image/gif. 
	 *use pre_split to split up the information about the file from finfo object. 
	 *take the first value, which will by the file type and look for it in the white list (acceptable array);
	 * 
	 * @return boolean if file type in array=true else false. 
	 */
	function check_if_image(){

	$file_info = pathinfo($this->the_file_array['name'],PATHINFO_EXTENSION);

	return(in_array($file_info, $this->acceptable));

	}


	/**
	 * Check file size, server side.
	 * @return boolean 
	 */
	function check_file_size(){

		return $this->the_file_array['size'] < 2000000;

	}

	/**
	 * Create a new file name by concatenating on time to the beinging of the tmp filename
	 * @return string filename for image.
	 * 
	 */
	function create_file_name(){

		return $this->the_file_array['file_name'] = time().'_'.$this->the_file_array['name'];

	}

	 
	/**
	 * Upload file to server
	 * @return boolean true if moved to directory on the server. 
	 */
	function upload_file(){

		return move_uploaded_file($this->the_file_array['tmp_name'], $this->dir.$this->the_file_array['file_name']);

	}
	
	/**
	 * Save user image to database
	 * @param  number $userID    User ID
	 * @param  string $userquery sql query
	 * @return boolean            return true if sql query successful 
	 */
	function save_image_db($userID, $userquery){

		$db = new db();

		$db->bind("userID", $userID);

		$db->bind("user_image_filename", $this->the_file_array['file_name']);

		return $db->query($userquery);

	}

	/**
	 * [imagechecks description]
	 * @return 1 (true) if pass image check and file size check
	 * else return a string with fail message
	 */
	function imagechecks(){

		$check1 = $this->check_if_image();

		$check2 = $this->check_file_size();

		if(!$check1 or !$check2){

			if(!$check1){

				return '<span class="fail">Sorry only .jpg .png .gif acceptable</span>';
			};

			if(!$check2){

				return '<span class="fail">Sorry file too big (file size < 2MB)</span>';
			}

		}else{

			return 1;
		}
	}	

}// End of Image.Class

//EOF


 ?>