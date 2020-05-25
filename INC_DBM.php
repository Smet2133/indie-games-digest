<?php 
	session_start();
	define ("DBUser","root",true);
	define ("DBHost","localhost",true);
	define ("DBPassword","",true);
	define ("DBName","indiedigest",true);
	define ("UsersTable","InDusers",true);
	define ("ArticlesTable","InDarticles",true);
	define ("CommentsTable","InDcomments",true);
	define ("FavArticlesTable","InDFavArticles",true);
	$connid = mysql_connect (DBHost,DBUser,DBPassword);
    if(!$connid)
        die("Подключение к базе не установлено.");
	mysql_select_db (DBName,$connid);				
?>