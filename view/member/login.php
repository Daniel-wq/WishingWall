<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册用户</title>
    <link rel="stylesheet" href="./resource/css/index.css">
    <link rel="stylesheet" href="./resource/bt/css/bootstrap.min.css">
    <script src="./resource/js/jquery.min.js"></script>
    <!--    <script src="./resource/js/check.js"></script>-->
</head>

<script type="text/javascript">
    $(function () {
        $('input[name=username]').blur(function () {
            //获得当前输入的用户名
            var username = $(this).val();
            //异步处理
            $.ajax({
                //请求地址
                url: '?s=member/checkUserName',
                //请求方式
                type:'post',
                //发送数据
                data:{u:username},
                //成功返回的操作
                success:function (phpData) {
                    if(phpData==0){
                        //设置提示信息
                        $('#userMsg').html('<span style="color: red">用户名已存在</span>');
                        //如果用户名存在注册，按钮就不能点击
                        $('button[type=submit]').attr('disabled',true);
                    }else {
                        $('#userMsg').html('<span style="color: green">用户名可用</span>');
                        $('button[type=submit]').attr('disabled',false);
                    }
                }
            })
        })

        //注册页面检测验证码
        $('input[name=code]').blur(function () {
            var code = $(this).val();
            $.ajax({
                //请求地址
                url:'?s=member/checkCode',
                //请求方式：
                type:'post',
                //发送数据
                data:{c:code},
                //成功返回的操作
                success:function (phpData) {
                    if(phpData==0){
                        //设置提示信息
                        $("#userCode").html('<span style="color: red">验证码错误</span>');
                        //如果验证码不对       按钮不能点击
                        $('button[type=submit]').attr('disabled',true);
                    }else{
                        $('#userCode').html('<span style="color: green">验证码正确</span>');
                        $('button[type=submit]').attr('disabled',false);
                    }
                }

            })
        })

    })
</script>



</head>
<body>
<div class="container" style="width: 500px;margin-top: 50px">
    <div class="alert alert-info" role="alert">用户登陆</div>
    <form action="" method="post">
        <div class="form-group">

            <input type="text" class="form-control"  placeholder="请输入用户名" name="username">
            <span class="help-block" id="userMsg">

    </span>
        </div>
        <div class="form-group">

            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="请输入密码" name="password">
            <span class="help-block" id="pwdMsg">

    </span>
        </div>
        <div class="form-group">

            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="确认密码" name="repassword">
            <span class="help-block" id="repwdMsg">

            </span>
        </div>
        <div class="form-group">

            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="验证码" name="code">
            <span class="help-block" >
    	<span style="color: red" id="userCode">

        </span>

    </span>
        </div>
        <div class="form-group">
            <img src="?s=member/code" style="width: 100px;height: 40px;border: 1px solid #c0c0c0;margin-left: 10px;border-radius: 5px" onclick="javascript:this.src='?s=member/code&tm='+Math.random()">
        </div>

        <div>
        <input style="width: 20px;line-height: 15px;" type="checkbox" name="remember" id="">记住我，七天内免登陆
        </div>
        <button type="submit" class="btn btn-primary ">登陆</button>
        <a href="?s=member/reg" type="submit" class="btn btn-primary ">去注册</a>
    </form>
</div>

</body>
</html>