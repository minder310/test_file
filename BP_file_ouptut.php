<?php
/*
 想法區20230711
1.串接PHPexcel並且可以正常輸出表單。
2.整理資料庫輸出資料並且順道作轉換塞入陣列中。
3.利用迴圈將所有資料塞入excel表單中。
20230711
正式機資料量太大無法一次取出。
1.判斷從資料庫取出是否有資料。
2.存入schedule_now第幾次
3.s_n_cnt用來設計跑第幾次跟跑多少資料(我預計是500筆)。
4.測試打開舊的excel檔，這要做測試。並且可以繼續寫下去。
ps:注意迴圈j數值，可以用來判斷輸入在哪一個格子裡面這要很注意。

說明書:
設定取出資料量在第34~39行，兩個數值設定一樣即可。
*/
include_once "../function/PHPExcel.php";
include_once "../function/function.php";
include_once "db.php";

// --------------------確定資料庫有在排程內，並且不會重複運行-----------------
// 連線資料庫取出資料庫資料。
$seq = 6; //排程序號
// 資料庫搜尋語句，提取資料庫內確認否有排成排成，並記錄最後更新日期。
$sql_Schedule_now =
    "SELECT * FROM schedule_now WHERE s_n_seq = {$seq}";
// 宣告連線資料庫帳號密碼，並且連線資料庫。
$rst = mysqli_query($conn, $sql_Schedule_now);
// 取出相對應資料。
$rowS = mysqli_fetch_assoc($rst);
// 取出執行第幾次。
$Execution_number = $rowS['s_n_cnt'];
// =====================數值設定區=====================================
// 取出資料初始值*後面要改成你想取的資料量。
$Get_data_value = $Execution_number * 100;
// 一次取多少資料，要跟上面一樣多唷
$how_much_data_to_take = 100;
// ===================================================================
// 如果資料庫沒有連線成功自動終止程式。
if (!$rst) {
    exit;
}

// 取出今天的日期。
$today = date('Y-m-d');
// 取出現在的時間。
$now = date('Y-m-d H:i:s');
// 將資料庫中的時間轉換為秒數拿來做比較，只要時間大於0
if (
    strtotime($rowS['s_n_date']) > 0
    // 同時功能計時等於今天。
    && date('Y-m-d', strtotime($rowS['s_n_date'])) == $today
    // 最後修改日期等於今天。
    && date('Y-m-d', strtotime($rowS['s_n_uptime'])) == $today
) {
    // 程式就不執行。
    exit;
}
// -------------------確定資料有在排程內,並且不會重複運行,結束。----------------------

// -------------------更新s_n_date資料。------------------------------------
// 存入紀錄啟動時間s_n_date換成現在。
$sql_Schedule_now = "UPDATE `schedule_now` SET `s_n_date` = '{$now}' WHERE 1 AND `s_n_seq`= {$seq}";
// 將資料存入資料庫。
$conn->query($sql_Schedule_now);
// -------------------更新s_n_date資料。------------------------------------

// -------------------------加進判斷檔案是否存在。--------------------------
// 如果不存在。
if (!file_exists("../public/BP_" . date("Y-m-d") . ".xlsx")) {
    // -------------------------宣告一個新的excel物件--------------------------
    $data = new PHPExcel();
    $data->setActiveSheetIndex(0);
    $data->getActiveSheet()->setTitle("BP_" . date("Y-m-d"));
    // -------------------------宣告一個新的excel物件。--------------------------
    $table = [
        1 => "訂單編號",
        2 => "亞太撥款年月",
        3 => "帳單日期",
        4 => "帳單年月",
        5 => "客戶編號",
        6 => "客戶",
        7 => "總金額",
        8 => "平台撥款日期",
        9 => "攤提金額",
        10 => "展延費",
        11 => "分期費",
        12 => "應繳日期",
        13 => "繳款日期",
        14 => "繳款年月",
        15 => "帳單原因",
        16 => "繳款帳號",
        17 => "銷帳原因",
        18 => "掛帳暫收",
        19 => "作帳日期",
        20 => "作帳年月",
        21 => "預計分期期數",
        22 => "預計展延時間",
        23 => "延遲天數",
        24 => "滯納金",
        25 => "滯納金繳款",
        26 => "滯納金繳款日期"
    ];
    //  抬頭區
    for ($i = 1; $i < 27; $i++) {
        $data->getActiveSheet()->setCellValue(chr(64 + $i) . "1", $table[$i]);
    }
}
// ============================如果資料存在存取表格=============================
elseif (file_exists("../public/BP_" . date("Y-m-d") . ".xlsx")) {
    // 讀取已存在表單
    $data = PHPExcel_IOFactory::load('BP_' . date("Y-m-d") . '.xlsx');
    // 讀取已存在的書籤。
    $data->setActiveSheetIndexByName('BP_' . date("Y-m-d"));
}
// ===========================================================================
$b_t[0] = "購買商品";
$b_t[1] = "展延第1次";
$b_t[2] = "展延第2次";
$b_t[3] = "展延第3次";
$b_t[4] = "展延第4次";
$b_t[5] = "展延第5次";
$b_t[6] = "展延第6次";
$b_t[10] = "總包";
$b_t[11] = "總包後展延第1次";
$b_t[12] = "總包後展延第2次";
$b_t[13] = "總包後展延第3次";
$b_t[14] = "總包後展延第4次";
$b_t[15] = "總包後展延第5次";
$b_t[16] = "總包後展延第6次";
$b_t[20] = "分期";
$b_t[21] = "直接分期";
$b_t[31] = "展延手續費";
$b_t[32] = "分期手續費";
$b_t[33] = "總包手續費";
$b_t[41] = "批次结清";
$b_t[42] = "一次结清";
$b_t[50] = "退貨處理中";
$b_t[51] = "已退貨";
$b_t[60] = "繳付租金";

$o_t[1] = "繳款";
$o_t[2] = "展延";
$o_t[3] = "分期";
$o_t[4] = "批次结清";
$o_t[5] = "一次结清";
$o_t[12] = "展延費";
$o_t[13] = "分期費";
$o_t[80] = "買回";
$o_t[81] = "客退作廢";
$o_t[96] = "申請退貨 ";
$o_t[97] = "退貨處理中";
$o_t[98] = "已退貨";
$o_t[99] = "作廢";




$sql = "SELECT
co.order_return_time ort,
co.check_status cs,
c.bill_seq bs,
c.virtual_account va,
c.special_seq ss,
c.user_seq us,
u.user_num ui,
u.user_name un,
c.check_no cn,
c.parent_seq ps,
c.group_seq gs,
c.list_seq ls,
c.total_amount ta,
co.paid_at pa,
c.apportion_fee af,
c.extend_fee ef,
c.staging_fee sf,
c.create_time ct,
c.payable_date pd,
c.repayment_date rd,
c.repayment_type tr,
c.bill_type bt,
c.check_pay_at cpa,
c.ok_pay_at oka,
c.temporary_collection tc,
c.tmp_parent tp,
c.tmp_staging ts,
c.tmp_extend te,
c.delay_day dd,
c.delay_fee df,
c.writeoff_delay wde,
c.writeoff_date wda
from check_bill c
left join user_info u on c.user_seq = u.user_seq
left join check_order co on c.check_no = co.check_no
where 1=1  LIMIT " . $Get_data_value . " , " . $how_much_data_to_take;
$ro = mysqli_query($conn, $sql);
$cnt = mysqli_num_rows($ro);
// ====================================設定終止條件。====================================
if ($cnt == 0) {
    $sql = "UPDATE schedule_now SET `s_n_uptime` = '{$now}'  WHERE s_n_seq = {$seq}";
    mysqli_query($conn, $sql);
    // 迴圈次數歸零。
    $sql = "UPDATE schedule_now SET `s_n_cnt` = '0'  WHERE s_n_seq = {$seq}";
    mysqli_query($conn, $sql);
    exit;
}
// =====================================================================================
if ($cnt > 0) {
    while ($row = mysqli_fetch_assoc($ro)) {
        $ct = $row['cs'] == 10 ? $row['ort'] : $row['ct'];
        $ta = $row['cs'] == 10 ? 0 - $row['ta'] : $row['ta'];
        $af = $row['cs'] == 10 ? 0 - $row['af'] : $row['af'];
        $ort = $row['cs'] == 10 ? '' : $row['cpa']; // $ort = $row['cs'] == 10 ? $row['ort'] : $row['cpa'];

        $appropriateDate = strtotime($row['pa']) > 0 ? date('Y.m', strtotime($row['pa'])) : '';
        $billDate = strtotime($ct) > 0 ? date('Y.m', strtotime($ct)) : '';
        $payDate = strtotime($row['rd']) > 0 ? date('Y.m', strtotime($row['rd'])) : '';
        $accountingDate = strtotime($ort) > 0 ? date('Y.m', strtotime($ort)) : '';
        // 將資料輸入陣列。
        $DataInArr[] = [
            1 => $row['cn'],
            2 => $appropriateDate,
            3 => $ct,
            4 => $billDate,
            5 => $row['ui'],
            6 => $row['un'],
            7 => $ta,
            8 => $row['pa'],
            9 => $af,
            10 => $row['ef'],
            11 => $row['sf'],
            12 => $row['pd'],
            13 => $row['rd'],
            14 => $payDate,
            15 => $b_t[$row['bt']],
            16 => $row['va'],
            17 => $o_t[$row['tr']],
            18 => $row['tc'],
            19 => $ort,
            20 => $accountingDate,
            21 => $row['ts'],
            22 => $row['te'],
            23 => $row['dd'],
            24 => $row['df'],
            25 => $row['wde'],
            26 => $row['wda']
        ];
    }
} else {
    $DataInArr = "查無資料";
}
// 資料輸入excel區。
for ($j = 0; $j <= max(array_keys($DataInArr)); $j++) {
    for ($i = 1; $i < 27; $i++) {
        // 這邊要注意是用來放入哪一個格子，所以要注意j的數值。
        $data->getActiveSheet()->setCellValue(chr(64 + $i) . ($Get_data_value + $j + 2), $DataInArr[$j][$i]);
    }
}
// 將特定表格文字格式轉換，成自訂格式。不會用科學方式呈現。
$data->getActiveSheet()
    ->getStyle("P2:P" . ($Get_data_value + 3))
    ->getNumberFormat()
    ->setFormatCode("0");


// =============================紀錄運行次數======================================
// 紀錄程式跑完的時間。
$sql = "UPDATE schedule_now SET `s_n_cnt` = '" . ($Execution_number + 1) . "'  WHERE s_n_seq = {$seq}";
// 並輸入資料庫。
mysqli_query($conn, $sql);
// ==============================================================================
// 直接下載區如果需要的話可以宣告。
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="BP_' . date("Y-m-d") . '.xlsx"');
// header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($data, 'Excel2007');


// 直接下載區，如果需要的話可以宣告。
// $objWriter->save('php://output');
$objWriter->save('BP_' . date("Y-m-d") . '.xlsx');
$objWriter->save("../public/BP_" . date("Y-m-d") . ".xlsx");



exit;
