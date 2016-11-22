<?php
use yii\helpers\Html;

?>
<header id="header" class="navbar navbar-default">
    <div class="container">
        <div class="row">
            <div class="col-xs-5 col-sm-4 col-md-2 col-lg-3">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo $bundle->baseUrl; ?>"><img src="<?php echo $bundle->baseUrl; ?>/images/logo.jpg" alt="techniansh Capital" class="img-responsive"></a>
                </div>
            </div>    
            <div class="col-xs-7 col-sm-8 col-md-10 col-lg-9">
                <div id="top-bar">
                    <ul class="social-media">
                        <li class="tw-icon"><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li class="share-icon"><a href="#"><i class="fa fa-share-alt"></i></a></li>
                        <li class="fb-icon"><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li class="google-icon"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li class="youtube-icon"><a href="#"><i class="fa fa-youtube"></i></a></li>
                        <li class="sign-btn"><a href="<?= (isset(Yii::$app->user->identity->id) ? Yii::$app->urlManager->createUrl(['myaccount']) : Yii::$app->urlManager->createUrl(['site/signin'])) ?>"><?= (isset(Yii::$app->user->identity->id) ? 'My Account' : 'Sign In') ?></a></li>
                    </ul>
                    
                </div>
                <div id="main-menu" class="navbar-collapse collapse clearfix">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo $bundle->baseUrl; ?>">Home</a></li>
                        <li class="submenu-one"><a href="#">About Us</a>
                            <ul>
                                <li><a href="<?= Yii::$app->urlManager->createUrl(['site/whoweare'])?>">Who we are</a></li>
                                <li><a href="#">What We Stand For</a></li>
                                <li><a href="#">Why Us</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Testimonials</a></li>
                        <li><a href="#">Blog </a></li>
                        <li><a href="#">FAQ </a></li>
                        <li><a href="<?= Yii::$app->urlManager->createUrl(['site/contactus'])?>">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <a href="javascript:;" id="mobile-menu-icon"><span></span></a>
        </div>
    </div>
</header>