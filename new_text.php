<?php
$file = 'new_text.txt';
$content = 'HELLO WORLD';

// 開啟文件以進行寫入（如果文件不存在則創建）
$handle = fopen($file, 'w');

// 將內容寫入文件
fwrite($handle, $content);

// 關閉文件
fclose($handle);


?>