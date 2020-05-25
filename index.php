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
    <div class="index_text">
    Добро пожаловать на информационный портал Indie Digest! На нашем сайте вы найдете постоянно обновляемую и расширяющуюся базу статей об инди-играх и сможете
    сами поучаствовать в её пополнении.
    </div>
    
    </br></br></br></br></br>
    
    <div class="index_text">
    И́нди-игры (англ. Indie games, от англ. independent video games — «независимые игры») подразумевают под 
    собой вид видеоигр, созданных отдельными личностями или небольшими командами вообще без финансовой поддержки 
    издателей, для которых характерны независимость от коммерческой поп-музыки и мейнстрима (преобладающих 
    тенденций), особая DIY-идеология (англ. Do It Yourself — сделай это сам).
    </div>

    ';
include('INC_BOTTOM_PART.php');
?>