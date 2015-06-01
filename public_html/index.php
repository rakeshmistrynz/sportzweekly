<?php

/**
 * @author Rakesh Mistry
 * Render Index Page
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

// Instantiate required classes
$db = new Db();

$html = new makeHTML();

$search = new makeform($searchform);

$mypdo = new mypdocrud(); 


//Set Global Variables - Sports Category ID
$sportsCatid = (isset($_GET['sports_category']) && is_numeric($_GET['sports_category']))? $_GET['sports_category']:1;
	
//**********************************************************//
	//Get Articles from DB
//**********************************************************//

//Get Sports page main articles
$main_article = $mypdo->get_sports_page_articles($sportsCatid, $mainartquery);

//Get Sports page side articles
$side_article = $mypdo->get_sports_page_articles($sportsCatid, $sideartquery);

//Get Home page main
$home_page_main_article = $mypdo->get_sports_homepage_articles($mainart_homepage_query);

//Get Home page side articles	
$home_page_side_article = $mypdo->get_sports_homepage_articles($sideart_homepage_query); 

//Get Page Title
$page_title = $mypdo->get_sports_page_article_info($sportsCatid, $page_title_query);

//Get Video
$sports_video = $mypdo->get_sports_video($sportsCatid, $videoquery);

//**********************************************************//
	//HTML Presentation 
//**********************************************************//

$menu = $mypdo->get_menu($menuquery);

echo $html->make_header(CSS_PATH."css/styles.css",'SportzWeekly Latest News');

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
		<li id="reset"><a href=" ">RESET MENU</a></li>
    </ul>   	
    </nav>
    
    <div class="article_container">
    <main>
	<h2><?php echo $html->make_page_title($page_title)?></h2>
<?php echo $main = ($_GET['sports_category']>1)?$html->make_main_article($main_article):$html->make_main_article($home_page_main_article)?>
<?php echo $html->make_video($sports_video)?>
<?php echo $side = ($_GET['sports_category']>1)?$html->make_side_article($side_article):$html->make_side_article($home_page_side_article) ?>
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