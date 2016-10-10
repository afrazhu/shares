<?php
$conn = mysql_connect('127.0.0.1','root',123456) or die('connect failed '.mysql_close());
mysql_query("SET NAMES 'UTF8'");
mysql_select_db('test',$conn);
for($i=0;$i<59;$i++){
	$sql = "CREATE TABLE `code_history".$i."` ( ";
  	$sql .=	"`id` int(11) NOT NULL AUTO_INCREMENT,";
  	$sql .=	"`code_id` int(11) DEFAULT NULL COMMENT 'code_num id',";
  	$sql .=	"`code` varchar(6) DEFAULT NULL COMMENT '股票代码',";
  	$sql .=	"`type` varchar(2) DEFAULT NULL COMMENT '类型',";
  	$sql .=	"`open_price` float(9,2) DEFAULT NULL COMMENT '开盘价',";
  	$sql .=	"`high_price` float(9,2) DEFAULT NULL COMMENT '最高价',";
  	$sql .=	"`low_price` float(9,2) DEFAULT NULL COMMENT '最低价',";
  	$sql .=	"`close_price` float(9,2) DEFAULT NULL COMMENT '收盘价',";
  	$sql .=	"`volume_num` varchar(20) DEFAULT NULL COMMENT '交易量',";
  	$sql .=	"`adj_close` float(9,2) DEFAULT NULL COMMENT '复权收盘价，已调整收盘价',";
  	$sql .=	"`date` varchar(11) DEFAULT NULL COMMENT '日期',";
  	$sql .=	"PRIMARY KEY (`id`),";
  	$sql .=	"KEY `code_id` (`code_id`) USING BTREE,";
  	$sql .=	"KEY `code` (`code`) USING BTREE,";
  	$sql .=	"KEY `low` (`low_price`) USING BTREE";
	$sql .=	" ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	mysql_query($sql);
}
echo "ok";
mysql_close($conn);