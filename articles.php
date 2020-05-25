<?php

//этот кусок берет полный путь к файлу, забирает из него имя страницы и сохраняет для использования
//в INC_TOP_PART
if(strpbrk(__FILE__,'/'))
	$filepath=explode('/',__FILE__);
else
	$filepath=explode('\\',__FILE__);
$filepath=$filepath[count($filepath)-1];
$filepath=substr($filepath,0,strlen($filepath)-4);


$aid = $_GET['aid'];


include('INC_TOP_PART.php'); //Только для этой страницы TOP_PART
//использует переменную $aid, поэтому include под переменными

//------------------------------------------------
define ("CommentsOnPage",10,true);
$SULogin=$_SESSION['ULogin'];
$SUID=$_SESSION['UID'];
$ctitle=trim(htmlspecialchars($_POST['CTitle'],ENT_QUOTES));
$ctext=trim(htmlspecialchars($_POST['CText'],ENT_QUOTES));
$currdatetime = date("Y-m-d H:i:s");
$fav_add = $_POST['SubButton'];

if($_GET['cpage']!=NULL && $_GET['cpage']>0)
	$commentpage=$_GET['cpage'];
else
	$commentpage=1;

$q=mysql_query("SELECT * FROM ".ArticlesTable." WHERE article_id='$aid'");
$q=mysql_fetch_assoc($q);
if ($q != NULL) {
    
    $user_is_author = $SUID == $q['poster_id'] || $SULogin == "admin";
    $filetext=file('Articles/'.$q['name'].'.txt');
    echo "
        <h1><pre>".$q['name']."</pre></h1><br>
        <img class='leftimg' width='300' src='".$q['main_img_link']."'><br>
        ";
    foreach($filetext as $keys => $rows)
        echo $rows."<br>";
    echo "
        <br>
        <p align='left'>Опубликовано ".$q['date']."</p>
        ";
    if ($user_is_author)
        echo '
            <form action="editarticle.php" method="POST">
            <input type="text" hidden="true" name="AID" value="'.$aid.'">
            <p align="justify">Вы - автор статьи <button class="button" type="submit">Редактировать статью</button></p>
            </form>
            ';
    


    if($SULogin != NULL && !$user_is_author) {
        $q = mysql_query("SELECT * FROM ".FavArticlesTable." WHERE article_id='$aid' AND login='$SULogin'");
        if(mysql_fetch_assoc($q) == 0){
            if($_POST['SubButton'] == 'Favorite'){
                mysql_query("INSERT INTO ".FavArticlesTable."(login, article_id) VALUES ('$SULogin','$aid');");
            }
            else {
            echo '
                <form class="form" method="post" action="articles.php?aid='.$aid.'">
                <p><button class="button but_fav" type="submit" name="SubButton" value="Favorite">Добавить в избранное</button></p> </br>
                </form>
                ';
            }
        }
    }

    if ($_POST['SubButton']&& $ctext!=NULL)
            mysql_query("INSERT INTO ".CommentsTable." (date,author_login,title,text,article_id) 
                VALUES('$currdatetime','$SULogin','".$ctitle."','".$ctext."','".$aid."');");
    $q=mysql_query("SELECT date,author_login,title,text FROM ".CommentsTable." WHERE article_id = '$aid' LIMIT ".(CommentsOnPage*$commentpage)."");
    $commnumber = mysql_query("SELECT COUNT(*) FROM ".CommentsTable." WHERE article_id = '$aid'");
    $commnumber=mysql_fetch_row($commnumber);
    $commnumber = $commnumber[0];

    if (ceil($commnumber/CommentsOnPage)<$commentpage)
        $commentpage = ceil($commnumber/CommentsOnPage);

    if ($commnumber != 0)
    {
        for ($i=0;$i<CommentsOnPage*($commentpage-1);$i++)
            mysql_fetch_row($q);

        echo "
            <h3>Комментарии</h3><br>
            <div class='com_table_div'>
            <table class='commentstable'>
            ";
        for ($i=0;$i<mysql_num_rows($q)-CommentsOnPage*($commentpage-1);$i++)
        {
            $m=mysql_fetch_assoc($q);
            echo "
                <tr>
                    <td rowspan=2 class='com_author_cell com_cell'><b>Автор:</b><br>".$m['author_login']."</td>
                    <td class='com_time_and_title_cell com_cell'><p align='left'><b>Время:</b> ".$m['date']."<br><div class='com_time_and_title_div'><b>Тема:</b> ".$m['title']."</div></p></td>
                </tr>
                <tr>
                    <td class='com_text_cell com_cell'><div align='left' class='com_text_div'>".$m['text']."</div></td>
                </tr>
                <tr class='emptyrow'>
                </tr>
                ";
        }
        echo "
            </table>
            </div>
            <br>
            ";
        for($i=1;$i<=ceil($commnumber/CommentsOnPage);$i++)
            echo "<a href = 'articles.php?aid=".$aid."&cpage=".$i."'>$i</a> ";
        echo "<br>";
    }
    else
        echo "<h2>Комментариев нет</h2><br>";
    echo "<br>";
    if ($SULogin != NULL)
        echo "
            <form class='form' action = 'articles.php?aid=".$aid."&cpage=".$commentpage."' method='POST'>
            <table class='submitcommenttable' align='center'>
            <tr>
                <td class='text'>Title:</td>
                <td class='input'><input class='textt' type='text' name='CTitle' size='105' maxlength='100'></td>
            </tr>
            <tr>
                <td class='text'>Text:</td>
                <td class='input'>
                    <textarea class='textt' name='CText' class='commentstextarea' rows='7' cols='80' maxlength='3000'></textarea>
                </td>
            </tr>
            <tr>
                <td class='text'></td>
                <td class='input'><input type='submit' name = 'SubButton' class ='button' value='Add'></td>
            </tr>
            </table>
            </form>
            ";
    else
        echo "Вы должны быть авторизованы, чтобы оставлять комментарии";
}
else
    echo "404 Статья не найдена";
include('INC_BOTTOM_PART.php');
?>