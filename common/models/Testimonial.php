<?php

namespace common\models;

use Yii;
use yii2tech\ar\position\PositionBehavior;

use common\components\UsercontrolBehavior;
use common\components\UseripBehavior;
use common\components\UsertimestampBehavior;
use yii\web\JsExpression;

/**
 * This is the model class for table "testimonial".
 *
 * @property string $id
 * @property string $user_id
 * @property string $testimonial
 * @property string $name
 * @property string $organisation
 * @property string $designation
 * @property string $image_name
 * @property string $image_ext
 * @property string $image_base_name
 * @property string $image_mime_type
 * @property string $image_size
 * @property integer $image_width
 * @property integer $image_height
 * @property integer $status
 * @property integer $is_home
 * @property string $sort_order
 * @property string $created_at
 * @property string $creator_ip
 * @property string $creator_id
 * @property string $modified_at
 * @property string $modifier_ip
 * @property string $modifier_id
 */
class Testimonial extends \yii\db\ActiveRecord
{
    public $userTypeArr = ['0' => 'Guest', '1' => 'User'];
    public $user_type;
    public $image;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testimonial';
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
            [['user_id', 'image_size', 'image_width', 'image_height', 'status', 'is_home', 'sort_order', 'creator_id', 'modifier_id'], 'integer'],
            [['testimonial'], 'required'],
            [['user_id'], 'required', 'whenClient' => new JsExpression("
                    function (attribute, value) {                    
                        return $('.usertype:checked').val()==1;
                    }
                    "),'when' => function($model) {
                return $model->user_id == 1;
            }],
            [['name'], 'required', 'whenClient' => new JsExpression("
                    function (attribute, value) {
                        return $('.usertype:checked').val()==0;
                    }
                    "),'when' => function($model) {
                return $model->user_id == 0;
            }],
            [['image'], 'image', 'extensions' => ['png', 'jpg'], 'maxSize' => 1024*1024*2, 'maxFiles' => 1, 'minWidth' => 170, 'maxWidth' => 1170, 'minHeight' => 170, 'maxHeight' => 400],
            [['image_ext'], 'string', 'min' => 3, 'max' => 5],
            [['created_at', 'modified_at'], 'safe'],
            [['testimonial'], 'string', 'max' => 500],
            [['name', 'organisation', 'designation', 'image_name', 'image_base_name', 'image_mime_type'], 'string', 'max' => 100],
            [['image_ext'], 'string', 'max' => 5],
            [['creator_ip', 'modifier_ip'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'testimonial' => 'Testimonial',
            'name' => 'Name',
            'organisation' => 'Organisation',
            'designation' => 'Designation',
            'image_name' => 'Image Name',
            'image_ext' => 'Image Ext',
            'image_base_name' => 'Image Base Name',
            'image_mime_type' => 'Image Mime Type',
            'image_size' => 'Image Size',
            'image_width' => 'Image Width',
            'image_height' => 'Image Height',
            'status' => 'Status',
            'is_home' => 'Show on home page?',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'creator_ip' => 'Creator IP',
            'creator_id' => 'Creator ID',
            'modified_at' => 'Modified At',
            'modifier_ip' => 'Modifier IP',
            'modifier_id' => 'Modifier Id',
            'user_type' => ''
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
