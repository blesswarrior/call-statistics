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
    </style>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-table.min.js"></script>
    <script src="assets/js/language/bootstrap-table-zh-CN.js"></script>
    <script src="assets/js/bootstrap-table-export.min.js"></script>
    <script src="assets/js/FileSaver.min.js"></script>
    <script src="assets/js/html2canvas.min.js"></script>
    <script src="assets/js/tableExport.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <table data-toggle="table" data-striped="true" data-search="true" data-show-export="true" data-show-toggle="true" data-show-columns="true" data-show-pagination-switch="true" data-page-size="25" data-export-types="['csv', 'png']" >
                <thead>
                    <tr>
                        <th data-sortable="true">日期</th>
                        <th data-sortable="true">姓名</th>
                        <th data-sortable="true">时长</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['list'] as $list): ?>
                    <tr <?= $list['time'] >= 10800 ? 'class="success highlight"' : null ?>>
                        <td><?= $list['date'] ?></td>
                        <td><?= $list['name'] ?></td>
                        <td><?= $list['timeformat'] ?></td>
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