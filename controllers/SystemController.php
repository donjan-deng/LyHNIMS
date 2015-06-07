<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use \yii\helpers\Url;
/**
 * 系统管理控制器，用于后续升级和进行特殊管理。
 *
 * @author 搬砖工
 * @since 1.0
 */
class SystemController extends Controller {

    public function beforeAction($action) {
        $user = Yii::$app->user;
        if (!$user->isGuest && $user->identity->username == Yii::$app->params['SuperAdmin']) {
            return true;
        } else {
            echo '只有超级管理员能进行此项操作';
            return false;
        }
    }

    public function actionIndex() {
       
    }

    private function insertPermission() {
        $auth = Yii::$app->authManager;
        /*$auth->removeAll();
        
        $p = $auth->createPermission('Record'); //大写开头没有实际链接，为controller name
        $p->description = '患者管理';
        $auth->add($p);

        $p = $auth->createPermission('record/index');
        $p->description = '对话管理';
        $auth->add($p);
        
        $p = $auth->createPermission('record/create');
        $p->description = '添加对话';
        $auth->add($p);
        
        $p = $auth->createPermission('record/edit');
        $p->description = '编辑对话';
        $auth->add($p);
        
        $p = $auth->createPermission('record/del');
        $p->description = '删除对话';
        $auth->add($p);
        
        $p = $auth->createPermission('record/list');
        $p->description = '查看对话';
        $auth->add($p);

        $p = $auth->createPermission('record/appointment');
        $p->description = '预约管理';
        $auth->add($p);

        $p = $auth->createPermission('record/appointmentlist');
        $p->description = '查看预约';
        $auth->add($p);

        $p = $auth->createPermission('record/allocate');
        $p->description = '分诊';
        $auth->add($p);

        $p = $auth->createPermission('Channel');
        $p->description = '渠道管理';
        $auth->add($p);

        $p = $auth->createPermission('channel/index');
        $p->description = '渠道管理';
        $auth->add($p);

        $p = $auth->createPermission('channel/list');
        $p->description = '查看渠道';
        $auth->add($p);

        $p = $auth->createPermission('channel/create');
        $p->description = '添加渠道';
        $auth->add($p);

        $p = $auth->createPermission('channel/edit');
        $p->description = '编辑渠道';
        $auth->add($p);

        $p = $auth->createPermission('channel/del');
        $p->description = '删除渠道';
        $auth->add($p);

        $p = $auth->createPermission('channel/cost');
        $p->description = '渠道消费管理';
        $auth->add($p);

        $p = $auth->createPermission('channel/costlist');
        $p->description = '查看渠道消费';
        $auth->add($p);

        $p = $auth->createPermission('channel/costcreate');
        $p->description = '添加渠道消费';
        $auth->add($p);

        $p = $auth->createPermission('channel/costedit');
        $p->description = '编辑渠道消费';
        $auth->add($p);

        $p = $auth->createPermission('channel/costdel');
        $p->description = '删除渠道消费';
        $auth->add($p);

        $p = $auth->createPermission('department/index');
        $p->description = '科室管理';
        $auth->add($p);

        $p = $auth->createPermission('department/list');
        $p->description = '查看科室';
        $auth->add($p);

        $p = $auth->createPermission('department/create');
        $p->description = '添加科室';
        $auth->add($p);

        $p = $auth->createPermission('department/edit');
        $p->description = '编辑科室';
        $auth->add($p);

        $p = $auth->createPermission('department/del');
        $p->description = '删除科室';
        $auth->add($p);

        $p = $auth->createPermission('department/merge');
        $p->description = '合并科室';
        $auth->add($p);

        $p = $auth->createPermission('doctor/index');
        $p->description = '医生管理';
        $auth->add($p);

        $p = $auth->createPermission('doctor/list');
        $p->description = '查看医生';
        $auth->add($p);

        $p = $auth->createPermission('doctor/create');
        $p->description = '添加医生';
        $auth->add($p);

        $p = $auth->createPermission('doctor/edit');
        $p->description = '编辑医生';
        $auth->add($p);

        $p = $auth->createPermission('doctor/del');
        $p->description = '删除医生';
        $auth->add($p);

        $p = $auth->createPermission('Report');
        $p->description = '统计报表';
        $auth->add($p);

        $p = $auth->createPermission('report/channel');
        $p->description = '渠道报表';
        $auth->add($p);

        $p = $auth->createPermission('report/channelreport');
        $p->description = '查看渠道报表';
        $auth->add($p);

        $p = $auth->createPermission('report/user');
        $p->description = '用户报表';
        $auth->add($p);

        $p = $auth->createPermission('report/userreport');
        $p->description = '查看用户报表';
        $auth->add($p);

        $p = $auth->createPermission('User');
        $p->description = '权限管理';
        $auth->add($p);
        
        $p = $auth->createPermission('user/index');
        $p->description = '用户管理';
        $auth->add($p);
        
        $p = $auth->createPermission('user/list');
        $p->description = '查看用户';
        $auth->add($p);
        
        $p = $auth->createPermission('user/create');
        $p->description = '添加用户';
        $auth->add($p);
        
        $p = $auth->createPermission('user/edit');
        $p->description = '编辑用户';
        $auth->add($p);
        
        $p = $auth->createPermission('user/del');
        $p->description = '删除用户';
        $auth->add($p);
        
        $p = $auth->createPermission('user/role');
        $p->description = '角色管理';
        $auth->add($p);
        
        $p = $auth->createPermission('user/rolelist');
        $p->description = '查看角色';
        $auth->add($p);
        
        $p = $auth->createPermission('user/rolecreate');
        $p->description = '添加角色';
        $auth->add($p);
        
        $p = $auth->createPermission('user/roleedit');
        $p->description = '编辑角色';
        $auth->add($p);
        
        $p = $auth->createPermission('user/roledel');
        $p->description = '删除角色';
        $auth->add($p);*/
    }

    private function writeConfig($key, $value) {
        $contents = file_get_contents('version.php');
        $contents = str_replace($this->loadConfig($key), $value, $contents);
        file_put_contents('version.php', $contents);
    }

    private function loadConfig($key) {
        $Config = require('version.php');
        return $Config[$key];
    }

}
