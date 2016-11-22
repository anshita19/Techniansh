<?php

namespace common\models;

use Yii;
use common\components\UsercontrolBehavior;
use common\components\UseripBehavior;
use common\components\UsertimestampBehavior;
use common\models\AppoinmentContact;


/**
 * This is the model class for table "contact".
 *
 * @property integer $contact_id
 * @property string $first_name
 * @property string $last_name
 * @property string $organization
 * @property string $designation
 * @property string $gender
 * @property string $address
 * @property string $city
 * @property string $email
 * @property string $mobile
 * @property string $fax
 * @property string $created_at
 * @property string $creator_ip
 * @property integer $creator_id
 * @property string $modified_at
 * @property string $modifier_ip
 * @property integer $modifier_id
 */
class Contact extends \yii\db\ActiveRecord
{
    public $fk_contact_id;
    public $contact_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'organization'], 'required'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],
            ['mobile', '\common\validators\MobileValidator', 'message' => 'Invalid mobile number.'],
            [['gender', 'address'], 'string'],
            [['created_at', 'modified_at'], 'safe'],
            [['creator_id', 'modifier_id'], 'integer'],
            [['first_name', 'last_name', 'organization', 'designation', 'city', 'email'], 'string', 'max' => 255],
            [['mobile', 'fax'], 'string', 'max' => 20],
            [['creator_ip', 'modifier_ip'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'contact_id' => Yii::t('app', 'Contact ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'organization' => Yii::t('app', 'Organization'),
            'designation' => Yii::t('app', 'Designation'),
            'gender' => Yii::t('app', 'Gender'),
            'address' => Yii::t('app', 'Address'),
            'city' => Yii::t('app', 'City'),
            'email' => Yii::t('app', 'Email'),
            'mobile' => Yii::t('app', 'Mobile'),
            'fax' => Yii::t('app', 'Fax'),
            'created_at' => Yii::t('app', 'Created At'),
            'creator_ip' => Yii::t('app', 'Creator Ip'),
            'creator_id' => Yii::t('app', 'Creator ID'),
            'modified_at' => Yii::t('app', 'Modified At'),
            'modifier_ip' => Yii::t('app', 'Modifier Ip'),
            'modifier_id' => Yii::t('app', 'Modifier ID'),
        ];
    }
    
    
    public function getContactRel(){
        return $this->hasOne(AppoinmentContact::className(), ['fk_contact_id' => 'contact_id']);
    }
    
    
    
}
