<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\bootstrap\ActiveForm;
use app\models\Doctor;
?>
<table id="" class="table table-striped table-bordered responsive">
    <thead>
        <tr>
            <th>医生名称</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model as $doctor) { ?>
            <tr>
                <td class="center"><?= Html::encode($doctor['name']) ?></td>
                <td class="center"><?= $doctor['enabled'] == 1 ? '<span class="label-success label label-default">正常</span>' : '<span class="label-default label">禁用</span>' ?></td>
                <td class="center">
                    <?php if(Yii::$app->user->can('doctor/edit')){?>
                    <a class="btn btn-info" href="#" data-toggle="modal" data-target="#myDialog" data-data='<?= Json::encode($doctor) ?>'>
                        <i class="glyphicon glyphicon-edit icon-white"></i>
                        编辑
                    </a>
                    <?php }?>
                    <?php if(Yii::$app->user->can('doctor/del')){?>
                    <a class="btn btn-danger" href="javascript:void(0);" onclick="del(<?= $doctor['id'] ?>)">
                        <i class="glyphicon glyphicon-trash icon-white"></i>
                        删除
                    </a>
                    <?php }?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>