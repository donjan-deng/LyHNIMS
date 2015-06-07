<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Record;
use \app\models\Department;
use app\models\Channel;
use app\models\Doctor;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/**
 * 患者记录管理控制器。
 *
 * @author 搬砖工
 * @since 1.0
 */
class RecordController extends CommonController {

    public function actionIndex() {
        $listDepartment = ArrayHelper::map(Department::find()->where('enabled<>0')->all(), 'id', 'name');
        $listChannel = ArrayHelper::map(Channel::find()->where('enabled<>0')->all(), 'id', 'name');
        $listDoctor = ArrayHelper::map(Doctor::find()->where('enabled<>0')->all(), 'id', 'name');
        $listUser = ArrayHelper::map(User::find()->where('enabled<>0')->all(), 'id', 'username');
        return $this->render('index', [
                    'model' => new Record(),
                    'listDepartment' => $listDepartment,
                    'listChannel' => $listChannel,
                    'listDoctor' => $listDoctor,
                    'listUser' => $listUser,
        ]);
    }

    public function actionEdit() {
        $data = Yii::$app->request->post('Record');
        $result = array();
        if (is_numeric($data['id']) && $data['id'] > 0) {
            $model = Record::findOne($data['id']);
            if (!$model) {
                $result['status'] = 0;
                $result['message'] = '未找到该记录';
            }
        } else {
            $model = new Record();
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $result['status'] = 1;
                $result['message'] = '保存成功';
            }
        }
        $errors = $model->getFirstErrors();
        if ($errors) {
            $result['status'] = 0;
            $result['message'] = current($errors);
        }
        return $this->renderJson($result);
    }

    public function actionList($page = 1) {
        $query = Record::find();
        $haveName = Yii::$app->request->get('havename');
        //$haveName ? $query->andWhere(['is not','name',null]) : null; //是否有名字
        $haveName ? $query->andWhere(['<>', 'name', '']) : null;
        $havePhone = Yii::$app->request->get('havephone');
        $havePhone ? $query->andWhere(['<>', 'phone', '']) : null; //是否有电话
        $query->andFilterWhere(['is_valid' => Yii::$app->request->get('is_valid')]); //是否是有效咨询
        $query->andFilterWhere(['is_reserve' => Yii::$app->request->get('is_reserve')]); //是否是有效预约
        $query->andFilterWhere(['department_id' => Yii::$app->request->get('department_id')]); //是否选择了科室
        $query->andFilterWhere(['channel_id' => Yii::$app->request->get('channel_id')]); //是否选择了渠道
        $query->andFilterWhere(['user_id' => Yii::$app->request->get('user_id')]); //是否选择了用户
        //添加的时间范围$startTime to $endTime
        if ($startTime = strtotime(Yii::$app->request->get('createtime_start')) !== false) {
            $startTime = strtotime(Yii::$app->request->get('createtime_start') . ' 00:00:00');
            $query->andFilterWhere(['>', 'created_at', $startTime]);
        }
        if ($endTime = strtotime(Yii::$app->request->get('createtime_end')) !== false) {
            $endTime = strtotime(Yii::$app->request->get('createtime_end') . ' 23:59:59');
            $query->andFilterWhere(['<', 'created_at', $endTime]);
        }
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);
        return $this->renderPartial('list', ['provider' => $provider]);
    }

    public function actionDel($id) {
        $result = array();
        $model = Record::findOne($id);
        if ($model) {
            $model->delete();
            $result['status'] = 1;
            $result['message'] = '删除成功';
        } else {
            $result['status'] = 0;
            $result['message'] = '未找到ID为' . $id . '的记录';
        }
        return $this->renderJson($result);
    }

    //预约管理开始
    public function actionAppointment() {
        $listDepartment = ArrayHelper::map(Department::find()->where('enabled<>0')->all(), 'id', 'name');
        $listChannel = ArrayHelper::map(Channel::find()->where('enabled<>0')->all(), 'id', 'name');
        $listDoctor = ArrayHelper::map(Doctor::find()->where('enabled<>0')->all(), 'id', 'name');
        $listUser = ArrayHelper::map(User::find()->where('enabled<>0')->all(), 'id', 'username');
        return $this->render('appointment', [
                    'model' => new Record(),
                    'listDepartment' => $listDepartment,
                    'listChannel' => $listChannel,
                    'listDoctor' => $listDoctor,
                    'listUser' => $listUser,
        ]);
    }

    public function actionAppointmentlist($page = 1) {
        $query = Record::find();
        $query->orWhere(['<>', 'name', '']); //姓名和电话必需有一个不为空
        $query->orWhere(['<>', 'phone', '']);
        $query->andFilterWhere(['is_arrive' => Yii::$app->request->get('is_arrive')]); //是否已经到院
        $query->andFilterWhere(['department_id' => Yii::$app->request->get('department_id')]); //是否选择了科室
        $query->andFilterWhere(['channel_id' => Yii::$app->request->get('channel_id')]); //是否选择了渠道
        $query->andFilterWhere(['user_id' => Yii::$app->request->get('user_id')]); //是否选择了用户
        $query->andFilterWhere(['doctor_id' => Yii::$app->request->get('doctor_id')]); //是否选择了医生
        $query->andFilterWhere(['like', 'name', Yii::$app->request->get('name')]);
        $query->andFilterWhere(['like', 'phone', Yii::$app->request->get('phone')]);
        //预约时间范围-没有勾选查询到院时生效
        if (!Yii::$app->request->get('is_arrive')&&strtotime(Yii::$app->request->get('reservetime_start')) !== false && strtotime(Yii::$app->request->get('reservetime_end')) !== false) {
            $startTime = strtotime(Yii::$app->request->get('reservetime_start') . ' 00:00:00');
            $endTime = strtotime(Yii::$app->request->get('reservetime_end') . ' 23:59:59');
            $query->andFilterWhere(['>', 'appointment', $startTime]);
            $query->andFilterWhere(['<', 'appointment', $endTime]);
        }
        //到院时间范围
        if (strtotime(Yii::$app->request->get('arrivedtime_start')) !== false && strtotime(Yii::$app->request->get('arrivedtime_end')) !== false&&Yii::$app->request->get('is_arrive')) {
            $startTime = strtotime(Yii::$app->request->get('arrivedtime_start') . ' 00:00:00');
            $endTime = strtotime(Yii::$app->request->get('arrivedtime_end') . ' 23:59:59');
            $query->andFilterWhere(['>', 'arrived_at', $startTime]);
            $query->andFilterWhere(['<', 'arrived_at', $endTime]);
        }
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    Yii::$app->request->get('orderby') => SORT_DESC,
                ]
            ],
        ]);
        return $this->renderPartial('appointmentlist', ['provider' => $provider]);
    }

    //导医分诊
    public function actionAllocate() {
        $data = Yii::$app->request->post('Record');
        $result = array();
        if (is_numeric($data['id']) && $data['id'] > 0) {
            $model = Record::findOne($data['id']);
            if ($model) {
                if ($model->load(Yii::$app->request->post())) {
                    $model->is_arrive= true;
                    $model->is_valid=true;
                    $model->is_reserve= true;
                    $model->appointment==0?$model->appointment=time():null;
                    $model->arrived_at=time();
                    if ($model->save()) {
                        $result['status'] = 1;
                        $result['message'] = '保存成功';
                    }else{
                        $result['status'] = 0;
                        $result['message'] = '保存失败';
                    }
                }
                $errors = $model->getFirstErrors();
                if ($errors) {
                    $result['status'] = 0;
                    $result['message'] = current($errors);
                }
            } else {
                $result['status'] = 0;
                $result['message'] = '未找到该记录';
            }
        } else {
            $result['status'] = 0;
            $result['message'] = '参数错误';
        }
        return $this->renderJson($result);
    }

    //autocomplete
    public function actionAutocomplete($col = 'name', $key) {
        if (isset($key)) {
            $result = Record::find()->select(['name', 'phone'])->where($col . ' like "%' . $key . '%"')->limit(10)->all();
            if ($result) {
                $result = ArrayHelper::getColumn($result, $col);
                return $this->renderJson($result);
            }
        }
    }

}
