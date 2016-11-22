<?php

namespace common\models;

use Yii;
use common\components\UsercontrolBehavior;
use common\components\UseripBehavior;
use common\components\UsertimestampBehavior;

/**
 * This is the model class for table "country".
 *
 * @property string $country_id
 * @property string $sortname
 * @property string $name
 * @property string $created_at
 * @property string $creator_ip
 * @property string $creator_id
 * @property string $modified_at
 * @property string $modifier_ip
 * @property string $modifier_id
 *
 * @property State[] $states
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }
    
    public function behaviors() {
        return [
            UseripBehavior::className(),
            UsercontrolBehavior::className(),
            UsertimestampBehavior::className(),            
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sortname', 'name'], 'required'],
            [['created_at', 'modified_at'], 'safe'],
            [['creator_id', 'modifier_id'], 'integer'],
            [['sortname'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 150],
            [['creator_ip', 'modifier_ip'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_id' => 'Country ID',
            'sortname' => 'Sortname',
            'name' => 'Name',
            'created_at' => 'Created At',
            'creator_ip' => 'Creator Ip',
            'creator_id' => 'Creator ID',
            'modified_at' => 'Modified At',
            'modifier_ip' => 'Modifier Ip',
            'modifier_id' => 'Modifier ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStates()
    {
        return $this->hasMany(State::className(), ['fk_country_id' => 'country_id']);
    }
}
