<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Record;
use \yii\helpers\Url;
/**
 * 后台首页控制器
 *
 * @author 搬砖工
 * @since 1.0
 */
class AdminController extends CommonController {
    
    public function actionIndex() {
        $today=strtotime(date('Y-m-d',time()).' 00:00:00');
        $startDate=$today-86400;
        $count=  Record::find()->where('created_at>:startDate and created_at<:endDate',[':startDate'=>$startDate,':endDate'=>$today-1])->count();
        $validCount=  Record::find()->where('created_at>:startDate and created_at<:endDate and is_valid=1',[':startDate'=>$startDate,':endDate'=>$today-1])->count();
        $reservedCount=  Record::find()->where('created_at>:startDate and created_at<:endDate and is_reserve=1',[':startDate'=>$startDate,':endDate'=>$today-1])->count();
        $arrivedCount=  Record::find()->where('arrived_at>:startDate and arrived_at<:endDate and is_arrive=1',[':startDate'=>$startDate,':endDate'=>$today-1])->count();
        return $this->render('index',['count'=>[$count,$validCount,$reservedCount,$arrivedCount]]);
    }

    public function actionProfile() {
        $model = new User(['scenario' => 'editprofile']);
        return $this->render('profile', [
                    'model' => $model
        ]);
    }

    public function actionEditprofile() {
        $model = new User(['scenario' => 'editprofile']);
        $result = array();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->editProfile(\Yii::$app->user->identity->id)) {
                $result['status'] = 1;
                $result['message'] = '保存成功，请重新登录';
                $result['url'] = Url::toRoute('site/logout');
            }
        }
        $errors = $model->getFirstErrors();
        if ($errors) {
            $result['status'] = 0;
            $result['message'] = current($errors);
        }
        return $this->renderJson($result);
    }

}
