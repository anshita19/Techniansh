<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\db\Query;
use common\models\State;
use yii\helpers\ArrayHelper;

/**
 * Login form
 */
class Profile extends Model
{
    public $first_name;    
    public $last_name;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $phone;
    public $mobile;    
    public $email;    
    public $service;    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['first_name','last_name'], 'required'],
            [['first_name','last_name', 'address1', 'address2', 'phone', 'city', 'mobile', 'state'], 'safe'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 
                'targetClass' => '\common\models\User',
                'filter'=>
                    ['!=', 'id',Yii::$app->user->getIdentity()->attributes['id']],
                'message' => 'This email address has already been taken.'],
            ['mobile', '\common\validators\MobileValidator', 'message' => 'Invalid mobile number.'],
            ['mobile', 'unique', 
                'targetClass' => '\common\models\User', 
                'filter'=>
                    ['!=', 'id',Yii::$app->user->getIdentity()->attributes['id']],
                'message' => 'This mobile number has already been taken.'],            
            // rememberMe must be a boolean value
            //['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            //['password', 'validatePassword'],
        ];
    }
    
    public function profileUpdate() {
        $user = User::findOne(Yii::$app->user->identity->id);
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->address1 = $this->address1;
        $user->address2 = $this->address2;
        $user->phone = $this->phone;        
        $user->mobile = $this->mobile;        
        $user->state = $this->state;        
        
        return $user->save(false) ? $user : null;
    }    
    
    public function getStateList(){
        $stateModel = State::find()->all();
        if ($stateModel) {         
            return ArrayHelper::map($stateModel, 'state_id', 'name');
        }
        return ;
    }
}
