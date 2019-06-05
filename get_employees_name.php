<?php session_start(); ?>
<?php include "conn.php" ?>
<?php

$sql = "SELECT * FROM employees";
$res = mysqli_query($conn, $sql);
echo "<option disabled selected value='0000'>default</option>";
while ($line = mysqli_fetch_array($res)) {
    echo "<option value='$line[eid]'>$line[ename]</option>";
}

?>