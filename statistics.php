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
        if (!$date = I('get.date', null)) {
            $result = $this->medoo->get('cc_statistics', '*', ['ORDER' => ['id' => 'DESC']]);
        } else {
            $result = $this->medoo->get('cc_statistics', '*', ['date' => $date]);
        }
        if ($result == false) {
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
            if ($this->medoo->update('cc_statistics', [
                'data' => $_POST['data'],
                'updatetime' => NOW_TIME,
            ], ['date' => $_POST['date']])) {
                return 'success';
            } else {
                return 'fail';
            }
        } else {
            if ($this->medoo->insert('cc_statistics', [
                'date' => $_POST['date'],
                'data' => $_POST['data'],
                'updatetime' => NOW_TIME,
                'deletetime' => NOW_TIME + 2592000
            ])) {
                return 'success';
            } else {
                return 'fail';
            }
        }
    }
}

$c = new Statistics();