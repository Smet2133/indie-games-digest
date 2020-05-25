<?php 

//этот кусок берет полный путь к файлу, забирает из него имя страницы и сохраняет для использования
//в INC_TOP_PART
if(strpbrk(__FILE__,'/'))
	$filepath=explode('/',__FILE__);
else
	$filepath=explode('\\',__FILE__);
$filepath=$filepath[count($filepath)-1];
$filepath=substr($filepath,0,strlen($filepath)-4);

include('INC_TOP_PART.php');

$_SESSION['ULogin'] = NULL;

//------------------------------------------------
if($_SESSION['RegFlag'] == 1){
	echo ' OK! ';
	echo '<p><a href="index.php">Главная страница</a></p>';
	unset($_SESSION['RegFlag']);
}
else {
	echo '
		<form class="form" method="post" action="ControlPanel.php">
		<input type="text" name="QLogin" placeholder="Логин" pattern="[a-zA-Z\_\-\s0-9]{3,30}" size="20">  </br>
		<input type="password" name="QPassword" placeholder="Пароль" pattern="[a-zA-Z\_\-0-9]{3,30}" size="20">  </br>
		<input type="email" name="QEMail" placeholder="Email" pattern="^[A-Za-z0-9._-]{1,}+@[A-Za-z0-9.-]{1,7}+\.[A-Za-z]{2,4}$" size="20"> </br>
		<input type="text" name="QName" placeholder="Имя" maxlength="50" size="20"> </br>
		<input type="text" name="QSname" placeholder="Фамилия" maxlength="50" size="20"> </br>
		<input type="text" name="QCountry" placeholder="Страна" maxlength="50" size="20"> </br>
		<input type="date" name="QBdate" placeholder="Дата рождения" maxlength="50" size="20"> </br>
		<button type="submit" name="SubButton" class="button" value="Conf">Зарегистрироваться</button> </br>
        ';
	echo '<h1>'.$_SESSION['RegFlag'].'</h1>';
}
//------------------------------------------------
include('INC_BOTTOM_PART.php');
?>