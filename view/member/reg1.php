<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册用户</title>
    <link rel="stylesheet" href="./resource/css/index.css">
    <link rel="stylesheet" href="./resource/bt/css/bootstrap.min.css">
    <script src="./resource/js/jquery.min.js"></script>
    <script src="./resource/js/check.js"></script>
</head>
<body>
<div class="box">
    <h3 style="text-align: center;margin-bottom: 10px">注册</h3>
    <form class="form-inline" action="" method="post">
        <table width="460">
            <!--用户名-->
            <tr>
                <td class="left" width="80"><label for="">用户名</label></td>
                <td class="center" width="200"><input type="text" class="form-control" name="userName" placeholder="用户名"></td>
                <td width="100"><span id="userMsg" style="color: #FF0000;">*</span></td>
            </tr>
            <!--密码-->
            <tr>
                <td class="left"><label for="">密码</label></td>
                <td class="center"><input type="password" maxlength="18" class="form-control" name="pwd" placeholder="密码"></td>
                <td><span id="pwdMsg">*</span></td>
            </tr>
            <!--重复密码-->
            <tr>
                <td class="left"><label for="">重复密码</label></td>
                <td class="center"><input type="password" maxlength="18" class="form-control" name="repwd" placeholder="重复密码"></td>
                <td><span id="repwdMsg">*</span></td>
            </tr>
            <!--验证码-->
            <tr>
                <td class="left"><label for="">验证码</label></td>
                <td style="padding-left: 12px;">
                    <input type="text" style="width: 100px;" maxlength="4" class="form-control" name="code" placeholder="验证码">
                    <img src="?s=member/code" style="width: 100px;height: 40px;border: 1px solid #c0c0c0;margin-left: 10px;border-radius: 5px" onclick="javascript:this.src='?s=member/code&tm='+Math.random()">
                </td>
                <td><span id="codeMsg" style="color: #FF0000;">验证码不区分大小写</span></td>
            </tr>
        </table>
        <div style="margin-top: 25px;overflow: hidden;padding-left: 50px">
            <div class="col-sm-6">
                <button name="reg" class="btn btn-info">注册账号</button>
            </div>
            <div class="col-sm-6">
                <button name="reset" type="reset" class="btn btn-warning">重新填写</button>
            </div>

        </div>
    </form>
    <!--底部提示性文字-->
    <p style="text-align: center;color: #303030;margin-top: 20px">如已有账号，可以<a href="?s=member/login" style="color: #FF3300">直接登录</a></p>
</div>
</body>
</html>