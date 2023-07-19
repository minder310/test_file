<?php
include_once "../../schedule/db.php";
include_once "../../function/function.php";

$all_sql = "SELECT * FROM selections";
$all = $conn->query($all_sql)->fetch_all(MYSQLI_ASSOC);

// 初始化数据数组
$data = [];
for ($i = 0; $i < count($all); $i++) {
    // 只有当IP存在时才添加到数据中
    if (!empty($all[$i]['selected_ip'])) {
        $data[] = [
            'name' => $all[$i]['name'],
            'group_id' => $all[$i]['group_id'],
            'selected_group_id' => $all[$i]['selected_group_id'],
            'selected_time' => $all[$i]['selected_time'],
            'selected_ip' => $all[$i]['selected_ip'],
        ];
    }
}

// 输出为JSON格式
echo json_encode($data);
?>