<?php
function authcode($data, $operation = true, $key = '', $expiry = 60, $autojson = true, $ckey_length = 4) {
    if (empty($key) && $operation && $autojson) {
        exit(json_encode($data));
    }
    if ($operation == true && $autojson == true) {
        $string = json_encode($data);
    } else {
        $string = $data;
    }
    $key = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == false ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == false ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == false) {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return $autojson ? json_decode(substr($result, 26), true) : substr($result, 26);
        } else {
            return false;
        }
    } else {
        exit($keyc . str_replace('=', '', base64_encode($result)));
    }
}

function get_client_ip($type = 0, $adv = false) {
    $type = $type ? 1 : 0;
    static $ip = null;
    if ($ip !== null) return $ip[$type];
    if ($adv) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) unset($arr[$pos]);
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

function dump($arg, $_ = null) {
    $args = func_get_args();
    if (php_sapi_name() == 'cli') {
        call_user_func_array('var_dump', $args);
    } else {
        echo '<pre>';
        call_user_func_array('var_dump', $args);
        echo '</pre>';
    }
}

function trigger404($msg = null) {
    if (!headers_sent()) {
        header('HTTP/1.1 404 NotFound');
    }
    if (empty($msg)) {
        $msg = '<h1>404 Not Found</h1>';
    }
    exit($msg);
}

function I($name, $default = null, $filter = null) {
    if (strpos($name, '/')) {
        list($name, $type) = explode('/', $name, 2);
    }
    if (strpos($name, '.')) {
        list($method, $name) = explode('.', $name, 2);
    } else {
        $method = 'param';
    }
    switch (strtolower($method)) {
        case 'get':
            $input =& $_GET;
            break;
        case 'post':
            $input =& $_POST;
            break;
        case 'param':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $input =& $_POST;
                    break;
                default:
                    $input =& $_GET;
                    break;
            }
            break;
        case 'request':
            $input =& $_REQUEST;
            break;
        case 'session':
            $input =& $_SESSION;
            break;
        case 'server':
            $input =& $_SERVER;
            break;
        case 'globals':
            $input =& $GLOBALS;
            break;
        default:
            return null;
    }
    if ($name == '') {
        $data = $input;
        $filters = isset($filter) ? $filter : 'htmlspecialchars';
        if ($filters) {
            if (is_string($filters)) {
                $filters = explode(',', $filters);
            }
            foreach ($filters as $filter) {
                $data = array_map_recursive($filter, $data);
            }
        }
    } elseif (isset($input[$name])) {
        $data = $input[$name];
        $filters = isset($filter) ? $filter : 'htmlspecialchars';
        if ($filters) {
            if (is_string($filters)) {
                if (strpos($filters, '/') === 0) {
                    if (preg_match($filters, (string)$data) !== 1) {
                        return isset($default) ? $default : null;
                    }
                } else {
                    $filters = explode(',', $filters);
                }
            } elseif (is_int($filters)) {
                $filters = array($filters);
            }
            if (is_array($filters)) {
                foreach ($filters as $filter) {
                    if (function_exists($filter)) {
                        $data = is_array($data) ? array_map_recursive($filter, $data) : $filter($data);
                    } else {
                        $data = filter_var($data, is_int($filter) ? $filter : filter_id($filter));
                        if ($data === false) {
                            return isset($default) ? $default : null;
                        }
                    }
                }
            }
        }
        if (!empty($type)) {
            switch (strtolower($type)) {
                case 'a': //数组
                    $data = (array)$data;
                    break;
                case 'd': //整数
                    $data = (int)$data;
                    break;
                case 'f': //浮点
                    $data = (float)$data;
                    break;
                case 'b': //布尔
                    $data = (boolean)$data;
                    break;
                default:  //文本
                    $data = (string)$data;
                    break;
            }
        }
    } else {
        $data = isset($default) ? $default : null;
    }
    is_array($data) && array_walk_recursive($data, 'think_filter');
    return $data;
}

function array_map_recursive($filter, $data) {
    $result = array();
    foreach ($data as $key => $val) {
        $result[$key] = is_array($val) ? array_map_recursive($filter, $val) : call_user_func($filter, $val);
    }
    return $result;
}

function think_filter(&$value) {
    if(preg_match('/^(EXP|NEQ|GT|EGT|LT|ELT|OR|XOR|LIKE|NOTLIKE|NOT BETWEEN|NOTBETWEEN|BETWEEN|NOTIN|NOT IN|IN)$/i', $value)) {
        $value .= ' ';
    }
}

function is_ssl() {
    if(isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))){
        return true;
    } elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'] )) {
        return true;
    }
    return false;
}

function redirect($url, $time = 0, $msg = '') {
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

function create_guid($option = 0, $strtolower = false)
{
    if (function_exists('com_create_guid')) {
        $result = trim(com_create_guid(), '{}');
    } else {
        mt_srand((double)microtime() * 10000);
        $hyphen = chr(45);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $result = substr($charid, 0, 8) . $hyphen
                .substr($charid, 8, 4) . $hyphen
                .substr($charid, 12, 4). $hyphen
                .substr($charid, 16, 4). $hyphen
                .substr($charid, 20, 12);
    }
    if ($option == 1) {
        $result = str_replace('-', null, $result);
    } elseif ($option == 2) {
        $result = '{' . $result . '}';
    }
    if ($strtolower) {
        $result = strtolower($result);
    }
    return $result;
}

function generate_password($length = 8) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ( $i = 0; $i < $length; $i++ ) 
    {
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password;
}

function build_order_no() {
    mt_srand((double) microtime() * 1000000);
    $i[0] = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    $i[1] = substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 3, 5);
    return date('Ymd') . $i[0] . $i[1];
}

function gethtml_resetpasswd($url, $title) {
return <<<HTML
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>取回密码说明</title>
    </head>
    <body>
        取回密码说明<br>
        <p>您好， 这封信是由<strong> {$title} </strong>官方发送的。</p>
        <p>
            您收到这封邮件，是由于这个邮箱地址在<strong> {$title} </strong>被登记为用户邮箱， 且该用户请求使用 Email 密码重置功能所致。
        </p>
        <p>
            ----------------------------------------------------------------------<br>
            <strong>重要！</strong><br>
            ----------------------------------------------------------------------
        </p>
        <p>
            如果您没有提交密码重置的请求或不是<strong> {$title} </strong>的注册用户，请立即忽略 并删除这封邮件。只有在您确认需要重置密码的情况下，才需要继续阅读下面的 内容。
        </p>
        <p>
            ----------------------------------------------------------------------<br>
            <strong>密码重置说明</strong><br>
            ----------------------------------------------------------------------
        </p>
        您只需在提交请求后的1天内，通过点击下面的链接重置您的密码：<br>
        <a href="{$url}" target="_blank">{$url}</a><br>
        (如果上面不是链接形式，请将该地址手工粘贴到浏览器地址栏再访问)
        <p>
            在上面的链接所打开的页面中输入新的密码后提交，您即可使用新的密码登录网站了。您可以在用户控制面板中随时修改您的密码。
        </p>
        <p>
            此致<br>
        </p>
        <p>
            《{$title}》官方 管理团队.
        </p>
    </body>
</html>
HTML;
}