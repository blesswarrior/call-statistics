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
        if (!$result = $this->medoo->get('cc_statistics', '*', I('date') ? ['date' => I('date')] : ['ORDER' => ['date' => 'DESC']])) {
            $this->error('暂无数据');
        }
        $this->assign('time', date('Y-m-d H:i:s', $result['updatetime']));
        $this->assign('list', json_decode($result['data']));
        $this->assign('date', $this->medoo->select('cc_statistics', 'date', ['ORDER' => ['date' => 'DESC']]));
        $this->display();
    }

    function userstat() {
        if (!$result = $this->medoo->select('cc_stat_field', '*', ['name' => I('name')])) {
            $this->error('暂无数据');
        }
        return $result;
    }

    function historystat() {

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
            yesterday_stat($_POST['date']);
        }
        if (!$result) {
            return 'fail';
        } else {
            return 'success';
        }
    }

    function yesterday_stat($date) {
        $date = date('Ymd', strtotime('-1 day', strtotime($date)));
        if ($this->medoo->has('cc_stat_field', ['date' => $date])) {
            return 'success';
        }
        if (!$data = $this->medoo->get('cc_statistics', 'data', ['date' => $date])) {
            return 'fail';
        }
        $data = json_decode($data);
        $list = array();
        foreach ($data as $data) {
            $list[] = [
                'date' => $date,
                'name' => $data[1],
                'time' => $data[4],
                'timeformat' => $data[5],
                'deletetime' => NOW_TIME + 2592000,
            ];

        }
        if (!$this->medoo->insert('cc_stat_field', $list)) {
            return 'fail';
        } else {
            return 'success';
        }
    }
}

$c = new Statistics();