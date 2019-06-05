<?php 
$hostname = "localhost"; // 主机名,可以用IP代替
$database = "business"; // 数据库名
$username = $_POST["username"]; // 数据库用户名
$password = $_POST["password"]; // 数据库密码
$conn = mysqli_connect($hostname, "root", "", $database) or trigger_error(mysql_error() , E_USER_ERROR); 

$sql = "select host, user, authentication_string from mysql.user where user=\"".$username."\"";
$res = mysqli_query($conn, $sql);
$num1 = mysqli_num_rows($res);

$sql = "select host, user, authentication_string from mysql.user where user=\"".$username."\" and authentication_string=PASSWORD(\"".$password."\")";
$res = mysqli_query($conn, $sql);
$num2 = mysqli_num_rows($res);

if ($num1 != 0 && $num2 != 0) {
    echo 1;   // 登录成功
} else if ($num1 != 0 && $num2 == 0) {
    echo 0;   // 密码错误
} else if ($num1 == 0) {
    echo 2;   // 用户名不存在
}