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
use app\models\Record;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;
?>
<table id="" class="table table-striped table-bordered responsive">
    <thead>
        <tr>
            <th>添加时间</th>
            <th>录入</th>
            <th>科室</th>
            <th>渠道</th>
            <th>渠道来源</th>
            <th>姓名</th>
            <th>电话</th>
            <th>预约时间</th>
            <th>备注</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($provider->models as $record) { ?>
            <tr>
                <td class="center"><?= date('Y-m-d',$record['created_at']) ?></td>
                <td class="center"><?= Html::encode($record->user->username) ?></td>
                <td class="center"><?= $record->department->name ?></td>
                <td class="center"><?= $record->channel->name ?></td>
                <td class="center"><?= Html::encode($record['channel_note']) ?></td>
                <td class="center"><?= Html::encode($record['name'])?></td>
                <td class="center"><?= Html::encode($record['phone'])?></td>
                <td class="center"><?= $record['appointment']==0?"":'<span class="text-info">'.date('Y-m-d',$record['appointment']).'</span>'?></td>
                <td class="center"><?= Html::encode(mb_substr($record['note'], 0,20,'utf-8'))?>
                <?=mb_strlen($record['note'])>20?'<a href="javascript:void(0);" data-placement="top" data-toggle="popover" data-content="'.Html::encode($record['note']).'" title="备注"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>全部</a>':""?></td>
                <td class="center">
                    <?php if(Yii::$app->user->can('record/edit')){?>
                    <a class="btn btn-info btn-sm" href="#" data-toggle="modal" data-target="#myDialog" data-data='<?=  Json::encode($record->attributes)?>'>
                        <i class="glyphicon glyphicon-edit icon-white"></i>
                        编辑
                    </a>
                    <?php }?>
                    <?php if(Yii::$app->user->can('record/del')){?>
                    <a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="del(<?= $record['id'] ?>)">
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
            <td colspan="10">
                <button class="btn btn-default pull-left" style="display: inline-block" disabled="disabled">(当前<?= $provider->count ?>条/共<?= $provider->totalCount ?>条)</button>
                <?=
                LinkPager::widget([
                    'pagination' => $provider->pagination,
                    'linkOptions' => ['onclick' => 'return goPage(this)'],
                    'options' => ['class' => 'pagination pull-left', 'style' => 'margin:0px']
                ]);
                ?>
            </td>
        </tr>
    </tfoot>
</table>
<script type="text/javascript">
    $(function(){
        $('[data-toggle="popover"]').popover();
    })
    </script>