<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <title>排程    </title>
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
<form action = "input_time.php" method = "post">
        <p>請輸入你每天預留的學習時數</p>
        <label >星期一: </label>
        <select id = "learn1" name = "learn1" >
            <option>0</option><option>1</option><option>2</option><option>3</option><option>4</option>
            <option>5</option><option>6</option><option>7</option><option>8</option><option>9</option>
            <option>10</option><option>11</option><option>12</option><option>13</option><option>14</option>
            <option>15</option><option>16</option><option>17</option><option>18</option><option>19</option>
            <option>20</option><option>21</option><option>22</option><option>23</option>
        </select>
        <label >星期二: </label>
        <select id = "learn2" name = "learn2" >
            <option>0</option><option>1</option><option>2</option><option>3</option><option>4</option>
            <option>5</option><option>6</option><option>7</option><option>8</option><option>9</option>
            <option>10</option><option>11</option><option>12</option><option>13</option><option>14</option>
            <option>15</option><option>16</option><option>17</option><option>18</option><option>19</option>
            <option>20</option><option>21</option><option>22</option><option>23</option>
        </select>
        <label >星期三: </label>
        <select id = "learn3" name = "learn3" >
            <option>0</option><option>1</option><option>2</option><option>3</option><option>4</option>
            <option>5</option><option>6</option><option>7</option><option>8</option><option>9</option>
            <option>10</option><option>11</option><option>12</option><option>13</option><option>14</option>
            <option>15</option><option>16</option><option>17</option><option>18</option><option>19</option>
            <option>20</option><option>21</option><option>22</option><option>23</option>
        </select>
        <label >星期四: </label>
        <select id = "learn4" name = "learn4" >
            <option>0</option><option>1</option><option>2</option><option>3</option><option>4</option>
            <option>5</option><option>6</option><option>7</option><option>8</option><option>9</option>
            <option>10</option><option>11</option><option>12</option><option>13</option><option>14</option>
            <option>15</option><option>16</option><option>17</option><option>18</option><option>19</option>
            <option>20</option><option>21</option><option>22</option><option>23</option>
        </select>
        <label >星期五: </label>
        <select id = "learn5" name = "learn5" >
            <option>0</option><option>1</option><option>2</option><option>3</option><option>4</option>
            <option>5</option><option>6</option><option>7</option><option>8</option><option>9</option>
            <option>10</option><option>11</option><option>12</option><option>13</option><option>14</option>
            <option>15</option><option>16</option><option>17</option><option>18</option><option>19</option>
            <option>20</option><option>21</option><option>22</option><option>23</option>
        </select>
        <label >星期六: </label>
        <select id = "learn6" name = "learn6" >
            <option>0</option><option>1</option><option>2</option><option>3</option><option>4</option>
            <option>5</option><option>6</option><option>7</option><option>8</option><option>9</option>
            <option>10</option><option>11</option><option>12</option><option>13</option><option>14</option>
            <option>15</option><option>16</option><option>17</option><option>18</option><option>19</option>
            <option>20</option><option>21</option><option>22</option><option>23</option>
        </select>
        <label >星期日: </label>
        <select id = "learn7" name = "learn7" >
            <option>0</option><option>1</option><option>2</option><option>3</option><option>4</option>
            <option>5</option><option>6</option><option>7</option><option>8</option><option>9</option>
            <option>10</option><option>11</option><option>12</option><option>13</option><option>14</option>
            <option>15</option><option>16</option><option>17</option><option>18</option><option>19</option>
            <option>20</option><option>21</option><option>22</option><option>23</option>
        </select><br><br>
        <label >課程一: </label>
        <select id="ClassList1" name ="ClassList1">
            <option>請選擇</option>
        </select>
        <select id="CheckClass1" name ="CheckList1">
            <option>已完成</option>
            <option>未完成</option>
        </select><br><br>
        <label >課程二: </label>
        <select id="ClassList2" name ="ClassList2">
            <option>請選擇</option>
        </select>
        <select id="CheckClass2" name ="CheckList2">
            <option>已完成</option>
            <option>未完成</option>
        </select><br><br>
        <label >課程三: </label>
        <select id="ClassList3" name ="ClassList3">
            <option>請選擇</option>
        </select>
        <select id="CheckClass3" name ="CheckList3">
            <option>已完成</option>
            <option>未完成</option>
        </select><br><br>
        <input type = "submit" value = "Submit">
    </form>   
<?php
    $time[1]=$_POST['learn1'];
    $time[2]=$_POST['learn2'];
    $time[3]=$_POST['learn3'];
    $time[4]=$_POST['learn4'];
    $time[5]=$_POST['learn5'];
    $time[6]=$_POST['learn6'];
    $time[7]=$_POST['learn7'];
    $total_time=$time[1]+$time[2]+$time[3]+$time[4]+$time[5]+$time[6]+$time[7];
    echo("星期一:".$time[1]."     ");
    echo("星期二:".$time[2]."     ");
    echo("星期三:".$time[3]."     ");
    echo("星期四:".$time[4]."     ");
    echo("星期五:".$time[5]."     ");
    echo("星期六:".$time[6]."     ");
    echo("星期日:".$time[7]."<br>");
    echo("一周預排時間為".$total_time."小時<br>");
    //每星期訓練四天以上
    $warning1=0;
    $warning2=0;
    $warning3=0;
    for($i=1;$i<=7;$i=$i+1)
    {
        if($time[$i]!=0)
        {
            $warning1=$warning1+1;
            if($time[$i]>=4)
                $warning2+=1; 

        }
        $warning3+=($time[$i]);
        
    }
    if($warning1<4)
    {
        echo("警告!!全日制職業訓練每星期需要訓練四日以上"."<br>");
    } 
    if($warning2<4)
        echo("警告!!全日制職業訓練每次上課日間4小時以上"."<br>");
    if($warning3*4<100)
        echo("警告!!全日制職業訓練每月總訓練時數100小時以上"."<br>");
    echo("<br>");

        $DB_HOST="localhost";
        $DB_USER="root";
        $DB_PASS="0000";
        
        // 建立資料庫連線
        $con =mysqli_connect($DB_HOST, $DB_USER, $DB_PASS);
        if ($con == FALSE) {
            echo "不幸地，現在無法連上資料庫。請查詢資料庫連結是否有誤，請稍後再試。\n".mysql_error();
            exit();
        }
                
        mysqli_query($con, "SET NAMES 'UTF-8'");
        $DB_NAME="職訓";
        mysqli_select_db($con,$DB_NAME);
        
        $Class = mysqli_query($con,"SELECT * FROM `職訓` ");
        if(!$Class){
               echo "Execute SQL failed : ". mysqli_error();
            exit;
        }
        $ClassCodeArr=array();     //用來存哪些選項的陣列
        $ClassCount=1;
        while($rows=mysqli_fetch_array($Class))
        {
            $ClassCodeArr[$ClassCount]=$rows['訓練職類'];
            $ClassCount++;
        }
        for($i=0;$i<count($ClassCodeArr);$i++)
        {
            echo "<script type=\"text/javascript\">";
            echo "document.getElementById(\"ClassList1\").options[$i]=new Option(\"$ClassCodeArr[$i]\",\"$ClassCodeArr[$i]\");";
            echo "document.getElementById(\"ClassList2\").options[$i]=new Option(\"$ClassCodeArr[$i]\",\"$ClassCodeArr[$i]\");";
            echo "document.getElementById(\"ClassList3\").options[$i]=new Option(\"$ClassCodeArr[$i]\",\"$ClassCodeArr[$i]\");";
            echo "</script>";
        }
    

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $query1 = $_POST['ClassList1'];
    $query2 = $_POST['ClassList2'];
    $query3 = $_POST['ClassList3'];
    $finish[1]=$_POST['CheckList1'];
    $finish[2]=$_POST['CheckList2'];
    $finish[3]=$_POST['CheckList3'];
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
    if($query2 == "請選擇"){
        //echo 'search only query1';
            $search = "SELECT * FROM `職訓` WHERE `訓練職類` LIKE '%" . $query1 ."%'";
            echo ("課程一:".$query1."<br>");
    }
    else if($query1 != "請選擇" and $query2 != "請選擇"){
        //echo 'search query1 and query2';
        if($query3 == "請選擇")
        {
            $search = "SELECT * FROM `職訓` WHERE `訓練職類` LIKE '%" . $query1 ."%' OR `訓練職類` LIKE '%" . $query2 ."%'";
            echo ("課程一:".$query1."<br>");
            echo ("課程二:".$query2."<br>");
        }
        else
        {
            $search = "SELECT * FROM `職訓` WHERE `訓練職類` LIKE '%" . $query1 ."%' OR `訓練職類` LIKE '%" . $query2 ."%'OR `訓練職類` LIKE '%" . $query3 ."%'" ;
            echo ("課程一:".$query1."<br>");
            echo ("課程二:".$query2."<br>");
            echo ("課程三:".$query3."<br>");
        }
    }
    $result = mysqli_query($con,$search);

    if (!$result) {
        echo ("錯誤：" . mysqli_error($con));
        exit();
    }
    $FinishCodeArr=array();
    $UnfinishTime=0;
    // 搜尋無資料時顯示「查無資料」
    if (mysqli_num_rows($result) <= 0) {
        echo "<tr><td colspan='4'>查無資料</td></tr>";
    }
    $classtime=0;
    $FinishCount=1;
        // 搜尋有資料時顯示搜尋結果
        while ($row = mysqli_fetch_array($result)) 
        {
            $classtime+=$row['訓練時數'];
            $FinishCodeArr[$FinishCount]=$row['訓練時數'];
            $FinishCount++;
                        
        }
        echo("預計上課時數為".$classtime."<br>");
    for($i=1;$i<=3;$i++)
    {
        if($finish[$i]=="未完成")
            $UnfinishTime+=$FinishCodeArr[$i];    

    }
    echo("尚餘上課時數:".$UnfinishTime);
}

?>

</body>

</html>