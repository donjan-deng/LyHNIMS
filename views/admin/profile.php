<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = '后台首页';
$this->params['breadcrumbs'][] = '更改资料';
?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>更改资料</h2>
            </div>
            <div class="box-content">
                <?php
                $form = ActiveForm::begin([
                    'id'=>'editProfile-form',
                    'action'=> Url::toRoute('admin/editprofile')
                ]);
                ?>
                    <?= $form->field($model, 'password')->passwordInput()->label("旧密码")?>
                    <?= $form->field($model, 'newPassword')->passwordInput() ?>
                    <?= $form->field($model, 'verifyNewPassword')->passwordInput() ?>
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$js=<<<JS
    $("#editProfile-form").on('beforeSubmit',function(e){
        ajaxSubmitForm($(this));
        return false;
    });
JS;
$this->registerJs($js);
?>