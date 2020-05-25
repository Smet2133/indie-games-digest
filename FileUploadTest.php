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


echo'
<form action = "FileUploadTest.php" method="POST" enctype="multipart/form-data">
	<table>
    <tr>
        <td>Main IMG:   <input type="file" name="userfile" accept="image/jpeg"></td>
	</tr>
        <td><button type="submit" name = "SubButton" class="button" value="AddUserArticle">Добавить статью</button><br></td>
    </tr>
	</table>
	</form>
    ';

$uploaddir = 'images/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo basename($_FILES['userfile']['name']).'<br><pre>';
if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        echo "Файл корректен и был успешно загружен.\n";
    } else {
        echo "Возможная атака с помощью файловой загрузки!\n";
    }
}

echo 'Некоторая отладочная информация:';
print_r($_FILES);

print "</pre>";

include('INC_BOTTOM_PART.php');
?>
