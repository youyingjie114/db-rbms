<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>RBMS Control</title>
<!-- 导入弹窗项目 -->
<script src="js/sweet-alert.js"></script>
<link rel="stylesheet" type="text/css" href="css/sweet-alert.css">
<!-- 导入JQ -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- 导入图标字体 -->
<link rel="stylesheet" type="text/css" href="http://at.alicdn.com/t/font_1229838_h5uzlt2lj5j.css">
<!-- 导入bootstrap -->
<link rel="stylesheet" href="bootstrap-table/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-table/bootstrap-table.min.css">
<script src="bootstrap-table/bootstrap.min.js"></script>
<script src="bootstrap-table/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.2/locale/bootstrap-table-zh-CN.min.js"></script>
<!-- 导入其他css文件 -->
<link rel="stylesheet" type="text/css" href="css/control.css">
<link rel="stylesheet" type="text/css" href="css/iconfont.css">
<link rel="stylesheet" type="text/css" href="css/table.css">
<link rel="stylesheet" type="text/css" href="css/dialog.css">
<link rel="stylesheet" type="text/css" href="css/control_dialog_form.css">
</head>
<body>
<div class="nav-header">
    <span class="header-icon">
        <span class="my-iconfont icon-user-check"></span>
        <strong>Admin</strong>
    </span>
    <li class = "header-user">
        <a href="javascript:;" class="user-head">
            <img src="img/head1.jpg" class="img-head">
            <span class="user-name"><?php echo $_POST['username']; ?></span>
            <span class="my-iconfont icon-triangle-down"></span>
        </a>
    </li>
</div>
<div class="nav">
    <div class="nav-top">
        <div id="mini" style="border-bottom:1px solid rgba(255,255,255,.1)"><img src="img/mini.png"></div>
    </div>
    <ul>
        <li class="nav-item">
            <a href="javascript:;"><i class="my-icon nav-icon icon_1"></i><span>系统设置</span><i class="my-icon nav-more"></i></a>
            <ul>
                <li><a href="javascript:;" onclick="showTable('logs')"><span>操作日志</span></a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="javascript:;"><i class="my-iconfont icon-table2 nav-icon"></i><span>项目表格</span><i class="my-icon nav-more"></i></a>
            <ul>
                <li><a href="javascript:;" onclick="showTable('customers')"><span>顾客列表</span></a></li>
                <li><a href="javascript:;" onclick="showTable('employees')"><span>雇员列表</span></a></li>
                <li><a href="javascript:;" onclick="showTable('products')"><span>商品列表</span></a></li>
                <li><a href="javascript:;" onclick="showTable('suppliers')"><span>供应商列表</span></a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="javascript:;"><i class="my-icon nav-icon icon_3"></i><span>订单管理</span><i class="my-icon nav-more"></i></a>
            <ul>
                <li><a href="javascript:;" onclick="showTable('purchases')"><span>订单列表</span></a></li>
            </ul>
        </li>
    </ul>
</div>
<div class="nav-content">
    <div class="content-header">
        <ul class="path">
            <li class="path-home my-iconfont icon-home">
                <span class="path-home-content">home</span>
            </li>
            <li class="path-first my-iconfont">
                <span class="path-home-content"></span>
            </li>
            <li class="path-second my-iconfont">
                <span class="path-home-content"></span>
            </li>
        </ul>
    </div>
    <div id="my-toolbar">
        <button class="toolbar-button-add" data-dialog-close="">新增</button>
    </div>
    <div class="table">
    </div>
</div>
<div class="dialog">
    <div class="dialog-overlay" onclick="closeDialog()"></div>
    <div class="dialog-content">
        <h2 class="dialog-header"><strong>Hello!</strong> Add New Data</h2>
        <div class="dialog-table"></div>
        <form class="form">
        </form>
        <div class="form-button-wrap">
            <button type="submit" class="action button-submit-show">Submit</button>
            <button class="action" onclick="closeDialog()" data-dialog-close="">Close</button>
        </div>
    </div>
</div>
</body>

<script type="text/javascript">

// 当页面加载完毕后，执行该函数
$(function() {
    // 给左边栏a标签添加点击监听器，点击展开边栏下的表格目录
    $('.nav-item>a').on('click', function() {
        if (!$('.nav').hasClass('nav-mini')) {
            if ($(this).next().css('display') == "none") {
                $('.nav-item').children('ul').slideUp(300)
                $(this).next('ul').slideDown(300)
                $(this).parent('li').addClass('nav-show').siblings('li').removeClass('nav-show')
            } else {
                $(this).next('ul').slideUp(300)
                $('.nav-item.nav-show').removeClass('nav-show')
            }
        }
    })
    // 若左边栏收缩到最小化，则采取悬浮下拉菜单显示表格目录
    $('#mini').on('click', function() {
        if (!$('.nav').hasClass('nav-mini')) {
            $('.nav-item.nav-show').removeClass('nav-show')
            $('.nav-item').children('ul').removeAttr('style')
            $('.nav').addClass('nav-mini')
            $('.nav-content').css('marginLeft', '60px')
        } else {
            $('.nav').removeClass('nav-mini')
            $('.nav-content').css('marginLeft', '220px')
        }
    })
    // 给表格名称添加监听器，点击后在页面中更新对应路径
    $('.nav-item li').on('click', function(){
        $('.path-first').addClass('icon-arrow-right2')
        $('.path-second').addClass('icon-arrow-right2')
        var firstStr = $(this).parent().prev().children().eq(1).text()
        var secondStr = $(this).children().children().eq(0).text()
        $('.path-first').children().eq(0).text(firstStr)
        $('.path-second').children().eq(0).text(secondStr)
    })
    // 设置自定义添加按钮监听器，点击弹出弹窗
    $('.toolbar-button-add').on('click', function() {
        openDialog()
    })
})

// 用AJAX实现表格显示，动态更新页面
function showTable (tableName) {
    $.ajax({
        type: 'post',
        url: 'show.php',
        data: `table_name=${tableName}`,
        success: data => {
            $('.content-header').after($('#my-toolbar'))
            $('#my-toolbar').css('display', 'none')
            $('.table').html(data)
            // 设置bootstrap table参数
            $('#table').bootstrapTable({
                pagination: true,
                paginationLoop: true,
                showPaginationSwitch: true,
                search: true,
                toolbar: '#my-toolbar',
                sortable: true,
                columns: getColumns()
            })
            
            // 添加自定义工具栏
            $('#my-toolbar').css('display', 'inline-block')
            if (tableName === 'logs')
                $('#my-toolbar').css('display', 'none')
            
            // 重新绑定监听器，避免排序后监听器失效
            $('thead th div').on('click', function () {
                setTimeout(() => {
                    setMonitors()
                }, 10)
            })

            setMonitors()
        }
    })
    // 显示表格的同时，更新“隐藏的”表单中的html代码，修改与表格对应的数据
    $.ajax({
        type: 'post',
        url: 'show_form.php',
        data: `table_name=${tableName}`,
        success: data => {
            $('.form').html(data)
            $('.input_field').on('focus', function() {
                $(this).parent().addClass('input-filled')
            })
            $('.input_field').on('blur', function() {
                if ($(this).val().trim() === '') 
                    $(this).parent().removeClass('input-filled')
            })
            $('.button-submit,.button-submit-show').click(event => {
                event.preventDefault()
                add()
            })
        }
    })
}

// 打开弹窗
function openDialog () {
    $('.dialog').addClass('dialog-open')
}

// 关闭弹窗
function closeDialog () {
    $('.dialog').removeClass('dialog-open')
    // 关闭弹窗的同时，清空表单数据
    $('.input_field').each(function() {
        $(this).val('')
        $(this).parent().removeClass('input-filled')
        $('.button-submit-show').removeClass('button-modify-show')
    })
    // 恢复表单中的标题等其他html代码
    $('.dialog-header').css('display', 'block')
    $('.form').css('display', 'block')
    $('.form-button-wrap').css('display', 'block')
    $('.dialog-table').html('')
    $('.dialog-header').html("<strong>Hello!</strong> Add New Data")
}

// AJAX实现添加一条数据
function add () {
    if ($('caption').text() === 'purchases') {  // 若添加的是订单数据，请求特定的add_purchases.php页面
        $.ajax({
            type: 'post',
            url: 'add_purchases.php',
            data: $('form').serialize() + `&table_name=${$('caption').text()}`,
            success: data => {
                // 插入成功后，使用append插入到table里
                var responce = eval('(' + data + ')')
                if (responce.purFlag === 1)
                    alertWarning('该purchases编号已存在')
                else if (responce.cidFlag === 0)
                    alertWarning('该customer编号不存在')
                else if (responce.eidFlag === 0)
                    alertWarning('该employee编号不存在')
                else if (responce.pidFlag === 0)
                    alertWarning('该商品编号不存在')
                else if (responce.buyFlag === 0)
                    alertWarning('该商品库存余量不足')
                else {
                    // 订单提交成功，更新界面
                    alertSuccess("订单提交成功")
                }
            }
        })
        return
    }
    // 如果判断是修改操作，跳转到modify函数并且执行完退出add
    if ($('.button-submit-show').hasClass('button-modify-show')) {
        modify()
        return
    }
    // 若代码执行到此处，则表明代码添加的数据是其他表格的数据，访问add.php页面
    $.ajax({
        type: 'post',
        url: 'add.php',
        data: $('form').serialize() + `&table_name=${$('caption').text()}`,
        success: data => {
            // 插入成功后，使用append插入到table里
            var responce = eval('(' + data + ')')
            responce.affectedNum === -1 ? alertError('插入失败') : alertSuccess('插入成功')
        }
    })
}

// sweetAlert弹窗，指示成功
function alertSuccess (info) {
    showTable($('caption').text())
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

// sweetAlert弹窗，指示存在警告信息
function alertWarning (info) {
    sweetAlert({
        title: info,  
        type: "warning",
    })
}

// AJAX删除一条数据，通过访问delete.php实现
function deleteLine (index) {
    $.ajax({
        type: 'post',
        url: 'delete.php',
        data: `table_name=${$('caption').text()}&index=${index}`,
        success: data => {
            var responce = eval('(' + data + ')')
            responce.affectedNum === -1 ? alertError('删除失败') : alertSuccess('删除成功')
        }
    })
}

// AJAX修改一条数据，通过访问modify.php实现
function modify () {
    $.ajax({
        type: 'post',
        url: 'modify.php',
        data: `table_name=${$('caption').text()}&` + $('.form').serialize(),
        success: data => {
            var responce = eval('(' + data + ')')
            responce.affectedNum === -1 ? alertError('修改失败') : alertSuccess('修改成功')
            // 如果修改成功，去掉submit按钮的名为modify的class
            if (responce.affectedNum != -1)
                $('.button-submit-show').removeClass('button-modify-show')
        }
    })
}

// AJAX展示商品的月度销售情况，通过后台php页面调用show_monthly的存储过程实现
function showMonthly (pid) {
    $.ajax({
        type: 'post',
        url: 'show_monthly.php',
        data: `pid=${pid}`,
        success: data => {
            $('.dialog-table').html(data)
            $('#dialog-table').bootstrapTable({
                pagination: true,
            })
        }
    })
}

// AJAX获取表格的表头信息，修改表头是否可以排序
function getColumns () {
    var columns = new Array()
    var num = 0;
    $('thead th').map(function () {
        var flag = true
        var field = $(this).text()
        if (field === 'options' || field === 'monthly_Report')
            flag = false
        columns[num++] = {
            title: field,
            sortable: flag,
        }
    })
    return columns
}

// 设置表格中按钮的监听器
function setMonitors () {
    // 对删除按钮添加监听器
    $('.td-button-delete-div').on('click', function() {
        deleteLine($(this).parent().parent().attr('data-index'))
    })

    // 对编辑按钮添加监听器
    $('.td-button-modify-div').on('click', function() {
        var button = $(this)
        $('.form input').each(function() {
            var str = $(this).next().children().text()
            $(this).val(button.parent().prevAll(`[class="${str}"]`).text())
            $(this).parent().addClass('input-filled')
        })
       // 给dialog中的submit按钮添加名为‘modify’的class
        $('.button-submit-show').addClass('button-modify-show')
        // 修改dialog标题
        $('.dialog-header').html("<strong>Hello!</strong> Update the Data")
        openDialog()
    })

    // 对products表格里的分析按钮添加监听器
    $('.td-button-analysis-div').on('click', function() {
        showMonthly($(this).parent().prevAll('[class="pid"]').text())
        $('.dialog-header').css('display', 'none')
        $('.form').css('display', 'none')
        $('.form-button-wrap').css('display', 'none')
        openDialog()
    })
}

</script>
</html>