<?php

namespace common\models;

use Yii;

use yii2tech\ar\position\PositionBehavior;

use common\components\UsercontrolBehavior;
use common\components\UseripBehavior;
use common\components\UsertimestampBehavior;

/**
 * This is the model class for table "banner".
 *
 * @property string $id
 * @property string $quote
 * @property string $author
 * @property string $image_name
 * @property string $image_ext
 * @property string $image_mime_type
 * @property string $image_base_name
 * @property integer $image_size
 * @property integer $image_width
 * @property integer $image_height
 * @property integer $sort_order
 * @property string $publish_at
 * @property string $expire_at
 * @property string $created_at
 * @property string $creator_ip
 * @property string $creator_id
 * @property string $modified_at
 * @property string $modifier_ip
 * @property string $modifier_id
 *
 * @property User $creator
 * @property User $modifier
 */
class Banner extends \yii\db\ActiveRecord
{
    public $image;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
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
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quote', 'author', 'publish_at'], 'required'],
            [['image'], 'required', 'on' => 'create'],
            [['image'], 'image', 'skipOnEmpty' => true, 'on' => 'update'],
            [['sort_order', 'image_size', 'creator_id', 'modifier_id'], 'integer'],
            [['publish_at', 'expire_at', 'created_at', 'modified_at', 'image'], 'safe'],
            [['image'], 'image', 'extensions' => ['png', 'jpg'], 'maxSize' => 1024*1024*2, 'maxFiles' => 1, 'minWidth' => 1170, 'maxWidth' => 1170, 'minHeight' => 400, 'maxHeight' => 400, 'checkExtensionByMimeType'=>false],
            [['sort_order'], 'number', 'min' => 1, 'max' => 4294967295],
            [['quote'], 'string', 'min' => 10, 'max' => 500],
            [['author', 'image_name', 'image_ext', 'image_mime_type'], 'string', 'min' => 3, 'max' => 100],
            [['image_ext'], 'string', 'min' => 3, 'max' => 5],
            //[['publish_at', 'expire_at'], 'date', 'format' => 'php:Y-m-d H:i'],
            [['publish_at', 'expire_at'], 'validateDateRange'],
            [['creator_ip', 'modifier_ip'], 'string', 'max' => 30],
//            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
//            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modifier_id' => 'id']],
        ];
    }

    public function validateDateRange() {
        if ($this->expire_at == '') return true;
        if (strtotime($this->publish_at) < strtotime($this->expire_at)) return true;
        
        $this->addError('expire_at', 'Expiry Date/Time date must be greater than Publish Date/Time.');
        
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quote' => 'Quote',
            'author' => 'Author',
            'image' => 'Image',
            'image_name' => 'Image Name',
            'image_ext' => 'Image Extension',
            'image_mime_type' => 'Image Mime Type',
            'image_base_name' => 'Image Base Name',
            'image_size' => 'Size',
            'image_width' => 'Width',
            'image_height' => 'Height',
            'sort_order' => 'Sort Order',
            'publish_at' => 'Publish At',
            'expire_at' => 'Expires At',
            'created_at' => 'Created At',
            'creator_ip' => 'Creator IP',
            'creator_id' => 'Creator ID',
            'modified_at' => 'Modified At',
            'modifier_ip' => 'Modifier IP',
            'modifier_id' => 'Modifier Id',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifier()
    {
        return $this->hasOne(User::className(), ['id' => 'modifier_id']);
    }
}
