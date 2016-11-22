<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use frontend\assets\AppInnerAsset;
use yii\helpers\Html;

AppInnerAsset::register($this);

$this->title = 'Who we are';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">  
    
    <div id="about-banner" class="title" style="background-image:url(<?php echo AppInnerAsset::register($this)->baseUrl; ?>/images/blog-bg.jpg);">
        <div class="bg-title">
            <h1><?php echo $this->title; ?></h1>
        </div>
    </div>

    <div id="content-block" class="clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="text-center heading">When we began our journey, it was with a conviction - Slow and steady wins the wealth. </h2>
            <div class="row main-content">
                <div class="col-sm-8">
                     <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                     <p>We at Techniansh single-minded focus on generating client facing web applications. </p>
                    <h3>Founder's Profile</h3>
                    <p>Anshita, an experienced practitioner in Web development, begun her development journey in 2011. A graduate in Commerce and Accounting and a Master of Computer Applications from India, she is a well experienced web developer who have worked with prestigious firms.</p>
                </div>
                <div class="col-sm-4">
                    <img src="<?php echo AppInnerAsset::register($this)->baseUrl; ?>/images/who-we-are.jpg" class="img-responsive img-border">
                </div>
           </div>
        </div>
    </div>            
</div>
