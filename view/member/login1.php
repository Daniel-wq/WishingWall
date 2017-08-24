<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" href="./resource/css/index.css">
    <link rel="stylesheet" href="./resource/bt/css/bootstrap.min.css">
    <script src="./resource/js/jquery.min.js"></script>
    <script>
        $(function () {
            //1、定义函数dis
            //2、主要功能实现阻止提交按钮的默认状态，之后的焦点事件需要多次用到，这里定义为函数，之后只需要调用就能实现功能
            function dis() {
                $('button[name=login]').attr('disabled', true);
            }
            //1、定义函数able
            //2、主要功能实现取消阻止提交按钮的默认状态，之后的焦点事件需要多次用到，只需要定义为函数，之后只需要调用就能实现功能
            function able() {
                $('button[name=login]').attr('disabled', false);
            }
            //1、给密码输入框绑定焦点事件
            //2、当失去焦点时，需要判断密码是否正确，在这里判断之后不需要刷新页面，不需要提交之后在进行判断
            $('input[name=pwd]').blur(function () {
                //1、获得用户输入的用户名
                //2、登录时候需要对用户名进行判断，判断用户名是否已注册
                var user = $('input[name=userName]').val();
                //1、获得用户输入的密码
                //2、需要判断密码是否输入正确，所以要获得用户数据输入的密码
                var pwd = $(this).val();
                //1、异步检测
                //2、这样做的话避免了页面刷新，用户体验更好，不需要提交之后再判断用户名和密码是否正确
                $.ajax({
                    //1、地址
                    //2、需要将数据提交给一个页面或者方法来处理
                    url:'?s=member/checkLoginUser',
                    //数据提交方式
                    type:'post',
                    //1、提交的数据
                    //2、需要将数据提交到给定的页面，才能处理
                    data:{u:user,p:pwd},
                    //1、成功之后的返回函数
                    //2、当数据处理成功之后需要获得一个反馈信息，然后对反馈回来的信息进一步处理
                    success: function (phpData) {
                        //1、返回1
                        //2、如果返回1，表示用户名和密码都输入正确，执行第一个田间成立的代码
                        if (phpData == 1) {
                            //1、改变提示框的信息
                            //2、这样给用户一个反馈信息，让用户知道哪里出错，界面交互更友好，更智能
                            $('#userMsg').html('<span style="color:#209fdc;">√</span>');
                            $('#pwdMsg').html('<span style="color:#209fdc;">√</span>');
                            //1、开放按钮
                            //2、用户输入正确之后就可注册了，开放按钮的默认状态
                            able();
                        } else if (phpData == 2) {
                            //1、当密码错误时，给用户提示信息
                            //2、这样给用户一个反馈信息，让用户知道哪里出错，界面交互更友好，更智能
                            $('#userMsg').html('<span style="color:#209fdc;">√</span>');
                            $('#pwdMsg').html('<span style="color:#FF0000;">密码错误</span>');
                            //1、阻止按钮的默认状态
                            //2、如果密码错误就不让用户登录，阻止按钮状态
                            dis();
                        }else{
                            $('#userMsg').html('<span style="color:#FF0000;">该用户名不存在</span>');
                            //1、阻止按钮的默认状态
                            //2、如果密码错误就不让用户登录，阻止按钮状态
                            dis();
                        }
                    }
                })
            });


            //1、校验验证码
            //2、需要校验验证码，才能让用户登录，如果不校验就会被机器识别，大量的向数据库中写入无意义的数据
            $('input[name=code]').blur(function () {
                //1、获得用户输入的code验证码
                //2、需要将用户输入的验证码与session中的验证码比对
                var code = $(this).val();
                //1、异步处理
                //2、这样做的话避免了页面刷新，用户体验更好，不需要提交之后再判断用户名和密码是否正确
                $.ajax({
                    url:'?s=member/checkCode',
                    type:'post',
                    data:{c:code},
                    success:function (phpCode) {
                        if(phpCode==1){
                            $('#codeMsg').html('<span style="color:#209fdc;">√</span>');
                            able();
                        }else{
                            $('#codeMsg').html('<span style="color:#FF0000;">验证码错误</span>');
                            dis();
                        }
                    }
                })
            });

        });
    </script>
    <style>
        p{
            text-align: center;
            color: #FFFFFF;
        }
    </style>
</head>
<body>
    <div class="box">
    <h3 style="text-align: center;margin-bottom: 10px">登录</h3>
    <form class="form-inline" action="" method="post">
        <table width="460">
            <!--用户名-->
            <tr>
                <td class="left" width="80"><label for="">用户名</label></td>
                <td class="center" width="200"><input type="text" class="form-control" name="userName" placeholder="用户名"></td>
                <td width="100"><span id="userMsg">*</span></td>
            </tr>
            <!--密码-->
            <tr>
                <td class="left"><label for="">密码</label></td>
                <td class="center"><input type="password" maxlength="18" class="form-control" name="pwd" placeholder="密码"></td>
                <td><span id="pwdMsg">*</span></td>
            </tr>
            <!--验证码-->
            <tr>
                <td class="left"><label for="">验证码</label></td>
                <td style="padding-left: 12px;">
                    <input type="text" style="width: 100px;" maxlength="4" class="form-control" name="code" placeholder="验证码">
                    <img src="?s=member/code" style="width: 100px;height: 40px;border: 1px solid #c0c0c0;margin-left: 10px;border-radius: 5px" onclick="javascript:this.src='?s=member/code&-tm='+Math.random()">
                </td>
                <td><span id="codeMsg">*</span></td>
            </tr>
            <!--免登陆-->
            <tr>
                <td colspan="3" class="center" ><input style="width: 20px;line-height: 15px;" type="checkbox" name="remember" id="">记住我，七天内免登陆</td>
            </tr>
        </table>
            <!--登录按钮-->
            <div style="margin: 10px auto;text-align: center">
                <button type="submit" class="btn btn-info" style="width: 100px;" name="login">登录</button>
            </div>

    </form>
    <p style="text-align: center;color: #333;margin-top: 20px">如没有账号，点击这里<a href="?s=member/reg" style="color: #FF3300">注册账号</a></p>
</div>
</body>
</html>