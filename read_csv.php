<html>
<head>
    <meta charset="UTF-8">
    <title>上傳CSV檔案</title>
</head>
<body>
    <?php
    print_r($_POST["csvFile"]);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        print_r($_POST);
        $uploadDir = 'uploads/';
        $uploadedFile = $_FILES['csvFile']['tmp_name'];
        $targetFile = $uploadDir . basename($_FILES['csvFile']['name']);
    
        // 檢查是否成功上傳檔案
        if (move_uploaded_file($uploadedFile, $targetFile)) {
            echo "檔案上傳成功！";
            // 在這裡可以對上傳的CSV檔案進行處理
        } else {
            echo "檔案上傳失敗。";
        }
    }
    ?>
    <h1>上傳CSV檔案</h1>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
        <label for="csvFile">選擇CSV檔案：</label>
        <input type="file" name="csvFile" id="csvFile" accept=".csv">
        <br>
        <input type="submit" value="上傳">
    </form>
</body>
</html>

<?php
// $filename = '活頁簿1.csv'; // 將 '檔案路徑.csv' 替換為您的CSV檔案路徑

// if (!file_exists($filename)) {
//     die("找不到檔案或檔案不存在。");
// }

// // 開啟檔案以讀取內容，同時指定使用UTF-8編碼
// $file = fopen($filename, 'r');

// // 檢查檔案是否成功開啟
// if (!$file) {
//     die("無法開啟檔案。");
// }
// $sql="
// INSERT INTO `selections`
// (`name`, `group_id`, `selected_group_id`, `selected_time`, `selected_ip`)
//  VALUES " ;
// // 逐行讀取CSV檔案的內容
// $rows=[];
// while (($row = fgetcsv($file) ) !== false) {
//     // $row 是一個包含目前行資料的陣列
//     // 在這裡您可以對$row做任何需要的處理
//     $rows[]=$row;    
// }
// $sql_in_data=[];
// for($i=1;$i<count($rows);$i++){
//     $sql_in_data[]="( ".implode(",",$rows[$i])." )";
// }
// $sql .=implode(",",$sql_in_data);
// echo $sql;
// // 關閉檔案資源
// fclose($file);
// ?>