<?php
	include('INC_DBM.php');
	
	$ctitle=trim(htmlspecialchars($_POST['CTitle'],ENT_QUOTES));
	$ctext=trim(htmlspecialchars($_POST['CText'],ENT_QUOTES));
	$cid=$_POST['CID'];
	$caid=$_POST['CAID'];
	
	switch($_POST['SubButton'])
	{
		case "Add":
			if($ctext!='')
			{
				$currdatetime = date("Y-m-d H:i:s"); 
				mysql_query("INSERT INTO ".CommentsTable."(date,title,text,article_id) VALUES ('$currdatetime','$ctitle','$ctext','$caid');");
			}
			else
				echo "Fill in the text!";
			break;
		case "Remove":
			if($cid != NULL)
				mysql_query("DELETE FROM ".CommentsTable." WHERE comment_id='$cid'");
			break;
		case "ClearAll":
			mysql_query("DELETE FROM ".CommentsTable."");
			break;
	}
	echo "
		<html>
		<head><title>Comments</title></head>
		<body>
		";
	echo "
		<form class='form' action = 'Comment.php' method='POST'>
		<table>
		<tr>
			<td>Comment ID: <input type = 'text' name='CID'></td>
			<td>Title: <input type='text' name='CTitle'></td>
			<td>Text: <input type='text' name='CText'></td>
			<td>Article ID: <input type='text' name='CAID'></td>
		</tr>
		<tr>
			<td><input type='submit' name = 'SubButton' value='Add'></td>
			<td><input type='submit' name = 'SubButton' value='Remove'></td>
			<td><input type='submit' name = 'SubButton' value='ClearAll'></td>
		</tr>
		</table>
		</form>
		";
	$q=mysql_query("SELECT * FROM ".CommentsTable."");
	echo "
		<table border='1px' float='left'>
		<tr>
			<td>comment ID</td>
			<td>Date</td>
			<td>Author ID</td>
			<td>Title</td>
			<td>Text</td>
			<td>Article ID</td>
		</tr>
		";
	for ($i=0;$i<mysql_num_rows($q);$i++)
	{
		echo "<tr>";
		foreach (mysql_fetch_row($q) as $keys =>$values) echo "<td>$values</td>";
		echo "</tr>";
	}
	echo "
		</table>
		</body>
		</html>
		";
	mysql_close($connid);
?>