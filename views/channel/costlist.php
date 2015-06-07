<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;
?>
<table id="" class="table table-striped table-bordered responsive">
    <thead>
        <tr>
            <th>渠道</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>费用</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($provider->models as $record) { ?>
            <tr>
                <td class="center"><span class="text-primary"><?= $record->channel->name ?></span> </td>
                <td class="center"><?= date('Y-m-d',$record['startdate']) ?></td>
                <td class="center"><?= date('Y-m-d',$record['enddate']) ?></td>
                <td class="center"><span class="text-danger"><?= $record['fee']?></span></td>
                <td class="center">
                    <?php if(Yii::$app->user->can('channel/costedit')){?>
                    <a class="btn btn-info btn-sm" href="#" data-toggle="modal" data-target="#myDialog" data-data='<?=  Json::encode($record)?>'>
                        <i class="glyphicon glyphicon-edit icon-white"></i>
                        编辑
                    </a>
                    <?php }?>
                    <?php if(Yii::$app->user->can('channel/costdel')){?>
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
            <td colspan="5">
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