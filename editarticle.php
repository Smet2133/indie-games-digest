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

$aid=$_POST['AID'];
if($_GET['confirm']==NULL){
    $q=mysql_query("SELECT * FROM ".ArticlesTable." WHERE article_id='$aid'");
    $q=mysql_fetch_assoc($q);
    if ($q != NULL)
        $filetext=file('Articles/'.$q['name'].'.txt');

    echo'
        <form action = "Article.php" class="AddUserArticleForm" method="POST" enctype="multipart/form-data">
        <table>
        <tr>
            <td>Name:       <input type="text" name="AName" pattern="[A-Za-z\s\-_0-9]{3,}" value="'.$q['name'].'">
                            <input type="text" name="AID" hidden="true" value="'.$aid.'"></td>
        </tr>
        <tr>
            <td>Text:       <textarea required rows="25" cols="30" maxlength="5000" name="AText">';
        foreach($filetext as $keys => $rows)
            echo $rows;

    echo'
            </textarea></td>
        </tr>
        <tr>
            <td>Main IMG:   <input type="file" name="ArticleIMGFile" accept="image/jpeg"></td>
        </tr>
            <td><button type="submit" name = "SubButton" class="button" value="EditArticle">Изменить статью</button><br></td>
        </tr>
        </table>
        </form>
        ';
}
else {
    echo $_SESSION['ArtEditMessage'];
    unset($_SESSION['ArtEditMessage']);
}

include('INC_BOTTOM_PART.php');
?>

