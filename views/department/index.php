<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = '科室管理';
$this->params['breadcrumbs'][] = '科室管理';
?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>科室管理</h2>
            </div>
            <?php if(Yii::$app->user->can('department/edit')){?>
            <div class="box-create"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myDialog" data-data="add"><i class="glyphicon glyphicon-plus-sign"></i><span>添加科室</span></a></div>
            <?php }?>
            <div class="box-content"  data-list="<?= Url::toRoute('department/list') ?>" data-del="<?= Url::toRoute('department/del') ?>">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'edit-form',
                    'action' => Url::toRoute('department/edit')
        ]);
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'enabled')->checkbox()->label('启用') ?>
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
        getList();
        $('#myDialog').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var data = button.data('data');
            var modal = $(this);
            $("#edit-form")[0].reset();//重置表单
            if(data=='add')
            {
                modal.find('.modal-title').text("添加科室");
                $("#department-id").val('');
                $("#department-enabled").prop('checked',true);
            }
            else{
                modal.find('.modal-title').text("编辑科室");
                data=eval(data);
                $("#department-id").val(data.id);
                $("#department-name").val(data.name);
                $("#department-enabled").prop('checked',data.enabled==1?true:false);
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
   //获得科室列表
   window.getList=function(){
       $.ajax({
        url: $(".box-content").data("list"),
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
   //禁用科室
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
                            getList();
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
   //显示合并科室dialog
   window.showMerge=function(){
        if($("input[name='source']:checked").length>0){
            var idArray=new Array();
            var nameArray=new Array();
            $("input[name='source']:checked").each(function(){
                id=$(this).val();
                name=$(this).parent().next().text();
                idArray.push(id);
                nameArray.push(name);
            });
            $("#merge-form .help-block span").text(nameArray.join(','));
            $("#merge-form input[name='source']").val(idArray.join(','));
            $('#mergeDialog').modal('show');
        }else{
            layer.msg('请至少选择一个科室', {icon: 5});
        }
   }
   //合并科室
   window.merge=function(){
        ajaxSubmitForm($('#merge-form'),function(data){
            if(data.status==1){
                getList();
                $('#mergeDialog').modal('hide');
            }
        });
        return false;
   }
JS;
$this->registerJs($js);
?>