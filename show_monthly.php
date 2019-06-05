<?php session_start(); ?>
<?php include "conn.php" ?>
<?php
$p_id = $_POST['pid'];

// 调用存储过程来获取对应商品的月度分析报表
$sql = "CALL report_monthly_sale('$p_id')";
$res = mysqli_query($conn, $sql) or die ("Analysis faild: ".mysql_error());

// 将月度分析报表构造成表格html代码传回前端显示
echo "<table cellspacing='0' id='dialog-table'>";
echo "<caption>月度销售表</caption>";
echo "<thead>";
echo "<tr>";
echo "<th>商品名称</th>";
echo "<th>月份</th>";
echo "<th>年份</th>";
echo "<th>月销量</th>";
echo "<th>月销售额</th>";
echo "<th>月平均销售额</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
while ($line = mysqli_fetch_array($res)) {
    echo "<tr>";
    echo "<td>".$line['pname']."</td>";
    echo "<td>".$line['pmonth']."</td>";
    echo "<td>".$line['pyear']."</td>";
    echo "<td>".$line['month_qty']."</td>";
    echo "<td>".$line['month_t_price']."</td>";
    echo "<td>".$line['month_avg_price']."</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
?>