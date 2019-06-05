<?php session_start(); ?>
<?php include "conn.php" ?>
<?php
// 本文件将传入的表格名作为条件，查询表格中的列名，将列名构造出一个表单html代码，返回给前端
// 表单的代码为前端用于在遮罩层中显示的html代码
$table_name = $_POST['table_name'];
$sql = "desc $table_name";

$res = mysqli_query($conn, $sql);
while ($key = mysqli_fetch_array($res)) {
    if ($table_name = 'customers' && (!strcmp($key['Field'], 'visits_made') || !strcmp($key['Field'], 'last_visit_time'))) {
        continue;
    }
    if ($table_name = 'purchases' && (!strcmp($key['Field'], 'ptime') || !strcmp($key['Field'], 'total_price'))) {
        continue;
    }
    echo "<span class='input'>";
    echo "<input class='input_field' spellcheck ='false' type='text' name='$key[Field]' autocomplete='off'/>";
    echo "<label class='input_label $key[Field]'>";
    echo "<span class='input_label-content'>$key[Field]</span>";
    echo "</label>";
    echo "</span>";
}
echo "<button type='submit' class='button-submit'></button>";
?>