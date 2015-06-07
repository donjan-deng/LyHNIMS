<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\User;
/**
 * 首页控制器。
 *
 * @author 搬砖工
 * @since 1.0
 */
class SiteController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'width' => 120,
                'height' => 40,
                'padding' => 0,
                'minLength' => 4,
                'maxLength' => 4,
            ],
        ];
    }

    public function actionIndex() {
        Yii::$app->controller->layout = false;
        if (!\Yii::$app->user->isGuest) {
            $this->redirect(Url::toRoute('admin/index')); //已登录直接跳转
        }
        $model = new User(['scenario' => 'login']);
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Url::toRoute('admin/index'));
        } else {
            return $this->render('index', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
