<?php

namespace common\models;

use Yii;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;

use common\models\Role;
use common\models\Module;
use common\models\ModuleAction;
use common\models\ModuleActionItem;

class ModuleAccessControl extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'module_access_controls';
    }

    public function getModule_access_control_id() {
        return $this->role_id;
    }

    public function rules() {
        return [
            [['role_id'], 'required'],
            //['module_action_item_id', 'string', 'min' => 1, 'skipOnEmpty' => false, 'message' => 'You should select at least one'],
            [['module_action_item_id'], 'required', 'whenClient' => new JsExpression("
                    function (attribute, value) {
                        return $('#module_action_container').find('input[type=checkbox]:checked').length == 0;
                    }
            "), 'message' => 'Please Select at least one action'],
            [['module_id', 'role_id', 'creator_id', 'modifier_id'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['creator_ip', 'modifier_ip'], 'string', 'max' => 30],
            //[['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
            //[['module_action_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModuleActionItem::className(), 'targetAttribute' => ['module_action_item_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'module_id' => 'Module',
            'role_id' => 'Role',
            'module_action_item_id' => 'Module Action Item',
            'created_at' => 'Created At',
            'creator_ip' => 'Creator Ip',
            'creator_id' => 'Creator ID',
            'modified_at' => 'Modified At',
            'modifier_ip' => 'Modifier Ip',
            'modifier_id' => 'Modifier ID',
        ];
    }

    public function getModule() {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }

    public function getModuleActionItem() {
        return $this->hasOne(ModuleActionItem::className(), ['id' => 'module_action_item_id']);
    }

    public function getModuleAccessControlList($id = 0) {
        $query = Module::find()
            ->joinWith(['moduleActionItems'])
            ->where('module_action_items.module_id IS NOT NULL')
            ->asArray()->all();
        return $query;
    }
    
    public function getRoleCmb($role_id='') {
        $whereclaues=(!empty($role_id))?' and roles.id NOT IN('.$role_id.')':'';
        $userGroup = Role::find()
            ->select(['roles.id as id', 'title'])
            ->where('module_access_controls.role_id IS NULL')
            ->join('LEFT OUTER JOIN', 'module_access_controls', 'roles.id = module_access_controls.role_id' . $whereclaues)
            ->all();                
        $listData = ArrayHelper::map($userGroup, 'id', 'title');
        return $listData;
    }

}
