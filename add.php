<?php session_start(); ?>
<?php include "conn.php" ?>
<?php
$table_name = $_POST['table_name'];
$sql = "desc $table_name";
$res = mysqli_query($conn, $sql);
$row = mysqli_num_rows($res);

// Initial
$keys = '(';
$data = '(';

// 遍历POST请求中的数据，构造sql插入语句中的插入字段和新的数据字段
$num = count($_POST);
foreach ($_POST as $key => $value) {
    if ($key == 'table_name')
        continue;
    $keys .= $key.",";
    $data .= "'".$value."',";
}
$keys = rtrim($keys, ",");
$data = rtrim($data, ",");
$keys .= ")";
$data .= ")";

// sql语句执行插入
$sql = "INSERT INTO $table_name $keys VALUES $data";
$res = mysqli_query($conn, $sql);
$num = mysqli_affected_rows($conn);    // 获取sql插入语句影响表格的行数，供前端进行判断是否插入成功

// 返回JSON数据给前端
$arr = array(
    'affectedNum' => $num,
);
$json = json_encode($arr);
echo $json;

?>

