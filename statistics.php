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
        $cc_statistics = $this->medoo->get('cc_statistics', '*', 'ORDER BY `id` DESC');
        dump('time:' . strftime($cc_statistics['createtime']));
        dump(json_decode($cc_statistics['data']));
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