<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = '预约管理';
?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>预约管理</h2>
            </div>
            <div class="box-create">
                <?php
                $form = ActiveForm::begin([
                            'id' => 'list-form',
                            'action' => Url::toRoute('record/appointmentlist'),
                            'options' => ['class' => 'form-horizontal'],
                ]);
                ?>
                <div class="form-group form-group-sm">
                    <input name="page" value="1" type="hidden">
                    <label class="control-label col-md-1">排序：</label>
                    <div class="col-md-1" style="padding-left:5px;padding-right:5px">
                        <?= Html::dropDownList('orderby','appointment',['appointment'=>'预约时间','arrived_at'=>'到院时间'],['class' => 'form-control']) ?>
                    </div>
                    <label class="control-label col-md-1">渠道</label>
                    <div class="col-md-2">
                        <?= Html::dropDownList('channel_id', 0, $listChannel, ['prompt' => '全部', 'class' => 'form-control']) ?>
                    </div>
                    <label class="control-label col-md-1">科室</label>
                    <div class="col-md-2">
                        <?= Html::dropDownList('department_id', 0, $listDepartment, ['prompt' => '全部', 'class' => 'form-control']) ?>
                    </div>
                    <label class="control-label col-md-1">医生</label>
                    <div class="col-md-2">
                        <?= Html::dropDownList('doctor_id', 0, $listDoctor, ['prompt' => '全部', 'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-1">姓名</label>
                    <div class="col-md-1" style="padding-left:5px;padding-right:5px">
                        <input data-url="<?= Url::toRoute('record/autocomplete') ?>" class="form-control" type="text" name="name">
                    </div>
                    <label class="control-label col-md-1">电话</label>
                    <div class="col-md-2">
                        <input data-url="<?= Url::toRoute(['record/autocomplete','col'=>'phone']) ?>" class="form-control" type="text" name="phone">
                    </div>
                    <label class="control-label col-md-1">预约时间</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="reservetime_start" readonly="readonly">
                    </div>
                    <label class="control-label col-md-1">到</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="reservetime_end" readonly="readonly">
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    
                    <label class="control-label col-md-1">登记员</label>
                    <div class="col-md-2">
                        <?= Html::dropDownList('user_id', 0, $listUser, ['prompt' => '全部', 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-1 col-md-offset-1" style="padding-left:10px;padding-right: 10px">
                        <div class="checkbox">
                            <label>
                                <input name="is_arrive" value="1" type="checkbox">是否到院
                            </label>
                        </div>
                    </div>
                    <label class="control-label col-md-1">到院时间</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="arrivedtime_start" readonly="readonly">
                    </div>
                    <label class="control-label col-md-1">到</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="arrivedtime_end" readonly="readonly">
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="box-content">
            </div>
        </div>
    </div>
    <div class="modal fade" id="myDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'allocate-form',
                        'action' => Url::toRoute('record/allocate'),
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
                        <?= $form->field($model, 'department_id', ['template' => '{label}<div class="col-md-2">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']])->dropDownList($listDepartment) ?>
                        <?= $form->field($model, 'name', ['template' => '{label}<div class="col-md-3">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']]) ?>
                        <?= $form->field($model, 'phone', ['template' => '{label}<div class="col-md-4">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'doctor_id', ['template' => '{label}<div class="col-md-2">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']])->dropDownList($listDoctor)->label('接待医生') ?>
                        <?= $form->field($model, 'note', ['template' => '{label}<div class="col-md-8">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-1', 'style' => 'padding-left:5px;padding-right:5px']])->textarea() ?>
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
        customDatepicker($("input[name='reservetime_start']"),$("input[name='reservetime_end']"));
        customDatepicker($("input[name='arrivedtime_start']"),$("input[name='arrivedtime_end']"));
        $("select[name='orderby'],input[name='is_reserve'],select[name='channel_id'],select[name='department_id'],select[name='doctor_id'],input[name='is_arrive'],select[name='user_id'],input[name='reservetime_start'],input[name='reservetime_end'],input[name='arrivedtime_start'],input[name='arrivedtime_end']",$("#list-form")).change(function(){
            getList(1);
        });
        $("#list-form input[name='name'],#list-form input[name='phone']").change(function(){
            getList(1);
        });
        $("#list-form input[name='name']").autocomplete({
            source: function( request, response ) {
                $.getJSON($("#list-form input[name='name']").data("url"), {
                    key: request.term
                }, response );
            },
            close: function( event, ui ) {
                getList(1);
            }
        });
        $("#list-form input[name='phone']").autocomplete({
            source: function( request, response ) {
                $.getJSON($("#list-form input[name='phone']").data("url"), {
                    key: request.term
                }, response );
            },
            close: function( event, ui ) {
                getList(1);
            }
        });
        getList(1);
        $('#myDialog').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var data = button.data('data');
            var modal = $(this);
            $("#allocate-form")[0].reset();//重置表单
            modal.find('.modal-title').text("确认到院");
            data=eval(data);
            $("#record-id").val(data.id);
            $("#record-department_id").val(data.department_id);
            $("#record-name").val(data.name);
            $("#record-phone").val(data.phone);
            data.doctor_id==0?$("#record-doctor_id").children().first().attr("selected",true):$("#record-doctor_id").val(data.doctor_id);
            data.appointment==0?$("#record-appointment").val(""):$("#record-appointment").val(new Date(parseInt(data.appointment)*1000).format('yyyy-MM-dd'));
            $("#record-note").val(data.note);
        });
        $("#allocate-form").on('beforeSubmit',function(e){
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
   window.goPage=function(obj){
          var page=$(obj).data('page')+1;
          getList(page);
          return false;
   }
JS;
    $this->registerJs($js);
    ?>