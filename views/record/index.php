<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = '对话管理';
?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>对话管理</h2>
            </div>
            <div class="box-create">
                <?php
                $form = ActiveForm::begin([
                            'id' => 'list-form',
                            'action' => Url::toRoute('record/list'),
                            'options' => ['class' => 'form-horizontal'],
                ]);
                ?>
                <?php if(Yii::$app->user->can('record/edit')){?>
                <div class="form-group form-group-sm">
                    <div class="col-md-1">
                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myDialog" data-data="add"><i class="glyphicon glyphicon-plus-sign"></i><span>添加对话</span></a>
                    </div>
                </div>
                <?php }?>
                <div class="form-group form-group-sm">
                    <input name="page" value="1" type="hidden">
                    <label class="control-label col-md-1">对话筛选</label>
                    <div class="col-md-1">
                        <div class="checkbox">
                            <label>
                                <input name="havename" value="1" type="checkbox">有姓名
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="checkbox">
                            <label>
                                <input name="havephone" value="1" type="checkbox">有电话
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1" style="padding-left:10px;padding-right: 10px">
                        <div class="checkbox">
                            <label>
                                <input name="is_valid" value="1"  type="checkbox">有效咨询
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1" style="padding-left:10px;padding-right: 10px">
                        <div class="checkbox">
                            <label>
                                <input name="is_reserve" value="1" type="checkbox">有效预约
                            </label>
                        </div>
                    </div>
                    <label class="control-label col-md-1">渠道</label>
                    <div class="col-md-2">
                        <?= Html::dropDownList('channel_id', 0, $listChannel, ['prompt' => '全部', 'class' => 'form-control']) ?>
                    </div>
                    <label class="control-label col-md-1">科室</label>
                    <div class="col-md-2">
                        <?= Html::dropDownList('department_id', 0, $listDepartment, ['prompt' => '全部', 'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-md-2">
                        <a href="#" onclick="getList(1)" class="btn btn-default btn-block" ><i class="glyphicon glyphicon-search"></i><span>查询</span></a>
                    </div>
                    <label class="control-label col-md-1">登记员</label>
                    <div class="col-md-2">
                        <?= Html::dropDownList('user_id', 0, $listUser, ['prompt' => '全部', 'class' => 'form-control']) ?>
                    </div>
                    <label class="control-label col-md-1">添加时间</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="createtime_start" readonly="readonly">
                    </div>
                    <label class="control-label col-md-1">到</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="createtime_end" readonly="readonly">
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="box-content"  data-list="<?= Url::toRoute('record/list') ?>" data-del="<?= Url::toRoute('record/del') ?>">
            </div>
        </div>
    </div>
    <div class="modal fade" id="myDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'edit-form',
                        'action' => Url::toRoute('record/edit'),
                        'options' => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'options' => ['class' => NULL],
                        ],
            ]);
            ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <?= $form->field($model, 'id', ['template' => '{input}', 'options' => ['stype' => 'display:none']])->hiddenInput()->label(false) ?>
                    <div class="form-group">
                        <?= $form->field($model, 'channel_id', ['template' => '{label}<div class="col-md-2">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']])->dropDownList($listChannel) ?>
                        <?= $form->field($model, 'channel_note', ['template' => '{label}<div class="col-md-4">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']]) ?>
                        <div class="col-md-2">
                            <?= $form->field($model, 'is_valid')->checkbox()->label('有效对话') ?>
                        </div>
                        <div class="col-md-2">
                            <?= $form->field($model, 'is_reserve')->checkbox()->label('有效预约') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'department_id', ['template' => '{label}<div class="col-md-2">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']])->dropDownList($listDepartment) ?>
                        <?= $form->field($model, 'name', ['template' => '{label}<div class="col-md-3">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']]) ?>
                        <?= $form->field($model, 'phone', ['template' => '{label}<div class="col-md-4">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'doctor_id', ['template' => '{label}<div class="col-md-2">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']])->dropDownList($listDoctor, ['prompt' => '不指定']) ?>
                        <?= $form->field($model, 'appointment', ['template' => '{label}<div class="col-md-4">{input}{hint}{error}</div>', 'inputOptions' => ['readonly' => true], 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']]) ?>
                        <?= Html::button('清除时间', ['class' => 'btn btn-default', 'onclick' => '$("#record-appointment").val("")']) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'note', ['template' => '{label}<div class="col-md-10">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']])->textarea() ?>
                    </div>
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
        $("#record-appointment").datepicker({
            dateFormat:'yy-mm-dd'
        });
        customDatepicker($("input[name='createtime_start']"),$("input[name='createtime_end']"));
        getList(1);
        $('#myDialog').on('show.bs.modal', function (event) {
            if(!event.relatedTarget){//判断是不是时间选择触发的事件
                return false;
            }
            var button = $(event.relatedTarget);
            var data = button.data('data');
            var modal = $(this);
            $("#edit-form")[0].reset();//重置表单
            if(data=='add')
            {
                modal.find('.modal-title').text("添加对话");
                $("#record-id").val('');
            }
            else{
                modal.find('.modal-title').text("编辑对话");
                data=eval(data);
                $("#record-id").val(data.id);
                $("#record-channel_id").val(data.channel_id);
                $("#record-channel_note").val(data.channel_note);
                $("#record-is_valid").prop('checked',data.is_valid==1);
                $("#record-is_reserve").prop('checked',data.is_reserve==1);
                $("#record-department_id").val(data.department_id);
                $("#record-name").val(data.name);
                $("#record-phone").val(data.phone);
                data.doctor_id==0?$("#record-doctor_id").val(""):$("#record-doctor_id").val(data.doctor_id);
                data.appointment==0?$("#record-appointment").val(""):$("#record-appointment").val(new Date(parseInt(data.appointment)*1000).format('yyyy-MM-dd'));
                $("#record-note").val(data.note);
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
        //当选择为有效预约的时候，同时更新为有效咨询
        $("#record-is_reserve").change(function(){
            var checked=$(this).prop('checked');
            checked?$("#record-is_valid").prop('checked',checked):null;
        });
        //当选择为无效咨询时，更新为没有预约
        $("#record-is_valid").change(function(){
            var checked=$(this).prop('checked');
            checked===false?$("#record-is_reserve").prop('checked',checked):null;
        });
   });
   //获得科室列表
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