<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="navbar navbar-default" role="navigation">
            <div class="navbar-inner">
                <button type="button" class="navbar-toggle pull-left animated flip">
                    <span class="sr-only">展开</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"> <img src="<?= Url::to('@web/img/logo20.png') ?>" class="hidden-xs"/>
                    <span><?= Yii::$app->params['Hospital'] ?></span></a>
                <!-- user dropdown starts -->
                <div class="btn-group pull-right">
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="<?=  Url::toRoute('admin/profile')?>">更改资料</a></li>
                        <li class="divider"></li>
                        <li><a href="<?= Url::toRoute('site/logout') ?>">注销</a></li>
                    </ul>
                </div>
                <!-- user dropdown ends -->
            </div>
        </div>
        <!-- topbar ends -->
        <div class="ch-container">
            <div class="row">
                <!-- left menu starts -->
                <div class="col-sm-2 col-lg-2">
                    <div class="sidebar-nav">
                        <div class="nav-canvas">
                            <div class="nav-sm nav nav-stacked">

                            </div>
                            <ul class="nav nav-pills nav-stacked main-menu">
                                <li class="nav-header">管理导航</li>
                                <li><a class="ajax-link" href="<?=  Url::toRoute('admin/index')?>"><i class="glyphicon glyphicon-home"></i><span>后台首页</span></a>
                                </li>
                                <?php if(Yii::$app->user->can('Record')){?>
                                <li class="accordion">
                                    
                                    <a href="#"><i class="glyphicon glyphicon-plus"></i><span>患者管理</span></a>
                                    
                                    <ul class="nav nav-pills nav-stacked">
                                        <?php if(Yii::$app->user->can('record/index')){?>
                                        <li><a href="<?= Url::toRoute('record/index')?>">对话管理</a></li>
                                        <?php }?>
                                        <?php if(Yii::$app->user->can('record/appointment')){?>
                                        <li><a href="<?= Url::toRoute('record/appointment')?>">预约管理</a></li>
                                        <?php }?>
                                    </ul>
                                </li>
                                <?php }?>
                                 <?php if(Yii::$app->user->can('Channel')){?>
                                <li class="accordion">
                                    <a href="#"><i class="glyphicon glyphicon-magnet"></i><span>渠道管理</span></a>
                                    <ul class="nav nav-pills nav-stacked">
                                        <?php if(Yii::$app->user->can('channel/index')){?>
                                        <li><a href="<?= Url::toRoute('channel/index')?>">渠道管理</a></li>
                                        <?php }?>
                                        <?php if(Yii::$app->user->can('channel/cost')){?>
                                        <li><a href="<?= Url::toRoute('channel/cost')?>">渠道消费</a></li>
                                        <?php }?>
                                    </ul>
                                </li>
                                <?php }?>
                                <?php if(Yii::$app->user->can('department/index')){?>
                                <li><a class="ajax-link" href="<?= Url::toRoute('department/index')?>"><i class="glyphicon glyphicon-list"></i><span>科室管理</span></a>
                                </li>
                                <?php }?>
                                <?php if(Yii::$app->user->can('doctor/index')){?>
                                <li><a class="ajax-link" href="<?= Url::toRoute('doctor/index')?>"><i class="glyphicon glyphicon-user"></i><span>医生管理</span></a>
                                </li>
                                <?php }?>
                                <?php if(Yii::$app->user->can('Report')){?>
                                <li class="accordion"><a href="#"><i class="glyphicon glyphicon-signal"></i><span>统计报表</span></a>
                                    <ul class="nav nav-pills nav-stacked">
                                        <?php if(Yii::$app->user->can('report/channel')){?>
                                        <li><a href="<?= Url::toRoute('report/channel')?>">渠道报表</a></li>
                                        <?php }?>
                                        <?php if(Yii::$app->user->can('report/user')){?>
                                        <li><a href="<?= Url::toRoute('report/user')?>">用户报表</a></li>
                                        <?php }?>
                                    </ul>
                                </li>
                                <?php }?>
                                <?php if(Yii::$app->user->can('User')){?>
                                <li class="accordion">
                                    <a href="#"><i class="glyphicon glyphicon-cog"></i><span>权限管理</span></a>
                                    <ul class="nav nav-pills nav-stacked">
                                        <?php if(Yii::$app->user->can('user/index')){?>
                                        <li><a href="<?= Url::toRoute('user/index')?>">用户管理</a></li>
                                        <?php }?>
                                        <?php if(Yii::$app->user->can('user/role')){?>
                                        <li><a href="<?= Url::toRoute('user/role')?>">角色管理</a></li>
                                        <?php }?>
                                    </ul>
                                </li>
                                <?php }?>
                        </div>
                    </div>
                </div>
                <!--/span-->
                <!-- left menu ends -->
                <div id="content" class="col-lg-10 col-sm-10" style="min-height: 500px;">
                    <!-- content starts -->
                    <?= $content ?>
                    <!-- content ends -->
                </div><!--/#content.col-md-0-->
            </div><!--/fluid-row-->
            <hr>
            <footer class="row">
                <p class="col-md-9 col-sm-9 col-xs-12 copyright">Powered by: 领域医院网络信息管理系统 V<?=  Yii::$app->params['version']?>  &copy; <a href="http://www.lyapp.com" target="_blank">领域工作室</a> 2014 - <?=date('Y')?></p>
            </footer>
        </div><!--/.fluid-container-->
<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
