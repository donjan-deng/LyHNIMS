<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * 渠道消费模型
 *
 * @author 搬砖工
 * @since 1.0
 */
class ChannelCost extends ActiveRecord {

    public static function tableName() {
        return 'tbl_channel_cost';
    }

    public function attributeLabels() {
        return [
            'channel_id' => '渠道',
            'startdate' => '开始时间',
            'enddate' => '结束时间',
            'fee' => '费用'
        ];
    }

    public function rules() {
        return [
            [['fee', 'enddate', 'startdate'], 'trim'],
            [['channel_id', 'fee', 'enddate', 'startdate'], 'required'],
            ['fee', 'double'],
            ['startdate', 'filter', 'filter' => function($value) {
                    return strtotime($value . ' 00:00:00'); //格式化时间字符串
                }],
            ['enddate', 'filter', 'filter' => function($value) {
                    return strtotime($value . ' 23:59:59');
                }],
        ];
    }
    public function getChannel() {
        return $this->hasOne(Channel::className(), ['id' => 'channel_id']);
    }
}
