<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\AppAsset;
use yii\captcha\Captcha;
AppAsset::register($this);
$this->title=Yii::$app->params['Hospital'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
	<?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	 <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="ch-container">
    <div class="row">
        
    <div class="row">
        <div class="col-md-12 center login-header">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            <div class="alert alert-info">
                请输入用户名和密码登录后使用
            </div>
			<?php $form = ActiveForm::begin([
				'id' => 'login-form',
				'options' => ['class' => 'form-horizontal'],
				'fieldConfig' => [
					'options' => ['class' => null],
				],
			]);?>
			<fieldset>
				<?= $form->field($model, 'username',[
					'template'=>"<div class=\"input-group input-group-lg\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user red\"></i></span>{input}</div>{error}"
				])->textInput(['placeholder'=>"用户名"])->label("用户名")?>
				<div class="clearfix"></div>
				<?= $form->field($model, 'password',[
					'template'=>"<div class=\"input-group input-group-lg\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock red\"></i></span>{input}</div>{error}"
				])->passwordInput(['placeholder'=>"密码"])->label("密码") ?>
				<div class="clearfix"></div>
				<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="input-group input-group-lg col-md-8"><span class="input-group-addon"><i class="glyphicon glyphicon-eye-open red"></i></span>{input}<div class="input-group-addon" style="padding:5px;">{image}</div></div>',
					'options' => ['class' => 'form-control','placeholder'=>"验证码"]
                ])->label(false) ?>
				<div class="clearfix"></div>
				<?= $form->field($model, 'rememberMe', [
					'template' => "<label class=\"remember\">{input}记住我</label>",
					'options'=>['class'=>"input-prepend"],
					'labelOptions'=>['class'=>"remember"],
				])->checkbox()->label('记住我')?>
				<div class="clearfix"></div>
				<p class="center col-md-5">
				 <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
				 </p>
			</fieldset>
			<?php ActiveForm::end(); ?>
        </div>
		<div class="col-md-5 center">
			<p>
				Powered by <a href="http://www.lyapp.com">领域医院网络信息管理系统</a>
			</p>
		</div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->
</div><!--/.fluid-container-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>