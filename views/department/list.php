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
use app\models\Department;
?>
<table id="" class="table table-striped table-bordered responsive">
    <thead>
        <tr>
            <th><label><input id="checkAll" type="checkbox"/>选择</label></th>
            <th>科室名称</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model as $department) { ?>
            <tr>
                <td class="center"><input name="source" value="<?= Html::encode($department['id']) ?>" type="checkbox"/></td>
                <td class="center"><?= Html::encode($department['name']) ?></td>
                <td class="center"><?= $department['enabled'] == 1 ? '<span class="label-success label label-default">正常</span>' : '<span class="label-default label">禁用</span>' ?></td>
                <td class="center">
                    <?php if(Yii::$app->user->can('department/edit')){?>
                    <a class="btn btn-info" href="#" data-toggle="modal" data-target="#myDialog" data-data='<?= Json::encode($department) ?>'>
                        <i class="glyphicon glyphicon-edit icon-white"></i>
                        编辑
                    </a>
                     <?php }?>
                    <?php if(Yii::$app->user->can('department/del')){?>
                    <a class="btn btn-danger" href="javascript:void(0);" onclick="del(<?= $department['id'] ?>)">
                        <i class="glyphicon glyphicon-trash icon-white"></i>
                        删除
                    </a>
                     <?php }?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">
                <?php if(Yii::$app->user->can('department/merge')){?>
                <a class="btn btn-primary" href="javascript:void(0);" onclick="showMerge()">
                    <i class="glyphicon glyphicon-share icon-white"></i>
                    合并科室
                </a>
                <?php }?>
            </td>
        </tr>
    </tfoot>
</table>
<div class="modal fade" id="mergeDialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'merge-form',
                    'action' => Url::toRoute('department/merge'),
                    'options'=>[
                         'onSubmit'=>'return merge()'
                    ],
        ]);
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">合并科室</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="source">
                <div class="form-group">
                <p class="text-danger">注意，合并后将删除源科室！</p>
                <p class="help-block">确定将（<span class="source text-danger"></span>）合并到</p>
                </div>
                <div class="form-group">
                    <select class="form-control" name="src">
                        <?php foreach ($model as $department) { ?>
                        <option value="<?=$department['id']?>"><?=$department['name']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <?= Html::submitButton('合并', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#checkAll").change(function () {
            $("input[name='source']").prop("checked", $(this).prop("checked"));
        });
    })
</script>