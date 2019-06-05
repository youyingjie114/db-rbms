<?php include "conn.php" ?>
<?php
$table_name = $_POST['table_name'];
$sql = "desc $table_name";
$res = mysqli_query($conn, $sql);

$primary_key;
$primary_key_type;
// 拿到主键名称和主键类型
while ($line = mysqli_fetch_array($res)) {
    if ($line['Key'] == 'PRI') {
        $primary_key = $line['Field'];
        $primary_key_type = $line['Type'];
        break;
    }
}

// 拿到主键值
$primary_key_value = $_POST[$primary_key];

// 构造新值
$newData = '';
$num = count($_POST);
foreach ($_POST as $key => $value) {
    if ($key == 'table_name')
        continue;
    $newData .= $key."='".$value."',";
}
$newData = rtrim($newData, ",");

// 将构造后的新值，更新到对应的表格中
$sql = "UPDATE $table_name SET $newData WHERE $primary_key='$primary_key_value'";
$res = mysqli_query($conn, $sql);
$num = mysqli_affected_rows($conn);  // 获取sql更新语句影响的行数，用于判断是否更新成功

// 返回JSON数据给前端
$arr = array(
    'affectedNum' => $num,
);
$json = json_encode($arr);
echo $json;

?>