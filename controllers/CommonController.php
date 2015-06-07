<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Json;
/**
 * 公共控制器，需要权限验证的都继承此控制器，在beforeAction验证权限。
 *
 * @author 搬砖工
 * @since 1.0
 */
class CommonController extends Controller {

    public function beforeAction($action) {
        $auth=  Yii::$app->authManager;
        $isAjax = Yii::$app->request->getIsAjax();
        //未登录
        if (\Yii::$app->user->isGuest) {
            if ($isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                Yii::$app->response->data = array(
                    'status' => -1,
                    'message' => '请先登录',
                    'url' => Yii::$app->getHomeUrl()
                );
                return false;
            } else {
                return $this->goHome();
            }
        }
        //超级管理员
        if(Yii::$app->user->identity->username==Yii::$app->params['SuperAdmin']){
            return true;
        }
        //return true;//调试
        //controller id 和 action id 组成节点，判断有否有权操作
        $action = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;
        $action=  strtolower($action);//转成小写
        if(!$auth->getPermission($action)){
            //该页面没有纳入权限管理
            return true;
        }
        if (!\Yii::$app->user->can($action)) {
            if ($isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                Yii::$app->response->data = array(
                    'status' => -1,
                    'message' => '对不起,你无权进行此项操作',
                );
                return false;
            } else {
                throw new \yii\web\HttpException(403, '对不起，您现在还没获此操作的权限');
            };
        } else {
            return parent::beforeAction($action);
        }
    }

    public function renderJson($params = array()) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $params;
    }

}
