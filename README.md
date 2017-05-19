#signuppay

演示地址 http://signuppay.91ycc.com/

后台由于涉及到支付接口信息，就不给出账号密码了

请自行安装后进入  http://域名/admin

账号 admin
密码 123456

如何安装
1.把域名绑定到根目录下的  public
2.修改 modules/database.php 文件写入数据库配置
3.导入signuppay.sql
4.public目录下 runtime和uploads给以权限

apache 需要开启重写模块
Nginx  请参考 http://document.thinkphp.cn/manual_3_2.html#url_rewrite

系统介绍
基于thinkphp5 rc4开发

只要功能
1.会员能创建报名活动
2.会员能参加活动
3.支付宝支付
4.微信扫码支付

包含的功能
1.图片管理器
2.auth权限管理
3.配置管理

模块化设计

功能比较简单，有需要请自行完善

QQ交流群号：161524330

交流网站 http://www.oscshop.cn

李梓钿 2016-07-13
