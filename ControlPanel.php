<?php
	include('INC_DBM.php');
	
	$qlogin=trim($_POST['QLogin']);
	$qpassword=trim($_POST['QPassword']);
	$qemail=trim($_POST['QEMail']);
	$qname=trim($_POST['QName']);
	$qsname=trim($_POST['QSname']);
	$qcountry=trim($_POST['QCountry']);
	$qbdate=$_POST['QBdate'];
	$qaid=$_POST['QAID'];
	$AuthFlag=&$_SESSION['AuthFlag'];
	$SULogin=&$_SESSION['ULogin'];
	$SUID=&$_SESSION['UID'];
	
	$checkb=$_POST['checkb'];
	$_SESSION['DelFaFlag'] = 0;
	
	if (!mysql_query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE table_scheme = '".DBName."' AND TABLE_NAME = '".UsersTable."' "))
		mysql_query("CREATE TABLE ".UsersTable."(
                                                       user_id INT NOT NULL AUTO_INCREMENT,
                                                       login TINYTEXT NOT NULL,
                                                       password TINYTEXT NOT NULL,
                                                       email TINYTEXT NOT NULL,
                                                       name TINYTEXT, surname TINYTEXT,
                                                       country TINYTEXT, birthdate DATE,
                                                       PRIMARY KEY (user_id))"
                    );
	if (!mysql_query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE table_scheme = '".DBName."' AND TABLE_NAME = '".ArticlesTable."' "))
		mysql_query("CREATE TABLE ".ArticlesTable."(
                                                        article_id INT NOT NULL AUTO_INCREMENT,
                                                        name TINYTEXT NOT NULL,
                                                        text MEDIUMTEXT NOT NULL,
                                                        poster_id INT NOT NULL,
                                                        date DATETIME NOT NULL,
                                                        main_img_link TINYTEXT NOT NULL,
                                                        PRIMARY KEY (article_id))"
                    );
	if (!mysql_query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE table_scheme = '".DBName."' AND TABLE_NAME = '".CommentsTable."' "))
		mysql_query("CREATE TABLE ".CommentsTable."(
                                                        comment_id INT NOT NULL AUTO_INCREMENT,
                                                        date DATETIME NOT NULL,
                                                        author_login TINYTEXT NOT NULL,
                                                        title TINYTEXT,
                                                        text MEDIUMTEXT NOT NULL,
                                                        article_id INT NOT NULL,
                                                        PRIMARY KEY (comment_id))"
                    );
	if (!mysql_query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE table_scheme = '".DBName."' AND TABLE_NAME = '".FavArticlesTable."' "))
		mysql_query("CREATE TABLE ".FavArticlesTable."(
                                                        login TINYTEXT NOT NULL,
                                                        article_id INT NOT NULL)"
                    );
	
	function EchoTable($tablename)
	{
		$q=mysql_query("SELECT * FROM $tablename");
		$d=mysql_query("DESCRIBE $tablename");
		echo "<b>$tablename</b>";
		echo "<table border='1px' float='left'><tr>";
		for ($i=0;$i<mysql_num_rows($d);$i++)
		{
			$r=mysql_fetch_row($d);
			echo "<td>".$r[0]."</td>";
		}
		echo "</tr>";
		for ($i=0;$i<mysql_num_rows($q);$i++)
		{
			echo "<tr>";
			foreach (mysql_fetch_row($q) as $keys =>$values) echo "<td>$values</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	function CheckLogin($login)
	{
		if($login!=NULL)
			{
				$q=mysql_query("SELECT * FROM ".UsersTable." WHERE login='$login'");
				return mysql_fetch_row($q)!=NULL;
				
			}
		return false;
	}
	function CheckLogPass($login,$password)
	{
		$q=mysql_query("SELECT * FROM ".UsersTable." WHERE login='$login' AND password='".md5($password)."'");
		return mysql_fetch_row($q)!=NULL;
	}
	switch($_POST['SubButton'])
	{
		case "Add":
			if($qlogin!='' && $qpassword!='' && $qemail!='')
				if (!CheckLogin($qlogin))
					mysql_query("INSERT INTO ".UsersTable."(login,password,email) VALUES ('$qlogin','".md5($qpassword)."','$qemail');");
				else
					echo "Логин уже занят!<br>";
			else
				echo "Заполните все поля!";
			break;
		case "Conf":
			if($qlogin!='' && $qpassword!='' && $qemail!='')
				if (!CheckLogin($qlogin)) {
							mysql_query("INSERT INTO ".UsersTable."(login,password,email,Name,Surname,Country,Birthdate) VALUES ('$qlogin','".md5($qpassword)."','$qemail','$qname','$qsname','$qcountry','$qbdate');");
							$_SESSION['RegFlag'] = '1';
							header("Location: Registration.php"); /* Redirect browser */
							exit;
                }
				else
					$_SESSION['RegFlag'] = 'Login already exists!';
			else
				$_SESSION['RegFlag'] = 'Fill in all fields!';
			header("Location: Registration.php");  
			exit;
			break;
		case "Register":
			if($qlogin!='' && $qpassword!='' && $qemail!='')
				if (!CheckLogin($qlogin))
					{
					mysql_query("INSERT INTO ".UsersTable."(login,password,email) VALUES ('$qlogin','".md5($qpassword)."','$qemail');");
					header("Location: Reg.php?Result=Successfully registered!");
					exit;
					}
				else
					{
					header("Location: Reg.php?Result=Login already exists!");
					exit;
					}
			else
				{
				header("Location:Reg.php?Result=Fill in all the fields!");
				exit;
				}
			break;
		case "Remove":
			if($qlogin != NULL)
				mysql_query("DELETE FROM ".UsersTable." WHERE login='$qlogin'");
			break;
		case "CheckLogin":
			if(CheckLogin($qlogin))
				echo "Логин существует<br>";
			else 
				echo "В базе нет такого логина<br>";
			break;
		case "ClearAll":
			mysql_query("DELETE FROM ".UsersTable."");
			break;
		case "CheckLogPass":
			if (CheckLogPass($qlogin,$qpassword))
				echo "Pair found<br>";
			else
				echo "No such pair in the DB<br>";
			break;
		case "Logout":
			foreach($_SESSION as $keys => $values)
				unset($_SESSION[$keys]);
			header("Location:index.php");
			exit;
			break;
		case "Authorize":
			if (CheckLogPass($qlogin,$qpassword))
				{
				$SULogin = $qlogin;
				$q=mysql_query("SELECT user_id FROM ".UsersTable." WHERE login = '$qlogin'");
				$q=mysql_fetch_assoc($q);
				$SUID= $q['user_id'];
				$AuthFlag = '';
				header("Location:".$_SESSION['AuthRedirAdress']."");
				exit;
				}
			else
				{
				$SULogin = NULL;
				$AuthFlag="Такого пользователя нет в базе";
				header("Location:index.php");
				}
			break;
		case "RemoveFA":
			if($qlogin !=NULL)
				mysql_query("DELETE FROM ".FavArticlesTable." WHERE login='$qlogin' AND article_id='$qaid'");
			break;
		case "FA_RemoveFA":
			if($SULogin!=NULL){
				foreach ($checkb as $keys =>$values)
					mysql_query("DELETE FROM ".FavArticlesTable." WHERE login='$SULogin' AND article_id='$values'");
				$_SESSION['DelFaFlag'] = 1;
				header("Location: PersonalPage.php"); /* Redirect browser */
				exit;
			}
			break;
		case  "AddFA":
			if($qlogin !=NULL && $qaid!=NULL)
				mysql_query("INSERT INTO ".FavArticlesTable." (login, article_id) VALUES('$qlogin','$qaid');");
			break;
	}
	echo "
		<html>
		<head>
            <title>ControlPanel</title>
            <meta http-equiv='Content-Type' content='text/html' charset='utf-8'>
        </head>
		<body>
		";
	echo "
		<form class='form' action = 'ControlPanel.php' method='POST'>
		<b>".UsersTable."</b>
		<table>
		<tr>
			<td>Login: 		<input type='text' name='QLogin'></td>
			<td>Password:   <input type='text' name='QPassword'></td>
			<td>EMail: 		<input type='text' name='QEMail'></td>
		</tr>
		<tr>
			<td><input type='submit' name = 'SubButton' value='Add'></td>
			<td><input type='submit' name = 'SubButton' value='Remove'></td>
			<td><input type='submit' name = 'SubButton' value='CheckLogin'></td>
			<td><input type='submit' name = 'SubButton' value='ClearAll'></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
            <td><input type='submit' name = 'SubButton' value='CheckLogPass'></td>
		</tr>
		</table>
		</form>
		";
	echo "
		<form class='form' action = 'ControlPanel.php' method='POST'>
		<b>".FavArticlesTable."</b>
		<table>
		<tr>
			<td>Login:      <input type='text' name='QLogin'></td>
			<td>Article ID: <input type='text' name='QAID'></td>
		</tr>
		<tr>
			<td><input type='submit' name = 'SubButton' value='AddFA'></td>
			<td><input type='submit' name = 'SubButton' value='RemoveFA'></td>
		</tr>
		</table>
		</form>
		";
	EchoTable(UsersTable);
	EchoTable(CommentsTable);
	EchoTable(ArticlesTable);
	EchoTable(FavArticlesTable);
	echo "
		</body>
		</html>
		";
	mysql_close($connid);
?>