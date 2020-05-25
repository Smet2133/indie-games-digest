<?php 
include 'INC_DBM.php';

//echo $filepath;//задается на каждой странице,определяет,какой код включать и какой заголовок выводить
switch($filepath) {
	case "articles":
		$pagetitle="Статья";
		break;
	case "index" :
		$pagetitle="Главная";
		break;
	case "search":
		$pagetitle="Поиск";
		break;
	case "PersonalPage":
		$pagetitle="Личный кабинет";
		break;
	case "Registration":
		$pagetitle="Регистрация";
		break;
    case "artlist":
        $pagetitle="Список статей";
        break;
    case "addarticle":
        $pagetitle="Добавить статью";
        break;
    case "editarticle":
        $pagetitle="Редактировать статью";
        break;
}
echo "
	<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html' charset='utf-8'>
		<link rel='stylesheet' type='text/css' href='style.css'>
		<title>".$pagetitle."</title>
	</head>
	<body>  
		<table class='main'>
		<tr>
			<td id='c11' class='left'>
				<div class='d_edge'>
	";

include 'INC_Auth.php';
echo "			</div>
			</td>
		
		<td id='c12' class='center'>
			  <div class='d_forimg'> <img class='logo' src='images/Interface/InDLogo.gif'   width='420' alt='main'> </div>
		</td>
		
		<td id='c13'>
			<div class='d_edge'>
	";
include 'INC_Search.php';
echo "		</div>	
		</td>
	</tr>
	
	<tr>
		<td id='c21'>
			<h3><a href='index.php'>Главная страница</a></h3>
			<h3><a href='PersonalPage.php'>Личный кабинет</a></h3>
            <h3><a href='artlist.php'>Список статей</a></h3>
	";
if ($_SESSION['ULogin']!=NULL)
    echo '<h3><a href="addarticle.php">Добавить статью</a>';
$q = mysql_query("SELECT article_id
    FROM ".ArticlesTable."
    WHERE 1 ORDER BY RAND() LIMIT 1");
$str = mysql_fetch_assoc($q);
echo "<h3><a href='articles.php?aid=".$str['article_id']."'>Случайная статья</a></h3>";

if ($filepath == "articles") {
    $q = mysql_query("SELECT article_id
        FROM ".ArticlesTable."
        ORDER BY article_id LIMIT 1");		
    $str = mysql_fetch_assoc($q);
    $minid = $str['article_id'];

    $q = mysql_query("SELECT article_id
        FROM ".ArticlesTable."
        ORDER BY article_id DESC LIMIT 1");		
    $str = mysql_fetch_assoc($q);
    $maxid = $str['article_id'];

    if($aid <> $minid){		
        $q = mysql_query("SELECT article_id
            FROM ".ArticlesTable."
            WHERE article_id < ".$aid." ORDER BY article_id DESC LIMIT 1");
        $str = mysql_fetch_assoc($q);
        echo "<h3><a href='articles.php?aid=".$str['article_id']."'><img src='images/Interface/arrow_left.gif' class='nonebord' width=15 height=15> Предыдущая статья</a></h3>";	
    }

    if($aid <> $maxid){	
        $q = mysql_query("SELECT article_id
            FROM ".ArticlesTable."
            WHERE article_id > ".$aid." LIMIT 1");
        $str = mysql_fetch_assoc($q);
        echo "<h3><a href='articles.php?aid=".$str['article_id']."'>Следующая статья <img src='images/Interface/arrow_right.gif' class='nonebord' width=15 height=15></a></h3>";	
    }
}
echo "
		</td>
		
		<td id='c22' class='center' rowspan='2'> <div class='d22'>
	";
?>