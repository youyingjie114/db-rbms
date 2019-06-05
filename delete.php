<?php
session_start();
?>

<?php include "conn.php" ?>
<?php
// 将传入的表格名作为查询条件，查找出表格的主键并记录下来
$table_name = $_POST['table_name'];
$index = intval($_POST['index']);
$sql = "desc $table_name";
$res = mysqli_query($conn, $sql);
$row = mysqli_num_rows($res);
$primary_key;
$primary_key_type;
for ($i = 0; $i < $row; $i++) {
    $line = mysqli_fetch_array($res);
    if ($line['Key'] == 'PRI') {
        $primary_key = $line['Field'];
        $primary_key_type = $line['Type'];
        break;
    } 
}

// 将传入的下标参数作为条件，查询到对应行的主键列的值
$index_value;
$sql = "SELECT * FROM $table_name";
$res = mysqli_query($conn, $sql);
$row = mysqli_num_rows($res);
for ($i = 0; $i < $row; $i++) {
    $line = mysqli_fetch_array($res);
    if ($i == $index) {
        $index_value = $line[$primary_key];
    }
}

// 按照主键的类型，删除对应的数据行
if (!strstr($primary_key_type, 'int')) {
    $sql = "DELETE FROM $table_name WHERE $primary_key = '$index_value'";
} else {
    $sql = "DELETE FROM $table_name WHERE $primary_key = $index_value";
}

$res = mysqli_query($conn, $sql);
$num = mysqli_affected_rows($conn);  // 获取sql语句影响的行数，用于判断是否删除成功

// 返回JSON数据给前端
$arr = array(
    'affectedNum' => $num,
);
$json = json_encode($arr);
echo $json;
?>

