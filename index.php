<?php
require 'includes/start.php';

class Index extends Template
{
    
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->redirect('statistics.php');
    }
}

$c = new Index();