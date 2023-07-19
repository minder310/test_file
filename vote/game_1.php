<?php
// 連線資料庫
include_once "../../schedule/db.php";
include_once "../../function/function.php";
// 取出get
$choose_group = jie($_GET['buttonData'][0]);
$time = $_GET['time'];
$ip = $_GET["ip"];
$name = jie($_GET["name"]);

$updata_sql =
    "UPDATE `selections` 
    SET 
    `selected_group_id`='$choose_group',
    `selected_time`='$time',
    `selected_ip`='$ip' 
    WHERE name='$name'";
$conn->query($updata_sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>網頁畫面</title>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
        @font-face {
            font-family: 'MyCustomFont';
            src: url('./XiaolaiMonoSC-Regular.ttf');
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            font-family: 'MyCustomFont', sans-serif;;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .title {
            font-size: 50px;
            text-align: center;
            z-index: 2;
            position: relative;
        }

        .subtitle {
            font-size: 250px;
            text-align: center;
            z-index: 2;
            position: relative;
        }
    </style>
</head>

<body>
    <div id="particles-js"></div>
    <h1 class="title"><?= $name ?></h1>
    <h2 class="subtitle"><?= $choose_group ?></h2>
    <script>
        particlesJS("particles-js", {
            particles: {
                number: { value: 100 },
                size: { value: 3 },
                color: { value: '#1472FA' },
                line_linked: {
                    color: '#21E8F5',
                    opacity: 0.5
                },
                move: {
                    direction: 'none',
                    speed: 1,
                    random: true,
                    straight: false,
                    out_mode: 'out'
                }
            },
            interactivity: {
                events: {
                    onhover: { enable: true, mode: 'repulse' },
                    onclick: { enable: true, mode: 'push' }
                },
                modes: {
                    repulse: { distance: 200, duration: 0.4 },
                }
            },
            retina_detect: true
        });
    </script>
</body>

</html>