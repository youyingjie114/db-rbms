<?php 
/*
 * 此文件用于连接数据库
 */
$hostname = "localhost"; // 主机名,可以用IP代替
$database = "business"; // 数据库名
// $username = $_SESSION['username']; // 数据库用户名
// $password = $_SESSION['password']; // 数据库密码
$username = "ptp"; // 数据库用户名
$password = "ptp666"; // 数据库密码
$conn = mysqli_connect($hostname, $username, $password, $database) or trigger_error(mysql_error() , E_USER_ERROR);
?>