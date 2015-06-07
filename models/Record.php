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
 * 患者记录模型，对话，预约，到院等
 *
 * @author 搬砖工
 * @since 1.0
 */
class Record extends ActiveRecord {

    public static function tableName() {
        return 'tbl_record';
    }
    public function attributeLabels() {
        return [
            'name' => '姓名',
            'phone' => '电话',
            'department_id' => '科室',
            'appointment' => '预约时间',
            'doctor_id' => '预约医生',
            'note' => '备注',
            'is_valid' => '有效咨询',
            'is_reserve' => '预约',
            'channel_id' => '渠道',
            'channel_note' => '渠道备注',
        ];
    }

    public function rules() {
        return [
            [['name', 'note', 'channel_note'], 'trim'],
            ['name', 'string', 'length' => [2, 8]],
            ['phone', 'string', 'length' => [6, 11]],
            [['department_id', 'doctor_id', 'user_id', 'channel_id'], 'number'],
            [['is_valid', 'is_reserve', 'is_arrive'], 'boolean'],
            ['doctor_id', 'default', 'value' => 0], //医生默认不指定
            ['created_at', 'default', 'value' => time()], //添加时间
            ['user_id', 'default', 'value' => Yii::$app->user->identity->id], //操作用户
            ['appointment', 'filter', 'filter' => function($value) {
                    if (empty($value)&&strtotime($value)===false) {
                        return 0;
                    } else {
                        return strtotime($value);
                    }
                }], //格式化时间字符串
        ];
    }

    public function getRecordLog() {
        return $this->hasMany(RecordLog::className(), ['record_id' => 'id']);
    }

    public function getChannel() {
        return $this->hasOne(Channel::className(), ['id' => 'channel_id']);
    }

    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    public function getDoctor() {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
