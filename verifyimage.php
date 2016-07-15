<?php
session_start();
error_reporting(E_ALL);

require 'includes/class-kcaptcha.php';

$kcaptcha = new KCAPTCHA();

$_SESSION['kcaptcha']['keystring'] = $kcaptcha->getKeyString();