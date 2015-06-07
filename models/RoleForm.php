<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
namespace app\models;

use Yii;
use yii\base\Model;
/**
 * 角色模型
 *
 * @author 搬砖工
 * @since 1.0
 */
class RoleForm extends Model
{
    public $name;
    public $permissions;
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'trim'],
            ['permissions', 'required'],
            ['permissions', 'validatePermissions'],
            ['name', 'string', 'length' => [2, 8]],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => '角色名称',
            'permissions' => '分配权限',
        ];
    }
    public function validatePermissions($attribute, $params) {
        if (!$this->hasErrors()) {
            if (!isset($this->permissions)) {
                $this->addError($attribute, '至少选择一个权限');
            }
        }
    }
}
