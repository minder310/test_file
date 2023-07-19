<!DOCTYPE html>
<html lang="en">
<?php
// 連線資料庫。
include "db.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>按鈕和文字顯示格</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .button-container {
            display: flex;
            justify-content: center;
            width: 900px;
        }

        .button {
            width: 300px;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ccc;
            margin: 5px;
            font-size: 100px;
        }

        .text-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            font-size: 50px;
        }
    </style>
</head>

<body>
<?php
/* 
1.從資料庫取出自己是第幾組的資料。
2.顯示其他組別，數字在button裡面。
3.紀錄點選時間。
*/

// 自己的的組別
$q = $_GET['q'];
$myname = jie($q);

$what_group_sql = "SELECT * FROM selections WHERE `id`='$myname'";
// 確認有沒有這個人，有沒有投過票。
$my_group = ($db->query($what_group_sql)->fetch_assoc());
$name=$my_group["name"];
if(empty($my_group)){
    echo "沒有這個人";
    exit;
};
if(!empty($my_group["selected_ip"])){
    echo "你已經投過票了";
    exit;
}
// 取出有多少組別
$max_number_sql = "SELECT MAX(group_id) AS max_value FROM selections";
$max_number = ($db->query($max_number_sql)->fetch_assoc())["max_value"];
// 將其他組別塞入陣列。
$choose_group = [];
for ($i = 1; $i <= $max_number; $i++) {
    if ($i != $my_group['group_id']) {
        $choose_group[] = $i;
    }
}
// 宣告時間，與自己的ip
$time = date("Y-m-d H:i:s");
if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
    $ip = $_SERVER["HTTP_CLIENT_IP"];
} elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else {
    $ip = $_SERVER["REMOTE_ADDR"];
}

?>
    <form class="button-container" method="GET" action="game_1.php">
        <button class="button" id="button1" name="buttonData[]" value="<?= $choose_group[0]; ?>" ></button>
        <button class="button" id="button2" name="buttonData[]" value="<?= $choose_group[1]; ?>" ></button>
        <button class="button" id="button3" name="buttonData[]" value="<?= $choose_group[2]; ?>" ></button>

        <input type="hidden" name="time" value="<?= $time ?>">
        <input type="hidden" name="ip" value="<?= $ip ?>">
        <input type="hidden" name="name" value="<?= jia($name)?>">
    </form>

    <div class="text-container" id="textDisplay"></div>
    <script>
        // 假設後台傳遞的按鈕文字和文字顯示格文字存儲在以下變量中
        var button1Text = <?= $choose_group[0]; ?>;
        var button2Text = <?= $choose_group[1]; ?>;
        var button3Text = <?= $choose_group[2]; ?>;
        var textDisplayText = "<?= $name ?>";

        // 更新按鈕文字
        document.getElementById('button1').innerText = button1Text;
        document.getElementById('button2').innerText = button2Text;
        document.getElementById('button3').innerText = button3Text;
        // 更新value
        document.getElementById('button1').setAttribute('value', '<?= jia($choose_group[0]); ?>');
        document.getElementById('button2').setAttribute('value', '<?= jia($choose_group[1]); ?>');
        document.getElementById('button3').setAttribute('value', '<?= jia($choose_group[2]); ?>');


        // 更新文字顯示格中的文字
        document.getElementById('textDisplay').innerText = textDisplayText;

        // function submitForm() {
        // document.forms[0].submit();
    // }
    </script>
</body>

</html>