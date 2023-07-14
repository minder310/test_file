<?php
include_once "./Classes/PHPExcel.php";

// 建立工作表並指定名稱
            // 創建一個PHPExcel物件。
$objPHPExcel = new PHPExcel();
            // 活頁簿第一頁。
$objPHPExcel->setActiveSheetIndex(0);
            // 設定分頁標題。
$objPHPExcel->getActiveSheet()->setTitle('TAB標題');
        //標題內用excel，的棋盤方式進行調整A1，後面是"表格內容";
        // 抬頭區
        $table =[
            1=>"訂單編號",
            2=>"亞太撥款年月",
            3=>"帳單日期",
            4=>"帳單年月",
            5=>"客戶編號",
            6=>"客戶",
            7=>"總金額",
            8=>"平台撥款日期",
            9=>"攤提金額",
            10=>"展延費",
            11=>"分期費",
            12=>"應繳日期",
            13=>"繳款日期",
            14=>"繳款年月",
            15=>"帳單原因",
            16=>"繳款帳號",
            17=>"銷帳原因",
            18=>"掛帳暫收",
            19=>"作帳日期",
            20=>"作帳年月",
            21=>"預計分期期數",
            22=>"預計展延時間",
            23=>"延遲天數",
            24=>"滯納金",
            25=>"滯納金繳款",
            26=>"滯納金繳款日期"
        ];
        // 抬頭區
        for($i=1;$i<26;$i++){
                $objPHPExcel->getActiveSheet()->setCellValue(chr(64+$i)."1",$table[$i]);
        }

        // 假設您要設置第2行到最大行的A列的格式
$maxRow = 500; //這裡應該使用您真實的最大行數
$objPHPExcel->getActiveSheet()
    ->getStyle('A2:A'.$maxRow)
    ->getNumberFormat()
    ->setFormatCode('0');

// 宣告將物件打包，並寫入資料表裡面。
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('./export_abc.xlsx');
header('Location:./export_abc.xlsx');
exit;
?>