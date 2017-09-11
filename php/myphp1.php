<?php
// error_reporting(E_ALL ^ E_DEPRECATED);
header("Content:text/html;charset=utf-8");
$conn= new mysqli("localhost","root","root",'loc');
$conn->query("SET NAMES 'UTF8'");
//$conn=mysqli_connect("localhost","root","hillstone",'sharekb'); //or die('waraeg');
date_default_timezone_set('PRC');
$ip=getonlineip();
if($_REQUEST['action']=='read')
{
	if(isset($_REQUEST['shareId'])){
		//$getdata = json_decode(file_get_contents("php://input"), true); 
		$sqls="select * from comdatabase where shareId='".$_REQUEST['shareId']."' order by comId desc";
		$result=mysqli_query($conn,$sqls);
		$i=0;
		$a=array();
		while($row=mysqli_fetch_array($result))
		{
			
			$a[$i]['comName']=gb2utf($row['comName']);
			$a[$i]['shareId']=gb2utf($row['shareId']);
			$a[$i]['ip']=gb2utf($row['ip']);
			$a[$i]['date']=gb2utf($row['date']);
			$i=$i+1;
		};
		mysqli_free_result($result);
		echo json_encode($a);//( $row);
	}else{
		
	}
}
else if($_REQUEST['action']=='create')
{
	$data = json_decode(file_get_contents("php://input"), true); 
	//var_dump($postData);
	// echo json_encode($data['userName']);
	
	
	 $sqls="insert into comdatabase (shareId,comName,ip,date) 
	 values ('".utf2gb($data['shareId'])."','".utf2gb($data['comName'])."','".utf2gb($ip)."','".utf2gb(date("Y-m-d H:i:s"))."')";
	 $result=mysqli_query($conn,$sqls);
	 // echo json_encode($result);
	 if($result==false)
	 {
	 	echo("new record Error,mabye name duplicate");
	 	die();
	 }
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
