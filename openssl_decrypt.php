<?php
$filename_key="key.txt";
$keyfp=fopen($filename_key, 'r');
$key=fread($keyfp,filesize("key.txt"));
$filename_iv="iv.txt";
$ivfp=fopen($filename_iv, 'r');
$iv=fread($ivfp,filesize("iv.txt"));
$filename_word="word.txt";
$wordfp=fopen($filename_word,'r');
$word=fread($wordfp,filesize("word.txt"));

$an=decryption($word,$key,$iv);

echo $an; 


//解密
function decryption($ciphertext, $key, $iv){
    $ciphertext = base64_decode($ciphertext);
    $plaintext = openssl_decrypt($ciphertext, "aes-128-cbc", $key, OPENSSL_RAW_DATA, $iv);
    return $plaintext;
}
