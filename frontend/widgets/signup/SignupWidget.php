<?php

namespace frontend\widgets\signup; // your App class

use yii\base\Widget;
use frontend\widgets\signup\models\Signup;


class SignupWidget extends Widget {
    
    public $signupService=[1=>'None',2=>'Web Development',3=>'Development & Enchancements',4=>'Project Upgrading'];
    
    public function init() {
        parent::init();
    }

    public function run() {
        
        //\Yii::$app->cache->flush();
        $model=new Signup();
        return $this->render('signup',['model'=>$model,'widget'=>$this]);
    }
}