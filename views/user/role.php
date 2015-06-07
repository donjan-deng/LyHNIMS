<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = '角色管理';
?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>角色管理</h2>
            </div>
            <?php if(Yii::$app->user->can('user/roleedit')){?>
            <div class="box-create"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myDialog" data-data="add"><i class="glyphicon glyphicon-plus-sign"></i><span>添加角色</span></a></div>
            <?php }?>
            <div class="box-content"  data-list="<?= Url::toRoute('user/rolelist') ?>" data-del="<?= Url::toRoute('user/roledel') ?>" data-permission="<?= Url::toRoute('user/getpermissionsbyrole') ?>">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'edit-form',
                    'action' => Url::toRoute('user/roleedit'),
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
                <div class="form-group">
                    <?= $form->field($model, 'name', ['template' => '{label}<div class="col-md-6">{input}{hint}{error}</div>', 'labelOptions' => ['class' => 'control-label col-md-2']]) ?>
                </div>
                <div class="form-group">
                    <label class="control-label  col-md-2">权限分配</label>
                </div>
                <?php foreach ($permissions as $permission) { ?>
                    <div class="form-group">
                        <div class="col-md-3">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="RoleForm[permissions][]" value="<?= $permission['name'] ?>">
                                <?= $permission['description'] ?>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <?php foreach ($permission['child'] as $child) { ?>
                                <label class="checkbox-inline">
                                    <input type="checkbox" data-parent="<?= $permission['name'] ?>" name="RoleForm[permissions][]" value="<?= $child['name'] ?>">
                                    <?= $child['description'] ?>
                                </label>
                                <?php
                                if (isset($child['child'])) {
                                    foreach ($child['child'] as $child2) {
                                        ?>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" data-parent="<?= $child['name'] ?>" name="RoleForm[permissions][]" value="<?= $child2['name'] ?>">
                                            <?= $child2['description'] ?>
                                        </label>
                                        <?php
                                    }
                                }
                                ?>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
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
        $("#edit-form input[name='RoleForm[permissions][]']").change(function(){
            selectParent($(this));
        });
        getList();
        $('#myDialog').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var data = button.data('data');
            var modal = $(this);
            $("#edit-form")[0].reset();//重置表单
            if(data=='add')
            {
                modal.find('.modal-title').text("添加角色");
                $("#roleform-name").removeAttr("readonly");
            }
            else{
                modal.find('.modal-title').text("编辑角色");
                $("#roleform-name").val(data).attr("readonly","readonly");
                $.ajax({
                    url: $(".box-content").data("permission"),
                    data:{name:data},
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
                        for(var i=0;i<data.length;i++){
                            $("#edit-form input[value='"+data[i]+"']").prop("checked",true);
                        }
                    }
                }); 
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
   window.del=function(name){
        layer.confirm('确定删除?', function(index){
            layer.close(index);
            $.ajax({
                url: $(".box-content").data("del"),
                data:{
                    name:name
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
   //选中父权限
   function selectParent(el){
        var parent=$(el).data("parent");
        if(parent&&$(el).prop("checked")==true){
            var el=$("#edit-form input[value='"+parent+"']");
            $(el).prop("checked",true);
            selectParent(el);
        }
   }
JS;
$this->registerJs($js);
?>