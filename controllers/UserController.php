<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use app\models\UserForm;
use app\models\RoleForm;
use app\models\Record;
/**
 * 用户管理控制器。
 *
 * @author 搬砖工
 * @since 1.0
 */
class UserController extends CommonController {

    public function actionIndex() {
        $auth = Yii::$app->authManager;
        $listRoles = ArrayHelper::getColumn($auth->getRoles(), 'name');
        return $this->render('index', ['model' => new UserForm(), 'listRoles' => $listRoles]);
    }

    public function actionEdit() {
        $auth = Yii::$app->authManager;
        $data = Yii::$app->request->post('UserForm');
        $result = array();
        $oldPassword; //更改用户时如果不改密码，保存旧密码
        if (is_numeric($data['id']) && $data['id'] > 0) {
            $user = UserForm::findOne($data['id']);
            if (!$user) {
                $result['status'] = 0;
                $result['message'] = '未找到该记录';
            } else {
                $oldPassword = $user->password;
            }
        } else {
            $user = new UserForm();
        }
        if ($user->load(Yii::$app->request->post())) {
            if (!$user->isNewRecord && $user->password != '******') {
                $oldPassword = Yii::$app->security->generatePasswordHash($user->password);
            }
            if ($user->save()) {
                if(isset($oldPassword)){
                    //重置密码
                    UserForm::updateAll(['password'=>$oldPassword], 'id=:id', [':id'=>$user->id]);
                }
                //分配权限
                $auth->revokeAll($user->id); //删除所有权限
                foreach ($user->roles as $rolename) {
                    if ($role = $auth->getRole($rolename)) {
                        $auth->assign($role, $user->id);
                    }
                }
                $result['status'] = 1;
                $result['message'] = '保存成功';
            }
        }
        $errors = $user->getFirstErrors();
        if ($errors) {
            $result['status'] = 0;
            $result['message'] = current($errors);
        }
        return $this->renderJson($result);
    }

    public function actionList() {
        $auth = Yii::$app->authManager;
        $model = UserForm::find()->all();
        return $this->renderPartial('list', ['model' => $model]);
    }

    public function actionDel($id) {
        $result = array();
        $model = UserForm::findOne($id);
        if (Record::find()->where('user_id=' . $id . '')->exists()) {
            $model->enabled = 0;
            $model->update();
            $result['status'] = 1;
            $result['message'] = '该用户已关联数据，不能删除，已经禁用！';
        } else {
            $model->delete();
            $result['status'] = 1;
            $result['message'] = '删除成功';
        }
        return $this->renderJson($result);
    }

    public function actionRole() {
        $auth = Yii::$app->authManager;
        $permissions = [
            ['name' => 'Record', 'description' => '患者管理', 'child' => [
                    ['name' => 'record/appointment', 'description' => '预约管理', 'child' => [
                            ['name' => 'record/appointmentlist', 'description' => '查看预约'],
                            ['name' => 'record/allocate', 'description' => '分诊'],
                        ]],
                    ['name' => 'record/index', 'description' => '对话管理', 'child' => [
                            ['name' => 'record/list', 'description' => '查看对话'],
                            //['name'=>'record/create','description'=>'添加对话'],
                            ['name' => 'record/edit', 'description' => '添加/编辑对话'],
                            ['name' => 'record/del', 'description' => '删除对话'],
                        ]]
                ]],
            ['name' => 'Channel', 'description' => '渠道管理', 'child' => [
                    ['name' => 'channel/cost', 'description' => '渠道消费管理', 'child' => [
                            ['name' => 'channel/costlist', 'description' => '查看渠道消费'],
                            //['name'=>'channel/costcreate','description'=>'添加渠道消费'],
                            ['name' => 'channel/costedit', 'description' => '添加/编辑渠道消费'],
                            ['name' => 'channel/costdel', 'description' => '删除渠道消费'],
                            
                        ]],
                    ['name' => 'channel/index', 'description' => '渠道管理', 'child' => [
                            ['name' => 'channel/list', 'description' => '查看渠道'],
                            //['name'=>'channel/create','description'=>'添加渠道'],
                            ['name' => 'channel/edit', 'description' => '添加编辑渠道'],
                            ['name' => 'channel/del', 'description' => '删除渠道'],
                        ]]
                ]],
            ['name' => 'department/index', 'description' => '科室管理', 'child' => [
                    ['name' => 'department/list', 'description' => '查看科室'],
                    //['name'=>'department/create','description'=>'添加科室'],
                    ['name' => 'department/edit', 'description' => '添加/编辑科室'],
                    ['name' => 'department/del', 'description' => '删除科室'],
                    ['name' => 'department/merge', 'description' => '合并科室'],
                ]],
            ['name' => 'doctor/index', 'description' => '医生管理', 'child' => [
                    ['name' => 'doctor/list', 'description' => '查看医生'],
                    //['name'=>'doctor/create','description'=>'添加医生'],
                    ['name' => 'doctor/edit', 'description' => '添加/编辑医生'],
                    ['name' => 'doctor/del', 'description' => '删除医生'],
                ]],
            ['name' => 'Report', 'description' => '统计报表', 'child' => [
                    ['name' => 'report/channel', 'description' => '渠道报表', 'child' => [
                            ['name' => 'report/channelreport', 'description' => '查看渠道报表'],
                        ]],
                    ['name' => 'report/user', 'description' => '用户报表', 'child' => [
                            ['name' => 'report/userreport', 'description' => '查看用户报表'],
                        ]]
                ]],
            ['name' => 'User', 'description' => '权限管理', 'child' => [
                    ['name' => 'user/index', 'description' => '用户管理', 'child' => [
                            ['name' => 'user/list', 'description' => '查看用户'],
                            //['name'=>'user/create','description'=>'添加用户'],
                            ['name' => 'user/edit', 'description' => '添加/编辑用户'],
                            ['name' => 'user/del', 'description' => '删除用户'],
                            
                        ]],
                    ['name' => 'user/role', 'description' => '角色管理', 'child' => [
                            ['name' => 'user/rolelist', 'description' => '查看角色'],
                            //['name'=>'user/rolecreate','description'=>'添加角色'],
                            ['name' => 'user/roleedit', 'description' => '添加/编辑角色'],
                            ['name' => 'user/roledel', 'description' => '删除角色'],
                        ]]
                ]],
        ];
        return $this->render('role', ['model' => new RoleForm(), 'permissions' => $permissions]);
    }

    public function actionRolelist() {
        $model = \Yii::$app->authManager->getRoles();
        return $this->renderPartial('rolelist', ['model' => $model]);
    }

    public function actionRoleedit() {
        $auth = \Yii::$app->authManager;
        $model = new RoleForm();
        $result = array();
        if ($model->load(Yii::$app->request->post())) {
            $role = $auth->getRole($model->name);
            if (!$role) {
                $role = $auth->createRole($model->name);
                $auth->add($role);
            }
            //分配权限
            $oldPermissions = array();
            if ($auth->getPermissionsByRole($role->name)) {
                $oldPermissions = ArrayHelper::getColumn($auth->getPermissionsByRole($role->name), 'name');
            }
            is_array($model->permissions) ? $newPermissions = $model->permissions : $newPermissions = array();
            //计算交集
            $intersection = array_intersect($newPermissions, $oldPermissions);
            //需要增加的权限
            $newPermissions = array_diff($newPermissions, $intersection);
            //需要删除的权限
            $oldPermissions = array_diff($oldPermissions, $intersection);
            foreach ($newPermissions as $new) {
                $auth->addChild($role, $auth->getPermission($new));
            }
            foreach ($oldPermissions as $old) {
                $auth->removeChild($role, $auth->getPermission($old));
            }
            $result['status'] = 1;
            $result['message'] = '保存成功';
        }
        $errors = $model->getFirstErrors();
        if ($errors) {
            $result['status'] = 0;
            $result['message'] = current($errors);
        }
        return $this->renderJson($result);
    }

    public function actionGetpermissionsbyrole($name) {
        $result = array();
        $auth = \Yii::$app->authManager;
        $permissions = $auth->getPermissionsByRole($name);
        if ($permissions) {
            foreach ($permissions as $p) {
                $result[] = $p->name;
            }
        }
        return $this->renderJson($result);
    }

    public function actionRoledel($name) {
        $result = array();
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        if ($role) {
            $auth->remove($role);
        }
        $result['status'] = 1;
        $result['message'] = '删除成功';
        return $this->renderJson($result);
    }

    private function getChild($item) {
        $auth = Yii::$app->authManager;
        $item = (array) $item;
        if ($childs = $auth->getChildren($item['name'])) {
            foreach ($childs as $child) {
                $item['child'][] = $this->getChild($child);
            }
            return $item;
        } else {
            return $item;
        }
    }

}
