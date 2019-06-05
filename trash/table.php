<?php
session_start();
// $_SESSION['username'] = $_POST['username'];
// $_SESSION['password'] = $_POST['password'];
?>

<?php include "conn.php" ?>

<?php
$query = "show tables";
$res = mysqli_query($conn, $query) or die(mysql_error());
$row = mysqli_num_rows($res);
$sheets = array();
for ($i = 0; $i < $row; $i++) {
    $line = mysqli_fetch_array($res);
    array_push($sheets, $line['Tables_in_business']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>PTP-项目数据库</title>
    <link rel="stylesheet" type="text/css" href="css/table.css">
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>   
    <div id="content">
        <div class="dropdown-wrap">
            <button type="button" class="tables_name"></button>
            <div class="dropdown-content">
            <?php
            for ($i = 0; $i < count($sheets); $i++) {
                echo "<p onclick='showTable(\"$sheets[$i]\")' >$sheets[$i]</p>";
            }
            ?>
            </div>
        </div>
        
    </div>

    <div id="table">
    </div>
    <div id="edit">
        <form id='form_edit'>
        </form>
    </div>
</body>

<script type="text/javascript">

showTable('products')

function showTable (name) {
    $.ajax({
        type: 'post',
        url: 'show.php',
        data: `table_name=${name}`, 
        success: function(data) {
            $('#table').html(data)
            show_form(name)
            $('.tables_name')[0].innerText = name
        }
    });
}

function deleteLine (name, index) {
    $.ajax({
        type: 'post',
        url: 'delete.php',
        data: `table_name=${name}&index=${index}`,
        success: data => {
            // $('#table').html(data)
            showTable(name)
        }
    })
}

function edit (index) {
    // console.log($(`#button_edit-${index}`).parent().children()[0].innerText)
    
    var nodes = $(`#button_edit-${index}`).parent().children()
    var length = $(`#button_edit-${index}`).parent().children().length
    var str = ''
    for (i = 0; i < length - 2; i++) {
        str += `${nodes[i].className}=${nodes[i].innerText}&`
    }
    str = str.substring(0, str.length - 1)

    $.ajax({
        type: 'post',
        url: 'edit.php',
        data: str,
        success: data => {
            $('#edit').html(data)
        }
    })
}

function modify () {
    // console.log($('table')[0].id)
    $.ajax({
        type: 'post',
        url: 'modify.php',
        data: $('#form_edit').serialize() + `&table_name=${$('table')[0].id}`,
        success: data => {
            // $('#edit').html(data)
            showTable($('table')[0].id)
        }
    })
}

function show_form (name) {
    $.ajax({
        type: 'post',
        url: 'show_form.php',
        data: `table_name=${name}`,
        success: data => {
            $('#edit').html(data)
        }
    })
}

function add () {
    var name = $('table')[0].id
    if (name === 'purchases') {
        $.ajax({
            type: 'post',
            url: 'add_purchases.php',
            data: $('#form_edit').serialize(),
            success: data => {
                var responce = eval('(' + data + ')')
                if (responce.purFlag === 1)
                    alert('订单编号已存在')
                else if (responce.cidFlag === 0)
                    alert('该customer编号不存在')
                else if (responce.eidFlag === 0)
                    alert('该employee编号不存在')
                else if (responce.pidFlag === 0)
                    alert('该商品编号不存在')
                else if (responce.buyFlag === 0)
                    alert('该商品库存余量不足')
                else
                    showTable('purchases')
            }
        })
        return 
    }
    $.ajax({
        type: 'post',
        url: 'add.php',
        data: $('#form_edit').serialize() + `&table_name=${$('table')[0].id}`,
        success: data => {
            // $('#edit').html(data)
            showTable($('table')[0].id)
        }
    })
}

function analysis(p_id) {
    $.ajax({
        type: 'post',
        url: 'show_monthly.php',
        data: `pid=${p_id}`,
        success: data => {
            $('#table').html(data)
        }
    })
}

function backMain () {
    showTable('products');
}
</script>
</html>

