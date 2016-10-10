<?php
//header("Content-type:text/html;charset=utf-8");
$url = 'http://hq.sinajs.cn/list=sh601006';
$headers = array("Content-type:text/html;charset=utf-8");
$code = '601006';
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

$content = getContentByCurl($url);
//获取引号之间的值
$ptn = '/\\"(.*)\\"/'; 
preg_match_all($ptn,$content,$match);
$arr = explode(',',$match[1][0]);
$conn = mysql_connect('127.0.0.1','root',123456) or die('connect failed.  '.mysql_error());
mysql_query("SET NAMES 'UTF8'");
$arr[0]= iconv("GBK", "UTF-8", $arr[0]); 
mysql_select_db('test',$conn);
$sql = "insert into code_today (code_num,code_name,start_price,yesterday_price,now_price,today_max_price,today_min_price,vie_buy_price,vie_sell_price,deal_code_num,deal_code_money,buy_one_num,buy_one_price,buy_two_num,buy_two_price,buy_three_num,buy_three_price,buy_four_num,buy_four_price,buy_five_num,buy_five_price,sell_one_num,sell_one_price,sell_two_num,sell_two_price,sell_three_num,sell_three_price,sell_four_num,sell_four_price,sell_five_num,sell_five_price,date,time,other) values ('".$code."','".$arr[0]."',".$arr[1].",".$arr[2].",".$arr[3].",".$arr[4].",".$arr[5].",".$arr[6].",".$arr[7].",".$arr[8].",".$arr[9].",".$arr[10].",".$arr[11].",".$arr[12].",".$arr[13].",".$arr[14].",".$arr[15].",".$arr[16].",".$arr[17].",".$arr[18].",".$arr[19].",".$arr[20].",".$arr[21].",".$arr[22].",".$arr[23].",".$arr[24].",".$arr[25].",".$arr[26].",".$arr[27].",".$arr[28].",".$arr[29].",'".$arr[30]."','".$arr[31]."','".$arr[32]."')";
mysql_query($sql);
mysql_close($conn);

















