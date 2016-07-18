<?php

class Template
{
    protected $data = [];

    function __construct($option = null)
    {
        $this->page = I('get.action', 'index');
        foreach (array('assign', 'display', 'success', 'error', 'redirect', 'verifycaptcha') as $value) {
            if (is_int(strpos($this->page, $value))) {
                trigger404();
            }
        }
        $this->file = APP_PATH . 'content/' . strtolower(get_class($this)) . '/' . $this->page . '.php';
        if (!method_exists($this, $action = $this->page)) {
            trigger404();
        } else {
            if ($GLOBALS['db']['host'] != '' && $GLOBALS['db']['username'] != '') {
                $this->medoo = new medoo([
                    'database_type' => 'mysql',
                    'charset' => 'utf8',
                    'server' => $GLOBALS['db']['host'],
                    'database_name' => $GLOBALS['db']['name'],
                    'username' => $GLOBALS['db']['username'],
                    'password' => $GLOBALS['db']['password'],
                ]);
            }
            $result = $this->$action();
            if (is_string($result) or is_numeric($result)) {
                echo $result;
            } elseif (is_array($result)) {
                echo json_encode($result);
            } elseif (is_bool($result)) {
                echo $result == true ? 'true' : 'false';
            } else {
                exit();
            }
        }
    }

    protected function assign($name, $value = '')
    {
        if (is_array($name)) {
            $this->data = array_merge($this->data, $name);
        } else {
            $this->data[$name] = $value;
        }
    }

    protected function display()
    {
        if (!file_exists($this->file)) {
            trigger404();
        }
        if (isset($this->data)) {
            $data = $this->data;
        }
        require $this->file;
        exit();
    }

    protected function success($msg = '', $url = null, $wait = 3)
    {
        $code = 1;
        $url = is_null($url) && isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : $url;
        require 'content/dispatch_jump.php';
        exit();
    }

    protected function error($msg = '', $url = null, $wait = 3)
    {
        $code = 0;
        $url = is_null($url) ? 'javascript:history.back(-1);' : $url;
        require 'content/dispatch_jump.php';
        exit();
    }

    protected function redirect($url, $time = 0, $msg = '')
    {
        $url = str_replace(array("\n", "\r"), '', $url);
        if (empty($msg))
            $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
        if (!headers_sent()) {
            if (0 === $time) {
                header('Location: ' . $url);
            } else {
                header("refresh:{$time};url={$url}");
                echo($msg);
            }
            exit();
        } else {
            $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
            if ($time != 0)
                $str .= $msg;
            exit($str);
        }
    }

    protected function verifycaptcha($verifycode)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $keystring = I('session.kcaptcha', 'null')['keystring'];
        unset($_SESSION['kcaptcha']);
        if ($verifycode === $keystring) {
            return true;
        } else {
            return false;
        }
    }
}