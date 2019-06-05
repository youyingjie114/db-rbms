<?php 
// 此文件用于判断用于登录的username顾客的cid是否在表格customers中
$hostname = "localhost"; // 主机名,可以用IP代替
$database = "business"; // 数据库名
$username = $_POST["username"]; // cid
$password = $_POST["password"]; // password(空)
$conn = mysqli_connect($hostname, "root", "", $database) or trigger_error(mysql_error() , E_USER_ERROR); 

$sql = "SELECT * FROM customers WHERE cid='$username'";
$res = mysqli_query($conn, $sql);
$num = mysqli_num_rows($res);

$cus_flag = 0;
if ($num != 0) {
    $cus_flag = 1;
}

// 返回JSON数据给前端，便于前端判断是否存在该cid
$arr = array(
    'cusFlag' => $cus_flag,
);

$json = json_encode($arr);
echo $json;

?>