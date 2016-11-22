<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\web\Request;
use yii\i18n\Formatter;
use frontend\modules\myaccount\Module;

$this->title = 'Notification';
?>
<section id="system-integrator-account" class="main-container">
    <div class="container">
        <?php echo $this->render("//layouts/_myaccountnav"); ?>
        <!-- Company Info Section -->
        <div class="manage-notifications">
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
                    <h2 class="title lg"><span class="pyr-sprite sprite-notifications"></span> Notifications</h2>
                </div>
            </div>

            <?php
            if ($modelNotification) {
                ?>
                <div class="block2 profile-view">

                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="item">
                                <span class="label">Set Alert for</span>
                                <span class="value"><?=  Html::encode($modelNotification->state_id)?></span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <div class="item">
                                <span class="label">Project Type</span>
                                <span class="value"><?=Html::encode(Yii::$app->params['projectType'][$modelNotification->project_type])?></span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <div class="item">
                                <span class="label">Minimum Order Value</span>
                                <span class="value"><?=  Html::encode($modelNotification->minimum_order_value)?> Rs.</span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <div class="item">
                                <span class="label">Minimum Capacity</span>
                                <span class="value"><?=  Html::encode($modelNotification->capacity)?>&nbsp;<?=  Html::encode(Yii::$app->params['capacityUnit'][$modelNotification->capacity_unit])?> </span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="add-address custom">
                            <?php
                            echo Html::a('Edit', Yii::$app->urlManager->createUrl(['myaccount/notification/create']), ['class' => 'btn btn-default bg-blue']);
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="add-address custom">
                            <?php
                            echo Html::a('+ Add Notification', Yii::$app->urlManager->createUrl(['myaccount/notification/create']), ['class' => 'btn bg-yellow']);
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>