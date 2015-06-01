<?php

/**
 * @author Rakesh Mistry
 * Renders Edit article page, including form for editing articles 
 */

session_start();

//Check if user logged in
if(!($_SESSION['loggedIn'])){

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

//Instantiate database object
$article_info = new mypdocrud();

//Generate an array of sports categories for form from database
$cat_list = $article_info->get_category($cat_query);

//Generate HTML drop down list
$options_list = $article_info->make_options_list($cat_list);

//Array to generate HTML form. 
$update_article_form = [

	'enctype_open'=>[

		'id'=>'update_article',

		'type'=>'openEnctype'

	],

	'file_input'=>[

		'input_message'=>'<span class="col3">Must be a .jpg, .png or .gif file (size < 2MB)</span>',

		'type'=>'file_input',

		'label'=>'Update Article Photo'

	],

	'news_category_id'=>[

				'type' => 'select',

				'label' => 'Sports Category',

				'input_message' => '<span></span>',

				'list_values'=> $options_list,

				'required' => true
	],

	'headline'=>[

				'type' => 'text',

				'label' => 'Headline',

				'input_message' => '<span></span>',

				'placeholder'=> 'Article Headline',

				'validation_message' => '<span class="fail">Sorry only letters accepted</span>',

				'required' => true
	],

	'article_text'=>[

				'type' => 'text_area',

				'form' => 'update_article',

				'label' => 'Article Text',

				'input_message' => '<span></span>',

				'col' => '10',

				'rows' => '10',

				'placeholder'=> ' ',

				'validation_message' => '<span class="fail">Sorry non-acceptable characters in text</span>',

				'required' => true
	],

	'approval_id'=>[

				'type' => 'select',

				'label' => 'Main Article?',

				'input_message' => '<span><span>',

				'list_values'=> [

				'4' => 'YES',

				'3' => 'NO'

				],

				'required' => true
	],

	'submit'=>[

				'name' => 'update_article',

				'value' => 'UPDATE ARTICLE'
	]

];

/**
 * Make sure article id is set for article being edited.
 */
if(isset($_GET['article_id']) && is_numeric($_GET['article_id'])){
            
    $artid = $_GET['article_id'];
            
    $_SESSION['article_id'] = $_GET['article_id'];
            

    }else{
            
        $artid = $_SESSION['article_id'];
            
};

/**
 * @var $full_article description Get information about the article from the database to populate form fields
 */
$full_article = $article_info->get_sports_page_article_info($artid, $dbQuery_get_article_info);

$html = new makeHTML();

//Create the Form HTML
$add_article = new makeform($update_article_form);

//Filter all the input from the database with the article info
$add_article->filter_everything($full_article[0]);

$db = new db();

//**********************************************************//
	//Edit Article Code 
//**********************************************************//

/**
 *1. Check if image and article submitted together
 *2. Check if images. 
 *3. Check fields entered
 *4. If fields entered correctly and file is an image then update article in DB 
 */

//1.
if($_POST){

	$filecheck = true;

	//2.
	if($_FILES['update_article']['name']){

		$thefile = new imageupload($_FILES['update_article'],$article_image_dir);

		if($thefile->imagechecks()!=1){

			$add_article->form_array['file_input']['input_message'] = $thefile->imagechecks(); 
			
			$filecheck = false; 

		}else{

			$add_article->filtered_array['article_image_filename'] = $thefile->create_file_name();

			$thefile->upload_file();
		}
	}

	//3.
	$checkfields = $add_article->check_fields_entered('update_article');

	//4.
	if($checkfields && $filecheck){

		if($add_article->filtered_array['approval_id']==4){

		$db->bind("news_category_id", $add_article->filtered_array['news_category_id']);

		$db->query($sQuery_update_main);

		}

		$newarray = array_slice($add_article->filtered_array,0,6);

		$db->bindMore($newarray);

		$db->query($dbQuery_update_article);

		ob_flush();

		header('Location: index.php');

	}
}

//**********************************************************//
	//Presentation 
//**********************************************************//

$menu = $article_info->get_menu($menuquery);

echo $html->make_header(CSS_PATH."css/styles.css",'Edit Article');

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

    <section class="form edit_article_form">
    <h3>EDIT ARTICLE</h3>
    <section>
    <h4>ARTICLE PHOTO</h4>
	<img src="<?php echo IMAGE_PATH.'article_images/'.$full_article[0]['article_image_filename']?>" alt="artimage">    	
    </section>
	<?php echo $add_article->writeWholeForm()?>    	 	
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