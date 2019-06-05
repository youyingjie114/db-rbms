<?php session_start(); ?>
<?php include "conn.php" ?>

<?php
$sql = "SELECT * FROM products";
$res = mysqli_query($conn, $sql);

// 循环将商品以商品卡片的形式构造出html代码，传回前端显示
while ($line = mysqli_fetch_array($res)) {
	echo "<div id='container' class='container animated fadeInRight'>";
	echo "<div class='product-details'>";
	echo "<h1>$line[pname]</h1>";
	echo "<div class='control'>";
	echo "<button class='btn' onclick='openDialog(\"$line[pid]\")'>";
	echo "<span class='price'>¥$line[original_price]</span>";
	echo "<span class='shopping-cart'><i class='fa fa-shopping-cart' aria-hidden='true'></i></span>";
	echo "<span class='buy'>立即购买</span>";
	echo "</button>";
	echo "</div>";
	echo "</div>";

	echo "<div class='product-image'>";
	echo "<img src='img/$line[pname].jpg' alt='Omar Dsoky'>";
	echo "<div class='info'>";
	echo "<h2>商品信息</h2>";
	echo "<ul class='$line[pid]'>";
	echo "<li><strong>商品名称：</strong>$line[pname]</li>";
	echo "<li><strong>编号(pid)：</strong>$line[pid]</li>";
	echo "<li><strong>库存(qoh)：</strong>$line[qoh]</li>";
	echo "<li><strong>原价(price)：</strong>$line[original_price]</li>";
	echo "<li><strong>折扣(rate)：</strong>$line[discnt_rate]</li>";
	$sql2 = "SELECT * FROM suppliers WHERE sid='$line[sid]'";
	$res2 = mysqli_query($conn, $sql2);
	$line2 = mysqli_fetch_array($res2);
	echo "<li><strong>供应商(supplier)：</strong>$line2[sname]</li>";
	echo "</ul>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
}
?>

