领域医院网络信息管理系统
================================

    领域医院网络信息管理系统是基于Yii2框架开发的一套医疗网络部信息管理系统。

    包含功能：对话管理、预约到院管理、科室管理、医生管理、渠道管理、效果报表、权限管理。

    当前版本1.0 Beta，下一步开发计划，实现自主预约接口、添加扩展中心方便自主开发插件在系统中使用。

    QQ交流群：303971117 
    演示地址：http://hnims.lyapp.com  账号:admin 密码:admin

运行环境
-------------------

php5.4以上、Mysql 5

安装说明
------------

#####数据库

`将data目录里的数据库文件导入Mysql` 编辑 `config/db.php` 里的数据库连接选项

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```
#####程序配置

打开`config/params.php`编辑医院名称和超级管理员

打开`web/index.php`修改

```php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
```
为
```php
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');
```

#####访问

有条件的直接将web目录设置为站点根目录直接访问，设置不了的通过`http://your url/web/`访问，默认管理员账户/密码：admin/admin。

BUG与建议
-------------

#####提问前

遇到问题时，心里都很着急。提问前请尝试从官方文档查找答案，搜索引擎也会是您的好朋友，也许别人已经提过你可以在[这里](https://github.com/tangjiandeng/LyHNIMS/issues) 找到你需要的答案。

#####提问时

如果还是没有解决，请尽可能的使用明确、有意义的标题，尽可能补充详细信息。[点这里提交](https://github.com/tangjiandeng/LyHNIMS/issues/new)

#####提问后

提交问题后，不要期待作者马上回复，建议通过邮件等方式订阅回复。切忌不要直接联系工作室的客服，因为他们的工作不是处理这些事情的。

版权说明
-------------

官方网站：http://www.lyapp.com

该源码仅供个人学习研究等非商业用途使用，企业、公司、政府、组织必须购买授权方能用于商业用途。