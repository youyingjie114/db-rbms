<?php session_start(); ?>
<?php include "conn.php" ?>
<?php

$cid = $_POST['cid'];
$eid = $_POST['eid'];
$pid = $_POST['pid'];
$qty = $_POST['qty'];
$sql = "SELECT is_can_buy_prod($pid, $qty) as 'flag';";
$res = mysqli_query($conn, $sql);
// 调用函数，判断商品库存是否足够
$buy_flag = (int)mysqli_fetch_array($res)['flag'];

// sql语句查询，判断订单中的cid是否存在
$sql = "SELECT * FROM customers WHERE cid = $cid";
$res = mysqli_query($conn, $sql);
$cid_flag = 0;
if (mysqli_num_rows($res))
    $cid_flag = 1;

// sql语句查询，判断订单中的eid是否存在
$sql = "SELECT * FROM employees WHERE eid = $eid";
$res = mysqli_query($conn, $sql);
$eid_flag = 0;
if (mysqli_num_rows($res))
    $eid_flag = 1;

// sql语句查询，判断订单中的pid是否存在
$sql = "SELECT * FROM products WHERE pid = $pid";
$res = mysqli_query($conn, $sql);
$pid_flag = 0;
if (mysqli_num_rows($res))
    $pid_flag = 1;

// 如果订单中的所有参数都是合法的，就调用存储过程add_purchase_with_purai实现订单编号自加的订单提交
if ($cid_flag && $eid_flag && $pid_flag && $buy_flag) {
    $sql = "CALL add_purchase_with_purai($_POST[cid], $_POST[eid], $_POST[pid], $_POST[qty]);";
    $res = mysqli_query($conn, $sql);
}

// 返回JSON数据格式给前端，便于前端做相应的信息提示
$arr = array(
    'cidFlag' => $cid_flag,
    'eidFlag' => $eid_flag,
    'pidFlag' => $pid_flag,
    'buyFlag' => $buy_flag
);

$json = json_encode($arr);
echo $json;

?>