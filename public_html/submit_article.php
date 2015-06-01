<?php

/**
 * @author Rakesh Mistry
 * Render submit article page and process any new articles submitted.
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

$db = new db();

$html = new makeHTML();

$add_article = new makeform($submit_article_form);

$mypdo = new mypdocrud(); 

//**********************************************************//
	//Submit Article code
//**********************************************************//

/**
 * 1. Check if image and article submitted together
 * 2. Check fields entered
 * 3. Check if images
 * 4. If fields entered correctly ie no script tags then enter into DB
 */
if($_POST && $_FILES['submit_article']['name']){

	$thefile = new imageupload($_FILES['submit_article'],$article_image_dir);

	$add_article->check_fields_entered('submit_article');

	
	if($thefile->imagechecks()!=1){

		$add_article->form_array['file_input']['input_message'] = $thefile->imagechecks(); 

	}; 

	$checkall = (($thefile->imagechecks()==1) and (!in_array(false,$add_article->filtered_array))) ? true : false ;

	if($checkall){

		array_shift($add_article->filtered_array);

		array_pop($add_article->filtered_array);

		$add_article->filtered_array['article_image_filename'] = $thefile->create_file_name();

		$add_article->filtered_array['user_id'] = 5;

		if($add_article->filtered_array['approval_id']==4){

		$db->bind("news_category_id", $add_article->filtered_array['news_category_id']);

		$db->query($sQuery_update_main);

		}

		$thefile->upload_file();

		$db->bindMore($add_article->filtered_array);

		$db->query($dbQuery_insert_article);

		ob_flush();

		header('Location: index.php');

	}
}

//**********************************************************//
	//Presentation 
//**********************************************************//

$menu = $mypdo->get_menu($menuquery);

echo $html->make_header(CSS_PATH."css/styles.css",'Submit Article');

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

	<section class="form submit_article_form">
	<h3>SUBMIT ARTICLE</h3>
	<p>ARTICLE MUST BE LOADED WITH A PHOTO</p>
	<?php echo $add_article->writeWholeForm() ?>
	</section>

    <footer>
	<section>
	<h2>LIVE MATCH COVERAGE</h2>
	<article>
	<h3>BLACKCAPS VS AUSTRALIA</h3>
	<p>STARTS: 3.30PM(NZT)</p>
	</article>
	</section>

	<nav>
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
	<ul class="group">
		<li class="facebook"><a href="http://www.facebook.com" class="icon facebook"><span>facebook</span></a></li>
		<li><a href="http://www.twitter.com" class="icon twitter"><span>twitter</span></a></li>
		<li><a href="http://www.instagram.com" class="icon instagram"><span>instagram</span></a></li>
	</ul>
	</nav>
	</section>    	
    </footer>

<?php echo $html->make_footer();  ?>