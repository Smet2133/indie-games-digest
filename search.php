<?php 

//этот кусок берет полный путь к файлу, забирает из него имя страницы и сохраняет для использования
//в INC_TOP_PART
if(strpbrk(__FILE__,'/'))
	$filepath=explode('/',__FILE__);
else
	$filepath=explode('\\',__FILE__);
$filepath=$filepath[count($filepath)-1];
$filepath=substr($filepath,0,strlen($filepath)-4);

include ('INC_TOP_PART.php');

$SULogin=&$_SESSION['ULogin'];
$SUID=&$_SESSION['UID'];
$urequest=$_POST['QSearch'];

//------------------------------------------------
echo"
	<h1 > Поиск  </h1>
	<form class='form' action = 'search.php' method='POST'>
	<input type='search' name='QSearch' placeholder='Искать' maxlength='50' size='50'> 
	<button type='submit' name='SubButton' class='button'  value='Search'>Найти</button> </br>
	</form>
	<h2 align='left' ><pre>    Результаты: </pre> </h2> </br>
	";

$q = mysql_query("SELECT article_id, name FROM ".ArticlesTable." WHERE name LIKE '%".$urequest."%'");
$str = mysql_fetch_row($q);
if($str == NULL || $urequest==NULL)
	echo '<p> По Вашему запросу ничего не найдено или запрос пустой </p>';
else {
	echo '<ol>';
	for ($i=0;$i<mysql_num_rows($q);$i++){
		echo "<li> <a href='articles.php?aid=".$str[0]."'>".$str[1]."</a> </li>";
		$str = mysql_fetch_row($q);	
	}
	echo '</ol>';
	
}
include('INC_BOTTOM_PART.php');
?>