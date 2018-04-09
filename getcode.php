<?php
$file_handle = @fopen('table.txt','r');
//php7连接数据库
$conn = mysqli_connect('127.0.0.1','root',123456,'test');
if (mysqli_connect_errno($conn))
{
    echo "连接 MySQL 失败: " . mysqli_connect_error();
}
//mysqli_select_db($conn,'test');
while($line = fgets($file_handle)){
	$code = substr($line,2,6);
	$type = strtolower(substr($line,0,2));
	$num = substr($line,2,1);
	if($num == '3'){
		$order = 2;
	}else{
		$order = 1;
	}
	//echo $line.'<br/>'.$code.'|'.$type.'|'.$num;die;
	//echo $num;
    if($code){
        mysqli_query($conn,"insert into code_num (code,code_type,ord) values ('".$code."','".$type."','".$order."')");
    }
	
}
mysqli_close($conn);
