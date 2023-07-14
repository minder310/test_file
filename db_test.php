<?php
function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
// 連結資料庫
// 連線位置
class db
{
    private $db;
    public function __construct($sqlname)
    {
        $host = "localhost";
        $username = "root";
        $pasword = "";
        $dbname = "$sqlname";
        $this->db = new mysqli($host, $username, $pasword, $dbname);

        if ($this->db->connect_error) {
            die("連線失敗: " .$this->db->connect_error);
        }
    }
    public function SeeSomeThing(){
        $sql="SELECT * FROM `board_list` WHERE `id`='1'";
        // 測試查詢系統。

        $result=mysqli_query($this->db,$sql);
        dd($result);
        $row=mysqli_fetch_assoc($result);
        dd($row);

        // 上面跟下面是同樣的東西。
        return $this->db->query($sql)->fetch_assoc();
    }
}
