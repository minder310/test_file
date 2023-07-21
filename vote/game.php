<!DOCTYPE html>
<html lang="en">
<?php
// 連線資料庫。
include_once "../../schedule/db.php";
include_once "../../function/function.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>按鈕和文字顯示格</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'MyCustomFont';
            src: url('./XiaolaiMonoSC-Regular.ttf');
        }

        body {
            font-family: 'MyCustomFont', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            /* background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            animation: gradient 15s ease infinite; */
            background-color: whitesmoke;
        }

        .button-container {
            display: flex;
            justify-content: center;
            width: 900px;
            margin-bottom: 20px;
        }

        .button {
            width: 300px;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(90deg, #0278F6 0%, #0A9BD6 50%, #09DFEB 100%);
            /* Button color gradient */
            margin: 5px;
            font-size: 70px;
            border-radius: 15px;
            transition: 0.3s;
            color: white;
            /* Button text color */
            border: none;
            cursor: pointer;
            outline: none;
            box-shadow: inset 0px 0px 0px 1px #6AABD4, 0px 5px 30px 5px #000;
            /* Button shadow color */
        }

        .button:hover {
            transform: scale(1.05);
        }

        .text-container {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            color: black;
            /* Text color */
            padding-bottom: 40px;
        }

        /* Mobile phones (portrait) */
        @media only screen and (max-width: 450px) {
            .button {
                width: 100px;
                height: 100px;
                font-size: 20px;
            }

            .text-container {
                font-size: 30px;
            }
        }

        @media only screen and (min-width: 451px) and (max-width: 600px) {
            .button {
                width: 200px;
                height: 200px;
                font-size: 40px;
            }

            .text-container {
                font-size: 30px;
            }
        }

        /* Tablet to laptop (portrait) */
        @media only screen and (min-width: 601px) and (max-width: 1024px) {
            .button {
                width: 250px;
                height: 250px;
                font-size: 50px;
            }

            .text-container {
                font-size: 40px;
            }
        }

        /* Desktop */
        @media only screen and (min-width: 1025px) {
            .button {
                width: 300px;
                height: 300px;
                font-size: 70px;
            }

            .text-container {
                font-size: 50px;
            }
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
    $my_group = ($conn->query($what_group_sql)->fetch_assoc());
    $name = $my_group["name"];
    if (empty($my_group)) {
        echo "沒有這個人";
        exit;
    };
    if (!empty($my_group["selected_ip"])) {
        echo "你已經投過票了";
        exit;
    }
    // 取出有多少組別
    $max_number_sql = "SELECT MAX(group_id) AS max_value FROM selections";
    $max_number = ($conn->query($max_number_sql)->fetch_assoc())["max_value"];
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
    // 小小寫個轉換資料庫。
    $name2 = [
        1 => "Kevin",
        2 => "Jeff",
        3 => "LingYun",
        4 => "Jackie"
    ];
    ?>
    <div class="text-container">你要投給哪一組</div>
    <form class="button-container" method="GET" action="game_1.php">
        <button class="button" id="button1" name="buttonData[]" value="<?= $choose_group[0]; ?>"></button>
        <button class="button" id="button2" name="buttonData[]" value="<?= $choose_group[1]; ?>"></button>
        <button class="button" id="button3" name="buttonData[]" value="<?= $choose_group[2]; ?>"></button>

        <input type="hidden" name="time" value="<?= $time ?>">
        <input type="hidden" name="ip" value="<?= $ip ?>">
        <input type="hidden" name="name" value="<?= jia($name) ?>">
    </form>

    <div class="text-container" id="textDisplay"></div>
    <script>
        // 假設後台傳遞的按鈕文字和文字顯示格文字存儲在以下變量中
        var button1Text = "<?= $name2[$choose_group[0]]; ?>";
        var button2Text = "<?= $name2[$choose_group[1]]; ?>";
        var button3Text = "<?= $name2[$choose_group[2]]; ?>";
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