<?php session_start(); ?>
<?php include "conn.php" ?>
<?php

$table_name = $_POST['table_name'];
$sql = "desc $table_name";

$res = mysqli_query($conn, $sql);
while ($key = mysqli_fetch_array($res)) {
    echo "<span class='input'>";
    echo "<input class='input_field' type='text' name='$key[Field]' id='input-1' autocomplete='off'/>";
    echo "<label class='input_label'>";
    echo "<span class='input_label-content'>$key[Field]</span>";
    echo "</label>";
    echo "</span>";
}
echo "<button type='submit' class='button-submit'></button>";
?>