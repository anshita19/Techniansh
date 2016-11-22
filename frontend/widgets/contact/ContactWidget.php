<?php

namespace frontend\widgets\contact; // your App class

use yii\base\Widget;
use frontend\widgets\contact\models\Contact;

class ContactWidget extends Widget {
    
    public function init() {
        parent::init();
    }

    public function run() {        
        //Yii::$app->cache->flush();
        $model=new Contact();
        return $this->render('contact',['model'=>$model,'widget'=>$this]);
    }
}