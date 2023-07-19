<?php
include_once "../../schedule/db.php";
include_once "../../function/function.php";
$all_sql = "SELECT *
FROM selections";
$all = $conn->query($all_sql)->fetch_all();

$voteCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0];

for ($i = 0; $i < count($all); $i++) {
    $chosenGroup = $all[$i][3];
    if (array_key_exists($chosenGroup, $voteCounts)) {
        $voteCounts[$chosenGroup]++;
    }
}

$data = [
    ['name' => 'Kevin', 'votes' => $voteCounts[1]],
    ['name' => 'Jeff', 'votes' => $voteCounts[2]],
    ['name' => 'LingYun', 'votes' => $voteCounts[3]],
    ['name' => 'Jackie', 'votes' => $voteCounts[4]]
];

// 输出为JSON格式
echo json_encode($data);
?>