<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use frontend\assets\AppInnerAsset;
use yii\helpers\Html;

AppInnerAsset::register($this);

$this->title = 'Why Us';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">  
    
    <div id="contact-bg">
        <div class="container">
            <div class="row">
                <div class="hidden-xs col-sm-6"></div>
                <div class="col-xs-12 col-sm-6">
                    <div id="contact-form-bg">
                        <?php
                            echo \frontend\widgets\contact\ContactWidget::widget();
                        ?>                        
                    </div>
                </div>
            </div>
        </div>
    </div>            
</div>
