<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>许愿墙</title>
    <link rel="stylesheet" href="./resource/css/index.css">
    <link rel="stylesheet" href="./resource/bt/css/bootstrap.min.css">
    <script src="./resource/js/jquery.min.js"></script>
    <style>
        body{
            background: url("./resource/images/bg.jpg");
            size: 100% 2000px;
            font-size: 16px;
        }
        #wish{
            width: 1200px;
            margin: 0px auto;
            background: rgba(255,255,255,0.5);
            overflow: hidden;
            padding: 20px;
        }
        .header{
            width:1100px;
            height: 60px;
            margin: 0px auto;
            line-height:60px;
            text-align: center;
        }
        #wish .show{
            width: 850px;
            min-height: 600px;
            border-right: 2px solid #FFFFFF;
            float: left;
        }
        #wish .add{
            width: 300px;
            height: 400px;
            float: right;
        }
        #wish .add p{
            line-height: 30px;
            margin-top: 10px;
            padding-left: 20px;
        }
        #wish .add p .name{
            color: #FF0000;
        }
        .show .msg{
            width: 180px;
            margin-left: 15px;
            margin-top: 15px;
            border-radius: 10px;
            float: left;
            padding: 5px;
            color: #333;
            background: #FFFFFF;
        }
        .show .msg .user{
            font-size: 16px;
            font-weight: 700;
            color: #09b3e2;
        }
        .show .msg .content{
            font-size: 14px;
            min-height: 60px;
            text-indent: 2em;
        }
        .show .msg .time{
            font-size: 12px;
            color: #3c3c3c;
            text-align: center;
            margin: 0px;
        }
    </style>
    <script>
        $(function () {
            //1、给表单绑定按钮提交事件
            //2、添加愿望是在点击了按钮之后才进行的，要实现异步操作，需要绑定事件
            $('form').submit(function () {
                //1、一次性抓取form中的所有表单的数据
                //2、表单中的数据不止一条，通过serialize获得一组序列化之后的数据
                var data = $(this).serialize();
                //1、异步请求
                //2、通过一部请求能够实现不刷新页面就能完成添加功能
                $.ajax({
                    url: '?s=wish/index',
                    type: 'post',
                    data: data,
                    success: function (phpData) {
                        $('.show').append(phpData);
                    }
                });
                //1、重置表单
                //2、
                $(this)[0].reset();
                //1、阻止提交，
                //2、因为提交就要刷新页面的，异步是不刷新页面的
                return false;
            });
        })
    </script>
</head>
<body>
    <div id="wish">
        <div class="header">
            <h2 class="text-center">许愿墙</h2>

        </div>
        <div class="show">
            <!--许愿标签-->
            <?php foreach ($data as $k=>$v):  ?>
            <div class="msg">
                    <span class="user" style="color: rgba(<?php echo mt_rand(0,255) ?>,<?php echo mt_rand(0,255) ?>,<?php echo mt_rand(0,255) ?>,1);"><?php echo $v['user']; ?>许愿说：</span>
                    <div class="content"><?php echo $v['wishing']; ?></div>
                    <p class="time" style="color: #333;">Time：<span><?php echo $v['time']; ?></span></p>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="add">
            <?php if(isset($_SESSION['user']['userame'])){ ?>
                <p>欢迎<span class="name"><?php echo $_SESSION['user']['username']; ?></span><a href="?s=member/quit">退出</a></p>
            <?php }else{ ?>
                <p>我要<a href="?s=member/login">登录</a>许愿</p>
            <?php } ?>
            <form action="" method="post">
                <p>快来写下自己的愿望吧：</p>
                <div style="width: 260px;margin: 0px auto">
                    <textarea class="form-control" rows="5" cols="2" name="wishing"></textarea>
                </div>
                <div style="margin: 20px;text-align: center">
                    <button type="submit" class="btn btn-info btn-lauge" id="xuyuan">许下愿望</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>