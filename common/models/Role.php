<?php

namespace common\models;

use Yii;

use common\components\UsercontrolBehavior;
use common\components\UseripBehavior;
use common\components\UsertimestampBehavior;

class Role extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'roles';
    }

    public function behaviors() {
        return [
            UseripBehavior::className(),
            UsercontrolBehavior::className(),
            UsertimestampBehavior::className(),
        ];
    }

    public function getGroupnameLowercase() {
        return strtolower($this->group_name);
    }

    public function rules() {
        return [
            [['title'], 'required'],
            ['title', 'unique', 'targetAttribute' => ['titleLowercase' => 'lower(title)']],
            [['created_at', 'modified_at'], 'safe'],
            [['creator_id', 'modifier_id'], 'integer'],
            [['title'], 'string', 'min' => 3, 'max' => 100],
            [['creator_ip', 'modifier_ip'], 'string', 'max' => 30],
//            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
//            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modifier_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'created_at' => 'Created At',
            'creator_ip' => 'Creator Ip',
            'creator_id' => 'Creator ID',
            'modified_at' => 'Modified At',
            'modifier_ip' => 'Modifier Ip',
            'modifier_id' => 'Modifier ID',
        ];
    }
    
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    public function getModifier()
    {
        return $this->hasOne(User::className(), ['id' => 'modifier_id']);
    }
}
