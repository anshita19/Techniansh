<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use frontend\modules\myaccount\Module;


//echo myaccount\Module::getInstance()->scal;

$this->title = 'My Account';
?>
<section id="system-integrator-account" class="main-container">
    <div class="container">
<?php echo $this->render("//layouts/_myaccountnav"); ?>
        <!-- My Account Section -->
        <div class="my-account-links">
            <div class="row">
                <div class="sia-profile-logo">
                    <div class="sia-profile-top clearfix">
                        <div class="pic"><a href="#"><img alt="" src="<?=Module::getInstance()->company_logo?>"></a></div>
                        <div class="compname"><?=Module::getInstance()->company_name?><span>Service Provider</span></div>
                    </div>
                </div>
            </div>
            <div class="block5">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="item clearfix"><a href="<?php echo Yii::$app->urlManager->createUrl(['myaccount/profile']); ?>"><span class="icon-container"><span class="pyr-sprite sprite-client-detail"></span></span><span class="text">Profile</span></a></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="item clearfix"><a href="<?php echo Yii::$app->urlManager->createUrl(['myaccount/company']); ?>"><span class="icon-container"><span class="pyr-sprite sprite-corpoffice"></span></span><span class="text">Company Information</span></a></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="item clearfix"><a href="<?php echo Yii::$app->urlManager->createUrl(['myaccount/turnover']); ?>"><span class="icon-container"><span class="pyr-sprite sprite-corpoffice"></span></span><span class="text">Company Turnover</span></a></div>
                    </div>
<!--                    <div class="col-xs-12">
                        <div class="item clearfix"><a href="#"><span class="icon-container"><span class="pyr-sprite sprite-mobile"></span></span><span class="text">Alternate Contact Information</span></a></div>
                    </div>-->
                    <div class="col-xs-12">
                        <div class="item clearfix"><a href="<?php echo Yii::$app->urlManager->createUrl(['myaccount/address']); ?>"><span class="icon-container"><span class="pyr-sprite sprite-location"></span></span><span class="text">Manage Address</span></a></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="item clearfix"><a href="<?php echo Yii::$app->urlManager->createUrl(['myaccount/certificate']); ?>"><span class="icon-container"><span class="pyr-sprite sprite-certifications"></span></span><span class="text">Manage Certificates</span></a></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="item clearfix"><a href="<?php echo Yii::$app->urlManager->createUrl(['myaccount/award']); ?>"><span class="icon-container"><span class="pyr-sprite sprite-awards"></span></span><span class="text">Manage Awards</span></a></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="item clearfix"><a href="<?php echo Yii::$app->urlManager->createUrl(['myaccount/project']); ?>"><span class="icon-container"><span class="pyr-sprite sprite-projects"></span></span><span class="text">Manage Projects</span></a></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="item clearfix"><a href="<?php echo Yii::$app->urlManager->createUrl(['myaccount/preference']); ?>"><span class="icon-container"><span class="pyr-sprite sprite-preferences"></span></span><span class="text">Manage Preferences</span></a></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="item clearfix"><a href="<?php echo Yii::$app->urlManager->createUrl(['myaccount/notification']); ?>"><span class="icon-container"><span class="pyr-sprite sprite-notifications"></span></span><span class="text">Manage Notifications</span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>