<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Channel;
use app\models\Record;
use app\models\ChannelCost;
use yii\data\ActiveDataProvider;
use \yii\helpers\Url;
use yii\helpers\ArrayHelper;
/**
 * 渠道管理控制器
 *
 * @author 搬砖工
 * @since 1.0
 */
class ChannelController extends CommonController {

    public function actionIndex() {
        return $this->render('index', ['model' => new Channel()]);
    }

    public function actionEdit() {
        $data = Yii::$app->request->post('Channel');
        $result = array();
        if (is_numeric($data['id']) && $data['id'] > 0) {
            $model = Channel::findOne($data['id']);
            if (!$model) {
                $result['status'] = 0;
                $result['message'] = '未找到该记录';
            }
        } else {
            $model = new Channel();
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

    public function actionList() {
        $model = Channel::find()->all();
        return $this->renderPartial('list', ['model' => $model]);
    }

    public function actionDel($id) {
        $result = array();
        $model = Channel::findOne($id);
        if (Record::find()->where('channel_id=' . $id . '')->exists() || ChannelCost::find()->where('channel_id=' . $id . '')->exists()) {
            $model->enabled = 0;
            $model->update();
            $result['status'] = 1;
            $result['message'] = '该渠道已关联数据，不能删除，已经禁用！';
        } else {
            $model->delete();
            $result['status'] = 1;
            $result['message'] = '删除成功';
        }
        return $this->renderJson($result);
    }

    public function actionCost() {
        $listChannel = ArrayHelper::map(Channel::find()->where('enabled<>0')->all(), 'id', 'name');
        return $this->render('cost', [
                    'model' => new ChannelCost(),
                    'listChannel' => $listChannel,
        ]);
    }

    public function actionCostlist($page = 1) {
        $query = ChannelCost::find();
        $query->andFilterWhere(['channel_id' => Yii::$app->request->get('channel_id')]);
        if ($startTime = strtotime(Yii::$app->request->get('startdate')) !== false) {
            $startTime = strtotime(Yii::$app->request->get('startdate') . ' 00:00:00');
            $query->andFilterWhere(['>=', 'startdate', $startTime]);
        }
        if ($endTime = strtotime(Yii::$app->request->get('enddate')) !== false) {
            $endTime = strtotime(Yii::$app->request->get('enddate') . ' 23:59:59');
            $query->andFilterWhere(['<=', 'enddate', $endTime]);
        }
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'enddate' => SORT_DESC,
                ]
            ],
        ]);
        return $this->renderPartial('costlist', ['provider' => $provider]);
    }

    public function actionCostedit() {
        $data = Yii::$app->request->post('ChannelCost');
        $result = array();
        if (is_numeric($data['id']) && $data['id'] > 0) {
            $model = Record::findOne($data['id']);
            if (!$model) {
                $result['status'] = 0;
                $result['message'] = '未找到该记录';
            }
        } else {
            $model = new ChannelCost();
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

    public function actionCostdel() {
        return $this->render('costlist', ['model' => new ChannelCost()]);
    }

}
