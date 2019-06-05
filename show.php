<?php session_start(); ?>
<?php include "conn.php" ?>
<?php
// 本文件用于获取任意表格的html代码，将传入的表格名作为查询条件，构造出表格的html代码传回前端显示
$table_name = $_POST['table_name'];
$sql = "desc $table_name";
$keys = array();

echo "<div class='table-card'>";

// 表格html代码
echo "<table cellspacing='0' id='table'>";
echo "<caption>$table_name</caption>";
echo "<thead>";
echo "<tr>";

// 查询数据库，获取数据表的所有字段名
$res = mysqli_query($conn, $sql) or die ("Query faild: ".mysql_error());

while ($key = mysqli_fetch_array($res)) {
    array_push($keys, $key['Field']);
    echo "<th>".$key['Field']."</th>";
}
// 表格html代码
if ($table_name != 'logs')
    echo "<th>options</th>";
// echo "<th>Edit</th>";
if ($table_name == 'products')
    echo "<th>monthly_Report</th>";
// if ($table_name == 'suppliers')
//     echo "<th>analysis</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
// 构造sql语句
$sql = "CALL show_table(\"$table_name\")";

// 查询数据库
$res = mysqli_query($conn, $sql) or die ("Query faild: ".mysql_error());
// 遍历查询结果集，编辑html代码
$i = 0;
while ($line = mysqli_fetch_array($res)) {
    echo "<tr>";
    for ($j = 0; $j < count($keys); $j++) {
        echo "<td class='$keys[$j]'>".$line[$keys[$j]]."</td>";
    }
    if ($table_name != 'logs') {
        // echo "<td class='td-button button-delete-wrap'><button class='button-delete' type='button' onclick='deleteLine(\"$table_name\", $i)'></button></td>";
        echo "<td class='td-button-wrap'>";
        echo "<div class='td-button-modify-div'><span class='td-button my-iconfont icon-pencil'></span></div>";
        echo "<div class='td-button-delete-div'><span class='td-button my-iconfont icon-bin'></span></div>";
        echo "</td>";
    }
    // echo "<td class='button-edit-wrap' id='button_edit-$i'><button class='button-edit' type='button' onclick='edit($i)'></button></td>";
    if ($table_name == 'products') {
        // echo "<td class='td-button button-analysis-wrap'><button class='button-analysis' type='button' onclick='analysis(\"$line[pid]\")'></button></td>";
        echo "<td class='td-button-wrap'>";
        echo "<div class='td-button-analysis-div'><span class='td-button my-iconfont icon-stats-dots'></div></span>";
        echo "</td>";
    }
    // if ($table_name == 'suppliers') {
    //     echo "<td class='td-button-wrap'>";
    //     echo "<div class='td-button-supAnalysis-div'><span class='td-button icon-paragraph-left'></span></div></span>";
    //     echo "</td>";
    // }
    echo "</tr>";
    $i++;
}
echo "</tbody>";
echo "</table>";
// echo "<div class='table-bottom'>";
// echo "</div>";
echo "</div>";

echo "<script>";
echo "$('.table-bottom').width($('table').width());";
echo "</script>";
?>