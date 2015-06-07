<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Department;
use app\models\Record;
use \yii\helpers\Url;
/**
 * 科室管理控制器。
 *
 * @author 搬砖工
 * @since 1.0
 */
class DepartmentController extends CommonController {

    public function actionIndex() {
        return $this->render('index', ['model' => new Department()]);
    }

    public function actionEdit() {
        $data = Yii::$app->request->post('Department');
        $result = array();
        if (is_numeric($data['id']) && $data['id'] > 0) {
            $model = Department::findOne($data['id']);
            if (!$model) {
                $result['status'] = 0;
                $result['message'] = '未找到该记录';
            }
        } else {
            $model = new Department();
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
        $model = Department::find()->all();
        return $this->renderPartial('list', ['model' => $model]);
    }

    public function actionDel($id) {
        $result = array();
        $model = Department::findOne($id);
        if (Record::find()->where('department_id=' . $id . '')->exists()) {
            $model->enabled = 0;
            $model->update();
            $result['status'] = 1;
            $result['message'] = '该科室已关联数据，不能删除，已经禁用！';
        } else {
            $model->delete();
            $result['status'] = 1;
            $result['message'] = '删除成功';
        }
        return $this->renderJson($result);
    }

    public function actionMerge() {
        $source = Yii::$app->request->post('source');
        $src = Yii::$app->request->post('src');
        Record::updateAll(array('department_id' => $src), 'department_id in (' . $source . ')'); //更新对话记录的科室
        Department::deleteAll('id in ('.$source.') and id<>' . $src); //删除源科室
        $result = array();
        $result['status'] = 1;
        $result['message'] = '合并成功';
        return $this->renderJson($result);
    }

}
