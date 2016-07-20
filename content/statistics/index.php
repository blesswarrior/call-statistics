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
            $('#d').change(function() {
                window.location.href = 'statistics.php?date=' + $(this).children('option:selected').val();
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
            $('#myModal').on('shown.bs.modal', function() {
                $('#myInput').focus()
            });
            $(".height li").click(function() {
                $(this).addClass("active").siblings().removeClass("active");
            });
            $('#myModal').on('show.bs.modal', function (e) {
                alert('1');
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
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <table data-toggle="table" data-striped="true" data-search="true" data-show-export="true" data-show-toggle="true" data-show-columns="true" data-pagination="true" data-page-size="10" data-export-types="['csv', 'png']">
                        <thead>
                            <tr>
                                <th data-sortable="true">日期</th>
                                <th data-sortable="true">姓名</th>
                                <th data-sortable="true">时长</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['list'] as $list): ?>
                            <tr>
                                <td><?= $list[0] ?></td>
                                <td><?= $list[3] ?></td>
                                <td><?= $list[5] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                        <a class="navbar-brand" href="http://tools.xl127.com">Brand</a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                            <li><a href="#">Link</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div role="alert" class="nav_xunlong">
                            <select id="d">
                                <option>筛选日期</option>
                                <?php foreach ($data['date'] as $date): ?>
                                <option><?= $date ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select id="s">
                                <option>筛选部门</option>
                                <option>超越队</option>
                                <option>火狼队</option>
                                <option>冲锋队</option>
                                <option>团结队</option>
                                <option>战狼队</option>
                                <option>火焰队</option>
                            </select>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#">Link</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
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
                <li role="presentation" class="active"><a href="#">Home</a></li>
                <li role="presentation"><a href="#">Profile</a></li>
                <li role="presentation"><a href="#">Messages</a></li>
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
                <tr>
                    <td><?= $list[0] ?></td>
                    <td class="shou" data-toggle="modal" data-target="#myModal"><?= $list[1] ?></td>
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