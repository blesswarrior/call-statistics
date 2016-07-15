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
        $result = $this->medoo->get('cc_statistics', '*', 'ORDER BY `id` DESC');
        /*
        $this->assign('time', strftime($result['createtime']));
        $this->assign('list', json_decode($result['data']));
        $this->display();
        */
        dump($result['createtime']);
        dump(json_decode($result['data']));
    }

    function report()
    {
        if (!$this->medoo->insert('cc_statistics', ['data' => $_POST['data'], 'deletetime' => NOW_TIME + 604800])) {
            echo "error";
        } else {
            echo "success";
        }
    }
}

$c = new Statistics();