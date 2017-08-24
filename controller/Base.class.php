<?php

/**
 * 1、构建一个公共父类
 * 2、member控制器和wish控制器能够继承使用这个类，完成模版载入，这样就不需要每次都用include载入模版了
 * Class Base
 */
abstract class Base{
    //1、构建view方法
    //2、member和wish控制器调用该方法完成模版载入，这里传入的参数是数据库的值，这样载入模板之后才能使用数据库文件
    public function view($data=[]){
        //1、组合模板路径并载入
        //2、通过首页的常量CONTROLLER和ACTION来组合路径，这样的话只要有这种路径的模板，通过调用就会直接载入
        include './view/' . CONTROLLER . '/' . ACTION .'.php';
    }
}