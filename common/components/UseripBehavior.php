<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

use Yii;
use yii\base\InvalidCallException;
use yii\db\BaseActiveRecord;
use yii\base\Behavior;
use yii\web\Request;
use yii\behaviors\AttributeBehavior;

/**
 * UseripBehavior automatically fills the specified attributes with the current user ip address.
 *
 * To use UseripBehavior , insert the following code to your ActiveRecord class:
 *
 * ```php
 * use common\behaviors\UseripBehavior ;
 *
 * public function behaviors()
 * {
 *     return [
 *         UseripBehavior::className(),
 *     ];
 * }
 * ```
 *
 * By default, UseripBehavior  will fill the ip_address attributes with the current user ip address
 * when the associated AR object is being inserted; it will fill the ip_address attribute
 * with the user ip when the AR object is being updated.
 *
 * If your attribute names are different or you want to use a different way of define the ip address,
 * you may configure the [[ip_address]] and [[value]] properties like the following:
 *
 * ```php
 * use yii\db\Expression;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => UseripBehavior::className(),
 *             'ipAddressAttribute' => 'ip_address',
 *             'value' => 'ip_address',
 *         ],
 *     ];
 * }
 * ```
 *
 */
class UseripBehavior extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive ip address value
     * Set this property to false if you do not want to record the current user ip address.
     */
    public $createipAddressAttribute = 'creator_ip';
    public $modifieripAddressAttribute = 'modifier_ip';
    
    public $value;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->createipAddressAttribute,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->modifieripAddressAttribute,
            ];
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($value=NULL)
    {
        if (isset($this->value)) {
            return $this->value;
        } else {
            return Yii::$app->request->getUserIP();
        }
    }

}
