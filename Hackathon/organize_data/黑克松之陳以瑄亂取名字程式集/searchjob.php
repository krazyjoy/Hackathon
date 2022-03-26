<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <form Name="searchjob" action = "../displayjob.php" method = "post" target = "_blank">
		<label>目前職業:
		<!--<input list="list1" id = "query1 "name="PreJob1"</label>-->
		<select id="list1" onchange="update1()"></select>
		<!--<input list="list2" id = "query2 "name="PreJob2"></label>-->
		<select id="list2" onchange="update2()"></select>
		<!--<input list="list3" id = "query3 "name="PreJob3"></label>-->
		<select id="list3"></select>
		<BR>
		<BR>
		<BR>
		<BR>
		<BR>
		<label>欲轉職職業:
		<!--<input list="list4" id = "query4 "name="FindJob1"></label>-->
		<select id="list4" onchange="update4()"></select>
		<!--<input list="list5" id = "query5 "name="FindJob2"></label>-->
		<select id="list5" onchange="update5()"></select>
		<!--<input list="list6" id = "query6 "name="FindJob3"></label>-->
		<select id="list6" onchange="update6()"></select>
        <input type = "submit" value = "Submit" onclick="express()">
    </form>
    </div>   
</body>
<?php
$DB_HOST="localhost";
$DB_USER="root";
$DB_PASS="0000";

// 建立資料庫連線
$link =mysqli_connect($DB_HOST, $DB_USER, $DB_PASS);
if ($link == FALSE) {
	echo "不幸地，現在無法連上資料庫。請查詢資料庫連結是否有誤，請稍後再試。\n".mysql_error();
	exit();
}
		
mysqli_query($link, "SET NAMES 'UTF-8'");
$DB_NAME="104";
mysqli_select_db($link,$DB_NAME);

$Class = mysqli_query($link,"SELECT * FROM `job_category` ORDER BY `job_category`.`類目代碼` ASC");
if(!$Class){
   	echo "Execute SQL failed : ". mysqli_error();
	exit;
}
$CountArr=array();     //用來存哪些選項的陣列
$ClassCount=0;
while($rows=mysqli_fetch_array($Class))
{
	$CountArr[$ClassCount]=(int)$rows['類目代碼'];
	$ClassCount++;
}
$s=1;
$big=array();
$mid=array();
$small=array();
for($i=0;$i<20;$i++)
{
	if($s>=528)
		break;
	$result=mysqli_query($link,"SELECT 類目名稱 FROM `job_category` WHERE 類目代碼='$CountArr[$s]'");
	$value = $result->fetch_row()[0] ?? false;
	$big[$i]=$value;
	$s++;
	$mid[$i][0] ="請選擇";
	$small[$i][0][0] ="請選擇";
	for($j=1;$j<100;$j++)
	{
		if($s>=528)
			break;
		if ((floor($CountArr[$s] / 1000000) - floor($CountArr[$s-1] / 1000000) )!= 0)
			break;
		$result=mysqli_query($link,"SELECT 類目名稱 FROM `job_category` WHERE 類目代碼='$CountArr[$s]'");
		$value = $result->fetch_row()[0] ?? false;		
		$mid[$i][$j] = $value;
		$s++;
		$small[$i][$j][0] = "請選擇";
		for ($k = 1; $k < 80; $k++)
		{
			if ((floor($CountArr[$s] / 1000) - floor($CountArr[$s-1] / 1000) )!= 0)
				break;
			if (($CountArr[$s] - $CountArr[$s-1]) != 1)
				break;
			$result=mysqli_query($link,"SELECT 類目名稱 FROM `job_category` WHERE 類目代碼='$CountArr[$s]'");
			$value = $result->fetch_row()[0] ?? false;
			$small[$i][$j][$k] = $value;
			$s++;
			if($s>=528)
				break;
		}
	}
}46740
?>
<script language="JavaScript" type='text/javascript'>
var jbig= <?php echo json_encode($big); ?>;
var jmid= <?php echo json_encode($mid); ?>;
var jsmall= <?php echo json_encode($small); ?>;
</script>
<script language="JavaScript" type="text/javascript" src="updatelist.js"></script>
</html>