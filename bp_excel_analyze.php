<?php

// 讀取 CSV 檔案
$file = fopen('file_path.csv', 'r');
// 宣告一個陣列。
$data = [];

while (($line = fgetcsv($file, 0, ';')) !== FALSE) {
    $data[] = $line;
}
fclose($file);

// 資料處理的部分與你的原始程式碼基本相同，但可能需要修改列的索引來符合 CSV 檔案的結構
// 此外，如果 CSV 檔案的第一行是欄位名稱，你可能會想要跳過它

// 選擇帳單原因
$selected_billing_reasons = ["分期","展延第1次","展延第2次","展延第3次","展延第4次","展延第5次","展延第6次","直接分期","購買商品"];
$filtered_by_billing_reason = array_filter($data, function ($row) use ($selected_billing_reasons) {
    return in_array($row[1], $selected_billing_reasons);  // 假設第 2 欄是帳單原因
});
// 根據客戶編號劃分
$grouped_by_client = [];
foreach ($filtered_by_billing_reason as $row) {
    $client_id = $row['A'];  // 假設 'A' 列是客戶編號
    if (!isset($grouped_by_client[$client_id])) {
        $grouped_by_client[$client_id] = [];
    }
    $grouped_by_client[$client_id][] = $row;
}

// 記錄延遲天數最大值，加總銷帳原因為空值的總金額，並扣掉銷帳原因空值的分期費數值
$results_per_client = [];
foreach ($grouped_by_client as $client_id => $rows) {
    $max_delay_days = max(array_column($rows, 'C'));  // 假設 'C' 列是延遲天數
    $total_amount_empty_billing_reason = 0;
    $total_amount_empty_billing_reason_minus_installment_fee = 0;
    foreach ($rows as $row) {
        if ($row['D'] == null) {  // 假設 'D' 列是銷帳原因，'E' 列是總金額，'F' 列是分期費
            $total_amount_empty_billing_reason += $row['E'];
            $total_amount_empty_billing_reason_minus_installment_fee += $row['E'] - $row['F'];
        }
    }
    $results_per_client[$client_id] = [
        '最大延遲天數' => $max_delay_days,
        '空值銷帳原因總金額' => $total_amount_empty_billing_reason,
        '空值銷帳原因總金額（扣掉分期費）' => $total_amount_empty_billing_reason_minus_installment_fee
    ];
}

// 依延遲天數最大值劃分組
$grouped_by_max_delay_days = [];
foreach ($results_per_client as $client_id => $result) {
    $max_delay_days = $result['最大延遲天數'];
    if ($max_delay_days == 0) {
        $group = '0 day';
    } elseif ($max_delay_days >= 1 && $max_delay_days < 8) {
        $group = '1~7 days';
    } elseif ($max_delay_days >= 8 && $max_delay_days < 16) {
        $group = '8~15 days';
    } // 等等...
    if (!isset($grouped_by_max_delay_days[$group])) {
        $grouped_by_max_delay_days[$group] = 0;
    }
    $grouped_by_max_delay_days[$group] += $result['空值銷帳原因總金額（扣掉分期費）'];
}

// 輸出結果
print_r($grouped_by_max_delay_days);