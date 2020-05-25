<?php 

if ($_SESSION['ULogin'] != NULL){
    $_SESSION['AuthRedirAdress'] = 'index.php';
    echo "<h2> Привет, ".$_SESSION['ULogin']."</h2><br>";
    echo "
            <form class='form' action = ControlPanel.php method='POST'>
            <button type='submit' name='SubButton' class= 'button' value='Logout'>Выйти</button> </br>
            </form>
            ";
}
else {
    if($_SESSION['AuthFlag'] != NULL)
            echo '<br>'.$_SESSION['AuthFlag'];
    echo "
        <form class='form' action = ControlPanel.php method='POST'>
                <input type='text' name='QLogin' placeholder='Логин' maxlength='50' size='20'> </br>
                <input type='password' name='QPassword' placeholder='Пароль' maxlength='50' size='20'> </br>
                <button type='submit' name='SubButton' class= 'button' value='Authorize'>Войти</button>  
        </form>
        <h3><a href='Registration.php'>Регистрация</a></h3>
        ";

if(strpbrk($_SERVER['REQUEST_URI'],'/'))
    $currlink=explode('/',$_SERVER['REQUEST_URI']);
else
    $currlink=explode('\\',$_SERVER['REQUEST_URI']);

if ($filepath != "Registration")
    $currlink=$currlink[count($currlink)-1];
else
    $currlink="index.php";
$_SESSION['AuthRedirAdress']=$currlink;
if($_SESSION['AuthFlag'] != NULL) $_SESSION['AuthFlag'] = NULL;
}


?>