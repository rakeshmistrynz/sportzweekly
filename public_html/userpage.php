<?php

/**
 * @author Rakesh Mistry
 * Render user land page, after users has logged in. 
 */
session_start();

if(!$_SESSION['loggedIn']){

	header('Location: loginform.php');
}; 

//**********************************************************//
	//Required files
//**********************************************************//

require '../config/config.php';

require '../config/form_arrays.php';

require CLASS_PATH."html.class.php";


// Instantiate required classes
$db = new Db();

$html = new makeHTML();

$search = new makeform($searchform);

$mypdo = new mypdocrud(); 

//**********************************************************//
	//HTML Preparation
//**********************************************************//

$articles = $mypdo->get_sports_homepage_articles($query_latest_articles);

$menu = $mypdo->get_menu($menuquery);

echo $html->make_header(CSS_PATH."css/styles.css",'User Page');

?>

<div id="container" class="container container_left group">

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
    <p><date><?php echo date('l jS F Y'); ?></date></p>

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
    <ul>
    	<li><i class="fa fa-navicon"></i>&nbsp;MENU</li>
<?php echo $html->make_menu($menu, $_SESSION['user'][0]['username'])?>
    </ul>   	
    </nav>
    
   	<section class="userarea">
   		<h2 class="hide">user area</h2>
   		<h2>Welcome</h2>
   		<h3><?php echo $_SESSION['user'][0]['username']?></h3>

		<menu class="user_menu">
			<img src="<?php echo IMAGE_PATH.'user_image/'.$_SESSION['user'][0]['user_image_filename']?>" alt="userimage">
			<li><a href="logout.php">LOGOUT</a></li>
			<li><a href="editprofile.php">EDIT PROFILE</a></li>
		</menu>

		<menu class="user_tools">
			<h3>TOOLS</h3>
			<li><a href="submit_article.php"><i class="fa fa-newspaper-o fa-2x"></i>SUBMIT AN ARTICLE</a></li>
			<li><a href=" "><i class="fa fa-envelope-o fa-2x"></i>EMAIL EDITOR</a></li>
			<?php echo ($_SESSION['user'][0]['username']=='admin')? '<li><a href=" "><i class="fa fa-wrench fa-2x"></i>ADMIN TOOLS</a></li>'."\n" : " "?>
		</menu>

		<section class="articles_table">
		<h3>LATEST ARTICLES</h3>
		<table>
		<?php echo $html->make_article_rows($articles)?>
		</table>
		</section>

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
