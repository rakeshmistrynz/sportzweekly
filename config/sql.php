<?php 

//**********************************************************//
	//Prepared Sql Statements
//**********************************************************//

//Cat Query
$cat_query = "SELECT id, category_type_descp 
						FROM news_category_type";


//Menu query
$menuquery = "SELECT news_category_id, menu_name 
						FROM news_pages 
						WHERE  news_category_id < 7";

//Menu query
$page_title_query = "SELECT news_category_id, menu_name 
						FROM news_pages 
						WHERE  news_category_id =:id";

//Search query
$searchquery = "SELECT id, news_category_id, date_time_created, headline, article_text,
										MATCH (article_text, headline, news_category_name)
										AGAINST (:a) AS relevance 
										FROM news_articles
										WHERE MATCH (article_text, headline, news_category_name) AGAINST (:a) 
										AND approval_id > 2
										ORDER BY relevance DESC";


$mainartquery = "SELECT id, news_category_id, headline, article_text, date_time_created, article_image_filename 
								FROM news_articles 
								WHERE news_category_id=:id 
								AND approval_id=4
								ORDER BY date_time_created
								DESC LIMIT 1";



$sideartquery = "SELECT id, news_category_id, headline, article_text, date_time_created, article_image_filename 
								FROM news_articles 
								WHERE approval_id=3 
								AND news_category_id=:id 
								ORDER BY date_time_created 
								DESC LIMIT 4";


$mainart_homepage_query = "SELECT id, news_category_id, headline, article_text, date_time_created, article_image_filename 
											FROM news_articles 
											WHERE approval_id=4 
											ORDER BY date_time_created 
											DESC LIMIT 1"; 


$sideart_homepage_query = "SELECT id, news_category_id, headline, article_text, date_time_created, article_image_filename 
											FROM news_articles
											WHERE approval_id=3  
											ORDER BY date_time_created 
											DESC LIMIT 4";


$full_article_query = "SELECT id, news_category_id, headline, article_text, date_time_created, article_image_filename 
									FROM news_articles 
									WHERE id=:id"; 


$videoquery = "SELECT video_filename  
								FROM news_videos 
								WHERE page_id=:id";


$article_commentcount_query = "SELECT COUNT(news_comments.comment_text) AS commentcount
										FROM news_articles
										LEFT JOIN news_comments
										ON news_comments.article_id = news_articles.id
										WHERE news_articles.id =:id
										GROUP BY news_articles.id DESC";

$article_commentrow_query = "SELECT news_users.user_image_filename, news_users.username, news_comments.comment_text
									FROM news_comments
									LEFT JOIN news_users
									ON news_users.id = news_comments.user_id 
									WHERE news_comments.article_id = :id
									ORDER BY news_comments.date_time_created DESC
									LIMIT 10";
//Add comment to database
$dbQuery_add_comment = "INSERT INTO news_comments(article_id, comment_text, user_id) 
                      	VALUES(:article_id, :comment_text, :userid)";


$dbQuery_all_users = "SELECT username 
							FROM news_users";

//Registration Form queries
$dbQuery_user_info    =   "SELECT id, username, firstname, user_image_filename, user_type_id, news_category_id 
							FROM news_users 
							WHERE username =:user";


$sQuery_new_user = "INSERT INTO news_users(firstname, lastname, username, userpassword, email) 
                        VALUES(:firstname, :lastname, :username, :userpassword, :email)";  


$dbQuery_user_password = "SELECT userpassword 
							FROM news_users 
							WHERE username =:user";

//Edit profile queries
$dbQuery_user = "SELECT firstname, lastname, username, email 
							FROM news_users 
							WHERE id = :userID"; 


$sQuery_update_user = "UPDATE news_users 
							SET firstname=:firstname, lastname=:lastname, username=:username, email=:email 
                        	WHERE id = :userID";  

$sQuery_update_user_image = " UPDATE news_users 
							SET user_image_filename=:user_image_filename  
                        	WHERE id = :userID";  



$query_latest_articles = "SELECT id, news_category_id, date_time_created, headline
											FROM news_articles 
											WHERE approval_id=3 OR approval_id=4 
											ORDER BY date_time_created 
											DESC LIMIT 5";


//Insert article
$dbQuery_get_article_info = "SELECT id, news_category_id, headline, article_text, article_image_filename, approval_id
							FROM news_articles
							WHERE id = :id";

$dbQuery_insert_article = "INSERT INTO news_articles(user_id, news_category_id, headline, article_text, article_image_filename, approval_id) 
                        VALUES(:user_id, :news_category_id, :headline, :article_text, :article_image_filename, :approval_id)"; 


$sQuery_update_main = "UPDATE news_articles 
							SET approval_id = 3 
                        	WHERE news_category_id = :news_category_id AND approval_id = 4";

$dbQuery_update_article = "UPDATE news_articles
							SET news_category_id = :news_category_id, headline = :headline, article_text = :article_text, article_image_filename = :article_image_filename, approval_id = :approval_id
							WHERE id = :id";

 ?>