<?php
include('INC_TOP_PART.php');
$clogin=array('correctlogin','1corrrect12login','___xxxcorr ec tlo gin','123124124124124');
$inclogin=array('/in-correct.login\\ff>','','a');
$cemail=array('hellrage@mail.ru','m@gmail.com','1@rambler.me');
$incemail=array('nodomain.ru','@mail.ru','','adress@domain','adress@domain.','.ru');

$mail_regexp='/^[a-z0-9_\.\-]+@([a-z0-9\-]+\.)+[a-z]{2,4}$/is';
$logregexp='/^[a-zA-Z\_\- а-яА-ЯЁё0-9]{3,30}$/iu';

echo "
	<table>
	<tr><td>Correct Logins<br>
	";
foreach($clogin as $keys => $values)
	echo "
		$keys => ".preg_match($logregexp,$values)."<br>
		";
	echo "
		</td>
		<td>Incorrect Logins<br>
		";
foreach($inclogin as $keys => $values)
	echo "
		$keys => ".preg_match($logregexp,$values)."<br>
		";
	echo "
		</td>
		<td>Correct Emails<br>
		";
foreach($cemail as $keys => $values)
	echo "
		$keys => ".preg_match($mail_regexp,$values)."<br>
		";
	echo "
		</td>
		<td>Incorrect Emails<br>
		";
foreach($incemail as $keys => $values)
	echo "
		$keys => ".preg_match($mail_regexp,$values)."<br>
		";
echo "
		</td>
	</tr>
	</table>
	";
		
include('INC_BOTTOM_PART.php');
?>