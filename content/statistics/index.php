<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>迅隆员工 - 通话报表</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-table.min.css" rel="stylesheet">
    <style type="text/css">
    body {
        font-family: "Helvetica Neue", Helvetica, Microsoft Yahei, Hiragino Sans GB, WenQuanYi Micro Hei, sans-serif;
        background: #f1f4f7;
        padding-top: 20px;
        color: #5f6468;
    }
    .statistics-footer {
        padding: 40px 0;
        color: #999;
        text-align: center;
    }
    .statistics-footer p:last-child {
        margin-bottom: 0;
    }
    .highlight {
        font-weight: bold;
    }
    .box {
        margin-bottom: 0;
    }
    .fixed-table-toolbar:after {
        clear: both;
        content: "";
        display: block;
    }
    </style>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-table.min.js"></script>
    <script src="assets/js/language/bootstrap-table-zh-CN.js"></script>
    <script src="assets/js/bootstrap-table-export.min.js"></script>
    <script src="assets/js/FileSaver.min.js"></script>
    <script src="assets/js/html2canvas.min.js"></script>
    <script src="assets/js/tableExport.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#d').change(function() {
                window.location.href = 'statistics.php?date=' + $(this).children('option:selected').val();
            });
            $('#s').change(function() {
                var value = $('#s').find('option:selected').text();
                if (value == '筛选部门') {
                    $('tr>td:first-child:contains()').parent().show();
                } else {
                    $('tr>td:first-child:contains(' + value + ')').parent().show();
                    $('tr>td:first-child:not(:contains(' + value + '))').parent().hide();
                };
            });
        });
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 box">
            <div class="col-xs-12 col-sm-12 alert alert-success box"">
                <div class="col-md-3">
                    <div role="alert"><b>更新时间：<?= $data['time'] ?></b></div>
                </div>
                <div class="col-md-9">
                    <select id="d">
                        <option>筛选日期</option>
                        <?php foreach ($data['date'] as $date): ?>
                        <option><?= $date ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="s">
                        <option value="0">筛选部门</option>
                        <option value="1">超越队</option>
                        <option value="2">火狼队</option>
                        <option value="3">冲锋队</option>
                        <option value="4">团结队</option>
                        <option value="5">战狼队</option>
                        <option value="6">火焰队</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12">
            <table data-toggle="table" data-striped="true" data-search="true" data-show-export="true" data-show-toggle="true" data-show-columns="true" data-show-pagination-switch="true" data-page-size="25" data-export-types="['csv', 'png']" >
                <thead>
                    <tr>
                        <th data-sortable="true">部门</th>
                        <th data-sortable="true">姓名</th>
                        <th data-sortable="true">预测</th>
                        <th data-sortable="true">手拨</th>
                        <th data-sortable="true">总计</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['list'] as $list): ?>
                    <tr <?= $list[4] >= 10800 ? 'class="success highlight"' : null ?>>
                        <td><?= $list[0] ?></td>
                        <td><?= $list[1] ?></td>
                        <td><?= $list[2] ?></td>
                        <td><?= $list[3] ?></td>
                        <td><?= $list[5] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<footer class="statistics-footer">
    <p><a href="#top">返回顶部</a></p>
</footer>
</body>
</html>