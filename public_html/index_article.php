<?php

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

// Instantiate required classes
$db = new Db();

$html = new makeHTML();

$search = new makeform($searchform);

$comment = new makeform($comment_form);

$mypdo = new mypdocrud(); 


//Set Global Variables - Article ID -$artid

    if(isset($_GET['article_id']) && is_numeric($_GET['article_id'])){
            
        $artid = $_GET['article_id'];
            
        $_SESSION['article_id'] = $_GET['article_id'];
            
    }else{
            
        $artid = $_SESSION['article_id'];
            
    };
        
//**********************************************************//
	//Get Full Article info and comments
//**********************************************************//

//Get Full Article 
$full_article = $mypdo->get_sports_page_articles($artid, $full_article_query);

//Get a count of the number of comments
$comment_count = $mypdo->get_sports_page_articles($artid, $article_commentcount_query);

//Get the comments to display next to article 
$comment_rows = $mypdo->get_sports_page_articles($artid, $article_commentrow_query); 

//**********************************************************//
	//Comment Form
//**********************************************************//

/**
 * 1.Check if comment posted
 * 2. Filter the comment.
 * 3. Put the comment back into the form if it can not be added, ie picks up a sharp bracket. 
 * 4. If passes through filter then put the comments, into the comments table with the article id and user id. 
 * 
 */

if(!empty($_POST['comment_button'])){

	$comment->filter_everything($_POST);

		if(empty($comment->filtered_array['comment'])){
                        
        $comment->form_array['comment']['comment'] = $_POST['comment']; 
                        
		$message = 'COMMENT COULD NOT BE ADDED, PLEASE TRY AGAIN';

		}else{

        $db->bind("article_id", $artid);

		$db->bind("comment_text", $comment->filtered_array['comment']);

		$db->bind("userid", $_SESSION['user'][0]['id']);

		$insert = $db->query($dbQuery_add_comment);

			if($insert){

			header('Location: ' . $_SERVER['HTTP_REFERER']);
			
			ob_flush();

			} 
		}
	};

//**********************************************************//
	//HTML Presentation 
//**********************************************************//

//Check if Administartor Logged in. 
$admin = false;

if($_SESSION['user'][0]['username']=='admin'){

$admin = true;

};

$menu = $mypdo->get_menu($menuquery);

echo $html->make_header(CSS_PATH."css/styles.css",'SportzWeekly');

 ?>

<div id="container" class="container group container_left">
	
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
    <i id="menu_left" class="fa fa-navicon fa-2x"></i>
    <i id="search_left" class="fa fa-search fa-2x"></i>
    <h1><a href="index.php">SportzWeekly</a></h1>
    <p>YOUR SPORTS NEWS</p>
    <p><?php echo date('l jS F Y'); ?></p>

    <section class="hide login">
    <h2 class="hide">LOGIN</h2>
    <a href="userpage.php" class="login"><i class="fa fa-user fa-2x"></i><?php echo $user = (isset($_SESSION['user']))? $_SESSION['user'][0]['username'] : 'LOG IN' ?></a>
    </section>

    <nav class="header_nav">
    <h2><i class="fa fa-navicon"></i>&nbsp;MENU</h2>
    <ul>
    	<li id="header_menu"><i class="fa fa-navicon"></i>&nbsp;MENU</li>
<?php echo $html->make_menu($menu, $_SESSION['user'][0]['username'])?>
		<li id="header_search" class="search"><i class="fa fa-search"></i>SEARCH</li>
    </ul>   	
    </nav>		

    <section role="search" class="search_bar hide">
    <h2 class="hide">Search for an article</h2>
	<?php echo $search->writeWholeForm()?>	
    </section>

    <section class="search_results hide">
    <h2 class="hide">Search Results</h2>
    <table id="search_results_table">
	</table>
	</section>

    </header>

    <nav class="left_nav">
    <h2 class="hide">FULL MENU</h2>
    <ul>
    	<li><i class="fa fa-navicon"></i>&nbsp;MENU</li>
<?php echo $html->make_menu($menu, $_SESSION['user'][0]['username'])?>
    </ul>   	
    </nav>
	
	<div class="article_container">
    <main class="full_article">
    <h2 class="hide">FULL ARTICLE</h2>
<?php echo $html->makefullarticle($full_article, $admin)?>
	<aside class="article_comments">
	<h2 class="hide">ARTICLE COMMENTS</h2>
<?php echo ($comment_count[0][0]>0) ? "\t".'<h3>Article Comments</h3>'."\n" : " " ?>
   	<table>
<?php echo ($comment_count[0][0]>0) ? $html->make_comment_row($comment_rows):" ";?>
	</table>
	<section class="comment_form">
	<h3>Post A Comment</h3>
	<?php echo ($_SESSION['loggedIn'])? $comment->writeWholeForm().$message:$html->make_login_area()?>
	</section>
	</aside>
    </main>
	</div>

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