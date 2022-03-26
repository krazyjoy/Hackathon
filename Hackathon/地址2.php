<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <title>地址二    </title>
    <meta charset="UTF-8">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" type="text/css" href="./g1.css" />
    <!-- <link rel="stylesheet" type="text/css" href="/location/location.css" /> -->
    <script src="./g1.js"></script>
    <!-- <script src="/location/location.js"></script> -->
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
<form action = "地址2.php" method = "post">
        <p>請輸入你每天預留的學習時數</p>
        
        <label >課程一: </label>
        <select id="list1" name="list1" onchange="update1()">
            <option>請選擇</option>
        </select>
        <label >開課單位: </label>
        <select id="list2" name="list2" onchange="update2()">
            <option>請選擇</option>
        </select>
        <label >分部: </label>
        <select id="list3" name="list3">
            <option>請選擇</option>
        </select><br><br>
        
        <input type = "submit" value = "Submit" >
</form> 
<?php

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
        $DB_NAME2="職訓中心地址";
        mysqli_select_db($con,$DB_NAME);
        mysqli_select_db($con,$DB_NAME2);
        $Class = mysqli_query($con,"SELECT * FROM `職訓` ");
        if(!$Class){
               echo "Execute SQL failed : ". mysqli_error();
            exit;
        }
        $Class2 = mysqli_query($con,"SELECT * FROM `職訓中心地址`");
        if(!$Class2){
               echo "Execute SQL failed : ". mysqli_error();
            exit;
        }
        $ClassCodeArr=array();     //用來存哪些選項的陣列
        $HostCodeArr=array();
        $HostCodeArr2=array();
        $AddressCodeArr=array();
        $AddressCodeArr2=array();
        $i=0;
        while($rows=mysqli_fetch_array($Class))
        {
            $ClassCodeArr[$i]=$rows['訓練職類'];
            $HostCodeArr[$i]=$rows['訓練單位地址'];
            $i++;
        }
        $i=0;
        while($rows=mysqli_fetch_array($Class2))
        {
            $j=0;
            $HostCodeArr2[$i]=$rows['本部'];
            $Class3 = mysqli_query($con,"SELECT * FROM `職訓中心地址` WHERE `本部`='$HostCodeArr2[$i]'");
            while($rows=mysqli_fetch_array($Class3))
            {
                
                $AddressCodeArr2[$i][$j]=$rows['分部'];
                
                $j++;
            }
            $i++;
        }
        for($i=0;$i<count($HostCodeArr);$i++)
        {
            $result=mysqli_query($con,"SELECT * FROM `職訓中心地址` WHERE `本部`='$HostCodeArr[$i]'");
            for($j=0;$j<count($HostCodeArr2);$j++)
            {
                if($HostCodeArr[$i]==$HostCodeArr2[$j])
                {
                    for($k=0;$k<count($AddressCodeArr2[$j]);$k++)
                    {
                        $AddressCodeArr[$i][$k]=$AddressCodeArr2[$j][$k];
                        //echo $i."<br>";
                    }
                }
            }

        }
        /*for($i=0 ;$i<count($HostCodeArr)-1;$i++)
        {
            for($j=0;$j<count($AddressCodeArr[$i]);$j++)
                echo($AddressCodeArr[$i][$j]."<br>");
        }
        
        for($i=0;$i<count($ClassCodeArr);$i++)
        {
            echo "<script type=\"text/javascript\">";
            echo "document.getElementById(\"ClassList1\").options[$i]=new Option(\"$ClassCodeArr[$i]\",\"$ClassCodeArr[$i]\");";
            echo "document.getElementById(\"Host1\").options[$i]=new Option(\"$HostCodeArr[$i]\",\"$HostCodeArr[$i]\");";
            echo "document.getElementById(\"Address1\").options[$i]=new Option(\"$AddressCodeArr[$i]\",\"$AddressCodeArr[$i]\");";
            echo "</script>";
        }*/
        $big=($_POST['list1']);
        $mid=($_POST['list2']);
        $small=($_POST['list3']);
        echo($small."<br>");
        $search = "SELECT * FROM `職訓中心地址` WHERE `分部` LIKE '%" . $small ."%'";
        $result = mysqli_query($con,$search);
        while ($row = mysqli_fetch_array($result)) {
            $destination= $row['地址'];
            echo $row['地址'];
        }
    


?>


<script language="JavaScript" type='text/javascript'>
var jclass= <?php echo json_encode($ClassCodeArr); ?>;
var jhost= <?php echo json_encode($HostCodeArr); ?>;
var jaddress= <?php echo json_encode($AddressCodeArr); ?>;
</script>
<script language="JavaScript" type="text/javascript" src="test.js"></script>
<h1>Google Maps</h1>
    <div style="display: none">
      <input
        id="origin-input"
        class="controls"
        type="text"
        placeholder="輸入地點一"
        value=""
      />

      <input
        id="destination-input"
        name="inputdes"
        class="controls"
        type="text"
        placeholder="輸入地點二"
        value="<?php echo $destination; ?>"
      <!-- <input
        id="autoposition"
        name="inputdes"
        class="controls"
        type="text"
        value=""
      /> -->

      <div id="mode-selector" class="controls">
        <input
          type="radio"
          name="type"
          id="changemode-walking"
          checked="checked"
        />
        <label for="changemode-walking">走路</label>

        <input type="radio" name="type" id="changemode-transit" />
        <label for="changemode-transit">大眾運輸</label>

        <input type="radio" name="type" id="changemode-driving" />
        <label for="changemode-driving">開車</label>
      </div>
    </div>
    <!-- <div class="col-xs-offset-2 col-xs-10">
      <button>search</button>
    </div> -->
    <div id="map"></div>
    <div id="output"></div>
    <div id="output2"></div>
    <div id="map2"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaPmpoPpEpG1rumCf8G35oKI9NVdMNH8s&callback=initMap&libraries=places&v=weekly"
      async
    ></script>
   
    <!-- <div id = "getPosition">
      <iframe id = "myframe" src =""></iframe>
    </div> -->
    
  </body>


</html>