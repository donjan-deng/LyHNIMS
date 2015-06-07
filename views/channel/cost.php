<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = '渠道消费管理';
?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>渠道消费管理</h2>
            </div>
            <div class="box-create">
                <?php
                $form = ActiveForm::begin([
                            'id' => 'list-form',
                            'action' => Url::toRoute('channel/costlist'),
                            'options' => ['class' => 'form-horizontal'],
                ]);
                ?>
                <div class="form-group form-group-sm">
                    <input name="page" value="1" type="hidden">
                    <?php if(Yii::$app->user->can('channel/costedit')){?>
                    <div class="col-md-1">
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myDialog" data-data="add"><i class="glyphicon glyphicon-plus-sign"></i><span>添加消费</span></a>
                    </div>
                     <?php }?>
                    <label class="control-label col-md-1">选择渠道</label>
                    <div class="col-md-2">
                        <?= Html::dropDownList('channel_id', 0, $listChannel, ['prompt' => '全部', 'class' => 'form-control']) ?>
                    </div>
                    <label class="control-label col-md-1">时间</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="startdate" readonly="readonly">
                    </div>
                    <label class="control-label col-md-1">到</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="enddate" readonly="readonly">
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="box-content">
            </div>
        </div>
    </div>
    <div class="modal fade" id="myDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'edit-form',
                        'action' => Url::toRoute('channel/costedit')
            ]);
            ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <?= $form->field($model, 'id', ['template' => '{input}', 'options' => ['stype' => 'display:none']])->hiddenInput()->label(false) ?>
                    <?= $form->field($model,'channel_id')->dropDownList($listChannel) ?>
                    <?= $form->field($model,'startdate',['inputOptions'=>['readonly'=>'readonly']]) ?>
                    <?= $form->field($model,'enddate',['inputOptions'=>['readonly'=>'readonly']]) ?>
                    <?= $form->field($model,'fee') ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?php
    $js = <<<JS
    $(function(){
        customDatepicker($("#list-form input[name='startdate']"),$("#list-form input[name='enddate']"));
        customDatepicker($("#channelcost-startdate"),$("#channelcost-enddate"));
        $("select[name='channel_id'],input[name='startdate'],input[name='enddate']",$("#list-form")).change(function(){
            getList(1);
        });
        getList(1);
        $('#myDialog').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var data = button.data('data');
            var modal = $(this);
            $("#edit-form")[0].reset();//重置表单
            if(data=='add')
            {
                modal.find('.modal-title').text("添加渠道消费");
                $("#channelcost-id").val('');
                $("#channelcost-channel_id").removeAttr('disabled');
            }
            else{
                modal.find('.modal-title').text("编辑渠道消费");
                data=eval(data);
                $("#channelcost-id").val(data.id);
                $("#channelcost-channel_id").val(data.channel_id);
                $("#channelcost-channel_id").attr('disabled','disabled');
                $("#channelcost-startdate").val(new Date(parseInt(data.startdate)*1000).format('yyyy-MM-dd'));
                $("#channelcost-enddate").val(new Date(parseInt(data.enddate)*1000).format('yyyy-MM-dd'));
                $("#channelcost-fee").val(data.fee);
            }
        });
        $("#edit-form").on('beforeSubmit',function(e){
            ajaxSubmitForm($(this),function(data){
                if(data.status==1){
                    getList();
                    $('#myDialog').modal('hide');
                }
            });
            return false;
        });
   });
   //获得列表
   window.getList=function(page){
       page!=null?$("#list-form input[name='page']").val(page):null; 
       $.ajax({
        url: $("#list-form").attr('action'),
        data:$("#list-form").serialize(),
        beforeSend: function () {
            layer.load();
        },
        complete: function () {
            layer.closeAll('loading');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            layer.alert('出错拉:' + textStatus + ' ' + errorThrown, {icon: 5});
        },
        success: function (data) {
            $(".box-content").html(data);
        }
    });
   }
   window.del=function(id){
        layer.confirm('确定删除?', function(index){
            layer.close(index);
            $.ajax({
                url: $(".box-content").data("del"),
                data:{
                    id:id
                },
                beforeSend: function () {
                    layer.load();
                },
                complete: function () {
                    layer.closeAll('loading');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.alert('出错拉:' + textStatus + ' ' + errorThrown, {icon: 5});
                },
                success: function (data) {
                    if (data.status == 1)
                    {
                        layer.alert(data.message, {icon: 6},function(index){
                            getList(null);
                            layer.close(index);
                        });
                    }
                    else {
                        layer.alert(data.message, {icon: 5}, function (index) {
                            layer.close(index);
                        });
                    }
                }
            });  
        });  
   }
   window.goPage=function(obj){
          var page=$(obj).data('page')+1;
          getList(page);
          return false;
   }
JS;
    $this->registerJs($js);
    ?>