<?php

namespace common\models;

use Yii;

use common\models\ModuleAccessControl;

class ModuleActionItem extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'module_action_items';
    }

    public function rules()
    {
        return [
            [['module_id', 'fk_module_action_id', 'action_name'], 'required'],
            [['module_id', 'fk_module_action_id'], 'integer'],
            [['action_name'], 'string', 'max' => 50],
            [['module_action_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModuleAction::className(), 'targetAttribute' => ['module_action_id' => 'action_id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module',
            'module_action_id' => 'Module Action',
            'action_name' => 'Action Name',
        ];
    }

    public function getModule()
    {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }
    
    public function getModuleAction()
    {
        return $this->hasOne(ModuleAction::className(), ['id' => 'module_action_id']);
    }
    
    public function getModuleAccessControl() {
        return $this->hasMany(ModuleAccessControl::className(), ['module_action_item_id' => 'id']);
    }
    
    public function getModuleActionItemsSelected() {
        return $this->hasMany(ModuleAccessControl::className(), ['module_action_item_id' => 'id'])
            ->select(['id', 'role_id', 'module_id', 'module_action_item_id']);
    }
    
}
