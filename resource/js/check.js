
$(function () {
    //注册页面检测用户名
    function dis() {
        $('button[name=reg]').attr('disabled', true);
    }
    function able() {
        $('button[name=reg]').attr('disabled', false);
    }
    dis();
    $('input[name=userName]').blur(function () {

        //获得当前用户名
        var userName = $(this).val();
        var len = userName.length;
        if (len<4||userName==''){
            $('#userMsg').html('<span style="color:red;">用户名不得少于4位</span>');
        }else{
            //alert(uname);
            $.ajax({
                url: '?s=member/checkUserName',
                type: 'post',
                data: {u: userName},
                success: function (phpData) {
                    if (phpData == 0) {
                        $('#userMsg').html('<span style="color:red;">用户名已存在</span>');
                    } else if (phpData == 1) {
                        $('#userMsg').html('<span style="color:#209fdc;">用户名可用</span>');
                    }
                }
            })
        }

    });//input:name=userName
    $('input[name=userName]').focus(function () {
        $('#userMsg').html('<span style="color:red;">*</span>');
    });//input:name=userName
    //注册页面检测用户名结束


    //注册页面检测密码和重复密码
    $('input[name=pwd]').blur(function () {
        var pwdReg = /[0-9A-Za-z_!]{6,16}/;//8到16位数字与字母组合
        var pwd = $(this).val();
        if(!pwdReg.test(pwd)){
            $('#pwdMsg').html('<span style="color:red;">密码必须是6-16位</span>');
        }else{
            $('#pwdMsg').html('<span style="color:#209fdc;">√</span>');
        }
    });
    //重复密码检测
    $('input[name=repwd]').blur(function () {
        if($(this).val()!=$('input[name=pwd]').val()){
            $('#repwdMsg').html('<span style="color:red;">两次密码不一致</span>');
        }else if($(this).val()==''){
            $('#repwdMsg').html('<span style="color:red;">请再次输入密码</span>');
        }else {
            $('#repwdMsg').html('<span style="color:#209fdc;">√</span>');
        }
    });
    //检测密码和重复密码结束

    //注册页面检测验证码
    $('input[name=code]').blur(function () {
        //获得用户输入的code验证码
        var code = $(this).val();
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