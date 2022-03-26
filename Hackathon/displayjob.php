<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>

<body>

<?php

// 定義資料庫資訊
$DB_NAME = "104";
$DB_USER = "root";
$DB_PASS = "0000";
$DB_HOST = "localhost";

// 連接 MySQL 資料庫伺服器
$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS);
if (empty($con)) {
    print mysqli_error($con);
    die("資料庫連接失敗！");
    exit;
}

// 選取資料庫
if (!mysqli_select_db($con, $DB_NAME)) {
    die("選取資料庫失敗！");
}

// 設定連線編碼
mysqli_query($con, "SET NAMES 'UTF-8'");
echo "<table>
<tr>
<th>職務名稱</th>
<th>學歷</th>
<th>語言條件1</th>
<th>語言條件2</th>
<th>語言條件3</th>
<th>相關科系類別</th>
<th>相關科系類別2</th>
<th>相關科系類別3</th>
<th>職務描述</th>
<th>其他條件</th>
</tr>";
$job_id=$_GET['value'];
if ($job_id=='2000000000')
	$sql = "SELECT * FROM job_info_schema";
else if ((int)$job_id%1000000==0)
{
	$job_id2=strval((int)$job_id+1000000-1);
	$sql = "SELECT * FROM job_info_schema WHERE jobcat1 BETWEEN '$job_id' AND '$job_id2' OR jobcat2 BETWEEN '$job_id' AND '$job_id2' OR jobcat3 BETWEEN '$job_id' AND '$job_id2'";
}
else if ((int)$job_id%1000==0)
{
	$job_id2=strval((int)$job_id+1000-1);
	$sql = "SELECT * FROM job_info_schema WHERE jobcat1 BETWEEN '$job_id' AND '$job_id2' OR jobcat2 BETWEEN '$job_id' AND '$job_id2' OR jobcat3 BETWEEN '$job_id' AND '$job_id2'";
}
else $sql = "SELECT * FROM job_info_schema WHERE jobcat1 = '$job_id' OR jobcat2='$job_id' OR jobcat3= '$job_id' "; 
	
$result = mysqli_query($con, $sql);
$i=strval(mysqli_num_rows($result));
echo ("共有".$i."筆符合之資料");
if (!$result) {
	echo ("錯誤：" . mysqli_error($con));
	exit();
}

while ($row = mysqli_fetch_array($result)) {
	$edunum=base_convert((int)$row['edu'], 10,2);
	$eduoutput="";
	$edutext=array("高中以下","高中","專科","大學","碩士","博士");
	$ten=10;
	for ($i=0;$i<6;$i++)
	{
		if($edunum%$ten!=0) $eduoutput.=$edutext[$i]." ";
		$edunum-=$edunum%$ten;
		$ten=$ten*10;
	}
	$row['edu']=$eduoutput;
	if($row['language1']=="1111"||$row['language1']=="0") 
		$row['language1']="無";
	if($row['language2']=="1111"||$row['language2']=="0") 
		$row['language2']="無";
	if($row['language3']=="1111"||$row['language3']=="0") 
		$row['language3']="無";
	$Lgnum1=(int)$row['language1'];
	$Lgnum2=(int)$row['language2'];
	$Lgnum3=(int)$row['language3'];
	$Lg=array("","英文","日文","法文","德文","西班牙文","","","","越文","泰文","馬來文"
	,"印尼文","韓文","俄文","義大利文","葡萄牙文","阿拉伯文","中文","菲律賓文");
	$level=array(1=>'不會',2=>'精通',4=>'略懂',8=>'中等');
	$Lgtype=array('寫','讀','說','聽');
	for($i=1;$i<=19;$i++)
	{	
		if(floor($Lgnum1/10000)==49) 
			$row['language1']="其他外文，";
		if(floor($Lgnum2/10000)==49) 
			$row['language2']="其他外文，";
		if(floor($Lgnum3/10000)==49) 
			$row['language3']="其他外文，";
		if(floor($Lgnum1/10000)==$i) 
			$row['language1']=$Lg[$i];
		if(floor($Lgnum2/10000)==$i) 
			$row['language2']=$Lg[$i];
		if(floor($Lgnum3/10000)==$i) 
			$row['language3']=$Lg[$i];
	}
	$Lgnum1%=10000;
	$Lgnum2%=10000;
	$Lgnum3%=10000;
	for($i=3;$i>=0;$i--)
	{
		if($row['language1']!="無")
		{
			$row['language1'].="，".$Lgtype[$i].":".$level[floor($Lgnum1/pow(10,$i))];
			$Lgnum1%=pow(10,$i);
		}
		if($row['language2']!="無")
		{
			$row['language2'].="，".$Lgtype[$i].":".$level[floor($Lgnum2/pow(10,$i))];
			$Lgnum2%=pow(10,$i);
		}
		if($row['language3']!="無")
		{
			$row['language3'].="，".$Lgtype[$i].":".$level[floor($Lgnum3/pow(10,$i))];
			$Lgnum3%=pow(10,$i);
		}
	}
	
	/*else if($row['edu']=="2") $row['edu']="高中";
	else if($row['edu']=="4") $row['edu']="專科";
	else if($row['edu']=="8") $row['edu']="大學";
	else if($row['edu']=="16") $row['edu']="碩士";
	else $row['edu']="博士";*/
	echo "<tr>";
	echo "<td>" . $row['job'] . "</td>";
	echo "<td>" . $row['edu'] . "</td>";
	/*echo "<td>" . $row['jobcat1'] . "</td>";
	echo "<td>" . $row['jobcat2'] . "</td>";
	echo "<td>" . $row['jobcat3'] . "</td>";*/
	echo "<td>" . $row['language1'] . "</td>";
	echo "<td>" . $row['language2'] . "</td>";
	echo "<td>" . $row['language3'] . "</td>";
	$d1=$row['major_cat'];
	$d2=$row['major_cat2'];
	$d3=$row['major_cat3'];
	$result1=mysqli_query($con,"SELECT 類目名稱 FROM `department` WHERE 類目代碼='$d1'");
	$value1 = $result1->fetch_row()[0] ?? false;	
	$row['major_cat']=$value1;
	$result2=mysqli_query($con,"SELECT 類目名稱 FROM `department` WHERE 類目代碼='$d2'");
	$value2 = $result2->fetch_row()[0] ?? false;	
	$row['major_cat2']=$value2;
	$result3=mysqli_query($con,"SELECT 類目名稱 FROM `department` WHERE 類目代碼='$d3'");
	$value3 = $result3->fetch_row()[0] ?? false;
	$row['major_cat3']=$value3;
	echo "<td>" . $row['major_cat'] . "</td>";
	echo "<td>" . $row['major_cat2'] . "</td>";
	echo "<td>" . $row['major_cat3'] . "</td>";
	echo "<td>" . $row['description'] . "</td>";
	echo "<td>" . $row['others'] . "</td>";
	echo "</tr>";
}

echo "</table>";
    
mysqli_close($con); // 連線結束
    

?>
</body>

</html>