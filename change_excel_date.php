<?php
include_once "./Classes/PHPExcel.php";
    // 判斷檔案是否存在寫法。
    if(file_exists('export_ab.xlsx')){
        echo "export_ab.xlsx檔案存在";
        // 讀取EXCEL文件。
        $excel=PHPExcel_IOFactory::load("export_ab.xlsx");
        // 取用EXCEL哪張分頁
        $excel->setActiveSheetIndexByName("TAB標題");
        // 輸入新資料。
        $excel->getActiveSheet()->setCellValue("Z2","測試");
        // 用一個
    }elseif(!file_exists('export_ab.xlsx')){
        echo "export_ab.xlsx檔案不存在";
    }
    
    if($excel->getActiveSheet()->getCell("A10")->getValue()){
       echo "我有偵測到唷A1"; 
    }else{
        echo "是空的唷A10";
    };
    // $Writer =PHPExcel_IOFactory::createWriter($excel,"Excel2007");
    // $Writer->save("export_ab.xlsx");
 


// $objPHPExcel = PHPExcel_IOFactory::load('example_ab.xlsx');

// 創建一個新的工作表

// 使用新工作表並在其中寫入數據
// $objPHPExcel->setActiveSheetIndexByName('new sheet');
// $objPHPExcel->getActiveSheet()->setCellValue('Z1', 'Hello');
// $objPHPExcel->getActiveSheet()->setCellValue('Z2', 'World');

// // 儲存修改後的Excel文件
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save('example_ab.xlsx');





?>