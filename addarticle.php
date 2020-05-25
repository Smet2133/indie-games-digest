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

if ($_GET['confirm']==NULL)
    echo'
        <form action = "Article.php" class="AddUserArticleForm" method="POST" enctype="multipart/form-data">
        <table>
        <tr>
            <td>Name:       <input required type="text" name="AName" pattern="[A-Za-z\s\-_0-9]{3,}">
                            <input type="text" name="AID" hidden="true" value="'.$aid.'"></td>
        </tr>
        <tr>
            <td>Text:       <textarea required rows="25" cols="30" maxlength="5000" name="AText"></textarea></td>
        </tr>
        <tr>
            <td>Main IMG:   <input type="file" required name="ArticleIMGFile" accept="image/jpeg"></td>
        </tr>
            <td><button type="submit" name = "SubButton" class="button" value="AddUserArticle">Добавить статью</button><br></td>
        </tr>
        </table>
        </form>
        ';
else {
    echo $_SESSION['ArtAddMessage'];
    unset($_SESSION['ArtAddMessage']);
}
include('INC_BOTTOM_PART.php');
?>

