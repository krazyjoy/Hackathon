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
<form action = "search.php" method = "post" target = "_self">
        <label for = "search_text1" >職業別: </label>
        <input type = "text" id = "query1" name = "query1"><br><br>
        <label for = "search_text1" >行業別 : </label>
        <input type = "text" id = "query2" name = "query2"><br><br>
        <input type = "submit" value = "Submit">
        <br><br>
    </form>
<?php

// 定義資料庫資訊
$DB_NAME = "平均薪資";
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
<th>職類別</th>
<th>行業別</th>
<th>受僱員工人數</th>
<th>總薪資</th>
<th>經常性薪資</th>
<th>非經常性薪資</th>
<th>平均薪資</th>
</tr>";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $query1 = $_POST['query1'];
    $query2 = $_POST['query2'];
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
if($query1 == null and $query2 == null) { // 如果沒有搜尋文字顯示所有資料
    $sql = "SELECT * FROM `平均薪資總表` ";
    $result = mysqli_query($con, $sql);
    
    if (!$result) {
        echo ("錯誤：" . mysqli_error($con));
        exit();
    }
    
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['職類別'] . "</td>";
        echo "<td>" . $row['行業別'] . "</td>";
        echo "<td>" . $row['受僱員工人數'] . "</td>";
        echo "<td>" . $row['總薪資'] . "</td>";
        echo "<td>" . $row['經常性薪資'] . "</td>";
        echo "<td>" . $row['非經常性薪資'] . "</td>";
        echo "<td>" . $row['平均薪資'] . "</td>";
        echo "</tr>";
    }
}
else{
    if($query2 == null){
        //echo 'search only query1';
        $search = "SELECT * FROM `平均薪資總表` WHERE `職類別` LIKE '%" . $query1 ."%'";
    
    }
    else if ($query1 == null ){
        //echo 'search query1 and query2';
        $search = "SELECT * FROM `平均薪資總表` WHERE  `行業別` LIKE '%" . $query2 . "%'" ;
    }
    else if($query1 != null and $query2 != null){
        //echo 'search query1 and query2';
        $search = "SELECT * FROM `平均薪資總表` WHERE  `職類別` LIKE '%" . $query1 . "%' AND `行業別` LIKE '%" . $query2 . "%'" ;
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
            echo "<td>" . $row['職類別'] . "</td>";
            echo "<td>" . $row['行業別'] . "</td>";
            echo "<td>" . $row['受僱員工人數'] . "</td>";
            echo "<td>" . $row['總薪資'] . "</td>";
            echo "<td>" . $row['經常性薪資'] . "</td>";
            echo "<td>" . $row['非經常性薪資'] . "</td>";
            echo "<td>" . $row['平均薪資'] . "</td>";
            echo "</tr>";
        }
   
}

echo "</table>";

mysqli_close($con); // 連線結束

?>

</body>

</html>