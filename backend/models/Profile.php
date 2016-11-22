<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\db\Query;
/**
 * Login form
 */
class Profile extends Model
{
    public $first_name;
    public $user_id;
    public $last_name;
    public $email;
    public $mobile;
    public $password_hash;
    public $password_repeat;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['first_name','last_name','email'], 'required'],
            [['first_name','last_name','email'], 'safe'],
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
            ['password_hash', 'string', 'min' => 6, 'message' => 'Password should contain at least 6 characters.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password_hash'],
            ['password_repeat', 'validatePasswordRepeat','skipOnEmpty' => false],
            // rememberMe must be a boolean value
            //['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            //['password', 'validatePassword'],
        ];
    }
    
    public function validatePasswordRepeat() {
        if ($this->password_hash && !$this->password_repeat) {
            $this->addError('password_repeat', 'Retype password can not be blank');
            //return false;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'password_hash' => 'Password',
            'password_repeat' => 'Confirm Password',
        ];
    }

    public function profileUpdate() {
        $user = User::findOne(Yii::$app->user->identity->id);
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        if ($this->password_repeat) {
            $user->setPassword($this->password_repeat);
        }
        $user->mobile = $this->mobile;
        return $user->save() ? $user : null;
    }
    
}
