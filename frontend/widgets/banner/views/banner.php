<?php

use common\models\Banner;
use frontend\widgets\banner\assets\AppAsset;

AppAsset::register($this);

$thumbURL = Yii::$app->urlManager->createUrl(['thumb/banner/1170/400']) . '/';

if (!empty($items)) {
    echo '<' . $widget->element . ($widget->id ? ' id="' . $widget->id . '"' : '') . ($widget->class ? ' class="' . $widget->class . '"' : '') . '>';
    echo '<ul class="slides">';
    foreach ($items as $item) {
        echo '<li style="background-image: url(\'' . $thumbURL . $item->image_name . '.' . $item->image_ext . '\');">
                    <div class="banner-title animated fadeInUp">
                        <span class="quote-icon"></span>
                        <div class="banner-txt">' . $item->quote . '</div>
                        <div class="name">' . $item->author . '</div>
                    </div>
                </li>';
    }
    echo '</ul>';
    echo '</' . $widget->element . '>';
}

$bannerJS = <<<JS
        
    $('.slides').bxSlider({
        mode: 'fade', pager: true, controls: false, pause: 7000, auto: true, autoControls: true,
        onSlideAfter: function () {
            $('.bx-start').trigger('click');
            $(".slides .banner-title").addClass("animated fadeInUp");
        },
        onSlideBefore: function () {
            $(".slides .banner-title").removeClass("animated fadeInUp");
        }
    });

JS;

$this->registerJs($bannerJS, $this::POS_END);
?>