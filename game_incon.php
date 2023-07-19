<?php
    include_once "db.php";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>輸入英文名字</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .input-container {
            text-align: center;
        }

        .input-container input {
            width: 300px;
            padding: 10px;
            font-size: 16px;
        }

        .input-container button {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <form method="POST" class="input-container" action="game.php">
        <h2>請輸入你的英文姓名</h2>
        <input type="text" id="nameInput" name="name">
        <button>提交</button>
    </div>
    <a href="game_all.php">公布結果</a>
</body>
</html>
