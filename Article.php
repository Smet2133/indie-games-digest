<?php
	include('INC_DBM.php');
	
	$aname=trim(htmlspecialchars($_POST['AName'],ENT_QUOTES));
	$atext=trim(htmlspecialchars($_POST['AText'],ENT_QUOTES));
	$aimg=$_POST['AIMG'];
	$aid=$_POST['AID'];
	$poster_id=$_SESSION['UID'];
    $uploadfolder = 'images/';
    $uploaddir = $uploadfolder . $aname.".jpg";
	
	switch($_POST['SubButton'])
	{
		case "Add":
            $q=mysql_query("SELECT name FROM ".ArticlesTable." WHERE name='$aname';");
            $q=mysql_fetch_assoc($q);
			if($atext!='' && $aname!='' && $q==NULL)
			{
				$fp=fopen('Articles/'.$aname.'.txt','w');
				fwrite($fp,$atext);
				fclose($fp);
				$currdatetime = date("Y-m-d H:i:s"); 
				mysql_query("INSERT INTO ".ArticlesTable."(name,poster_id,date,main_img_link) VALUES ('$aname','$poster_id','$currdatetime','$aimg');");
			}
			else
				echo "Fill in the text!";
			break;
		case "Remove":
			if($aid != NULL)
            {
                $q=mysql_query("SELECT name FROM ".ArticlesTable." WHERE article_id='$aid';");
                $q=mysql_fetch_row($q);
                $q=$q[0];
				mysql_query("DELETE FROM ".ArticlesTable." WHERE article_id='$aid'");
                //unlink('Articles/'.$q.'.txt');
                //unlink('images/'.$q.'.txt');
            }
			break;
		case "ClearAll":
			mysql_query("DELETE FROM ".ArticlesTable."");
			break;
        case "AddUserArticle":
            $q=mysql_query("SELECT name FROM ".ArticlesTable." WHERE article_id='$aid';");
            $q=mysql_fetch_assoc($q);
			if($q==NULL)
                if (is_uploaded_file($_FILES['ArticleIMGFile']['tmp_name']) && $_FILES['ArticleIMGFile']['type'] == "image/jpeg" && $_FILES['ArticleIMGFile']['size']<5242880){
                    if (move_uploaded_file($_FILES['ArticleIMGFile']['tmp_name'], $uploaddir)) {
                        $_SESSION['ArtAddMessage']= "Статья добавлена!";
                    }
                    else {
                        $_SESSION['ArtEditMessage']= "При добавлении статьи возникла ошибка!";
                    }
                $fp=fopen('Articles/'.$aname.'.txt','w');
                fwrite($fp,$atext);
                fclose($fp);
                $currdatetime = date("Y-m-d H:i:s"); 
                mysql_query("INSERT INTO ".ArticlesTable."(name,poster_id,date,main_img_link) VALUES ('$aname','$poster_id','$currdatetime','$uploaddir');");
                }
                else {
                    $_SESSION['ArtAddMessage']="Во время загрузки изображения произошла ошибка!";
                }
            else
                $_SESSION['ArtAddMessage']="Статья с таким именем уже существует!";
            //header("Location:addarticle.php?confirm=true");
            //exit;
            break;
        case "EditArticle":
            $q=mysql_query("SELECT name FROM ".ArticlesTable." WHERE article_id='$aid';");
            $q=mysql_fetch_assoc($q);
            rename('Articles/'.$q['name'].'.txt','Articles/'.$aname.'.txt');
            $fp=fopen('Articles/'.$aname.'.txt','w');
            fwrite($fp,$atext);
            fclose($fp);
            $currdatetime = date("Y-m-d H:i:s"); 
            if (is_uploaded_file($_FILES['ArticleIMGFile']['tmp_name']) && $_FILES['ArticleIMGFile']['size']<5242880){
                unlink('images/'.$q[name].'.jpg');
                if (move_uploaded_file($_FILES['ArticleIMGFile']['tmp_name'], $uploaddir)) {
                    $_SESSION['ArtEditMessage']="Статья обновлена!";
                }
                else {
                    $_SESSION['ArtEditMessage']="При обновлении статьи возникла ошибка!";
                }
                mysql_query("UPDATE ".ArticlesTable." SET name='$aname', poster_id='$poster_id',date='$currdatetime',main_img_link='$uploaddir' WHERE article_id='$aid'");
            }
            else {
                mysql_query("UPDATE ".ArticlesTable." SET name='$aname', poster_id='$poster_id',date='$currdatetime' WHERE article_id='$aid'");
            }   
            header("Location:editarticle.php?confirm=true");
            exit;
            break;
	}
	echo "
        <html>
        <head>
            <title>Article</title>
            <meta http-equiv='Content-Type' content='text/html' charset='utf-8'>
        </head>
        <body>
            <form action = 'Article.php' method='POST'>
            <table>
            <tr>
                <td>Article ID: <input type = 'text' name='AID'></td>
                <td>Name:       <input  type='text' name='AName' pattern='[A-Za-z\s\-_0-9]{3,}'></td>
                <td>Text:       <textarea  rows='10' cols='30' maxlength='5000' name='AText'></textarea></td>
                <td>Main IMG:   <input type='text' name='AIMG'></td>
            </tr>
            <tr>
                <td><input type='submit' name = 'SubButton' value='Add'></td>
                <td><input type='submit' name = 'SubButton' value='Remove'></td>
                <td><input type='submit' name = 'SubButton' value='ClearAll'></td>
            </tr>
            </table>
            </form>
        ";
            //echo $q;
	$q=mysql_query("SELECT * FROM ".ArticlesTable."");
	echo "
        <table border='1px' float='left'>
        <tr>
            <td>Article ID</td>
            <td>Name</td>
            <td>Text</td>
            <td>Poster ID</td>
            <td>Date</td>
            <td>Main IMG</td>
        </tr>
        ";
	for ($i=0;$i<mysql_num_rows($q);$i++)
	{
		echo "<tr>";
		foreach (mysql_fetch_row($q) as $keys =>$values)
			if ($keys == 5)
				echo "<td><img src='$values' width=150></td>";
			elseif ($keys==2)
				echo "<td><pre>$values</pre></td>";
			else
				echo "<td>$values</td>";
		echo "</tr>";
	}
	echo "
        </table>
        </body>
        </html>
        ";
	mysql_close($connid);
?>