<?php

namespace frontend\widgets\signup\models;

use yii;
use yii\base\Model;
use common\models\User;
use yii\base\InvalidParamException;
use yii\db\Expression;

/**
 * Signup form
 */
class Signup extends Model {

    public $email;
    public $first_name;
    public $last_name;
    public $is_agree;
    public $password_hash;
    public $password_repeat;
    public $auth_key;
    public $ua_auth_key;
    public $uc_auth_key;
    public $address1;
    public $address2;
    public $phone;
    public $services;
    public $city;
    public $state;
    public $reCaptcha;
    public $verifyCode;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /* ['username', 'filter', 'filter' => 'trim'],
              ['username', 'required'],
              ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
              ['username', 'string', 'min' => 2, 'max' => 255], */

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            //['mobile', 'match', 'pattern' => '/^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$/', 'message' => 'Invalid mobile number.'],
            //['mobile', 'mobile', 'message' => 'Invalid mobile number.'],
            //['mobile', '\common\validators\MobileValidator', 'message' => 'Invalid mobile number.'],
            //['mobile', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This mobile number has already been taken.'],
            ['is_agree', 'compare', 'compareValue' => true, 'message' => 'You must agree to the terms and conditions.'],
            //[['is_owner', 'is_system_integrator'], 'validateUserType'],
            ['password_hash', 'required', 'message' => 'Password can not be blank.'],
            ['password_hash', 'string', 'min' => 6, 'message' => 'Password should contain at least 6 characters.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password_hash'],
            ['auth_key', 'safe'],
            [['first_name', 'last_name','is_agree','services', 'password_repeat'], 'required'],
            //[['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6LcO8wgUAAAAALT0aXQ75xKzyI1acztl5KCjiWXX']
            ['verifyCode', 'captcha'],
        ];
    }

    public function validateUserType($attribute) {

        if ($this->is_owner == 'N' && $this->is_system_integrator == 'N') {
            $this->addError('is_owner', 'You must select atlest one user type.');
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'password_hash' => 'Password',
            'password_repeat' => 'Confirm Password',
            'is_agree' => 'I agree to terms and conditions',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

    public function register() {

        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->address1=$this->address1;
        $user->address2=$this->address2;
        $user->city=$this->city;
        $user->state=$this->state;
        $user->setPassword($this->password_repeat);
        $user->phone = $this->phone;
        $user->services = implode(',',$this->services);
        $user->user_status= User::STATUS_Pending;
        $user->user_type= User::TYPE_Normal;
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->ua_auth_key = Yii::$app->security->generateRandomString();
        $user->uc_auth_key = Yii::$app->security->generateRandomString();
        
        return $user->save() ? $user : null;
    }

    public function sendRegisterEmail($user) {

        return Yii::$app
                        ->mailer
                        ->compose(
                                ['html' => 'registrationEmail-html'], ['user' => $user]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                        ->setTo($user->email)
                        ->setSubject('Registration activation for ' . Yii::$app->name)
                        ->send();
    }

    public function getActiveAccount($token) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Account activation token cannot be blank.');
        }
        $this->_user = User::findOne([
                    'ua_auth_key' => $token,
                    'user_status' => User::STATUS_Pending,
        ]);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong activation token.');
        } else {
            $user = $this->_user;
            $user->ua_auth_key = null;
            $user->uc_auth_key = null;
            $user->user_status = User::STATUS_Active;
            return $user->save(false);
        }
    }

    public function getCancelAccount($token) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Registration cancelation token cannot be blank.');
        }
        $this->_user = User::findOne([
                    'uc_auth_key' => $token,
                    'user_status' => User::STATUS_Pending,
        ]);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong cancelation token.');
        } else {
            $user = $this->_user;
            return $user->delete();
        }
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email) {
        return Yii::$app->mailer->compose()
                        ->setTo($email)
                        ->setFrom([$this->email => $this->name])
                        ->setSubject($this->subject)
                        ->setTextBody($this->body)
                        ->send();
    }

}
