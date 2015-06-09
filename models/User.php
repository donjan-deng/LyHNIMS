<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * 用户模型，用于登录，个人更改自己资料，权限验证
 *
 * @author 搬砖工
 * @since 1.0
 */
class User extends ActiveRecord implements IdentityInterface {

    //登录时使用，记住我和验证码
    public $rememberMe = false;
    public $verifyCode;
    //用户更改资料时使用
    public $newPassword; //新密码
    public $verifyNewPassword; //确认用户密码

    public static function tableName() {
        return 'tbl_user';
    }

    public function attributeLabels() {
        return [
            'username' => '用户名',
            'password' => '密码',
            'newPassword' => '新密码',
            'verifyNewPassword' => '确认新密码'
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString(); //自动添加随机auth_key
                $this->password = Yii::$app->security->generatePasswordHash($this->password); //密码加密
                $this->created_at = time();
                $this->updated_at = time();
                $this->enabled = 1;
            }
            return true;
        }
        return false;
    }

    public function rules() {
        return [
            //通用
            [['username', 'password', 'newPassword', 'verifyNewPassword'], 'trim'], //去两端空格
            //登录场景
            [['username', 'password'], 'required', 'on' => 'login'], //必填
            ['verifyCode', 'captcha', 'on' => 'login'], //验证码
            ['password', 'validatePassword', 'on' => 'login'], //调用validatePassword
            ['username', 'string', 'length' => [2, 10], 'on' => 'login'], //长度验证
            ['password', 'string', 'length' => [4, 12], 'on' => 'login'],
            ['rememberMe', 'boolean', 'on' => 'login'], //是否
            //修改资料场景
            [['username', 'password', 'newPassword', 'verifyNewPassword'], 'required', 'on' => 'editprofile'], //必填
            ['username', 'string', 'length' => [2, 10], 'on' => 'editprofile'], //长度验证
            [['password', 'newPassword', 'verifyNewPassword'], 'string', 'length' => [4, 12], 'on' => 'editprofile'], 
            ['verifyNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => '请重复输入新密码', 'on' => 'editprofile'], //newPassword与verifyNewPassword是否相同
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['login'] = ['username', 'password', 'rememberMe', 'verifyCode'];
        $scenarios['editprofile'] = ['password', 'newPassword', 'verifyNewPassword'];
        return $scenarios;
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    //根据用户名查找用户
    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = static::findByUsername($this->username);
            if (!$user || !\Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, '用户名或者密码错误');
            }
            if($user&&$user->enabled==false){
                $this->addError($attribute, '账户已经禁用');
            }
        }
    }

    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login(static::findByUsername($this->username), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    public function editProfile($id) {
        $user = User::findIdentity($id);
        if ($user) {
            if ($this->validate()) {
                if (\Yii::$app->security->validatePassword($this->password, $user->password)) {
                    $user->password = Yii::$app->security->generatePasswordHash($this->newPassword);
                    if ($user->save()) {
                        return true;
                    } else {
                        $this->addError('username', '更新数据出错');
                        return false;
                    }
                } else {
                    $this->addError('password', '旧密码错误');
                    return false;
                }
            } else {
                return false;
            }
        } else {
            $this->addError('username', '未找到该用户');
            return false;
        }
    }

}
