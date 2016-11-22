<?php

namespace frontend\widgets\banner; // your App class

use yii\base\Widget;

class Banner extends Widget {

    public $id = 'banner';
    public $class = '';
    public $element = 'div';

    public function run() {
        
        $items = \common\models\Banner::find()
                ->where(['<=', "date(publish_at)", date("Y-m-d")])
                ->andWhere('IF(expire_at IS NOT NULL, date(expire_at) >= ' . date("Y-m-d") . ', expire_at IS NULL)')
                ->orderBy(['sort_order' => SORT_ASC])->all();
        
        return $this->render('banner', ['widget' => $this, 'items' => $items]);
    }
}