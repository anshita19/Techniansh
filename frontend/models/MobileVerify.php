<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use yii;
use yii\base\Model;
use common\models\User;
use yii\base\InvalidParamException;

/**
 * Mobile Verify
 */
class MobileVerify extends Model {

    public $mobile;
    private $_clients;
    public $is_owner;
    public $is_system_integrator;
    public $is_agree;

    public function setClients($clients) {
        $this->_clients = $clients;
    }

    /**
     * @return ClientInterface[] auth providers
     */
    public function getClients() {
        if ($this->_clients === null) {
            $this->_clients = $this->defaultClients();
        }

        return $this->_clients;
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['mobile', '\common\validators\MobileValidator', 'message' => 'Invalid mobile number. Allowed types are only US numbers'],
            ['mobile', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This mobile number has already been taken.'],
            ['mobile', 'required'],
            [['is_owner', 'is_system_integrator'], 'validateUserType'],
            ['is_agree', 'compare', 'compareValue' => true, 'message' => 'You must agree to the terms and conditions.'],
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
            'is_owner' => 'Owner',
            'is_system_integrator' => 'System Integrator',
            'is_agree' => 'I agree to terms and conditions',
        ];
    }

    public function sendSocialRegisterEmail($user) {

        return Yii::$app
                        ->mailer
                        ->compose(
                                ['html' => 'socialregistrationEmail-html'], ['user' => $user]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                        ->setTo($user->email)
                        ->setSubject('Thank you for Your Register in ' . Yii::$app->name)
                        ->send();
    }

}
