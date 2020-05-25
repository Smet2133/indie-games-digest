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

$SULogin=&$_SESSION['ULogin'];
$SUID=$_SESSION['UID'];
$qlogin=$_POST['QLogin'];
$qpassword=$_POST['QPassword'];
$qemail=$_POST['QEMail'];
$qname=$_POST['QName'];
$qsname=$_POST['QSname'];
$qcountry=$_POST['QCountry'];
$qbdate=$_POST['QBdate'];

//------------------------------------------------
function CheckLogin($login)	{
	if($login!=NULL)
		{
			$q=mysql_query("SELECT * FROM ".UsersTable." WHERE login='$login'");
			return mysql_fetch_row($q)!=NULL;
		}
	return false;
}
	
	$db_users_fields = array ('email','Name','Surname','Country','Birthdate');
	$db_new_values = array ($qemail,$qname,$qsname,$qcountry,$qbdate);
	if($_POST['SubButton'] == 'FA_ChangeU') {
		if($qlogin != '')
			if(!CheckLogin($qlogin) && preg_match('/^[a-zA-Z\_\- 0-9]{3,30}$/iu',$qlogin)){
			mysql_query("UPDATE ".UsersTable."
							SET login='$qlogin'
							WHERE login='$SULogin';");
			mysql_query("UPDATE ".FavArticlesTable."
							SET login='$qlogin'
							WHERE login='$SULogin';");
			mysql_query("UPDATE ".CommentsTable."
							SET author_login='$qlogin'
							WHERE author_login='$SULogin';");				
			$_SESSION['ULogin'] = $qlogin;						
			}
		else echo '<h3> Login EXISTS or INCORRECT! </h3>';
		
		if($qpassword!='')
			if (preg_match('/^[a-zA-Z\_\-0-9]{3,30}$/iu',$qpassword))
				mysql_query("UPDATE ".UsersTable."
								SET password='$qpassword'
								WHERE login='$SULogin';");
			else
				echo '<h3>Incorrect password!</h3>';
		
		foreach($db_users_fields as $keys => $values){
			if($db_new_values[$keys] != '')
				switch($values) {
					case 'email': 
						if(preg_match('/^[a-z0-9_\.\-]+@([a-z0-9\-]+\.)+[a-z]{2,4}$/is',$db_new_values[$keys]))
							mysql_query("UPDATE ".UsersTable."
									SET ".$values."='".$db_new_values[$keys]."'
									WHERE login='$SULogin';");
						else
							echo '<h3>Incorrect E-mail!</h3>';
					break;
					case 'Name':
					case 'Surname':
					case 'Country':
						mysql_query("UPDATE ".UsersTable."
									SET ".$values."='".$db_new_values[$keys]."'
									WHERE login='$SULogin';");
					break;
					case 'Birthdate':
						if ((substr($qbdate,0,4) >= (date("Y")-120)) && (substr($qbdate,0,4) <= date("Y")))
							mysql_query("UPDATE ".UsersTable."
									SET ".$values."='".$db_new_values[$keys]."'
									WHERE login='$SULogin';");
						else
							echo '<h3>Incorrect B-date!</h3>';
					break;					
				}	
		}
	}
				
	if($SULogin == NULL) {
		echo '<h1> Пожалуйста, авторизуйтесь </h1>';
		include 'INC_Auth.php';
		$_SESSION['RedirToPP'] = 1;
	}
	else{
	
		echo '<h1> Личный кабинет </h1>';
		echo '<h2> Ваши данные: </h2>';
		
		$q = mysql_query("SELECT * FROM ".UsersTable." WHERE login='$SULogin'");
		$str = mysql_fetch_row($q);
		/* Пароль звёздами */
		$str[2] = '*****';
		$tab = array('Логин', 'Пароль', 'E-mail', 'Имя', 'Фамилия', 'Страна', 'День рождения');
		$names = array ('QLogin', 'QPassword', 'QEMail', 'QName', 'QSname', 'QCountry', 'QBdate');
		$types = array ('text', 'password', 'email', 'text', 'text', 'text', 'date');
		
		echo "<form class='form' action = 'PersonalPage.php' method='POST'>
			<table  class='pers'>";
		
		for ($i=0;$i<mysql_num_fields($q)-1;$i++){
			$ii = $i + 1;	
			echo "
				<tr>
					<td class='ppnoneri'>".$tab[$i]." :</td>
					<td class='ppnone'>".$str[($i+1)]."</td>
					<td class='ppnone'> <input type='".$types[$i]."' name='".$names[$i]."' maxlength='50' size='20'> </td> 
				</tr>
				";
		}
		
		echo "
			<tr>
				<td class='none'></td>
				<td class='none'></td>
				<td class='ppnone'><button type='submit' name='SubButton' class='button' value='FA_ChangeU'>Изменить</button></td>
			</tr>
			</table>
			</form>
			";
		
		
		$artnumber = mysql_query("SELECT COUNT(*) FROM ".FavArticlesTable." WHERE login='$SULogin'");
		$artnumber = mysql_fetch_row($artnumber);
		$artnumber = $artnumber[0];
		
		if($artnumber > 0){
			echo '<h2> Ваши избранные статьи: </h2>';
			$q = mysql_query("SELECT  at.main_img_link, at.name, at.article_id
								FROM  ".FavArticlesTable."  ft
								INNER JOIN  ".ArticlesTable." at  ON ft.article_id = at.article_id
								WHERE ft.login='$SULogin' ");
								
			/*echo "<table border='1px' float='left'><tr><td>img</td><td>name</td><td>id</td></tr>";
			for ($i=0;$i<mysql_num_rows($q);$i++){
				echo "<tr>";
				foreach (mysql_fetch_row($q) as $keys =>$values) echo "<td>$values</td>";
				echo "</tr>";
			}
			echo '</table>';
			*/
            echo "
                    <table class='pers'>
                    <form class='form' action = 'ControlPanel.php' method='POST'>";
			for ($i=0;$i<mysql_num_rows($q);$i++){
				$str = mysql_fetch_row($q);
				echo "
                    <tr>
                        <td class='nonebord'><p>".($i+1).".</td>
                        <td class='nonebord'><a href='articles.php?aid=".$str[2]."'><img src='".$str[0]."'width='220' alt='main'></a></p></td>
                        <td class='nonebord'><a href='articles.php?aid=".$str[2]."'>".$str[1]."</a></td>
                        <td class='nonebord'><input type='checkbox' name='checkb[]' value='".$str[2]."'>Удалить из избранного</td>
                    </tr>
                    ";
			}
			echo '
				<tr>
					<td class="nonebord"></td>
					<td class="nonebord"></td>
					<td class="nonebord"></td>
					<td class="nonebord"><button type="submit" class="button" name="SubButton" value="FA_RemoveFA">Удалить выделенные</button></td>
				</tr>
				</table>
				';	
		}
			
		if($_SESSION['DelFaFlag'] == 1){
			echo '<h2> Successfuly deleted! </h2>';
			$_SESSION['DelFaFlag'] = 0;
		}
        
        $artnumber = mysql_query("SELECT COUNT(*) FROM ".ArticlesTable." WHERE poster_id='$SUID'");
		$artnumber = mysql_fetch_row($artnumber);
		$artnumber = $artnumber[0];
        
        if ($artnumber>0){
            $q=mysql_query("SELECT main_img_link,name,article_id FROM ".ArticlesTable." WHERE poster_id='$SUID'");
            echo '
                <h2>Статьи, опубликованные Вами:</h2>
                <table class="pers">
                ';
            for ($i = 0; $i < mysql_num_rows($q); $i++) {
                $row=mysql_fetch_row($q);
                echo '
                    <tr>
                        <td>'.($i+1).'.</td>
                        <td><a href = "articles.php?aid='.$row[2].'"><img src="'.$row[0].'" width="220"></a></td>
                        <td><a href = "articles.php?aid='.$row[2].'">'.$row[1].'</a></td>
                    </tr>
                    ';
            }
            echo '</table>';
        }
	}
//------------------------------------------------
include('INC_BOTTOM_PART.php');
?>