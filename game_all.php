<?php
include_once "db.php";

$all_sql="SELECT *
FROM selections";
$all=$db->query($all_sql)->fetch_all();
?>

<table border="1">
    <tr>
        <th>名子</th>
        <th>自己的的組別</th>
        <th>選擇的組別</th>
        <th>紀錄時間</th>
        <th>紀錄ip</th>
        <th>索引(加密)</th>
    </tr>
    <?php
    for($i=0;$i<33;$i++){
    ?>
    <tr>
        <th><?= $all[$i][1]?></th>
        <th><?= $all[$i][2]?></th>
        <th><?= $all[$i][3]?></th>
        <th><?= $all[$i][4]?></th>
        <th><?= $all[$i][5]?></th>
        <th><?php echo jia($all[$i][0])?></th>
    </tr>
    <?php    
    }   
    ?>
</table>
<form id="decryptForm">
    <input type="text" name="encryptedData" id="encryptedData">
    <button type="submit">解密</button>
</form>

<script>
    document.getElementById('decryptForm').addEventListener('submit', function(event) {
        event.preventDefault(); // 防止表單提交刷新頁面

        // 獲取輸入框中的數據
        var encryptedData = document.getElementById('encryptedData').value;

        // 使用AJAX向後端發送請求
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var decryptedData = xhr.responseText;
                // 在前端處理解密後的數據
                // 例如，更新頁面上的元素或顯示解密結果的彈窗
                console.log('解密結果:', decryptedData);
            }
        };
        xhr.send('encryptedData=' + encodeURIComponent(encryptedData));
    });
</script>
