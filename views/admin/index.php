<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use app\assets\SystemAsset;
SystemAsset::register($this);
$this->title = '后台首页';
$this->params['breadcrumbs'][] = 'Dashboard';
?>
<div class=" row">
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a  class="well top-block">
            <i class="glyphicon glyphicon-comment blue"></i>
            <div>昨日总咨询</div>
            <div><?= $count[0] ?></div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="well top-block">
            <i class="glyphicon glyphicon-star-empty green"></i>
            <div>有效咨询</div>
            <div><?= $count[1] ?></div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="well top-block">
            <i class="glyphicon glyphicon-star yellow"></i>
            <div>预约</div>
            <div><?= $count[2] ?></div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="well top-block">
            <i class="glyphicon glyphicon-user red"></i>
            <div>到院</div>
            <div><?= $count[3] ?></div>
        </a>
    </div>
</div>
<div class="row">
    <div class="box col-md-4">
        <div class="box-inner homepage-box">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-th"></i>服务器信息</h2>
            </div>
            <div class="box-content">
                <div class="list-group">
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">系统类型</h4>
                        <p class="list-group-item-text"><?= php_uname() ?></p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">解译引擎</h4>
                        <p class="list-group-item-text"><?= $_SERVER['SERVER_SOFTWARE'] ?>，Zend：<?= Zend_Version() ?></p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">数据库</h4>
                        <p class="list-group-item-text">MySql:<?= (new yii\db\Query())->select('VERSION()')->one()['VERSION()'] ?></p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">服务器</h4>
                        <p class="list-group-item-text">服务器IP：<?= GetHostByName($_SERVER['SERVER_NAME']) ?></p>
                        <p class="list-group-item-text">程序目录：<?= Yii::$app->BasePath ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-user"></i>程序信息</h2>
            </div>
            <div class="box-content">
                <p><b>程序名称：</b>领域医院网络信息管理系统</p>
                <p><b>当前版本：</b><?= Yii::$app->params['version'] ?></p>
                <p><b>最新版本：</b><span id="newVersion"></span></p>
                <p><b>核心框架：</b><a href="http://www.yiiframework.com/" target="_blank">Yii PHP Framework</a></p>
                <p><b>前端模板：</b><a href="https://github.com/usmanhalalit/charisma" target="_blank">Charisma</a></p>
                <p><b>程序开发：</b><a href="http://www.lyapp.com" target="_blank">领域工作室</a></p>
                <p><b>开源地址：</b><a href="http://www.lyapp.com" target="_blank">GitHub</a></p>
                <p><b>版权所有：</b>该源码仅供个人学习研究等非商业用途使用，领域工作室保留该源码的所有权利，企业、公司、政府、组织必须购买授权方能用于商业用途。</p>
            </div>
        </div>
    </div>
    <div class="box col-md-4">
        <div class="box-inner homepage-box">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-list-alt"></i>赞助商链接</h2>
            </div>
            <div class="box-content">
                <h3>Charisma is Open Source</h3>
                <a class="btn btn-default center-block col-md-6" title="GitHub"
                   href="https://github.com/usmanhalalit/charisma" target="_blank"><i class="icon-edit"></i> View on
                    GitHub</a>

                <div class="clearfix"></div>
                <br>
                <ul class="github-buttons center-block">
                    <li>
                        <iframe
                            src="http://ghbtns.com/github-btn.html?user=usmanhalalit&amp;repo=charisma&amp;type=watch&amp;count=true"
                            height="20" width="100" frameborder="0" scrolling="0"></iframe>
                    </li>
                    <li>
                        <iframe
                            src="http://ghbtns.com/github-btn.html?user=usmanhalalit&amp;repo=charisma&amp;type=fork&amp;count=true"
                            height="20" width="98" frameborder="0" scrolling="0"></iframe>
                    </li>
                </ul>
                <div class="clearfix"></div>

                <div class="donate">
                    <div>
                        <small>Help development of Charisma</small>
                    </div>
                    <a class="btn btn-default" href="http://flattr.com/thing/1507720/usmanhalalitcharisma-on-GitHub"
                       target="_blank"><i class="glyphicon glyphicon-usd green"></i> Donate</a>
                </div>
                <br/>

                <p>You may like my other open source work, check my profile on <a href="http://github.com/usmanhalalit"
                                                                                  target="_blank">GitHub</a>.</p>

            </div>
        </div>
    </div>
    <!--/span-->
</div><!--/row-->