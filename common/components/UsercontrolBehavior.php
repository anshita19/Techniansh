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
 * UsercontrolBehavior automatically fills the specified attributes with the current user ip address,modified date and modified user.
 *
 * To use UsercontrolBehavior , insert the following code to your ActiveRecord class:
 *
 * ```php
 * use common\behaviors\UsercontrolBehavior ;
 *
 * public function behaviors()
 * {
 *     return [
 *         UsercontrolBehavior::className(),
 *     ];
 * }
 * ```
 *
 * By default, UsercontrolBehavior  will fill the ip_address attributes with the current userid
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
 *             'class' => UsercontrolBehavior::className(),
 *             'createdByAttribute' => 'author_id',
 *             'updatedByAttribute' => 'updater_id',
 *         ],
 *     ];
 * }
 * ```
 *
 */
class UsercontrolBehavior extends AttributeBehavior {
    /**
     * @var string the attribute that will receive current user ID value
     * Set this property to false if you do not want to record the creator ID.
     */
    public $createdByAttribute = 'creator_id';
    /**
     * @var string the attribute that will receive current user ID value
     * Set this property to false if you do not want to record the updater ID.
     */
    public $updatedByAttribute = 'modifier_id';
    /**
     * @inheritdoc
     *
     * In case, when the property is `null`, the value of `Yii::$app->user->id` will be used as the value.
     */
    public $value;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->createdByAttribute,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedByAttribute,
            ];
        }
    }

    /**
     * @inheritdoc
     *
     * In case, when the [[value]] property is `null`, the value of `Yii::$app->user->id` will be used as the value.
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            $user = Yii::$app->get('user', false);
            return $user && !$user->isGuest ? $user->id : null;
        }

        return parent::getValue($event);
    }
}