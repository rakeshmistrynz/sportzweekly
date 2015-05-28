<?php

/**
 * @author Rakesh Mistry
 * General HTML class. Contains a range of method for creating HTML.
 */

class makeHTML{

	/**
	 * makes a css link tag - used by make_header method below. 
	 * @param  string $href location to style sheet. 
	 * @return string       HTML code
	 */
	function make_css_tag($href){

	return '<link rel="stylesheet" type="text/css" href="'.$href.'">'."\n";

	}// End of make_css_tag

	/**
	 * makes a HTML head with a body tag. 
	 * @param  string $csshref  link to css style sheet
	 * @param  string $title    title of page
	 * @return sting           HTML code
	 */
	function make_header($csshref, $title){
	
	$header_row  = '';
	$header_row .= '<!DOCTYPE html>'."\n";
	$header_row .= '<html lang="en">'."\n";
	$header_row .= '<head>'."\n";
	$header_row .= "\t".'<meta charset="UTF-8">'."\n";
	$header_row .= "\t".'<meta http-equiv="X-UA-Compatible" content="IE=edge">'."\n";
	$header_row .= "\t".'<title>'.$title.'</title>'."\n";
	$header_row .= "\t".'<meta name="description" content=" ">'."\n";
	$header_row .= "\t".'<meta name="viewport" content="width=device-width, initial-scale=1">'."\n";
	$header_row .= "\t".$this->make_css_tag($csshref);
	$header_row .= "\t".'<script src="http://rakeshmistry.co.nz/jslibs/modernizr-2.6.2.min.js"></script>'."\n";
	$header_row .= "</head>"."\n";
	$header_row .= '<body>'."\n";

	return $header_row;

	}//End of make_header

	function make_page_title($array){

		$title = strtoupper($array[0]['menu_name']);

		return $title;

	}

	/**
	 * Makes list items for a menu, using information from a database
	 * @param  array $array tablulated data from database
	 * @return string        HTML list of menu items
	 */
	function make_menu($array, $user){
	
	$li_row = '';

	$user_name = "\t".'<li><a href="userpage.php" class="login">LOGIN IN</a></li>'."\n";

	if($user){

		$user_name = "\t".'<li><a href="userpage.php" class="login">USER PAGE</a></li>'."\n";
		$user_name .= "\t".'<li><a href="logout.php" class="login">LOGOUT</a></li>'."\n";
	};
	
		foreach($array as $key=>$value){
		
			$li_row .= "\t".'<li>';
			$li_row .= '<a href="index.php?sports_category='.$value[0].'">';
			$li_row .= strtoupper($value[1])."</a></li>"."\n";
		};

	return $li_row.$user_name;

	}


	/**
	 * Makes HTML containers to display a feature article on a sports website.
	 * $synop takes whole article text, explodes it into an array of sentences. 
	 * @param  array $array data from a a database
	 * @return string        HTML
	 */
	function make_main_article($array){
		
		$news_item = '';
		
		foreach($array as $key=>$value){
			
			$date_format = date('jS M Y', strtotime($value[3]));
			$synop = explode(".",$value[3]);
			
			$news_item .= "\t".'<article class="main_article group">'."\n";
			$news_item .= "\t".'<h2>'.$value[2].'</h2>'."\n";
			$news_item .= "\t".'<img src="public/images/article_images/'.$value[5].'" alt="main image">'."\n";
			$news_item .= "\t".'<p>'.$synop[0].'.'.$synop[1].'.</p>'."\n";
			$news_item .= "\t".'<p><a href="index_article.php?sports_category='.$value[1].'&amp;article_id='.$value[0].'" class="myButton">READ MORE</a></p>'."\n";
			$news_item .= "\t".'</article>';
				
		}
		
	return $news_item;
			
	}

	 /** Makes HTML containers to display a side articles on a sports website.
	 * $synop takes whole article text, explodes it into an array of sentences. 
	 * @param  array $array data from a a database
	 * @return string        HTML
	 *
	 */
	function make_side_article($array){
		
		$news_item = '';
		
		foreach($array as $key=>$value){
			
			$date_format = date('jS M Y', strtotime($value[3]));
			$synop = explode(".",$value[3]);
			
			$news_item .= "\t".'<article class="side_article group">'."\n";
			$news_item .= "\t".'<h3>'.$value[2].'</h3>'."\n";
			$news_item .= "\t".'<img src="public/images/article_images/'.$value[5].'" alt="main image">'."\n";;
			$news_item .= "\t".'<p>'.$synop[0].'.</p>'."\n";;
			$news_item .= "\t".'<p><a href="index_article.php?sports_category='.$value[1].'&amp;article_id='.$value[0].'" class="myButton">READ MORE</a></p>'."\n";
			$news_item .= "\t".'</article>'."\n";			
		}
		
	return $news_item;
			
	}


	function make_video($array){
		
		$news_item = '';
		
		foreach($array as $key=>$value){
			
			$news_item .= "\t".'<article id="'.$value[0].'" class="side_article video group">'."\n";
			$news_item .= "\t".'<h3>Latest Video Highlights</h3>'."\n";
			$news_item .= "\t".'<img src="https://img.youtube.com/vi/'.$value[0].'/0.jpg" alt="video image" id="video_image">'."\n";
			$news_item .= "\t".'<p><i class="fa fa-play-circle">PLAY</i></p>'."\n";
			$news_item .= "\t".'</article>'."\n";			
		}
		
	return $news_item;
			
	}

	/**
	 * Make HTML Container for full article on index_article.php. 
	 * @param  array $array article info
	 * @return string        HTML
	 */
	function makefullarticle($array, $admin){

		$edit_article = ' ';

		$news_item = '';

		if($admin){

		$edit_article = '<p><a href="edit_article.php?article_id='.$array[0][0].'">EDIT</a></p>';

		}

		foreach ($array as $key => $value) {

			$date1 = date('d-m-y', strtotime($value[4]));
			$date2 = date('jS F Y', strtotime($value[4]));

			$news_item .= "\t".'<article class="full_article">'."\n";
			$news_item .= "\t".'<h2 id="headline">'.$array[0][2].'</h2>'."\n";
			$news_item .= "\t".'<img src="public/images/article_images/'.$array[0][5].'" alt="main image">'."\n";
			$news_item .= "\t".'<p>'.$date2.'</p>'."\n";
			$news_item .= "\t".'<p class="article_text">'.nl2br($array[0][3]).'</p>'."\n";
			$news_item .= "\t".'<p>Author: Sportsfan</p>'."\n";
			$news_item .= "\t".$edit_article."\n";
			$news_item .= "\t".'</article>'."\n";
		}
		return $news_item;

	}


	 /* Make HTML table rows to display user comment on an side articles on a sports website.
	 * @param  array $array data from a a database
	 * @return string        HTML
	 */
	function make_comment_row($array){
		
		$a = '';
		
		foreach($array as $key=>$value){
			
		$a.= "\t".'<tr>';
		$a.= '<td><img src="public/images/user_image/'.$value[0].'" alt="main image"><p>'.$value[2].'</p></td>';
		$a.= '</tr>'."\n";
		$a.= "\t".'<tr>';
		$a.= '<td><p>'.$value[1].'</p></td>';
		$a.= '</tr>'."\n";

		}
		
	return $a;
			
	}

	 /* Make HTML table rows to display search results for sports articles on a sports website.
	 * @param  array $array data from a a database
	 * @return string        HTML
	 */
	function make_search_row($array){
		
		$searchrow = '';

		if(count($array)>0){
		
			$searchrow.='<tr><p>Results for '.$_SESSION['search'].'</p></tr>';
			$searchrow.='<tr><td><p>ARTICLE</p></td><td><p>DATE</p></td>';

			foreach($array as $key=>$value){
		
			$date_format = date('jS M Y', strtotime($value[2]));

			$searchrow.='<tr>';
			$searchrow.='<td><a href="index_article.php?sports_category='.$value[1].'&article_id='.$value[0].'">'.$value[3].'</a></td>';
			$searchrow.='<td>'.$date_format.'</td>';
			$searchrow.='</tr>';

			}

		}else{

			$searchrow.= '<tr><td>No results for '.$_SESSION['search'].'</td></tr>';
		}

	return $searchrow;
			
	}
	

	/**
	 * Make a table of the latest articles 
	 * @param  array $array article information
	 * @return string        HTML
	 */
	function make_article_rows($array){
		
		$articlerow = '';
		$articlerow = '<tr><td><p>ARTICLE</p></td><td><p>DATE</p></td></tr>'."\n";
		
		foreach($array as $key=>$value){
			
			$date_format = date('d\/m\/y', strtotime($value[2]));

			$articlerow.= "\t\t".'<tr>';
			$articlerow.='<td><a href="index_article.php?sports_category='.$value[1].'&article_id='.$value[0].'">'.$value[3].'</a></td>';
			$articlerow.='<td>'.$date_format.'</td>';
			$articlerow.='</tr>'."\n";

		}
		
	return $articlerow;
			
	}

	/* Make HTML to display a login area below comments on a sports article on a sports website.
	 * @return string        HTML code 
	 */
	function make_login_area(){


		$login_area='';

		 $login_area.='<div class="login_area group">';
		 $login_area.='<p>Have your say</p>';
		 $login_area.='<a class="login_button" href="loginform.php">SIGN UP</a>';
		 $login_area.='</div>';

		return $login_area; 

	}
	/**
	 * Makes an HTML footer
	 * @return string HTML code for a footer and closing body tag
	 */
	function make_footer(){

	$footer_row='';

	$footer_row.='</div>'."\n";

	$footer_row.='<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>'."\n";

	$footer_row.='<script>window.jQuery || document.write(\'<script src="http://rakeshmistry.co.nz/jslibs/jquery-1.10.2.min.js"><\/script>\')</script>'."\n"; 

	$footer_row.='<script src="public/js/index.js" type="text/javascript"></script>'."\n";

	$footer_row.='</body>'."\n".'</html>';

	return $footer_row;

	}

}// EOF - End of HTML.class

?>