<?php

/**
 * @author Rakesh Mistry
 * Renders Edit profile page, including form for editing user profile
 */
session_start();

//Check if user logged in
if(!$_SESSION['loggedIn']){

	header('Location: loginform.php');
}; 

//**********************************************************//
	//Required files
//**********************************************************//

require '../config/config.php';

require '../config/form_arrays.php';

require CLASS_PATH."html.class.php";

//**********************************************************//
	//Preparation
//**********************************************************//

// Instantiate required classes

$db = new db();

$html = new makeHTML();

$update_user = new makeform($update_user_form);

$image_form = new makeform($update_user_photo);

$mypdo = new mypdocrud(); 

//**********************************************************//
	//Update Form code
//**********************************************************//

/**
 * 1. Prepare form with user information 
 * 1a. $First_step is to check if data posted and all fields have been entered, ie no empty values. 
 * 2. $Second_step check if all fields are valid - against regular expression checks.
 * 3. Two checks at $Third_step. A. Checks if entered user name is the same as $_session[username], if is it moves onto fourth step.
 *     B. If username is different to current session username then checks to find if the new user name matches an existing username in the database. 
 * 4. $Fourth Step enters new user information into the database. 
 * 5. Updates the $_SESSION username, incase it has changed.       
 */

//1. Prepare form
$userID = (isset($_SESSION['user'][0]['id'])&& is_numeric($_SESSION['user'][0]['id'])) ? $_SESSION['user'][0]['id'] : ' ';

$user_info = $update_user->get_user_info($userID, $dbQuery_user);

$update_user->filter_everything($user_info[0]);

// 2.Routine to exectute when data posted
$first_step_update = $update_user->check_fields_entered('update_button'); 

$second_step_update = ($first_step_update)? $update_user->check_fields_valid($updateValidation): false; 

if($second_step_update){

	if($update_user->filtered_array['username']!==$_SESSION['user'][0]['username']){

		$look_up_users = $db->query($dbQuery_all_users);

		$third_step_update = $update_user->check_duplicate_username($look_up_users, 'username', 'username');

	}else{

		$third_step_update = true; 
	}
};

$fourth_step_update = ($third_step_update)? $update_user->enter_updateduser_db($sQuery_update_user, $userID) : false;

if($fourth_step_update){

	$_SESSION['user'][0]['username'] = $update_user->filtered_array['username'];  
        
	ob_flush();

	header('Location: userpage.php');

};

//**********************************************************//
	//Image Upload Code 
//**********************************************************//

/**
 * 1. Check if there is a file uploaded by the user. If true than instantiate imageupload class with an array containing the files information. 
 * 2. Two checks. First check, checks if the file is an image, against a white list of acceptable file types. 
 * 3. Second check if the file is under 2mb. 
 * 4. If $check1 and $check2 area true then goes ahead and uploads file to server, saves the name of the file to the database. 
 * 5. If either check fails, returns a fail message to user.  
 */

//1.
if(!empty($_POST['image_upload']) && ($_FILES['image_upload']['error']<4)){
	
	$thefile = new imageupload($_FILES['image_upload'], $user_image_dir);

}; 

//2.
if($thefile->the_file_array){

	if($thefile->imagechecks!=1){

		$image_form->form_array['file_input']['input_message'] = $thefile->imagechecks(); 

	}; 

	if($thefile->imagechecks()==1){

		$thefile->create_file_name();

		$thefile->upload_file();

		$thefile->save_image_db($userID, $sQuery_update_user_image);

		$_SESSION['user'][0]['user_image_filename'] = $thefile->the_file_array['file_name'];

		$image_message = 'file uploaded'; 

		ob_flush();

	}
}


//**********************************************************//
	//Presentation 
//**********************************************************//

$menu = $mypdo->get_menu($menuquery);

echo $html->make_header(CSS_PATH."css/styles.css",'Edit Profile');

?>

<div id="container" class="container group">

	<div class="overlay">
		<div class="pop_up">
			<p>CHANGE MENU TO THE RIGHT?</p>
			<div class="buttons">
				<button id="yes">YES</button>
				<button id="no">NO</button>				
			</div>	
		</div>
    </div>


    <header class="header_left">
    <h1><a href="index.php">SportzWeekly</a></h1>
    <p>YOUR SPORTS NEWS</p>
    <p><date><?php echo date('l jS F Y'); ?></date></p>

    <section class="hide login">
    <h2 class="hide">LOGIN</h2>
    <a href="userpage.php" class="login"><i class="fa fa-user fa-2x"></i><?php echo $user = (isset($_SESSION['user']))? $_SESSION['user'][0]['username'] : 'LOG IN' ?></a>
    </section>
	
    </header>

	<section class="form update_profile">
	<h3>UPDATE PROFILE</h3>
	<?php echo $update_user->writeWholeForm()?>
	</section>

	<section class="form user_photo">
	<h3>UPDATE PROFILE IMAGE</h3>
	<img src="<?php echo IMAGE_PATH.'user_image/'.$_SESSION['user'][0]['user_image_filename']?>" alt="userimage">
	<?php echo $image_form->writeWholeForm() ?>
	</section>

    <footer>
    <div class="footer-container">
	<section>
	<h2>LIVE MATCH COVERAGE</h2>
	<article>
	<h3>BLACKCAPS VS AUSTRALIA</h3>
	<p>STARTS: 3.30PM(NZT)</p>
	</article>
	</section>

	<nav>
	<h2 class="hide">FOOTER MENU</h2>
	<ul class="group">
		<li><a href="loginform.php">SIGN UP</a></li>
		<li><a href="loginform.php">LOGIN</a></li>
		<li><a href="loginform.php">ABOUT US</a></li>
		<li><a href="loginform.php">CONTACT US</a></li>
	</ul>
	</nav>

	<section class="group">
	<h2><a href="index.php">SportzWeekly</a></h2>
	<q>Winners never quit and quitters never win.<br>-Vince Lombardi</q>
	<nav class="group">
	<h2 class="hide">SOCIAL MEDIA MENU</h2>
	<ul class="group">
		<li class="facebook"><a href="http://www.facebook.com" class="icon facebook"><span>facebook</span></a></li>
		<li><a href="http://www.twitter.com" class="icon twitter"><span>twitter</span></a></li>
		<li><a href="http://www.instagram.com" class="icon instagram"><span>instagram</span></a></li>
	</ul>
	</nav>
	</section>      	
    </div>
  	
    </footer>

<?php echo $html->make_footer();  ?>