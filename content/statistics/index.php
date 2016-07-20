<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>迅隆员工 - 通话报表</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-table.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
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
            $(".d li").click(function() {
                window.location.href = 'statistics.php?date=' + $(this).text();
            });
            $(".s li").click(function() {
                var value = $(this).text();
                if (value == $('.s-all').text()) {
                    $('tr>td:first-child').parent().show();
                } else {
                    $('tr>td:first-child:contains(' + value + ')').parent().show();
                    $('tr>td:first-child:not(:contains(' + value + '))').parent().hide();
                }
            });
            var all = $('#s option').first('option:selected').text();
            $('#s').change(function() {
                var value = $('#s').find('option:selected').text();
                if (value == all) {
                    $('tr>td:first-child').parent().show();
                } else {
                    $('tr>td:first-child:contains(' + value + ')').parent().show();
                    $('tr>td:first-child:not(:contains(' + value + '))').parent().hide();
                }
            });
            $('#myModal').on('show.bs.modal', function (e) {
                var o = $(e.relatedTarget);
                var name = o.data('whatever');
                var modal = $(this);
                modal.find('.modal-title').text('历史时长：' + name);
                $('#userstat').bootstrapTable('destroy');
                $('#userstat').bootstrapTable($.extend({url: 'statistics.php?action=userstat'}, {
                    queryParams: function(params) {
                        return $.extend({}, params, {name: name});
                    }
                }));
            });
        });
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">历史时长</h4>
                </div>
                <div class="modal-body">
                    <table id="userstat" data-striped="true" data-search="true" data-show-export="true" data-show-toggle="true" data-show-columns="true" data-pagination="true" data-page-size="15" data-export-types="['csv', 'png']">
                        <thead>
                            <tr>
                                <th data-field="date">日期</th>
                                <th data-field="name">姓名</th>
                                <th data-field="timeformat">时长</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">关闭窗口</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 padding">
            <nav class="navbar navbar-default navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="http://tools.xl127.com"><span><b>上海迅隆投资 - 统计报表</b></span></a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> 筛选日期 <span class="caret"></span></a>
                                <ul class="dropdown-menu d">
                                    <?php foreach ($data['date'] as $date): ?>
                                    <li><a href="javascript:void(0);"><?= $date ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> 筛选部门 <span class="caret"></span></a>
                                <ul class="dropdown-menu s">
                                    <li><a href="javascript:void(0);" class="s-all">全部</a></li>
                                    <li><a href="javascript:void(0);">超越队</a></li>
                                    <li><a href="javascript:void(0);">火狼队</a></li>
                                    <li><a href="javascript:void(0);">冲锋队</a></li>
                                    <li><a href="javascript:void(0);">团结队</a></li>
                                    <li><a href="javascript:void(0);">战狼队</a></li>
                                    <li><a href="javascript:void(0);">火焰队</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 padding">
            <ul class="nav nav-pills nav-stacked height">
                <li role="presentation" class="active"><a href="#"><span class="glyphicon glyphicon-align-right" aria-hidden="true"></span> 统计报表</a></li>
                <li role="presentation"><a href="http://www.xl127.com/" target="_blank"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> 迅隆官网</a></li>
                <li role="presentation"><a href="http://www.xl127.com/cc" target="_blank"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span> 呼叫中心</a></li>
                <li role="presentation"><a href="http://www.xl127.com/tv" target="_blank"><span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span> 财经直播</a></li>
            </ul>
        </div>
        <div class="col-md-10 tableH" style="background-color: white;">
            <table data-toggle="table" data-striped="true" data-search="true" data-show-export="true" data-show-toggle="true" data-show-columns="true" data-pagination="true" data-page-size="100" data-export-types="['csv', 'png']">
                <thead>
                    <h4 class="col-md-12 h4 hidden-xs">
                        <div role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <?= $data['time'] ?>
                        </div>
                    </h4>
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
                    <td class="shou" data-toggle="modal" data-target="#myModal" data-whatever="<?= $list[1] ?>"><?= $list[1] ?></td>
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
</body>
</html>