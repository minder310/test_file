<?php
    // 連線資料庫
    include_once "db.php";
    // 取出get
    $choose_group=jie($_GET['buttonData'][0]);
    $time=$_GET['time'];
    $ip=$_GET["ip"];
    $name=jie($_GET["name"]);
    
    $updata_sql=
    "UPDATE `selections` 
    SET 
    `selected_group_id`='$choose_group',
    `selected_time`='$time',
    `selected_ip`='$ip' 
    WHERE name='$name'";
    $db->query($updata_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>網頁畫面</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .title {
            font-size: 50px;
            text-align: center;
        }

        .subtitle {
            font-size: 250px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 class="title"><?= $name ?></h1>
    <h2 class="subtitle"><?= $choose_group ?></h2>
</body>
</html>
    
