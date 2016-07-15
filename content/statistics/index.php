生成时间 <?= $data['time'] ?>
<?php foreach ($data['list'] as $list): ?>
部门<?= $list[0] ?>
姓名<?= $list[1] ?>
预测<?= $list[2] ?>
手拨<?= $list[3] ?>
秒数<?= $list[4] ?>
总计<?= $list[5] ?>
<?php endforeach; ?>