<?php

/**
 * @author Rakesh Mistry
 * Render and process forms for logging in and registering with Sportzweekly.
 */
session_start();

//**********************************************************//
	//Required files
//**********************************************************//

require '../config/config.php';

require '../config/form_arrays.php';

require CLASS_PATH."html.class.php";

//**********************************************************//
	//Preparation
//**********************************************************//

//Instantiate required classes
$html = new makeHTML();

$mypdo = new mypdocrud(); 

$db = new db();

$login = new makeform($login_form);

$register = new makeform($register_form); 

//**********************************************************//
	//Login Form code
//**********************************************************//

/**
 * Login Steps - 
 * 1. Check if data posted and fields have been entered
 * 2. Retrieve the password from database using the entered username 
 * 3. Check the password, if true move to next step, if doesnt match give error message
 * 4. If the password matches, user logins and set sessions, with user info. Sent user to userpage.php      
 */

$first_step_login = $login->check_fields_entered('login_button');

if($first_step_login){

	$hash = $login->find_password($dbQuery_user_password, $login->filtered_array['username']);

	if(password_verify($login->filtered_array['userpassword'], $hash)){

	$db->bind('user', $login->filtered_array['username']);

	$user_info = $db->query($dbQuery_user_info);

	$_SESSION['loggedIn'] = true;

	$_SESSION['user'] = $user_info;

	header('Location: userpage.php');
			
	ob_flush();


	}else{

		$message = '<h2>LOGIN FAILED</h2>'; 
	}
}

//**********************************************************//
	//Registration Code
//**********************************************************//

/**
 * Registration Steps - 
 * 1. Check if data posted and fields have been entered
 * 2. Check if the fields are valid, ie match regular expression checks. 
 * 3. Check if username is unique against existing usernames. 
 * 4. Create a password hash
 * 4. Enter user into the database.      
 */

$first_step_reg = $register->check_fields_entered('register_button'); 

$second_step_reg = ($first_step_reg)? $register->check_fields_valid($registerValidation): false; 

$list_of_users = $db->query($dbQuery_all_users);

$third_step_reg = ($second_step_reg)? $register->check_duplicate_username($list_of_users,'username','username'): false;

$fourth_step_reg = ($third_step_reg)? $register->makepassword('userpassword'): false;

$fifth_step_reg = ($fourth_step_reg)? $register->enter_newuser_db($sQuery_new_user): false; 

if($fifth_step_reg){

	$db->bind('user', $register->filtered_array['username']);

	$user_info = $db->query($dbQuery_user_info);

	$_SESSION['loggedIn'] = true;

	$_SESSION['user'] = $user_info;

	header('Location: userpage.php');
			
	ob_flush();

};


//**********************************************************//
	//Presentation 
//**********************************************************//

$menu = $mypdo->get_menu($menuquery);

echo $html->make_header(CSS_PATH."css/styles.css",'Login');

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

	<section class="login_form">
	<?php echo (!$_SESSION['loggedIn'])? '<h3>LOGIN</h3>'.$login->writeWholeForm().$message : " ";?>
	</section>

	<section class="register_form">
	<h3>SIGN UP</h3>
	<?php echo $register->writeWholeForm()?>
	<p>* All information is required</p>
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
    
<?php echo $html->make_footer() ?>