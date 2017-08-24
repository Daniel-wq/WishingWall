<?php
//1、继承Base类
//2、Base中有view方法是用来载入模板的，而wish方法中也需要载入模板，我们只需要调用Base类中的view方法就能实现模板载入
class Wish extends Base {
    //1、定义一个私有属性
    //2、用来调用实现载入数据库文件，因为只内部调用，所以定义为私有属性
    private $data;
    //1、构建构造方法
    //2、之后不仅index方法中需要载入数据库,可能其他场景也需要载入数据库文件，我们将载入
    public function __construct(){
        //1、载入数据库文件
        //2、添加愿望需要用到数据库，所以要先载入数据库文件
        $this->data = include './data/data.php';
    }

    public function index(){

        //1、检测是否为post提交
        //2、添加愿望、将数据存到数据库中都是在点击了提交按钮之后（post提交）进行的，如果没有点击，就不需要进行之后的添加和将数据写入数据库等操作
        if (IS_POST) {
            //1、判断是否登录
            //2、用户需要登录才能添加愿望，如果没有登录，就不能添加愿望，防止大量无意义的数据写入数据库
            if (!isset($_SESSION['user']['username'])){
                //1、提示信息、跳转登录页面
                //2、让用户知道为什么不能添加愿望，然后跳转到登录页面，交互性更强
                go('亲，您需要登录才能许愿哦','./?s=member/login');
            }else {
                //1、获得session中的userName值
                //2、需要将userName值存入数据库中，用来显示在页面中。如果不存的话，以后不管是谁登陆那么之前的用户名都会是当前登陆的
                $_POST['user'] = $_SESSION['user']['username'];
                //1、获得时间
                //2、需要在愿望页面中显示时间
                $_POST['time'] = date('Y-m-d H:i');
                //1、将数据追加到数组中
                //2、这里需要将数据写入数据库中，先追加到数组中，然后再将数组写入数据库中
                $this->data[] = $_POST;
                //1、将数据写入数据库中
                //2、我们需要保存数据，那么通过将数据写入到文件中，之后如果用到，直接从数据库中取得
                dataToFile('./data/data.php', $this->data);
                //1、定义一个定界符字符串，存放返回值
                //2、ajax操作之后，需要在页面中显示数据库中的信息，通过定界符组合页面中的布局和输出信息
                $str = <<<str
            <div class="msg" style="background: #FFFFFF">
                    <span class="user" style="color: #09b3e2">{$_SESSION['user']['username']}许愿说：</span>
                    <div class="content">{$_POST['wishing']}</div>
                    <p class="time">许愿时间：    <span>{$_POST['time']}</span></p>
            </div>
str;
                //1、输出$str
                //2、需要将字符串输出，这样在异步操作时候才能获得返回值
                echo $str;
                //1、阻止之后的代码运行
                //2、如果不阻止，就会二次载入模板，出现两个页面重合的现象
                exit;
            }
        }
        //1、载入模板
        //2、需要先载入模板，才能在页面中的添加愿望
        $this->view($this->data);
    }
}