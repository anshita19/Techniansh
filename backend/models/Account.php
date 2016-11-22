<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

use common\models\User;
use common\models\UserMacAddress;

class Account extends \yii\db\ActiveRecord {

    public $password_repeat;
    
    public static function tableName() {
        return 'users';
    }

    public function rules() {
        return [
            [['first_name', 'last_name', 'password_repeat', 'user_status', 'user_type'], 'required', 'on' => 'insert'],
            [['first_name', 'last_name', 'user_status', 'user_type'], 'required', 'on' => 'update'],
            ['mobile', 'default', 'value' => null],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User',
                'filter' =>
                ['!=', 'id', $this->attributes['id']],
                'message' => 'This email address has already been taken.'],
            ['mobile', '\common\validators\MobileValidator', 'message' => 'Invalid mobile number.'],
            ['mobile', 'unique', 'targetClass' => '\common\models\User',
                'filter' =>
                ['!=', 'id', $this->attributes['id']],
                'message' => 'This mobile number has already been taken.'],
            ['password_hash', 'required', 'message' => 'Password can not be blank.', 'on' => 'insert'],
            ['password_hash', 'string', 'min' => 6, 'message' => 'Password should contain at least 6 characters.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password_hash'],
            ['password_repeat', 'validatePasswordRepeat', 'skipOnEmpty' => false, 'on' => 'update'],
            [['user_status', 'user_type'], 'safe']
        ];
    }

    public function validatePasswordRepeat() {
        if ($this->password_hash && !$this->password_repeat) {
            $this->addError('password_repeat', 'Retype password can not be blank');
            return false;
        }
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'user_status' => 'Status',
            'user_type' => 'User Type',
            'password_hash' => 'Password',
            'password_repeat' => 'Confirm Password',
            'mac_address' => 'MAC Address',
        ];
    }

    public function register($id = 0) {
        if (!empty($id)) {
            $user = User::findOne($id);
        } else {
            $user = new User();
            $user->auth_key = Yii::$app->security->generateRandomString();
        }

        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        if ($this->password_repeat) {
            $user->setPassword($this->password_repeat);
        }
        $user->mobile = $this->mobile;
        $user->user_status = $this->user_status;
        $user->user_type = $this->user_type;
        if ($user->save()) {
            return $user;
        } else {
            return null;
        }
    }

}
