<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\components\UsercontrolBehavior;
use common\components\UseripBehavior;
use common\components\UsertimestampBehavior;
use common\models\User;
use yii\helpers\ArrayHelper;

class ChangePassword extends Model {

    public $password_hash;
    public $new_password;
    public $retype_password;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['password_hash', 'new_password', 'retype_password'], 'required'],
            [['new_password'], 'compare', 'compareAttribute'=>'password_hash', 'operator'=>'!='],
            ['password_hash', 'findPasswords'],
            ['retype_password', 'compare', 'compareAttribute' => 'new_password'],
        ];
    }
    
    public function findPasswords($attribute, $params) {
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        if (!Yii::$app->security->validatePassword($this->password_hash, $user->password_hash))
            $this->addError($attribute, 'Current password is incorrect');
    }
    
    public function updatePassword() {
        $user = User::findOne(Yii::$app->user->identity->id);                
        $user->setPassword($this->retype_password);
        
        return $user->save(false) ? $user : null;
    }    
    
}
