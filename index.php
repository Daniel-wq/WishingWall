<?php
include './functions.php';
//p(123);

//$s=wish/index $s=member/login
$s = isset($_GET['s']) ? $_GET['s'] : 'wish/index';
//将字符串转换为数组
//我们需要通过上述字符串来获得控制器名和方法名
$arr = explode('/',$s);
//p($arr);
//转换为数组之后的格式如下：
//Array
//(
//    [0] => wish
//    [1] => index
//)
$c = ucfirst($arr[0]);

define("CONTROLLER",strtolower($c));

$a = strtolower($arr[1]);
define("ACTION",$a);

call_user_func_array([new $c,$a],[]);


