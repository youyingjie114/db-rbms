<?php session_start(); ?>
<?php include "conn.php" ?>
<?php
$c_id = $_POST['cid'];

// 在purchases表格中查询该cid的所有订单，返回给前端
$sql = 
"SELECT pur.pur, pur.pid, prod.pname, pur.eid, prod.original_price, prod.discnt_rate, pur.qty, pur.total_price
FROM purchases pur, products prod
WHERE pur.cid = '$c_id' AND pur.pid = prod.pid";
$res = mysqli_query($conn, $sql);

echo "<table cellspacing='0' id='dialog-table'>";
echo "<caption>历史订单</caption>";
echo "<thead>";
echo "<tr>";
echo "<th>订单编号</th>";
echo "<th>商品编号</th>";
echo "<th>商品名称</th>";
echo "<th>雇员ID</th>";
echo "<th>单价</th>";
echo "<th>折扣</th>";
echo "<th>数量</th>";
echo "<th>订单总价</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
while ($line = mysqli_fetch_array($res)) {
    echo "<tr>";
    echo "<td>".$line['pur']."</td>";
    echo "<td>".$line['pid']."</td>";
    $sql2 = "SELECT * FROM products WHERE pid = '$line[pid]'";
    $res2 = mysqli_query($conn, $sql2);
    $line2 = mysqli_fetch_array($res2);
    echo "<td>".$line2['pname']."</td>";
    echo "<td>".$line['eid']."</td>";
    echo "<td>".$line['original_price']."</td>";
    echo "<td>".$line['discnt_rate']."</td>";
    echo "<td>".$line['qty']."</td>";
    echo "<td>".$line['total_price']."</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
?>