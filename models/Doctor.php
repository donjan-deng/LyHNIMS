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
 * 医生模型
 *
 * @author 搬砖工
 * @since 1.0
 */
class Doctor extends ActiveRecord {

    public static function tableName() {
        return 'tbl_doctor';
    }

    public function attributeLabels() {
        return [
            'name' => '医生姓名'
        ];
    }

    public function rules() {
        return [
            ['name', 'trim'], //去两端空格
            ['name', 'required'], //必填
            ['name', 'unique'], //唯一
            ['name', 'string', 'length' => [2, 8]], //长度验证
            ['enabled', 'boolean'], //是否
        ];
    }

}
