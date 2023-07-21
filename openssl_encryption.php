<?php
// ==========要加密的檔案。=======
$data="耶耶耶";
// =============================

// =====宣告一個text檔案儲存金史，跟iv======
$filename = 'key.txt';
$file = fopen($filename,'w');
$filename_iv = "iv.txt";
$file_iv = fopen($filename_iv,'w');
// ======================================

// =======宣告被加密過後的資料存在text======
$filename_word = "word.txt";
$file_word=fopen($filename_word,"w");
// ======================================

// 自動建立金鉂
$key=openssl_random_pseudo_bytes(16);
// 自動建立初始化文件。
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));
// 將文件加密。
$ciphertext=encryption($data,$key,$iv);
echo "加密後:".$ciphertext;
// 輸出三個文件資料，key.txt,iv.txt,word.txt，分別代表。金鉂，初始化，與加密後文件。
fwrite($file,$key);
fwrite($file_iv,$iv);
fwrite($file_word,$ciphertext);
fclose($file);
fclose($file_iv);
fclose($file_word);
//加密 
function encryption($word,$key,$iv){
    $ciphertext=openssl_encrypt($word,"aes-128-cbc",$key,OPENSSL_RAW_DATA,$iv);
    return base64_encode($ciphertext);
}


