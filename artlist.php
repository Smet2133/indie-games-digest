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

define ("ArtOnPage",6,true);
//------------------------------------------------


if ($_GET['page'] != NULL && $_GET['page']>0)
	$pagenum=$_GET['page'];
else
	$pagenum = 1;
	
//запрос всех статей до последней,выводимой на страницу
$q=mysql_query("SELECT * FROM ".ArticlesTable." LIMIT ".(ArtOnPage*$pagenum)."");
$artnumber = mysql_query("SELECT COUNT(*) FROM ".ArticlesTable."");
$artnumber=mysql_fetch_row($artnumber);
$artnumber = $artnumber[0];

if (ceil($artnumber/ArtOnPage)<$pagenum)
    $pagenum = ceil($artnumber/ArtOnPage);
//Пропуск ведущих статей - тех,которые перед выводимыми
for ($i=0;$i<ArtOnPage*($pagenum-1);$i++){
	mysql_fetch_row($q);
}

echo "<table class='table_ind'><tr>";
for ($i=0;$i<mysql_num_rows($q)-ArtOnPage*($pagenum-1);$i++)
{
	$a=mysql_fetch_assoc($q);
	echo "
		<td class='nonebord'>
			<a href = 'articles.php?aid=".$a['article_id']."'><img src='".$a['main_img_link']."' width='250'></a><br>
			<a href = 'articles.php?aid=".$a['article_id']."'>".$a['name']."</a>
		</td>
		";			
	if(($i+1)%2 == 0)
		echo "
            </tr>
            <tr class='emptyrow'>
            </tr>
            <tr>
            ";
}
if(($i+1)%2 == 0){echo "</tr><tr class='emptyrow'>";}
echo "
    </tr>
    <tr>
        <td class='nonebord' colspan = 4>
    ";
for($i=1;$i<=ceil($artnumber/ArtOnPage);$i++)
	echo "<a href = 'artlist.php?page=".$i."'>$i</a> ";
echo "
        </td>
    </tr>
    </table>
    ";
include('INC_BOTTOM_PART.php');
?>