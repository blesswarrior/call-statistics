<?php
require 'includes/start.php';

class Statistics extends Template
{
    
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        if (!$result = $this->medoo->get('cc_statistics', '*', I('date') ? ['date' => I('date')] : ['ORDER' => ['id' => 'DESC']])) {
            $this->error('暂无数据');
        }
        $this->assign('time', date('Y-m-d H:i:s', $result['updatetime']));
        $this->assign('list', json_decode($result['data']));
        $this->assign('date', $this->medoo->select('cc_statistics', 'date'));
        $this->display();
    }

    function report()
    {
        if ($this->medoo->has('cc_statistics', ['date' => $_POST['date']])) {
            $result = $this->medoo->update('cc_statistics', [
                'data' => $_POST['data'],
                'updatetime' => NOW_TIME,
            ], ['date' => $_POST['date']]);
        } else {
            $result = $this->medoo->insert('cc_statistics', [
                'date' => $_POST['date'],
                'data' => $_POST['data'],
                'updatetime' => NOW_TIME,
                'deletetime' => NOW_TIME + 2592000
            ]);
        }
        return $result;
    }
}

$c = new Statistics();