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
 * 回访记录模型
 *
 * @author 搬砖工
 * @since 1.0
 */
class RecordLog extends ActiveRecord
{
	public static function tableName()
    {
        return 'tbl_record_log';
    }
}
