<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment;filename=BP_'.date("Ymd").'.csv');
header('Cache-Control: max-age=0');

// 資料
$data = "姓名,年齡,職業,時間\n";
$data .= "John Doe,30,工程師,".date("Y.m")."\n";
$data .= "Jane Smith,25,設計師,".date("Y.m")."\n";

// 轉換資料編碼
$data = mb_convert_encoding($data, 'UTF-8', 'utf-8');

// 添加 BOM
$data = "\xEF\xBB\xBF" . $data;

// 輸出 CSV 內容
echo $data;

// 停止程式執行
exit;