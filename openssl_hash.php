<?php
// 單向加密測試程式，測測看輸出是不是都一樣。
// 哈希函數，單向測試，已確定每次輸出結果都一樣，用於儲存密碼，讓密碼不會用明碼儲存。
$data = 'Hello, world!';
$hash = openssl_digest($data, 'sha256');
echo $hash;
echo "<br>";
$data = '1';
$hash = hash('sha512', $data);
echo $hash;
echo "<br>";
$data="123456";
$md5 = md5(md5(md5($data)));
echo $md5;
