<?php
//设置时区
date_default_timezone_set("PRC");
//开启session
session_start();
//输出函数
function p($var){
    echo "<pre style='font-size: 16px;'>";
    print_r($var);
    echo "</pre>";
}

//定义常量，检测是否为POST提交
define("IS_POST",$_SERVER['REQUEST_METHOD'] == "POST" ? true : false);

/**
 * 自动加载函数
 * 当实例化找不到类的时候，就会自动执行这个函数，会把为找的类名作为参数传入，运行里面的代码
 * @param $className
 */
function __autoload($className){
    include "./controller/{$className}.class.php";
}

/**
 * 跳转函数
 * @param $meg  [提示信息]
 * @param $url  [跳转的路径]
 */
function go($msg,$url){
    $str = <<<str
<script>
alert("{$msg}");
location.href = "{$url}";
</script>
str;
    exit($str);
}

/**
 * 写入数据库文件
 * @param $file [数据库文件]
 * @param $data [要添加的数据]
 */
function dataToFile($file,$data){
    //合法化，转换为可操作的字符串
    $data = var_export($data,true);
    //拼接字符串
    $str = <<<str
<?php
return {$data};
?>
str;
    //将数据写入数据库
    file_put_contents($file,$str);
}

/**
 * 实用工具类的函数
 * @param $name [工具名]
 */
function useTool($name){
    include "./lib/{$name}.php";
}
//eg：useTool(code);