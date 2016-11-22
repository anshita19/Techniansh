<?php

namespace common\models;

use Yii;
use common\components\UsercontrolBehavior;
use common\components\UseripBehavior;
use common\components\UsertimestampBehavior;

/**
 * This is the model class for table "state".
 *
 * @property string $state_id
 * @property string $name
 * @property string $fk_country_id
 * @property string $created_at
 * @property string $creator_ip
 * @property string $creator_id
 * @property string $modified_at
 * @property string $modifier_ip
 * @property string $modifier_id
 *
 * @property Country $fkCountry
 */
class State extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'state';
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
            [['name', 'fk_country_id'], 'required'],
            [['fk_country_id', 'creator_id', 'modifier_id'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['name', 'creator_ip', 'modifier_ip'], 'string', 'max' => 30],
            [['fk_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['fk_country_id' => 'country_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'state_id' => 'State ID',
            'name' => 'Name',
            'fk_country_id' => 'Country',
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
    public function getFkCountry()
    {
        return $this->hasOne(Country::className(), ['country_id' => 'fk_country_id']);
    }
}
