<?php
// error_reporting(E_ALL ^ E_DEPRECATED);
header("Content:text/html;charset=utf-8");
//$conn=mysqli_connect("localhost","root","hillstone",'sharekb'); //or die('waraeg');
$conn= new mysqli("localhost","root","root",'loc');
$conn->query("SET NAMES 'UTF8'");
date_default_timezone_set('PRC');
$ip=getonlineip();
if($_REQUEST['action']=='read')
{
	//$getdata = json_decode(file_get_contents("php://input"), true); 
	$sqls="select userName, count(1) as amount from sharedatabase group by userName order by amount desc";
	$result=mysqli_query($conn,$sqls);
	$i=0;
	$a=array();
	while($row=mysqli_fetch_array($result))
	{	
		
		$a[$i]['userName']=gb2utf($row['userName']);
		$a[$i]['amount']=gb2utf($row['amount']);
		if($a[$i]['amount']==$a[$i-1]['amount']){
			$a[$i]['userRank']=$a[$i-1]['userRank'];
		}else{
			$a[$i]['userRank']=$i+1;
		}
		
		$i=$i+1;
	};
	mysqli_free_result($result);
	//echo $sqls;
	echo json_encode($a);//( $row);
}


mysqli_close($conn);	
function getonlineip(){
	if($_SERVER['HTTP_CLIENT_IP'])
	{
		$onlineip=getenv("HTTP_CLIENT_IP"); //用户IP
	}
	else if($_SERVER['HTTP_X_FORWARDED_FOR'])
	{
		$onlineip=$_SERVER['HTTP_X_FORWARDED_FOR']; //代理IP
	}
	else
	{
		$onlineip=$_SERVER['REMOTE_ADDR']; //服务器IP
	}
	return $onlineip;
}
function gb2utf($txt){
	//if($txt!=""){
	//	$a=iconv("gbk//translit","utf-8",$txt);
	//}else{
	//	$a="";
	//}
	return $txt;
}
function utf2gb($txt){
	//if($txt!=""){
	//	$a=iconv("utf-8","gbk//translit",$txt);
	//}else{
	//	$a="";
	//}
	return $txt;
}
?>
