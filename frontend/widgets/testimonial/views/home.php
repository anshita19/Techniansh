<?php

use common\models\Banner;
use frontend\widgets\banner\assets\AppAsset;

AppAsset::register($this);

$thumbURL = Yii::$app->urlManager->createUrl(['thumb/banner/1170/400']) . '/';

echo '<' . $widget->element . ($widget->id ? ' id="' . $widget->id . '"' : '') . ($widget->class ? ' class="' . $widget->class . '"' : '') . '>';
echo '<ul class="feedback-slider clearfix">';
    foreach($items as $item) {    
        echo '<li>
                <span class="quote-icon"></span>
                    <div class="para">'.$item->testimonial.'</div>
                    <div class="info">
                        <p>'.$item->name.'</p>
                        <span>'.(!empty($item->designation)?$item->designation:'').(!empty($item->organisation)?' @'.$item->organisation:'').'</span>
                    </div>
             </li>';
    }
echo '</ul>';    
echo '</' . $widget->element . '>';
    
$testimonialJS = <<<JS
    $('.feedback-slider').bxSlider({
            mode: 'fade', pager: true, controls: false
    });
JS;

$this->registerJs($testimonialJS, $this::POS_END);

?>