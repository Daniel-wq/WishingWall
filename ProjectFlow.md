##许愿墙流程
###文件目录分布
```php
|--Wishing Wall
  	|--controller						//控制器文件目录	
  		|--Base.class.php				//公共类控制器
  		|--Member.class.php				//用户控制器
  		|--Wish.class.php				//许愿页面墙控制器
  	|--data								//数据库目录
  		|--data.php						//许愿信息数据库
  		|--userData.php					//用户数据库
  	|--lib								//库文件目录，存放各类工具，如：验证码
  		|--code.php						//验证码类
  	|--resource							//资源目录
  		|--bt							//bootstrap文件目录
  		|--css							//样式文件目录
  		|--js							//自定义js文件目录
  	|--view								//模板目录
  		|--member						//用户登陆、注册模板目录
  			|--login.php				//登录页面模板
  			|--reg.php					//注册页面模板
  		|--wish							//许愿墙模板目录
  			|--index.php				//许愿墙首页
  	-functions.php						//函数文件
  	-index.php							//入口文件
```



* 1 创建文件目录：controller、data、view、resource、lib、resource、view等文件目录，用来对项目文件进行分类

* 2 创建index.php、functions.php、data.php、userData.php文件

* 3 构建function.php文件，书写（自定义）常用的函数：p函数（输出函数）、IS_POST常量（检测是否为pos提交）、__autoload函数（自动加载函数）、go函数（跳转函数）、dataToFile函数（数据存入数据库函数）

  ```php
  //设置时区为东八区
  date_default_timezone_set("PRC");
  //开启session
  session_start();
  //p函数
  function p($var){
    	echo "<pre>";
    	print_r($var);
    	echo "</pre>";
  }
  //IS_POST常量
  define("IS_POST",$_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
  //自动加载函数__autoload(实例化时为找到的类名)
  function __autoload($className){
  	inlcude './controller/{$className}.class.php';
  }
  //跳转函数go(提示信息,跳转指向的页面或方法)
  function go($msg,$url){
    	$str = <<<str
  <script>
  alert("{$msg}");
  location.href="{$url}";
  </script>
  str;
    exit($str);//跳转并阻止之后的代码运行
  }
  //数据写入数据库函数dataToFile(数据库文件名,要写入的数据)
  function dataToFile($file,$data){
    	//合法化数据
    	$data = var_export($data,true);
    	//组合数据库
    	$str = <<<str
  <?php
  	return {$data};
  ?>
  str;  	
    	//将数据写入数据库
    	file_put_contents($file,$str);
  }
  ```

* 4 构建index.php入口文件

  ```php
  <?php
    	//载入数据库文件
  	include './functions.php';
  	//get地址栏参数：?s=wish/index或?s=member/login
  	$s = isset($_GET['s']) ? $_GET['s'] : 'wish/index';
  	//将上字符串转换数组，需要从字符串中获得控制器名和方法名
  	$arr = explode('/',$s);
  	//Array
  	//(
  	//    [0] => wish
  	//    [1] => index
  	//)	
  	//获得控制器名
  	$c = ucfirst($arr[0]);
  	//定义为常量，公共类中需要用到控制器名来组合模板的载入路径
  	define('CONTROLLER',strtolower($c));
  	//获得方法名
  	$a = strtolower($arr[1]);
  	//定义为常量，公共类中需要用到方法名来组合模板的载入路径
  	define('ACTION',$a);
  	
  	//实例化，并调用
  	call_user_func_array([new $c,$a],[]);
  ```

* 5 在controller目录下构建公共类Base.class.php，构建view方法，组合模板路径

  ```php
  abstract class Base{    
    	public function view($data=[]){ 
        	//include './view/wish/index.php
      	include './view/' . CONTROLLER . '/' . ACTION .'.php';    
    	}
  }
  ```

  ​