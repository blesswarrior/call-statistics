<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>讯隆员工-当天通话报表</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-table.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: "Helvetica Neue", Helvetica, Microsoft Yahei, Hiragino Sans GB, WenQuanYi Micro Hei, sans-serif;
            background: #f1f4f7;
            padding-top: 20px;
            color: #5f6468;
        }
    </style>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-table.min.js"></script>
    <script src="assets/js/language/bootstrap-table-zh-CN.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#d').change(function() {
                window.location.href = 'statistics.php?date=' + $(this).children('option:selected').val();
            });
            $("#s").change(function() {
                var value = $('#s').find('option:selected').text();
                $("tr>td:first-child:contains("+value+")").parent().show();
                $("tr>td:first-child:not(:contains("+value+"))").parent().hide();
            });
        });
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 center">
            <div>
                <b>更新时间：<?= $data['time'] ?></b>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12">
            <p>
                <b>每隔半小时刷新一次数据！</b>
            </p>
        </div>
        <div class="col-xs-12 col-sm-12">
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
        <div class="col-xs-12 col-sm-12">
            <table data-toggle="table" data-striped="true" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-pagination="true" data-page-size="100" >
                <thead>
                    <tr>
                        <th data-sortable="true">部门</th>
                        <th data-sortable="true">姓名</th>
                        <th data-sortable="true">预测</th>
                        <th data-sortable="true">手拨</th>
                        <th data-sortable="true">秒数</th>
                        <th data-sortable="true">总计</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['list'] as $list): ?>
                    <tr>
                        <td><?= $list[0] ?></td>
                        <td><?= $list[1] ?></td>
                        <td><?= $list[2] ?></td>
                        <td><?= $list[3] ?></td>
                        <td><?= $list[4] ?></td>
                        <td><?= $list[5] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
