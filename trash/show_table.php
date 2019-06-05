<?php session_start(); ?>
<?php include "conn.php" ?>
<?php
$table_name = $_POST['table_name'];
// $table_name = 'student';
$sql = "desc $table_name";
$res = mysqli_query($conn, $sql);
$row = mysqli_num_rows($res);
$fields = array();
echo "<table cellspacing='0' id='$table_name'>";
echo "<caption>$table_name</caption>";
echo "<thead>";
echo "<tr>";
for ($i = 0; $i < $row; $i++) {
    $line = mysqli_fetch_array($res);
    array_push($fields, $line['Field']);
    echo "<th>".$line['Field']."</th>";   
}
echo "<th>Delete</th>";
echo "<th>Edit</th>";
if ($table_name == 'products') {
    echo "<th>Monthly-Report</th>";
}
echo "</tr>";
echo "</thead>";

echo "<tbody>";
$sql = "SELECT * FROM $table_name";
$res = mysqli_query($conn, $sql);
$row = mysqli_num_rows($res);
$data = array();
for ($i = 0; $i < $row; $i++) {
    $line = mysqli_fetch_array($res);
    array_push($data, $line);
    echo "<tr>";
    for ($j = 0; $j < count($fields); $j++) {
        echo "<td class='$fields[$j]'>".$line[$fields[$j]]."</td>";
    }
    echo "<td class='button-delete-wrap'><button class='button-delete' type='button' onclick='deleteLine(\"$table_name\", $i)'></button></td>";
    echo "<td class='button-edit-wrap' id='button_edit-$i'><button class='button-edit' type='button' onclick='edit($i)'></button></td>";
    if ($table_name == 'products') {
        echo "<td class='button-analysis-wrap'><button class='button-analisis' type='button' onclick='analysis($line[pid])'></button></td>";
    }
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
?>

