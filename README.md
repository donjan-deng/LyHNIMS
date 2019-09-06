关于本代码
================================

    本代码为以前学习Yii2框架时开发的一套医疗网络部信息管理系统，适合初学者入门学习。

    包含功能：对话管理、预约到院管理、科室管理、医生管理、渠道管理、效果报表、权限管理。

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
