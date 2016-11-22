<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use frontend\modules\myaccount\Module;

$this->title = 'View My Profile';
?>
<section id="system-integrator-account" class="main-container">
    <div class="container">
<?php echo $this->render("//layouts/_myaccountnav"); ?>
        <!-- Profile Section -->
        <div class="my-profile">
            <div class="row">
                <div class="sia-profile-logo">
                    <div class="sia-profile-top clearfix">
                        <div class="pic"><a href="#"><img alt="" src="<?=Module::getInstance()->company_logo?>"></a></div>
                        <div class="compname"><?=Module::getInstance()->company_name?><span>Service Provider</span></div>
                    </div>
                </div>
            </div>
            <?= common\widgets\Alert::widget() ?>    
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="title lg"><span class="pyr-sprite sprite-client-detail"></span> Profile</h2>
                </div>
            </div>

            <div class="block2 profile-view">

                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Name</span>
                            <span class="value"><?php echo Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name; ?></span>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Email</span>
                            <span class="value"><?php echo Yii::$app->user->identity->email; ?></span>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Phone</span>
                            <span class="value"><?php echo Yii::$app->user->identity->mobile; ?></span>
                        </div>
                    </div>
                    <?php
                    if (isset(Yii::$app->user->identity->password_hash)) {
                        ?>
                        <div class="col-xs-12 col-sm-6">
                            <div class="item">
                                <span class="label">Password</span>
                                <span class="value">•••••••••••••••</span>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="add-address custom">
                        <?php
                        echo Html::a('Edit', Yii::$app->urlManager->createUrl(['myaccount/profile/update']), ['class' => 'btn btn-default bg-blue']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>