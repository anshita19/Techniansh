<?php

namespace common\models;

use Yii;
use common\components\UsercontrolBehavior;
use common\components\UseripBehavior;
use common\components\UsertimestampBehavior;

/**
 * This is the model class for table "user_group".
 *
 * @property integer $user_group_id
 * @property string $group_name
 * @property string $created_at
 * @property string $creator_ip
 * @property integer $creator_id
 * @property string $modified_at
 * @property string $modifier_ip
 * @property integer $modifier_id
 */
class UserGroup extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_group';
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['group_name'], 'required'],
            ['group_name', 'unique', 'targetAttribute' => ['groupnameLowercase' => 'lower(group_name)']],
            [['created_at', 'modified_at'], 'safe'],
            [['creator_id', 'modifier_id'], 'integer'],
            [['group_name'], 'string', 'max' => 50],
            [['creator_ip', 'modifier_ip'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_group_id' => 'User Group ID',
            'group_name' => 'Group Name',
            'created_at' => 'Created At',
            'creator_ip' => 'Creator Ip',
            'creator_id' => 'Creator ID',
            'modified_at' => 'Modified At',
            'modifier_ip' => 'Modifier Ip',
            'modifier_id' => 'Modifier ID',
        ];
    }

}
