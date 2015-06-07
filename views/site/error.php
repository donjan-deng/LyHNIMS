<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
Yii::$app->controller->layout = false;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $name;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <title><?= Html::encode($this->title) ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            * {
                margin: 0;
                padding: 0;
            }
            body {
                font-family: arial, helvetica, sans-serif;
                background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAUElEQVQYV2NkYGAwBuKzQAwDID4IoIgxIikAMZE1oRiArBDdZBSNMIXoJiFbDZYDKcSmCOYimDuNSVKIzRNYrUYOFuQgweoZbIoxgoeoAAcAEckW11HVTfcAAAAASUVORK5CYII=) repeat;
                background-color: #212121;
                color: white;
                font-size: 28px;
                padding-bottom: 20px;
            }
            .error-code {
                font-family: 'Creepster', cursive, arial, helvetica, sans-serif;
                font-size: 200px;
                color: white;
                color: rgba(255, 255, 255, 0.98);
                width: 50%;
                text-align: right;
                margin-top: 5%;
                text-shadow: 5px 5px hsl(0, 0%, 25%);
                float: left;
            }
            .not-found {
                font-family: 'Audiowide', cursive, arial, helvetica, sans-serif;
                width: 45%;
                float: right;
                margin-top: 5%;
                font-size: 50px;
                color: white;
                text-shadow: 2px 2px 5px hsl(0, 0%, 61%);
                padding-top: 70px;
            }
            .clear {
                float: none;
                clear: both;
            }
            .content {
                text-align: center;
                line-height: 30px;
            }
            input[type=text] {
                border: hsl(247, 89%, 72%) solid 1px;
                outline: none;
                padding: 5px 3px;
                font-size: 16px;
                border-radius: 8px;
            }
            a {
                text-decoration: none;
                color: #9ECDFF;
                text-shadow: 0px 0px 2px white;
            }
            a:hover {
                color: white;
            }
        </style>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <p class="error-code">
            <?=$exception->getCode()?$exception->getCode():$exception->statusCode?>
        </p>
        <p class="not-found"><?= Html::encode($this->title) ?></p>

        <div class="clear"></div>
        <div class="content">
            <?= nl2br(Html::encode($message)) ?>
            <br>
            <a href="<?=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:Url::toRoute('site/index')?>">点这里返回</a>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>