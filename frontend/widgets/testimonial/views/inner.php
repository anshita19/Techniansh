<?php

use common\models\Testimonial;
use frontend\widgets\testimonial\assets\AppAsset;

AppAsset::register($this);

$thumbURL = Yii::$app->urlManager->createUrl(['thumb/testimonial/111/111']) . '/';

echo '<' . $widget->element . ($widget->id ? ' id="' . $widget->id . '"' : '') . ($widget->class ? ' class="' . $widget->class . '"' : '') . '>';
    foreach($items as $item) {    
        echo '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="testimonial">
                    <div class="img"><span><img src="' . $thumbURL . $item->image_name . '.' . $item->image_ext . '"></span></div>
                    <h4>'.$item->name.'</h4>
                    <h5>'.(!empty($item->designation)?$item->designation:'').(!empty($item->organisation)?' @'.$item->organisation:'').'</h5>
                    <p><q>'.$item->testimonial.'</q></p>                    
                </div>
             </div>';
    }
echo '</' . $widget->element . '>';

?>