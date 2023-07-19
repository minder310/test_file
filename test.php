<?php
// 包含PHPExcel庫
include_once "./Classes/PHPExcel.php";
ini_set('memory_limit', '1024M');
set_time_limit(300);
// 創建新的PHPExcel對象
$objPHPExcel = new PHPExcel();

// 設置活動工作表索引為第一個工作表，所以Excel打開這個工作表
$objPHPExcel->setActiveSheetIndex(0);

// 打開TXT文件並讀取內容
$file = fopen('BP_20230717.txt', 'r');
$row = 1; // 1-based index
while (($data = fgetcsv($file, 0, ";")) !== FALSE) {
    $col = 0;
    foreach ($data as $value) {
        // 將數據添加到工作表中
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
        $col++;
    }
    $row++;
}
fclose($file);

// 將工作表標題設置為"Sheet 1"
$objPHPExcel->getActiveSheet()->setTitle('Sheet 1');

// 設置Excel 2007格式（xlsx）的Writer對象
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

// 將工作表保存為xlsx格式
$objWriter->save('yourfile.xlsx');

echo 'File has been successfully converted to Excel.';
?>
