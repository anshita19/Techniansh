<?php

namespace common\models;

use Yii;
use \yii2tech\ar\position\PositionBehavior;

use common\components\UsercontrolBehavior;
use common\components\UseripBehavior;
use common\components\UsertimestampBehavior;

use common\models\ModuleActionItem;
use common\models\ModuleAction;
use common\models\ModuleAccessControl;

class Module extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'modules';
    }

    public function behaviors() {
        return [
            UseripBehavior::className(),
            UsercontrolBehavior::className(),
            UsertimestampBehavior::className(),
            'positionBehavior' => [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'sort_order',
            ],
        ];
    }

    public function rules() {
        return [
            [['name', 'controller_name'], 'required'],
            ['sort_order', 'default', 'value' => 1],
            [['sort_order', 'creator_id', 'modifier_id'], 'integer'],
            [['name', 'created_at', 'modified_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['css_class', 'icon'], 'string', 'max' => 50],
            [['creator_ip', 'modifier_ip'], 'string', 'max' => 30],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'css_class' => 'CSS Class',
            'icon' => 'Icon',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'creator_ip' => 'Creator Ip',
            'creator_id' => 'Creator ID',
            'modified_at' => 'Modified At',
            'modifier_ip' => 'Modifier Ip',
            'modifier_id' => 'Modifier ID',
        ];
    }

    public function getModuleActionItems() {
        //return $this->hasMany(ModuleActionItem::className(), ['fk_module_id' => 'module_id'])->joinWith('moduleActionItemsSelected');
        return $this->hasMany(ModuleActionItem::className(), ['module_id' => 'id']);
    }
    
    public function getModuleAccesscontrol() {
        return $this->hasMany(ModuleActionItem::className(), ['id' => 'module_action_item_id'])->select(['id', 'LOWER(action_name) as action_name'])
            ->viaTable(ModuleAccessControl::tableName(), ['module_id' => 'id'], function ($innerSubQuery){
            $innerSubQuery->andOnCondition('module_access_controls.role_id = ' . Yii::$app->user->identity->role_id);
        });
    }
    
    public function getModule() {
        return $this->hasOne(ModuleAction::className(), ['module_id' => 'id']);
    }
    

}
