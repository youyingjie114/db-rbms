<?php session_start(); ?>
<?php include "conn.php" ?>
<?php
$sql = "SELECT cname FROM customers WHERE cid = '$_POST[username]'";
$cid = $_POST['username'];
$res = mysqli_query($conn, $sql);
$line = mysqli_fetch_array($res);
$cname = $line['cname'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>RBMS application</title>
<!-- 导入弹窗项目 -->
<script src="js/sweet-alert.js"></script>
<link rel="stylesheet" type="text/css" href="css/sweet-alert.css">
<!-- 导入表单样式 -->
<script src="js/classie.js"></script>
<!-- 导入图标字体 -->
<link rel="stylesheet" type="text/css" href="http://at.alicdn.com/t/font_1229838_h5uzlt2lj5j.css">
<!-- 导入JQ -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- 导入bootstrap -->
<link rel="stylesheet" href="bootstrap-table/bootstrap-table.min.css">
<script src="bootstrap-table/bootstrap.min.js"></script>
<script src="bootstrap-table/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.2/locale/bootstrap-table-zh-CN.min.js"></script>
<!-- 导入其他css文件 -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="css/dialog.css">
<link type="text/css" rel="stylesheet" href="css/dialog_form.css">
<link type="text/css" rel="stylesheet" href="css/client.css">
<link rel="stylesheet" type="text/css" href="css/duration.css">
<link rel="stylesheet" type="text/css" href="css/dialog_table.css">
</head>
<body>
<div class="nav-header">
<span class="header-icon">
    <span class="my-iconfont icon-user-tie"></span>
    <strong>Shopping Mall</strong>
</span>
<li class = "header-user">
    <a href="javascript:;" class="user-head">
        <img src="img/head1.jpg" class="img-head">
        <span class="user-name"><?php echo $cname ?></span>
        <span class="my-iconfont icon-triangle-down"></span>
    </a>
    <ul class="down-menu">
        <li class="menu-history">历史订单</li>
    </ul>
</li>
</div>
<div class="products"></div>
<div class="dialog">
    <div class="dialog-overlay" onclick="closeDialog()"></div>
    <div class="dialog-content dialog-content-form">
        <h2><strong>Hello!</strong> Fill The Order</h2>
        <form id="form-purchases" class="form">
            <span class="input">
                <input class="input_field" type="text" name="pur" id="input-5" autocomplete="off"/>
                <label class="input_label input_label-color-5">
                    <span class="input_label-content">订单编号(pur)</span>
                </label>
            </span>
            <span class="input">
                <input class="input_field" type="text" name="cid" id="input-1" autocomplete="off"/>
                <label class="input_label input_label-color-1">
                    <span class="input_label-content">用户ID(cid)</span>
                </label>
            </span>
            <span class="input span-eid">
                <input class="input_field" type="text" name="eid" id="input-2" autocomplete="off"/>
                <label class="input_label input_label-color-2">
                    <span class="input_label-content">雇员ID(eid)</span>
                </label>
            </span>
            <select class="emp_name"></select>
            <span class="input">
                <input class="input_field" type="text" name="pid" id="input-3" autocomplete="off"/>
                <label class="input_label input_label-color-3">
                   <span class="input_label-content">商品编号(pid)</span>
                </label>
            </span>
            <span class="input">
                <input class="input_field" type="text" name="qty" id="input-4" autocomplete="off"/>
                <label class="input_label input_label-color-4">
                    <span class="input_label-content">购买数量(qty)</span>
                </label>
            </span>
            <button type="submit" class="button-submit"></button>
        </form>
        <div><button class="action" onclick="closeDialog()" data-dialog-close="">Close</button></div>
    </div>
    <div class="dialog-content dialog-content-history"></div>
</div>
</body>

<script type="text/javascript">

// AJAX访问后台php页面，加载商品卡片
$.ajax({
    type: 'post',
    url: 'show_products.php',
    data: '',
    success: data => {
        $('.products').html(data)
    }
})

// 当页面加载完毕后，执行该函数
$(function() {
    $('.menu-history').on('click', function () {
        $.ajax({
            type: 'post',
            url: 'show_history.php',
            data: 'cid=<?php echo $cid;?>',
            success: data => {
                $('.dialog-content-history').html(data)
                $('#dialog-table').bootstrapTable({
                    pagination: true,
                    paginationLoop: true,
                })
                openDialogHistory()
            }
        })
    })
})

// 打开遮罩，同时将顾客的历史订单以表格形式展示出来
function openDialogHistory () {
    $('.dialog').addClass('dialog-open')
    $('.dialog-content-form').css('display', 'none')
    $('.dialog-content-history').css('display', 'block')
}

// 打开遮罩，同时将对应的cid和pid加载到表单对应位置中
function openDialog (pid) {
    $('.dialog').addClass('dialog-open')
    $('.dialog-content-form').css('display', 'block')
    $('.dialog-content-history').css('display', 'none')   // 关掉另一个遮罩内容层
    $('#input-1').val('<?php echo $_POST['username'] ?>')
    $('#input-3').val(pid)
    $('#input-3').parent().addClass('input-filled')
    $('#input-1').parent().addClass('input-filled')
    getEmpName()
    setOption()
}

// 关闭遮罩
function closeDialog () {
    $('.dialog').removeClass('dialog-open')
    // 清空表单
    $('#input-1').val('')
    $('#input-2').val('')
    $('#input-3').val('')
    $('#input-4').val('')
    $('#input-5').val('')
    $('#input-1').parent().removeClass('input-filled')
    $('#input-2').parent().removeClass('input-filled')
    $('#input-3').parent().removeClass('input-filled')
    $('#input-4').parent().removeClass('input-filled')
    $('#input-5').parent().removeClass('input-filled')
}

// AJAX访问后台php页面，请求提交订单信息
function addPurchases () {
var start = async function () {
    var emptyFlag = 1
    $('#form-purchases input').map(function () {
        if ($(this).val().trim() === '') {
            
            emptyFlag = 0
        }
    })

    if (!emptyFlag)
        alertError('请填写完整订单信息')
    else {
        $.ajax({
            type: 'post',
            url: 'add_purchases.php',
            data: $('#form-purchases').serialize(),
            success: data => {
                var responce = eval('(' + data + ')')
                if (responce.purFlag === 1)
                    alertError('该purchases编号已存在')
                else if (responce.cidFlag === 0)
                    alertError('该customer编号不存在')
                else if (responce.eidFlag === 0)
                    alertError('该employee编号不存在')
                else if (responce.pidFlag === 0)
                    alertError('该商品编号不存在')
                else if (responce.buyFlag === 0)
                    alertError('该商品库存余量不足')
                else {
                    // 订单提交成功，更新界面
                    alertSuccess("订单提交成功")
                    updateProductInfo()  // 在update内调用关闭dialog函数
                }
            }
        })
    }
}
start()
}

// 提交订单成功时执行此函数，更新商品卡片信息，关闭遮罩
function updateProductInfo () {
    $.ajax({
        type: 'post',
        url: 'get_product_info.php',
        data: `pid=${$('#form-purchases input[name="pid"]').val()}`,
        success: data => {
            $(`ul[class=${$('#form-purchases input[name="pid"]').val()}]`).html(data)
            closeDialog()
        }
    })
}

// 给表单label设置监听器，让表单中的label在获取和释放焦点的时候产生不同样式效果
(() => {
    [].slice.call(document.getElementsByClassName('input_field')).forEach(ele => {
        ele.addEventListener('focus', onFocus)
        ele.addEventListener('blur', onBlur)
    })

    // console.log([].slice.call(document.getElementsByClassName('input_field')))
    function onFocus (ele) {
        classie.add(ele.target.parentNode, 'input-filled')
    }

    function onBlur (ele)  {
        if (ele.target.value.trim() === '') {
            classie.remove(ele.target.parentNode, 'input-filled')
        }
    }
})()

// 回车后，表单向后台提交订单信息
$('.button-submit').click(event => {
    event.preventDefault()
    addPurchases()
})

// sweetAlert弹窗，指示成功
function alertSuccess (info) {
    closeDialog()
    sweetAlert({
        title: info,
        type: "success",
        timer: 1000,
        showConfirmButton: false,
    })
}

// sweetAlert弹窗，指示发生错误
function alertError (info) {
    sweetAlert({
        title: info,  
        type: "error",
        timer: 1000,
        showConfirmButton: false,
    })
}

// 获取所有employee的name
function getEmpName () {
    $.ajax({
        type: 'post',
        url: 'get_employees_name.php',
        data: '',
        success: data => {
            $('.emp_name').html(data)
        }
    })
}

// 给select下的option标签设置监听器
function setOption () {
    $('.emp_name').on('change', function () {
        $('#input-2').val(($(this).val()))
        $('#input-2').parent().addClass('input-filled')
    })
}
</script>
</html>
