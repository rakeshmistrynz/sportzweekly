<?php
//**********************************************************//
	//constants
//**********************************************************//

//Client Side
define("HOME_PATH", "http://sportzweekly.rakeshmistry.co.nz/public_html/assets");
define("CSS_PATH", HOME_PATH.'/styles/');
define("IMAGE_PATH", HOME_PATH.'/images/');
define("JS_PATH", HOME_PATH.'/js/');

//Server Side
define("PARENT_PATH", "../");
define("CONFIG_PATH", PARENT_PATH.'config/');
define("ADMIN_PATH", PARENT_PATH.'/public_html/admin');
define("CLASS_PATH", PARENT_PATH.'classes/');

//Require Sql Statements 
require 'sql.php';

//**********************************************************//
	//Image Upload Directories
//**********************************************************//


$user_image_dir = '/var/www/vhosts/rakeshmistry.co.nz/sportzweekly.rakeshmistry.co.nz/public_html/assets/images/user_image/';

$article_image_dir = '/var/www/vhosts/rakeshmistry.co.nz/sportzweekly.rakeshmistry.co.nz/public_html/assets/images/article_images/';

//EOF 
?>
