<?php session_start(); ?>
<?php include "conn.php" ?>
<?php

$pid = $_POST['pid'];
$sql = "SELECT * FROM products WHERE pid = $pid";
$res = mysqli_query($conn, $sql);

$line = mysqli_fetch_array($res);
echo "<li><strong>商品名称：</strong>$line[pname]</li>";
echo "<li><strong>编号(pid)：</strong>$line[pid]</li>";
echo "<li><strong>库存(qoh)：</strong>$line[qoh]</li>";
echo "<li><strong>原价(price)：</strong>$line[original_price]</li>";
echo "<li><strong>折扣(rate)：</strong>$line[discnt_rate]</li>";

?>