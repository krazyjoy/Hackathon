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
    <form action = "searchclass.php" method = "post" target = "_self">
        <label for = "search_text1" >訓練職類: </label>
        <input type = "text" id = "query1" name = "query1"><br><br>
        <label for = "search_text1" >訓練時數 : </label>
        <input type = "text" id = "query2" name = "query2"><br><br>
        <label for = "search_text1" >訓練單位地址 : </label>
        <input type = "text" id = "query3" name = "query3"><br><br>
        <input type = "submit" value = "Submit">
        <br><br>
    </form>
<?php

// 定義資料庫資訊
$DB_NAME = "職訓";
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

// 顯示表頭
echo "<table>
<tr>
<th>訓練職類</th>
<th>訓練時數</th>
<th>預訓人數</th>
<th>報名起訖日期</th>
<th>訓練期間</th>
<th>受訓資格</th>
<th>訓練單位地址</th>
</tr>";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $query1 = $_POST['query1'];
    $query2 = $_POST['query2'];
    $query3 = $_POST['query3'];
    /*if(empty($query1)){
        echo "query1 is empty";
    }
    else{
        echo $query1;
    }
    if(empty($query2)){
        echo "query2 is empty";
    }else{
        echo $query2;
    }*/
}
if($query1){
    if($query2 == null){
        //echo 'search only query1';
        if($query3 == null)
            $search = "SELECT * FROM `職訓` WHERE `訓練職類` LIKE '%" . $query1 ."%'";
        else
            $search = "SELECT * FROM `職訓` WHERE  `訓練職類` LIKE '%" . $query1 . "%' AND `訓練單位地址` LIKE '%" . $query3 . "%'" ;
    }
    else if($query1 != null and $query2 != null){
        //echo 'search query1 and query2';
        if($query3 == null)
            $search = "SELECT * FROM `職訓` WHERE `訓練職類` LIKE '%" . $query1 ."%' AND `訓練時數` LIKE '%" . $query2 . "%'";
        else
            $search = "SELECT * FROM `職訓` WHERE  `訓練職類` LIKE '%" . $query1 . "%' AND `訓練時數` LIKE '%" . $query2 . "%' AND `訓練單位地址` LIKE '%" . $query3 . "%'" ;
    }
    $result = mysqli_query($con,$search);

    if (!$result) {
        echo ("錯誤：" . mysqli_error($con));
        exit();
    }
    
    // 搜尋無資料時顯示「查無資料」
    if (mysqli_num_rows($result) <= 0) {
        echo "<tr><td colspan='4'>查無資料</td></tr>";
    }
    
        // 搜尋有資料時顯示搜尋結果
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['訓練職類'] . "</td>";
            echo "<td>" . $row['訓練時數'] . "</td>";
            echo "<td>" . $row['預訓人數'] . "</td>";
            echo "<td>" . $row['報名起訖日期'] . "</td>";
            echo "<td>" . $row['訓練期間'] . "</td>";
            echo "<td>" . $row['受訓資格'] . "</td>";
            echo "<td>" . $row['訓練單位地址'] . "</td>";
            echo "</tr>";
        }
   
} else { // 如果沒有搜尋文字顯示所有資料
    $sql = "SELECT * FROM `職訓` ";
    $result = mysqli_query($con, $sql);
    
    if (!$result) {
        echo ("錯誤：" . mysqli_error($con));
        exit();
    }
    
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['訓練職類'] . "</td>";
        echo "<td>" . $row['訓練時數'] . "</td>";
        echo "<td>" . $row['預訓人數'] . "</td>";
        echo "<td>" . $row['報名起訖日期'] . "</td>";
        echo "<td>" . $row['訓練期間'] . "</td>";
        echo "<td>" . $row['受訓資格'] . "</td>";
        echo "<td>" . $row['訓練單位地址'] . "</td>";
        echo "</tr>";
    }
}

echo "</table>";

mysqli_close($con); // 連線結束

?>

</body>

</html>