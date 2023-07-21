<?php
include_once "../../schedule/db.php";
include_once "../../function/function.php";
$all_sql = "SELECT *
FROM selections";
$all = $conn->query($all_sql)->fetch_all();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .styled-table thead tr {
            background-color: #009879;
            color: white;
            text-align: left;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }


        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

        .group-1 {
            background-color: #ffdddd;
        }

        .group-2 {
            background-color: #ddffdd;
        }

        .group-3 {
            background-color: #ddddff;
        }

        .group-4 {
            background-color: #ffffdd;
        }

        .table-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: auto;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="table-container">
        <?php
        // 初始化计数数组
        $voteCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0];

        // 计算投票
        for ($i = 0; $i < count($all); $i++) {
            $chosenGroup = $all[$i][3];
            if (array_key_exists($chosenGroup, $voteCounts)) {
                $voteCounts[$chosenGroup]++;
            }
        }
        $name = [
            1 => "Kevin",
            2 => "Jeff",
            3 => "LingYun",
            4 => "Jackie"
        ];
        // 显示统计结果
        echo '<table class="styled-table">';
        echo '<tr><th>組別</th><th>票數</th></tr>';
        foreach ($voteCounts as $group => $count) {
            echo '<tr id=' . $name[$group] . ' class=group-' . $group . '><td>' . $name[$group] . '</td><td>' . $count . '</td></tr>';
        }
        echo '</table>';
        ?>
        <table class="styled-table" id="tableip">
            <tr>
                <th>名子</th>
                <th>自己的的組別</th>
                <th>選擇的組別</th>
                <th>紀錄時間</th>
                <th>紀錄ip</th>
            </tr>
            <?php
            for ($i = 0; $i < 40; $i++) {
                if (!empty($all[$i][5])) {
                    $groupClass = 'group-' . $all[$i][2]; // 這邊假設 $all[$i][2] 是組別數字
            ?>
                    <tr class="<?= $groupClass ?>">
                        <th><?= $all[$i][1] ?></th>
                        <th><?= $all[$i][2] ?></th>
                        <th><?= $all[$i][3] ?></th>
                        <th><?= $all[$i][4] ?></th>
                        <th><?= $all[$i][5] ?></th>
                    </tr>
            <?php
                }
            } ?>
        </table>
    </div>
    <script>
        function refreshVotes() {
            $.ajax({
                url: 'get_votes.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // 此处应更新您的表格，假设数据格式为
                    // [{name: 'Kevin', votes: 10}, {name: 'Jeff', votes: 15}, ...]
                    // 您可以遍历此数据并更新相应的表格行
                    data.forEach(function(group) {
                        // 假设每行的 id 是组名
                        var row = document.getElementById(group.name);
                        if (row) {
                            // 假设投票数是第二列
                            row.children[1].innerText = group.votes;
                        }
                    });
                }
            });
        }

        function refreshTable() {
            $.ajax({
                url: 'get_vote.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $("#tableip tr:gt(0)").remove();
                    // 使用新數據添加新行
                    data.forEach(function(row) {
                        if (row.selected_ip) { // 如果 IP 存在，則新增行
                            var groupClass = 'group-' + row.group_id;
                            var newRow = '<tr class="' + groupClass + '">' +
                                '<td>' + row.name + '</td>' +
                                '<td>' + row.group_id + '</td>' +
                                '<td>' + row.selected_group_id + '</td>' +
                                '<td>' + row.selected_time + '</td>' +
                                '<td>' + row.selected_ip + '</td>' +
                                '</tr>';
                            $('#tableip').append(newRow);
                        }
                    });
                }
            });
        }

        // 每5秒刷新一次表格
        setInterval(refreshTable, 5000);
        // 每5秒刷新一次
        setInterval(refreshVotes, 5000);
    </script>
</body>

</html>