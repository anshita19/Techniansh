<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\helpers\Json;
use yii\helpers\Html;

use common\components\UsercontrolBehavior;
use common\components\UseripBehavior;
use common\components\UsertimestampBehavior;

use common\models\Module;
use common\models\ModuleActionItem;

class ModuleAction extends \yii\db\ActiveRecord {

    public $action_name;

    public static function tableName() {
        return 'module_actions';
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
            [['module_id', 'action_name'], 'required'],
            [['module_id', 'creator_id', 'modifier_id'], 'integer'],
            [['created_at', 'modified_at', 'action_name'], 'safe'],
            [['creator_ip', 'modifier_ip'], 'string', 'max' => 30],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'module_id' => 'Module',
            'action_name' => 'Action',
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

    public function getModuleActionItems() {
        return $this->hasMany(ModuleActionItem::className(), ['module_action_id' => 'id']);
    }

    public function getModuleCmb() {

        $moduleModel = Module::find()->joinWith(['module']);
        if ($this->isNewRecord) $moduleModel->where('module_id IS NULL');
        
        $moduleArr = $moduleModel->all();
        $listData = [];
        if ($moduleArr) {
            $listData = ArrayHelper::map($moduleArr, 'id', 'name');
        }
        return $listData;
    }

    public function getControllerActionCheckboxList($id = 0) {
        $moduleModel = Module::findOne($id);
        if (!empty($moduleModel)) {
            $actionArr = Yii::$app->metadata->getActions($moduleModel->controller_name);
            if(empty($actionArr)){
                return 'There is not controller found for specifid name. Please correct the name of specified controller and try again.';
            }
            $controllerNameArr = [];
            foreach ($actionArr as $key => $value) {
                $controllerNameArr[$key]['id'] = $value;
                $controllerNameArr[$key]['name'] = $value;
            }
            $actionArr = ArrayHelper::map($controllerNameArr, 'id', 'name');
            if (Yii::$app->request->isAjax) {
                $html='';
                foreach ($actionArr as $key => $value) {
                    $html .= '<div class="checkbox"><label><span><input class="styled" name="ModuleAction[action_name][]" value="' . $value . '" type="checkbox"></span>' . $key . '</label></div>';
                }
                return $html;
                /* echo Html::activeCheckboxList($this, 'action_name', $actionArr,['itemOptions' => ['class' => 'styled'],'checkboxTemplate'=>'<div class="form-group">{label}<div class="choice"><span class="checked">{input}</span></div>{error}</div>']); */
            } else {
                return $actionArr;
            }
        } 
        return [];
    }

}
