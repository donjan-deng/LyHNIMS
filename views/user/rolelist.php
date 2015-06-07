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
use app\models\Channel;
?>
<table id="" class="table table-striped table-bordered responsive">
    <thead>
        <tr>
            <th>角色名称</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model as $role) { ?>
            <tr>
                <td class="center"><?= Html::encode($role->name) ?></td>
                <td class="center">
                    <?php if(Yii::$app->user->can('user/roleedit')){?>
                    <a class="btn btn-info" href="#" data-toggle="modal" data-target="#myDialog" data-data='<?=$role->name?>'>
                        <i class="glyphicon glyphicon-edit icon-white"></i>
                        权限分配
                    </a>
                    <?php }?>
                    <?php if(Yii::$app->user->can('user/roledel')){?>
                    <a class="btn btn-danger" href="javascript:void(0);" onclick="del('<?=$role->name?>')">
                        <i class="glyphicon glyphicon-trash icon-white"></i>
                        删除
                    </a>
                    <?php }?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>