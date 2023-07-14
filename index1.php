<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hello word</title>
</head>
<body>
    <?php
    session_start();
    echo "hello word";
    echo "<br>";
    echo "SERVER['PHP_SELF']=";
    print_r($_SERVER['PHP_SELF']);
    echo "代表現在在執行的php程式碼。";
    echo "<br>";
    echo "SERVER['REQUEST_URI']=";
    print_r($_SERVER['REQUEST_URI']);
    echo "代表現在頁面的url，如果是index.php即為不存在。";
    echo "<br>";
    if(!empty($_SERVER['REQUEST_URI'])){
        echo "存在。";
        $u1="/index.php";
        $u2="/?";
        echo strpos($_SERVER['REQUEST_URI'],$u1);
        echo "<br>";
        echo strpos($_SERVER['REQUEST_URI'],$u2);
        echo "<br>";
        if(strpos($_SERVER['REQUEST_URI'],$u1) !== false){
            echo "!==".$u1;
            $get_url = substr(strchr($_SERVER['REQUEST_URI'],$u1),13);
        }elseif(strpos($_SERVER['REQUEST_URI'],$u2) !== false){
            echo "!==".$u2;
            $get_url = substr(strchr($_SERVER['REQUEST_URI'],$u2),2);
        }else{
            echo "都不存在。";
        }
    }else{
        echo "不存在。";
    }
    $u["/"]="min.php";
    print_r($u);
    
    // 測試ip取得方式。
    $ip1 = $_SERVER["HTTP_CLIENT_IP"];
    echo "ip1".$ip1;
    echo "<br>";
    $ip2 =  $_SERVER["HTTP_X_FORWARDED_FOR"];
    echo "ip2".$ip2;
    echo "<br>";
    $ip3 = $_SERVER["REMOTE_ADDR"];
    echo "ip3".$ip3;
    
    // 測試$_session['admin']是否存在。
    $_SESSION['admin']='pierre';
    if(empty($_SESSION['admin'])){
        echo "session不存在唷。";
    }else{
        echo "session存在唷。";
        echo $_SESSION['admin'];
    }
    echo "<hr>";
    $_GET["s"]="login";
    echo $_GET["s"];
    echo "<br>";
    $goto=$u[$_GET["s"]];
    print_r ($goto);
    print_r($u);
    ?>
    <hr>
    <?php
    include "./db_test.php";
    $obqqtklj_beautypay=new db("obqqtklj_beautypay");
    dd($obqqtklj_beautypay->SeeSomeThing());
    ?>
</body>
</html>