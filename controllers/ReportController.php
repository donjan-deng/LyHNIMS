<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Record;
use app\models\Channel;
use app\models\ChannelCost;
use app\models\User;
use yii\helpers\ArrayHelper;
/**
 * 报表控制器。
 *
 * @author 搬砖工
 * @since 1.0
 */
class ReportController extends CommonController {
    
    public function actionChannel() {
        return $this->render('channel');
    }
    public function actionChannelreport(){
        $listChannel=Channel::find()->where('enabled<>0')->asArray()->all();
        $startDate=strtotime(Yii::$app->request->get('startdate') . ' 00:00:00');
        $endDate=strtotime(Yii::$app->request->get('enddate') . ' 23:59:59');
        for($i=0;$i<count($listChannel);$i++){
            $baseQuery=  Record::find()->andWhere(['channel_id'=>$listChannel[$i]['id']]);
            $baseQuery->andWhere(['>','created_at',$startDate]);
            $baseQuery->andWhere(['<','created_at',$endDate]);
            $tempQuery=  clone $baseQuery;
            $listChannel[$i]['total']=$tempQuery->count();
            $tempQuery=  clone $baseQuery;
            $listChannel[$i]['validcount']=$tempQuery->andWhere(['is_valid'=>1])->count();
            $tempQuery=  clone $baseQuery;
            $listChannel[$i]['reservecount']=$tempQuery->andWhere(['is_reserve'=>1])->count();
            $tempQuery=  clone $baseQuery;
            $listChannel[$i]['arrivedcount']=$tempQuery->andWhere(['is_arrive'=>1])->count();
            //消费
            $totalCost=0;
            $cost=  ChannelCost::find()->where('startdate>=:startdate and enddate<=:enddate and channel_id=:channel_id',[':startdate'=>$startDate,':enddate'=>$endDate,':channel_id'=>$listChannel[$i]['id']])->sum('fee');
            $totalCost+=$cost;
            //后开始还未到结束日期的费用
            $channelCost=ChannelCost::find()->where('startdate>=:startdate and enddate>:enddate and channel_id=:channel_id',[':startdate'=>$startDate,':enddate'=>$endDate,':channel_id'=>$listChannel[$i]['id']])->all();
            foreach ($channelCost as $tmpCost){
                $days=  ceil(($tmpCost['enddate']-$tmpCost['startdate'])/86400);
                $avgCost=  $tmpCost['fee']/$days;//平均每天费用
                $days=  ceil(($endDate-$tmpCost['startdate'])/86400);
                $cost=  round($avgCost*$days,2);
                $totalCost+=$cost;
            }
            //先开始提前结束的费用
            $channelCost=ChannelCost::find()->where('startdate<:startdate and enddate<=:enddate and channel_id=:channel_id',[':startdate'=>$startDate,':enddate'=>$endDate,':channel_id'=>$listChannel[$i]['id']])->all();
            foreach ($channelCost as $tmpCost){
                $days=  ceil(($tmpCost['enddate']-$tmpCost['startdate'])/86400);
                $avgCost=  $tmpCost['fee']/$days;
                $days=  ceil(($tmpCost['enddate']-$startDate)/86400);
                $cost=  round($avgCost*$days,2);
                $totalCost+=$cost;
            }
            //提前开始还未结束的费用
            $channelCost=ChannelCost::find()->where('startdate<:startdate and enddate>:enddate and channel_id=:channel_id',[':startdate'=>$startDate,':enddate'=>$endDate,':channel_id'=>$listChannel[$i]['id']])->all();
            foreach ($channelCost as $tmpCost){
                $days=  ceil(($tmpCost['enddate']-$tmpCost['startdate'])/86400);
                $avgCost=  $tmpCost['fee']/$days;
                $days=  ceil(($endDate-$startDate)/86400);
                $cost=  round($avgCost*$days,2);
                $totalCost+=$cost;
            }
            $listChannel[$i]['cost']=$totalCost;
        }
        return $this->renderPartial('channelreport',['model'=>$listChannel]);
    }
    public function actionUser() {
        return $this->render('user');
    }
    public function actionUserreport(){
        $ids=  ArrayHelper::getColumn(Record::find()->select('user_id')->where('is_reserve=1')->distinct()->all(), 'user_id');
        $model=  User::find()->select(['id','username'])->andWhere(['in','id',$ids])->asArray()->all();
        $startDate=strtotime(Yii::$app->request->get('startdate') . ' 00:00:00');
        $endDate=strtotime(Yii::$app->request->get('enddate') . ' 23:59:59');
         for($i=0;$i<count($model);$i++){
             $baseQuery=  Record::find()->andWhere(['user_id'=>$model[$i]['id']]);
             $tempQuery=  clone $baseQuery;
             $model[$i]['reservecount']=$tempQuery->andWhere(['>','created_at',$startDate])->andWhere(['<','created_at',$endDate])->andWhere(['is_reserve'=>1])->count();
             $tempQuery=  clone $baseQuery;
             $model[$i]['arrivedcount']=$tempQuery->andWhere(['>','arrived_at',$startDate])->andWhere(['<','arrived_at',$endDate])->andWhere(['is_arrive'=>1])->count();
         }
        return $this->renderPartial('userreport',['model'=>$model]);
    }
}
