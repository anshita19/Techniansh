<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

use common\components\UsercontrolBehavior;
use common\components\UseripBehavior;
use common\components\UsertimestampBehavior;

class User extends ActiveRecord implements IdentityInterface {

    const TYPE_Normal = 1;
    const TYPE_Admin = 2;
    
    const STATUS_Pending = 0;
    const STATUS_Active = 1;
    const STATUS_Blocked = 2;
    const STATUS_Suspended = 3;
    const STATUS_Deleted = 4;
    
    public static $typeLabels = [self::TYPE_Normal => 'Normal', self::TYPE_Admin => 'Admin'];
    public static $statusLabels = [self::STATUS_Pending => 'Pending', self::STATUS_Active => 'Active', self::STATUS_Blocked => 'Blocked', self::STATUS_Suspended => 'Suspended', self::STATUS_Deleted => 'Deleted'];

    public static function tableName() {
        return '{{%users}}';
    }

    public function behaviors() {
        return [
            UseripBehavior::className(),
            UsercontrolBehavior::className(),
            UsertimestampBehavior::className(),
        ];
    }

    public function rules() {
        return [
            ['user_type', 'default', 'value' => self::TYPE_Normal],
            ['user_type', 'in', 'range' => [self::TYPE_Normal, self::TYPE_Admin]],
        ];
    }

    public function getName() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'user_status' => self::STATUS_Active]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username) {
        return static::findOne(['username' => $username,
            'user_type' => self::TYPE_Admin,
            'user_status' => self::STATUS_Active
        ]);
    }

    public static function findByEmail($email) {
        return static::findOne(['email' => $email, 'user_status' => self::STATUS_Active]);
    }
    
    public static function findByEmailFront($email) {
        $query = static::find()->where(['email' => $email]);
        return $query->andWhere(['user_type' => self::TYPE_Normal, 'user_status' => self::STATUS_Active])->one();
    }

    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'user_status' => self::STATUS_Active,
        ]);
    }

    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }
}
