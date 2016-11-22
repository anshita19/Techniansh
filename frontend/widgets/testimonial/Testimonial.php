<?php

namespace frontend\widgets\testimonial; // your App class

use yii\base\Widget;

class Testimonial extends Widget {

    public $id = 'testimonial';
    public $class = 'slider-outer';
    public $element = 'div';
    public $page = 'home';

    public function run() {

        if($this->page == 'home')
        {
            $items = \common\models\Testimonial::find()->where(['status'=>1,'is_home'=>1])->orderBy(['sort_order' => SORT_ASC])->all();
            return $this->render('home', ['widget' => $this, 'items' => $items]);
        }
        else
        {
            $this->id = '';
            $this->class = 'row main-content';
            $items = \common\models\Testimonial::find()->where(['status'=>1])->orderBy(['sort_order' => SORT_ASC])->all();
            return $this->render('inner', ['widget' => $this, 'items' => $items]);
        }        
    }

}
