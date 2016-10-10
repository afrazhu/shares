<?php
$file_handle = @fopen('table.txt','r');
$conn = mysql_connect('127.0.0.1','root',123456) or die('connect failed'.mysql_error());
mysql_select_db('test',$conn);
while($line = fgets($file_handle)){
	$code = substr($line,2,6);
	$type = strtolower(substr($line,0,2));
	$num = substr($line,2,1);
	if($num == '3'){
		$order = 2;
	}else{
		$order = 1;
	}
	//echo $num;
	mysql_query("insert into code_num (code,type,ord) values ('".$code."','".$type."','".$order."')");
	
}
mysql_close($conn);
