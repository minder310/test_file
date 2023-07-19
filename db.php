<?php
    $servername = "localhost"; // 資料庫伺服器名稱
    $username = "root"; // 資料庫使用者名稱
    $password = ""; // 資料庫密碼
    $dbname = "test"; // 資料庫名稱
    $db=new mysqli($servername,$username,$password,$dbname);
    if ($db->connect_error) {
        echo "連線失敗";
    };
    function jia($a){
        $key = "1234567890123456";
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($a, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
    
    function jie($e){
        $key = "1234567890123456";
        list($encrypted_data, $iv) = explode('::', base64_decode($e), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    }