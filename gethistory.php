<?php
set_time_limit(0);
//获取页面数据
function getContentByCurl($url, $headers=array(), $binary=false ) {
	$curlHandler = curl_init();
	$cookie_file = dirname(__FILE__) . "/googlecookie.txt";
	curl_setopt($curlHandler, CURLOPT_URL, $url);
	curl_setopt($curlHandler, CURLOPT_TIMEOUT, 5);
	// headers like: array('Content-type: text/plain', 'Content-length: 100')
	curl_setopt($curlHandler, CURLOPT_HTTPHEADER, $headers);//not need header
	curl_setopt($curlHandler, CURLOPT_HEADER, false);//not need header
	curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1); //return contents
	curl_setopt($curlHandler, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
	curl_setopt($curlHandler, CURLOPT_COOKIEJAR, $cookie_file);
	curl_setopt($curlHandler, CURLOPT_USERAGENT, array_rand(
	array(
	 "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
	 "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.97 Safari/537.11",
	))
	);
	if( false!==(stripos($url,"https://")) ){
		curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false); //need for https
		curl_setopt($curlHandler, CURLOPT_SSL_VERIFYHOST, false); //need for https
	}
	curl_setopt($curlHandler, CURLOPT_BINARYTRANSFER, $binary);
	//curl_setopt($curlHandler, CURLOPT_FILE, $fileOutput);
	$contents = curl_exec($curlHandler);
	return $contents;
}
//获取所有股票代码
$conn = mysqli_connect('127.0.0.1','root',123456,'test');
//mysql_select_db('test',$conn);
//echo "<pre>";
$res = mysqli_query($conn,'select id,code,code_type from code_num order by ord');
$arr_code = array();
$i = 0;
while($arr = mysqli_fetch_array($res,MYSQLI_NUM)){
	$arr_code[$i]['id'] = $arr[0];
	$arr_code[$i]['code'] = $arr[1];
	$arr_code[$i]['type'] = $arr[2];
	$i++;
}
//获取数据
$i = 0;
foreach ($arr_code as $k => $val) {
	$url = 'http://table.finance.yahoo.com/table.csv?s='.$val['code'].'.'.$val['type'];
	$content = getContentByCurl($url);
    print_r($content);die;
	$arr_inter = explode(';',str_replace("\n",";",trim($content)));
	unset($arr_inter[0]);
	if($arr_inter){
		//获取数据表名称
		$table_num = floor($i/50);
		$table_name = 'code_history'.$table_num;
		echo $table_name.'<br/>';
		foreach ($arr_inter as $v) {
			$arr_v = explode(',',trim($v));
			$sql = "insert into ".$table_name." (code_id,code,type,open_price,high_price,low_price,close_price,volume_num,adj_close,date) values (".$val['id'].",'".$val['code']."','".$val['type']."',".$arr_v[1].",".$arr_v[2].",".$arr_v[3].",".$arr_v[4].",'".$arr_v[5]."',".$arr_v[6].",'".$arr_v[0]."')";
			mysqli_query($conn,$sql);
		}
		$i++;
	}
}
//关闭
mysqli_close($conn);