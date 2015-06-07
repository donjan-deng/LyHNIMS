<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = '用户报表';
?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>用户报表</h2>
            </div>
            <div class="box-create">
                <?php
                $form = ActiveForm::begin([
                            'id' => 'report-form',
                            'action' => Url::toRoute('report/userreport'),
                            'options' => ['class' => 'form-horizontal'],
                ]);
                ?>
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-1">时间选择</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="startdate" readonly="readonly">
                    </div>
                    <label class="control-label col-md-1">到</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="enddate" readonly="readonly">
                    </div>
                    <div class="col-md-1">
                        <a rel='setDate' data-date='1' href="javascript:void(0);" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-calendar"></i><span>昨天</span></a>
                    </div>
                    <div class="col-md-1">
                        <a rel='setDate' data-date='2' href="javascript:void(0);" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-calendar"></i><span>最近7天</span></a>
                    </div>
                    <div class="col-md-1">
                        <a rel='setDate' data-date='3' href="javascript:void(0);" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-calendar"></i><span>本月</span></a>
                    </div>
                    <div class="col-md-1">
                        <a rel='setDate' data-date='4' href="javascript:void(0);" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-calendar"></i><span>上个月</span></a>
                    </div>
                    <div class="col-md-1">
                        <a href="javascript:void(0);" onclick="getReport()" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-plus-sign"></i><span>查看报表</span></a>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="box-content">
            </div>
        </div>
    </div>
    <?php
    $js = <<<JS
    $(function(){
        customDatepicker($("#report-form input[name='startdate']"),$("#report-form input[name='enddate']"));
        $("a[rel='setDate']").click(function(){
                var startDate,endDate;
                var today=new Date();
                switch($(this).data("date")){
                    case 2://最近7天
                        var start=end=new Date();
                        startDate=new Date(Date.parse(today)-(86400000 * 7)).format('yyyy-MM-dd');
                        endDate=new Date(Date.parse(today)-(86400000 * 1)).format('yyyy-MM-dd');
                        break;
                    case 3://本月
                        startDate=new Date(today.getFullYear(),today.getMonth(),01).format('yyyy-MM-dd');
                        endDate=new Date(today.getFullYear(),today.getMonth(),today.getDate()-1).format('yyyy-MM-dd');
                        break;
                    case 4://上个月
                        startDate=new Date(today.getFullYear(),today.getMonth()-1,01).format('yyyy-MM-dd');
                        endDate=new Date(today.getFullYear(),today.getMonth(),0).format('yyyy-MM-dd');
                        break;
                    default:
                        startDate=endDate=new Date(Date.parse(today)-(86400000 * 1)).format('yyyy-MM-dd');//默认昨天
                        break;
                }
                $("#report-form input[name='startdate']").datepicker( "setDate", startDate );
                $("#report-form input[name='enddate']").datepicker( "setDate", endDate );
        });
   });
   //获得列表
   window.getReport=function(){
       $.ajax({
        url: $("#report-form").attr('action'),
        data:$("#report-form").serialize(),
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
JS;
    $this->registerJs($js);
    ?>