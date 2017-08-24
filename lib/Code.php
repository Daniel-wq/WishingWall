<?php

/**
 * Class Code
 * 1、验证码类
 * 2、将来有很多场景需要用到验证码，如果每次需要都自己写的话很麻烦，在这里我们将它封装成一个类，在哪里用到，就只需要调用就可以了
 */
class Code{
    //1、定义一个私有属性$img
    //2、下面的很多方法啊都需要用到，这里定义成私有属性，在构造方法中调用调用复制之后，不管下面哪里用到直接调用就可以了
    private $img;
    //1、定义一个宽度属性，
    //2、用来指定画布的宽，这样我们只需要改变这个宽度，就可以创建出不同宽度的画布
    private $width;
    //1、定义一个高度属性，
    //2、用来指定画布的宽，这样我们只需要改变这个高度，结合宽度就可以创建出不同宽高的画布
    private $height;
    //1、定义文本字体大小
    //2、用来指定文本字体大小，之后我们可以通过传参来改变这个值，适用于更多场景
    private $size;
    //1、定义画布背景颜色
    //2、之后调用使用，还可以传参给定颜色，这样使验证码的适用性更高
    private $bgColor;


    //1、显示验证码的方法
    //2、因为外部需要一个方法来调用显示验证码，这里用的是共用的方法
    public function showCode($width=200,$height=80,$size=50,$bgColor='#FFFFFF'){
        //1、将参数赋值给属性
        //2、这里通过传参指定画布的宽高、文本字体大小，让验证码适用于更多的场景
        $this->width = $width;      //画布宽度
        $this->height = $height;    //画布高度
        $this->size = $size;        //字体大小
        $this->bgColor = $bgColor;  //画布背景颜色

        //1、发送头部信息，
        //2、表名为当前文件问图像格式的文件，让浏览器按照图片文件格式解析
        header("Content-type:image/png");
        //1、创建画布并且填充
        //2、这里调用cteateBg私有方法，我们需要先创建画布，才能在进行绘画
        $this->createBg();
        //1、调用写文字方法
        //2、调用私有方法，执行里面的代码，产生不同的字符，在画布中显示字符形成验证码的文本
        $this->write();
        //1、调用制造干扰方法
        //2、如果验证码太清晰了那么很容易被机器识别，就会向我们的数据库灌入大量的无用的数据
        $this->makeTrouble();
        //1、调用输出图像并销毁方法
        //2、调用之后，释放图形资源，防止图像占用更多资源，为后面的代码腾出更多空间和资源
        $this->showDestory();
    }

    //1、创建画布的方法
    //2、这里用私有方法申明一个创建画布的方法，来进行创建画布，只有先创建画布才能在画布上绘画
    private function createBg(){
        //1、创建画布
        //2、创建画布之后我们才才能进行绘画，才能在画布上写字
        $this->img = imagecreatetruecolor($this->width,$this->height);

        //1、设置颜色
        //2、填充画布需要设置颜色
        //$bgColor = imageColorAllocate($this->img,240,240,240);
        $bgColor = hexdec($this->bgColor);

        //1、填充画布
        //2、默认画布是没有颜色的，我们需要给画布填充颜色，这样我们才能绘画不同背景的验证码
        imageFill($this->img,0,0,$bgColor);
	}

    //1、写文本字符的方法
    //2、这里通过私有方法申明一个书写字符的方法，单独来进行书写文本字符
	private function write(){
        //1、设置字体大小
        //2、创建文字需要用到文字大小，通过改变字体字体大小可以创建不同大小的验证码
        $size = $this->size;
        //1、调用画布高度
        //2、之后需要用到高度结合字体大小来计算字的垂直方向的位置，
        $w = $this->width;

        //1、调用画布宽度
        //2、需要用到宽度来分配每一个字符所占的宽度
        $h = $this->height;

        //1、文字文字x轴位置
        //2、这里将文字水平平均分成多份，我们需要保证字能够平均的显示在画布中
        $x = $w/4;
        //1、文本在画布中的垂直位置
        //2、设置文本垂直居中，让文本始终显示在画布中间
        $y = ($h+$size)/2;
        //1、定义一个验证码文本字符串
        //2、我们之后我们通过从字符串中随机取出字符来实现显示文本，这样就变得比较灵活，而不需要我们自己一个一个的修改
        $codes = 'qwertyuioasdfghjklzxcvbnm123456789QWERTYUIOPASDFGHJKLZXCVBNM';

        //1、定义一个变量
        //2、用来存储获得的随机字符
        $codeStr='';
        //1、循环显示字
        //2、这里设置里多个字，需要通过循环来输出显示
        for ($i=0;$i<4;$i++){
            //1、随机角度
            //2、让字的旋转方向各不相同，如果太整齐，很容易被机器识别，就会向数据库中灌入大量无用数据
            $rang = mt_rand(-30,30);
            //1、随机产生字符
            //2、每一个验证码中的字符一般是各不相同的，所以通过随机产生不同的字符
            $text = $codes[mt_rand(0,strlen($codes)-1)];

            //1、将获得的随机字符存储
            //2、之后在页面中需要用来进行比对，如果成功就允许登录
            $codeStr.=$text;

            //1、随机颜色
            //2、字符颜色一般也会各不相同，所以也可以通过随机来指定字符颜色
            $color = imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));

            //1、在画布上写字
            //2、验证码有字母、数字、文字等，需要创建文字图像
            imageTtfText($this->img,$size,$rang,$x*$i+8,$y,$color,'corbelz.ttf',$text);
        }
        //1、将验证码字符串保存到session中
        //2、我们登录时需要进行验证码校验，到时候直接通过session就能获得验证码
        $_SESSION['code'] = strtolower($codeStr);
        //p($_SESSION);
     }

    //1、制造干扰的方法
    //2、申明一个制造干扰的方法，如果验证码太清晰，就很容易被机器识别，向数据库中写入大量无用数据
    private function makeTrouble(){
        //1、循环设置干扰圆
        //2、如果验证码太清晰，很容被机器批量注册，向数据库中写入大量数据
        for ($i=0;$i<10;$i++){
            //1、随机圆心的位置
            //2、这样就会产生不同位置的圆，结合下面的圆的宽高，就会产生不同位置的圆，起到干扰的作用
            $cx = mt_rand(0,$this->width);   //圆心x轴坐标，不能超过画布宽度
            $cy = mt_rand(0,$this->height);    //圆心y轴坐标，不能超过画布高度
            //1、圆的宽高
            //2、因为是个正圆，宽高都是一样的，所以这里定义的$cw，就是圆的宽高
            $cw  =mt_rand(0,30);
            //1、随机颜色
            //2、随机产生不同颜色，使得验证码颜色更加丰富，同时也不容易被机器识别
            $color = imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            imageellipse($this->img, $cx, $cy, $cw, $cw, $color);
        }
        //1、设置线条随机颜色
        //2、线条需要颜色，通过随机颜色，就可以绘画出不同颜色的线条
        $lineColor = imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));

        //1、设置干扰线
        //2、使得验证码，不容易被机器识别，提高安全性，防止机器向数据库中灌入大量的无用数据
        imageline($this->img,0,mt_rand(0,$this->height),$this->width,mt_rand(0,$this->height),$lineColor);
    }

    //1、输出、释放资源的方法
    //2、将输出图像和释放资源放到一个方法中，只需要调用这个方法就能实现显示图像和释放资源
    private function showDestory(){
        //1、输出图像
        //2、需要输出图像，只有输出图像，我们才可以在页面中看到最终出现的结果
        imagepng($this->img);

        //1、释放资源
        //2、防止图像占用更多资源，释放之后，为后面的代码腾出空间和资源
        imagedestroy($this->img);
    }
}


//1、实例化调用方法
//2、需要先实例化，然后调用方法，这样才能执行里面的方法，不管哪里场景用到，只需引入类文件调用即可实现验证码
/**
 * Code class
 * 使用示例：
 * $width    画布宽度
 * $height   画布高度
 * $size     文本字体大小
 * $bgColor  画布背景颜色
 * $obj = new Code($width,$height,$size,$bgColor);
 *
 * 方法一：
 * $obj = new Code(180,70,30,'#E0E0E0');
 * $obj->showCode();
 *
 * 方法二：
 * (new Code())->showCode(180,70,30,'#E0E0E0');
 */
//(new Code())->showCode(100,35,24,'#FFFFFF');