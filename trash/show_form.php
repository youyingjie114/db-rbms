<?php session_start(); ?>
<?php include "conn.php" ?>
<?php
$table_name = $_POST['table_name'];
$sql = "desc $table_name";
$res = mysqli_query($conn, $sql);
$row = mysqli_num_rows($res);

echo "<form id='form_edit'>";
for ($i = 0; $i < $row; $i++) {
    $line = mysqli_fetch_array($res);
    if ($table_name == 'logs') {
        break;
    }
    if ($table_name == 'customers') {
        if ($line['Field'] == 'visits_made' || $line['Field'] == 'last_visit_time')
            continue;
    } else if ($table_name == 'purchases') {
        if ($line['Field'] == 'ptime' || $line['Field'] == 'total_price')
            continue;
    }
    
    echo "<span class='ky-wrap'><label class='key'>".$line['Field']." : </label><input class='field' type='text' name='".$line['Field']."' value=''/></span>";
}

echo "<div class='button-wrap'>";
// echo "<button class='button-modify' type='button' value='修改' onclick='modify()'/>";
// if ($table_name != 'logs')
//     echo "<button class='button-add' type='button' value='添加' onclick='add()'/>";
echo "<button type='submit' class='button-submit'></button>";
echo "</div>";
echo "</form>";

echo "<script type='text/javascript'>";
echo "$('.button-submit').click(function (event) {";
    echo "event.preventDefault();";
    echo "add();";
echo "})";
echo "</script>";
?>

