<?php
// error_reporting(E_ALL ^ E_DEPRECATED);
header("Content:text/html;charset=utf-8");
$conn=new mysqli("localhost","root","hillstone",'sharekb');
$conn->query("SET NAMES 'UTF8'");
//$conn=mysqli_connect("localhost","root","hillstone",'sharekb'); //or('杩炴帴閿欒');
date_default_timezone_set('PRC');
if($_REQUEST['action']=='read')
{
	$start=$_REQUEST['start'];
	$limit=$_REQUEST['limit'];
	$ip=getonlineip();
	if(!(isset($_REQUEST['datestart'])&&isset($_REQUEST['datestop']))){
		$sqls="select * from sharedatabase";
		$results=mysqli_query($conn,$sqls);
		$res=mysqli_num_rows($results);
		mysqli_free_result($results);
		if(!isset($_REQUEST['ii'])){
			if(isset($_REQUEST['praise'])){
				$sqls="select * from voteup where ip='".$ip."' and shareId='".utf2gb($_REQUEST['praise'])."'";
				$result3=mysqli_query($conn,$sqls);
				if(mysqli_num_rows($result3)==0){
					$sqls="select voteUp from sharedatabase where shareId='".$_REQUEST['praise']."'";
					$result1=mysqli_query($conn,$sqls);
					while($row=mysqli_fetch_array($result1))
					{
						$b=$row['voteUp']+1;
					}
					mysqli_free_result($result1);
					$sqls="update sharedatabase set
					voteUp='".$b."'
					where shareId='".$_REQUEST['praise']."'";
					$result2=mysqli_query($conn,$sqls);
					$sqls="insert into voteup (ip,shareId)
					values ('".$ip."','".utf2gb($_REQUEST['praise'])."')";
					$result4=mysqli_query($conn,$sqls);
					// echo json_encode($result);
					if($result4==false)
					{
						echo("new record Error,mabye name duplicate");
						die();
					}
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
					$result4=mysqli_query($conn,$sqls3);
					while($row=mysqli_fetch_array($result4))
					{
						$b=$b." ".gb2utf($row['tag']);
					};
					mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					//echo json_encode($a);//( $row);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
				}else{
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
									$result4=mysqli_query($conn,$sqls3);
									while($row=mysqli_fetch_array($result4))
									{
											$b=$b." ".gb2utf($row['tag']);
									};
									mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
					//echo json_encode($a);//( $row);
				}
				mysqli_free_result($result3);
			}else if(isset($_REQUEST['depraise'])){
				$sqls="select * from voteup where ip='".$ip."' and shareId='".utf2gb($_REQUEST['depraise'])."'";
				$result3=mysqli_query($conn,$sqls);
				if(mysqli_num_rows($result3)!=0){
					$sqls="select voteUp from sharedatabase where shareId='".utf2gb($_REQUEST['depraise'])."'";
					$result1=mysqli_query($conn,$sqls);
					while($row=mysqli_fetch_array($result1))
					{
						$b=$row['voteUp']-1;
					}
					mysqli_free_result($result1);
					$sqls="update sharedatabase set
					voteUp='".$b."'
					where shareId='".utf2gb($_REQUEST['depraise'])."'";
					$result2=mysqli_query($conn,$sqls);
					$sqls="delete from voteup where ip='".$ip."' and shareId='".utf2gb($_REQUEST['depraise'])."'";
					$result4=mysqli_query($conn,$sqls);
					// echo json_encode($result);
					if($result4==false)
					{
						echo("new record Error,mabye name duplicate");
						die();
					}
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
									$result4=mysqli_query($conn,$sqls3);
									while($row=mysqli_fetch_array($result4))
									{
											$b=$b." ".gb2utf($row['tag']);
									};
									mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
					//echo json_encode($a);//( $row);
				}else{
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
									$result4=mysqli_query($conn,$sqls3);
									while($row=mysqli_fetch_array($result4))
									{
											$b=$b." ".gb2utf($row['tag']);
									};
									mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
					//echo json_encode($a);//( $row);
				}
				mysqli_free_result($result3);
			}else if(isset($_REQUEST['tread'])){
				$sqls="select * from votedown where ip='".$ip."' and shareId='".utf2gb($_REQUEST['tread'])."'";
				$result3=mysqli_query($conn,$sqls);
				if(mysqli_num_rows($result3)==0){
					$sqls="select voteDown from sharedatabase where shareId='".$_REQUEST['tread']."'";
					$result1=mysqli_query($conn,$sqls);
					while($row=mysqli_fetch_array($result1))
					{
						$b=$row['voteDown']+1;
					}
					mysqli_free_result($result1);
					$sqls="update sharedatabase set
									voteDown='".$b."'
									where shareId='".$_REQUEST['tread']."'";
					$result2=mysqli_query($conn,$sqls);
					$sqls="insert into votedown (ip,shareId)
									values ('".$ip."','".utf2gb($_REQUEST['tread'])."')";
					$result4=mysqli_query($conn,$sqls);
					// echo json_encode($result);
					if($result4==false)
					{
						echo("new record Error,mabye name duplicate");
						die();
					}

					$i=0;
					$a=array();
					$sqls="select * from sharedatabase order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
									$result4=mysqli_query($conn,$sqls3);
									while($row=mysqli_fetch_array($result4))
									{
											$b=$b." ".gb2utf($row['tag']);
									};
									mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					//echo json_encode($a);//( $row);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
				}else{
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
									$result4=mysqli_query($conn,$sqls3);
									while($row=mysqli_fetch_array($result4))
									{
											$b=$b." ".gb2utf($row['tag']);
									};
									mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
					//echo json_encode($a);//( $row);
				}
				mysqli_free_result($result3);
			}else if(isset($_REQUEST['detread'])){
				$sqls="select * from votedown where ip='".$ip."' and shareId='".utf2gb($_REQUEST['detread'])."'";
				$result3=mysqli_query($conn,$sqls);
				if(mysqli_num_rows($result3)!=0){
					$sqls="select voteDown from sharedatabase where shareId='".utf2gb($_REQUEST['detread'])."'";
					$result1=mysqli_query($conn,$sqls);
					while($row=mysqli_fetch_array($result1))
					{
						$b=$row['voteDown']-1;
					}
					mysqli_free_result($result1);
					$sqls="update sharedatabase set
									voteDown='".$b."'
									where shareId='".utf2gb($_REQUEST['detread'])."'";
					$result2=mysqli_query($conn,$sqls);
					$sqls="delete from votedown where ip='".$ip."' and shareId='".utf2gb($_REQUEST['detread'])."'";
					$result4=mysqli_query($conn,$sqls);
					// echo json_encode($result);
					if($result4==false)
					{
						echo("new record Error,mabye name duplicate");
						die();
					}
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
									$result4=mysqli_query($conn,$sqls3);
									while($row=mysqli_fetch_array($result4))
									{
											$b=$b." ".gb2utf($row['tag']);
									};
									mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
					//echo json_encode($a);//( $row);
				}else{
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
									$result4=mysqli_query($conn,$sqls3);
									while($row=mysqli_fetch_array($result4))
									{
											$b=$b." ".gb2utf($row['tag']);
									};
									mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
					//echo json_encode($a);//( $row);
				}
				mysqli_free_result($result3);
			}else if(isset($_REQUEST['iii'])){
				$sqls="select tag from tags";
				$result=mysqli_query($conn,$sqls);
				$i=0;
				$a=array();
				while($row=mysqli_fetch_array($result))
				{
					$a[$i]['tag']=$a[$i]['tag']." ".gb2utf($row['tag']);
				};
				$a[$i]['isPraise']=2;
				$a[$i]['isTread']=2;
				$a[$i]['userName']=gb2utf('');
				$a[$i]['headName']=gb2utf('');
				$a[$i]['urlName']=gb2utf('');
				$a[$i]['tagName']=gb2utf('');
				$a[$i]['date']=gb2utf('');
				$a[$i]['tag']=substr($a[$i]['tag'],1);
				$i=$i+1;
				mysqli_free_result($result);
				echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
				//echo json_encode($a);//( $row);
			}else{
				$i=0;
				$a=array();
				$sqls="select * from sharedatabase order by shareId desc limit $start,$limit";
				$result1=mysqli_query($conn,$sqls);
				$sqls3="select tag from tags";
				$result4=mysqli_query($conn,$sqls3);
				while($row=mysqli_fetch_array($result4))
				{
					$b=$b." ".gb2utf($row['tag']);
				};
				mysqli_free_result($result4);
				while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					
				echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
				//echo json_encode($a);//( $row);
			}
		}else{
			$i=0;
			$a=array();
			$sqls="select * from sharedatabase order by shareId desc limit $start,$limit";
			$result1=mysqli_query($conn,$sqls);
			$sqls3="select tag from tags";
			$result4=mysqli_query($conn,$sqls3);
			while($row=mysqli_fetch_array($result4))
			{
				$b=$b." ".gb2utf($row['tag']);
			};
			mysqli_free_result($result4);
			while($row=mysqli_fetch_array($result1))
			{
				$a[]=$row;
			};
			for($i=0;$i<mysqli_num_rows($result1);$i++){
				$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
				$result2=mysqli_query($conn,$sqls1);
				if(mysqli_num_rows($result2)==0){
					$a[$i]['isPraise']=0;
				}else{
					$a[$i]['isPraise']=1;
				}
				mysqli_free_result($result2);
				$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
				$result3=mysqli_query($conn,$sqls2);
				if(mysqli_num_rows($result3)==0){
					$a[$i]['isTread']=0;
				}else{
					$a[$i]['isTread']=1;
				}
				$a[$i]['tag']=$b;
				mysqli_free_result($result3);
			}
			mysqli_free_result($result1);
			
			echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
			//echo json_encode($a);//( $row);
		}
	}else if(isset($_REQUEST['datestart'])&&isset($_REQUEST['datestop'])){
		$sqls="select * from sharedatabase where date between '".$_REQUEST['datestart']."' and '".$_REQUEST['datestop']."'";
		$results=mysqli_query($conn,$sqls);
		$res=mysqli_num_rows($results);
		mysqli_free_result($results);
		if(!isset($_REQUEST['ii'])){
			if(isset($_REQUEST['praise'])){
				$sqls="select * from voteup where ip='".$ip."' and shareId='".utf2gb($_REQUEST['praise'])."'";
				$result3=mysqli_query($conn,$sqls);
				if(mysqli_num_rows($result3)==0){
					$sqls="select voteUp from sharedatabase where shareId='".$_REQUEST['praise']."'";
					$result1=mysqli_query($conn,$sqls);
					while($row=mysqli_fetch_array($result1))
					{
						$b=$row['voteUp']+1;
					}
					mysqli_free_result($result1);
					$sqls="update sharedatabase set
					voteUp='".$b."'
					where shareId='".$_REQUEST['praise']."'";
					$result2=mysqli_query($conn,$sqls);
					$sqls="insert into voteup (ip,shareId)
					values ('".$ip."','".utf2gb($_REQUEST['praise'])."')";
					$result4=mysqli_query($conn,$sqls);
					// echo json_encode($result);
					if($result4==false)
					{
						echo("new record Error,mabye name duplicate");
						die();
					}

					$i=0;
					$a=array();
					$sqls="select * from sharedatabase where date between '".$_REQUEST['datestart']."' and '".$_REQUEST['datestop']."' order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
					$result4=mysqli_query($conn,$sqls3);
					while($row=mysqli_fetch_array($result4))
					{
						$b=$b." ".gb2utf($row['tag']);
					};
					mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					//echo json_encode($a);//( $row);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
				}else{
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase where date between '".$_REQUEST['datestart']."' and '".$_REQUEST['datestop']."' order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
									$result4=mysqli_query($conn,$sqls3);
									while($row=mysqli_fetch_array($result4))
									{
											$b=$b." ".gb2utf($row['tag']);
									};
									mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
					//echo json_encode($a);//( $row);
				}
				mysqli_free_result($result3);
			}else if(isset($_REQUEST['depraise'])){
				$sqls="select * from voteup where ip='".$ip."' and shareId='".utf2gb($_REQUEST['depraise'])."'";
				$result3=mysqli_query($conn,$sqls);
				if(mysqli_num_rows($result3)!=0){
					$sqls="select voteUp from sharedatabase where shareId='".utf2gb($_REQUEST['depraise'])."'";
					$result1=mysqli_query($conn,$sqls);
					while($row=mysqli_fetch_array($result1))
					{
						$b=$row['voteUp']-1;
					}
					mysqli_free_result($result1);
					$sqls="update sharedatabase set
					voteUp='".$b."'
					where shareId='".utf2gb($_REQUEST['depraise'])."'";
					$result2=mysqli_query($conn,$sqls);
					$sqls="delete from voteup where ip='".$ip."' and shareId='".utf2gb($_REQUEST['depraise'])."'";
					$result4=mysqli_query($conn,$sqls);
					// echo json_encode($result);
					if($result4==false)
					{
						echo("new record Error,mabye name duplicate");
						die();
					}
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase where date between '".$_REQUEST['datestart']."' and '".$_REQUEST['datestop']."' order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
									$result4=mysqli_query($conn,$sqls3);
									while($row=mysqli_fetch_array($result4))
									{
											$b=$b." ".gb2utf($row['tag']);
									};
									mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
					//echo json_encode($a);//( $row);
				}else{
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase where date between '".$_REQUEST['datestart']."' and '".$_REQUEST['datestop']."' order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
					$result4=mysqli_query($conn,$sqls3);
					while($row=mysqli_fetch_array($result4))
					{
						$b=$b." ".gb2utf($row['tag']);
					};
					mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
					//echo json_encode($a);//( $row);
				}
				mysqli_free_result($result3);
			}else if(isset($_REQUEST['tread'])){
				$sqls="select * from votedown where ip='".$ip."' and shareId='".utf2gb($_REQUEST['tread'])."'";
				$result3=mysqli_query($conn,$sqls);
				if(mysqli_num_rows($result3)==0){
					$sqls="select voteDown from sharedatabase where shareId='".$_REQUEST['tread']."'";
					$result1=mysqli_query($conn,$sqls);
					while($row=mysqli_fetch_array($result1))
					{
						$b=$row['voteDown']+1;
					}
					mysqli_free_result($result1);
					$sqls="update sharedatabase set
									voteDown='".$b."'
									where shareId='".$_REQUEST['tread']."'";
					$result2=mysqli_query($conn,$sqls);
					$sqls="insert into votedown (ip,shareId)
									values ('".$ip."','".utf2gb($_REQUEST['tread'])."')";
					$result4=mysqli_query($conn,$sqls);
					// echo json_encode($result);
					if($result4==false)
					{
						echo("new record Error,mabye name duplicate");
						die();
					}

					$i=0;
					$a=array();
					$sqls="select * from sharedatabase where date between '".$_REQUEST['datestart']."' and '".$_REQUEST['datestop']."' order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
					$result4=mysqli_query($conn,$sqls3);
					while($row=mysqli_fetch_array($result4))
					{
						$b=$b." ".gb2utf($row['tag']);
					};
					mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					//echo json_encode($a);//( $row);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
				}else{
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase where date between '".$_REQUEST['datestart']."' and '".$_REQUEST['datestop']."' order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
					$result4=mysqli_query($conn,$sqls3);
					while($row=mysqli_fetch_array($result4))
					{
						$b=$b." ".gb2utf($row['tag']);
					};
					mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
					//echo json_encode($a);//( $row);
				}
				mysqli_free_result($result3);
			}else if(isset($_REQUEST['detread'])){
				$sqls="select * from votedown where ip='".$ip."' and shareId='".utf2gb($_REQUEST['detread'])."'";
				$result3=mysqli_query($conn,$sqls);
				if(mysqli_num_rows($result3)!=0){
					$sqls="select voteDown from sharedatabase where shareId='".utf2gb($_REQUEST['detread'])."'";
					$result1=mysqli_query($conn,$sqls);
					while($row=mysqli_fetch_array($result1))
					{
						$b=$row['voteDown']-1;
					}
					mysqli_free_result($result1);
					$sqls="update sharedatabase set
									voteDown='".$b."'
									where shareId='".utf2gb($_REQUEST['detread'])."'";
					$result2=mysqli_query($conn,$sqls);
					$sqls="delete from votedown where ip='".$ip."' and shareId='".utf2gb($_REQUEST['detread'])."'";
					$result4=mysqli_query($conn,$sqls);
					// echo json_encode($result);
					if($result4==false)
					{
						echo("new record Error,mabye name duplicate");
						die();
					}
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase where date between '".$_REQUEST['datestart']."' and '".$_REQUEST['datestop']."' order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
									$result4=mysqli_query($conn,$sqls3);
									while($row=mysqli_fetch_array($result4))
									{
											$b=$b." ".gb2utf($row['tag']);
									};
									mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
					//echo json_encode($a);//( $row);
				}else{
					$i=0;
					$a=array();
					$sqls="select * from sharedatabase where date between '".$_REQUEST['datestart']."' and '".$_REQUEST['datestop']."' order by shareId desc limit $start,$limit";
					$result1=mysqli_query($conn,$sqls);
					$sqls3="select tag from tags";
									$result4=mysqli_query($conn,$sqls3);
									while($row=mysqli_fetch_array($result4))
									{
											$b=$b." ".gb2utf($row['tag']);
									};
									mysqli_free_result($result4);
					while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
					
					echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
					//echo json_encode($a);//( $row);
				}
				mysqli_free_result($result3);
			}else if(isset($_REQUEST['iii'])){
				$sqls="select tag from tags";
				$result=mysqli_query($conn,$sqls);
				$i=0;
				$a=array();
				while($row=mysqli_fetch_array($result))
				{
					$a[$i]['tag']=$a[$i]['tag']." ".gb2utf($row['tag']);
				};
				$a[$i]['isPraise']=2;
				$a[$i]['isTread']=2;
				$a[$i]['userName']=gb2utf('');
				$a[$i]['headName']=gb2utf('');
				$a[$i]['urlName']=gb2utf('');
				$a[$i]['tagName']=gb2utf('');
				$a[$i]['date']=gb2utf('');
				$a[$i]['tag']=substr($a[$i]['tag'],1);
				$i=$i+1;
				mysqli_free_result($result);
				echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
				//echo json_encode($a);//( $row);
			}else{
				$i=0;
				$a=array();
				$sqls="select * from sharedatabase where date between '".$_REQUEST['datestart']."' and '".$_REQUEST['datestop']."' order by shareId desc limit $start,$limit";
				$result1=mysqli_query($conn,$sqls);
				$sqls3="select tag from tags";
				$result4=mysqli_query($conn,$sqls3);
				while($row=mysqli_fetch_array($result4))
				{
					$b=$b." ".gb2utf($row['tag']);
				};
				mysqli_free_result($result4);
				while($row=mysqli_fetch_array($result1))
					{
						$a[]=$row;
					};
					for($i=0;$i<mysqli_num_rows($result1);$i++){
						$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result2=mysqli_query($conn,$sqls1);
						if(mysqli_num_rows($result2)==0){
							$a[$i]['isPraise']=0;
						}else{
							$a[$i]['isPraise']=1;
						}
						mysqli_free_result($result2);
						$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
						$result3=mysqli_query($conn,$sqls2);
						if(mysqli_num_rows($result3)==0){
							$a[$i]['isTread']=0;
						}else{
							$a[$i]['isTread']=1;
						}
						$a[$i]['tag']=$b;
						mysqli_free_result($result3);
					}
					mysqli_free_result($result1);
				echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
				//echo json_encode($a);//( $row);
			}
		}else{
			$i=0;
			$a=array();
			$sqls="select * from sharedatabase where date between '".$_REQUEST['datestart']."' and '".$_REQUEST['datestop']."' order by shareId desc limit $start,$limit";
			$result1=mysqli_query($conn,$sqls);
			$sqls3="select tag from tags";
			$result4=mysqli_query($conn,$sqls3);
			while($row=mysqli_fetch_array($result4))
			{
				$b=$b." ".gb2utf($row['tag']);
			};
			mysqli_free_result($result4);
			while($row=mysqli_fetch_array($result1))
			{
				$a[]=$row;
			};
			for($i=0;$i<mysqli_num_rows($result1);$i++){
				$sqls1="select * from voteup where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
				$result2=mysqli_query($conn,$sqls1);
				if(mysqli_num_rows($result2)==0){
					$a[$i]['isPraise']=0;
				}else{
					$a[$i]['isPraise']=1;
				}
				mysqli_free_result($result2);
				$sqls2="select * from votedown where ip='".$ip."' and shareId='".$a[$i]['shareId']."'";
				$result3=mysqli_query($conn,$sqls2);
				if(mysqli_num_rows($result3)==0){
					$a[$i]['isTread']=0;
				}else{
					$a[$i]['isTread']=1;
				}
				$a[$i]['tag']=$b;
				msqli_free_result($result3);
			}
			mysqli_free_result($result1);
			echo '({"total":"'.$res.'","data":'.json_encode($a).'})';
			//echo json_encode($a);//( $row);
		}
	}
}
else if($_REQUEST['action']=='destroy')
{
	$postData = json_decode(file_get_contents("php://input"), true);
	// var_dump($postData);
	$a= isset($postData['shareId']);
	// echo $a;
	if($a)
	{
		$shareId= $postData['shareId'];
		if($shareId)
		{
			$sqls="delete from sharedatabase where shareId='".$shareId."'";
			$result=mysqli_query($conn,$sqls);
			$sqls="delete from comdatabase where shareId='".$shareId."'";
			$result1=mysqli_query($conn,$sqls);
			$sqls="delete from voteup where shareId='".$shareId."'";
			$result2=mysqli_query($conn,$sqls);
			$sqls="delete from votedown where shareId='".$shareId."'";
			$result3=mysqli_query($conn,$sqls);
		};
	}
	else
	{
		foreach ($postData as $key => $value)
		{
			$shareId= $value["shareId"];
			// var_dump($value);
			if($shareId)
			{
				$sqls="delete from sharedatabase where shareId='".$shareId."'";
				$result=mysqli_query($conn,$sqls);
				$sqls="delete from comdatabase where shareId='".$shareId."'";
				$result1=mysqli_query($conn,$sqls);
				$sqls="delete from voteup where shareId='".$shareId."'";
				$result2=mysqli_query($conn,$sqls);
				$sqls="delete from votedown where shareId='".$shareId."'";
				$result3=mysqli_query($conn,$sqls);
			};
		};
	}
}
else if($_REQUEST['action']=='create')
{
	$data = json_decode(file_get_contents("php://input"), true);
	//var_dump($postData);
	// echo json_encode($data['userName']);


	$sqls="insert into sharedatabase (userName,headName,urlName,tagName,date)
	 values ('".utf2gb($data['userName'])."','".utf2gb($data['headName'])."','".utf2gb($data['urlName'])."','".utf2gb($data['tagName'])."','".utf2gb(date("Y-m-d H:i:s"))."')";
	$result=mysqli_query($conn,$sqls);
	// echo json_encode($result);
	if($result==false)
	{
		echo("new record Error,mabye name duplicate");
		die();
	}
	$fi=$data['tagName'];
	$token=strtok($fi," ");
	while($token!=false){
		$sqls="select * from tags where tag='".utf2gb($token)."'";
		$result2=mysqli_query($conn,$sqls);
		if(mysqli_num_rows($result2)==0){
			$sqls="insert into tags (tag) values('".utf2gb($token)."')";
			$result1=mysqli_query($conn,$sqls);
		}
		$token=strtok(" ");
	}
}
else if($_REQUEST['action']=='update')
{
	$data = json_decode(file_get_contents("php://input"), true);
	$sqls="update sharedatabase set
	userName='".utf2gb($data['userName'])."' ,
	headName='".utf2gb($data['headName'])."' ,
	urlName='".utf2gb($data['urlName'])."' ,
	tagName='".utf2gb($data['tagName'])."' ,
	voteUp='".$data['voteUp']."',
	voteDown='".$data['voteDown']."'
	where shareId='".$data['shareId']."'";
	$result=mysqli_query($conn,$sqls);
	$fi=$data['tagName'];
	$token=strtok($fi," ");
	while($token!=false){
		$sqls="select * from tags where tag='".utf2gb($token)."'";
		$result2=mysqli_query($conn,$sqls);
		if(mysqli_num_rows($result2)==0){
			$sqls="insert into tags (tag) values('".utf2gb($token)."')";
			$result1=mysqli_query($conn,$sqls);
		}
		$token=strtok(" ");
	}
}



mysqli_close($conn);
function getonlineip(){
	if($_SERVER['HTTP_CLIENT_IP'])
	{
		$onlineip=$_SERVER['HTTP_CLIENT_IP']; //用户IP
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
