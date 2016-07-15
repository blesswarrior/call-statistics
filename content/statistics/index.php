<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>讯隆员工-当天通话报表</title>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- 可选的Bootstrap主题文件（一般不用引入） -->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script>
        $(function(){
           var option=$(".s option:selected").text();
            
        });
    </script>
    <style>
        body{background: url("assets/images/bg-0.png");color: white;font-family: 微软雅黑;}
        .center,p{text-align: center;  font-size: 2em;  color: red;}
        span>option{font-weight: bold;font-size: 1.5em;}
        select{background-color: gray;font-weight: bold;font-size: 1.5em;}
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 center">
            <div>
                <b>最近更新时间： <?= $data['time'] ?></b>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12">
            <p>
                <b>每隔1小时刷新一次数据！</b>
            </p>
        </div>
        <div class="col-xs-12 col-sm-12">
            <table class="table table-bordered a">
                <tr>
                    <th class="s">
                        <select>
                            <option>部门</option>
                            <option>超越队</option>
                            <option>火狼队</option>
                            <option>冲锋队</option>
                            <option>团结队</option>
                            <option>战狼队</option>
                            <option>火焰队</option>
                        </select>
                    </th>
                    <th>
                        <span>
                            <option>姓名</option>
                        </span>
                    </th>
                    <th>
                        <span>
                            <option>预测</option>
                        </span>
                    </th>
                    <th>
                        <span>
                            <option>手拨</option>
                        </span>
                    </th>
                    <th>
                        <span>
                            <option>秒数</option>
                        </span>
                    </th>
                    <th>
                        <span>
                            <option>总计</option>
                        </span>
                    </th>
                </tr>
                <?php foreach ($data['list'] as $list): ?>
                <tr>
                    <td>
                        <?= $list[0] ?>
                    </td>
                    <td>
                        <?= $list[1] ?>
                    </td>
                    <td>
                        <?= $list[2] ?>
                    </td>
                    <td>
                        <?= $list[3] ?>
                    </td>
                    <td>
                        <?= $list[4] ?>
                    </td>
                    <td>
                        <?= $list[5] ?>
                    </td>
                </tr>
                <?php endforeach; ?>
        </div>
    </div>
</div>

</body>
</html>
