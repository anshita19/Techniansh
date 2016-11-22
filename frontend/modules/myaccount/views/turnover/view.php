<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\web\Request;
use frontend\modules\myaccount\Module;

$this->title = 'View Company Turnover';
?>
<section id="system-integrator-account" class="main-container">
    <div class="container">
        <?php echo $this->render("//layouts/_myaccountnav"); ?>
        <!-- Company Info Section -->
        <div class="company-information">
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
                    <h2 class="title lg"><span class="pyr-sprite sprite-corpoffice"></span> Company Turnover Info</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="add-address custom">
                        <?php
                        echo Html::a('+ Add Turnover', Yii::$app->urlManager->createUrl(['myaccount/turnover/create']), ['class' => 'btn bg-yellow']);
                        ?>
                    </div>
                </div>
            </div>
            <div class="block2 profile-view">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="item">
                            <span class="value"><?=Module::getInstance()->company_name?></span>
                            <span class="image"><span><img src="<?=Module::getInstance()->company_logo?>" alt="<?=Module::getInstance()->company_name?>"></span></span>
                        </div>
                    </div>
                    <?php
                    if (!empty($modelTurnover)) {
                        ?>
                        <div class="col-xs-12">
                            <div class="item">
                                <span class="label">Financial (Historical Years)</span>
                                <?php
                                foreach ($modelTurnover as $value) {
                                    ?>
                                    <span class="value">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <?php echo number_format($value['amount']) . ' ' . Yii::$app->params['currencyConversionType'][$value['conversion_type']] . ' &nbsp;(' . $value['financial_year'] . ')' ?>
                                            </div>
                                            <div class="col-xs-3">
                                                <?= Html::a('Edit', Yii::$app->urlManager->createUrl(['myaccount/turnover/update', 'id' => $value['turnover_id']]), ['class' => 'btn btn-default bg-blue']) ?>
                                                <!--<a href="<?php echo Yii::$app->urlManager->createUrl(['myaccount/turnover/update', 'id' => $value['turnover_id']]); ?>" class="btn btn-default bg-blue">Edit</a>-->
                                            </div>
                                            <div class="col-xs-3">
                                                <?= Html::a('Delete', Yii::$app->urlManager->createUrl(['myaccount/turnover/delete', 'id' => $value['turnover_id']]), ['class' => 'btn btn-default bg-red']) ?>
                                                <!--<a href="<?php echo Yii::$app->urlManager->createUrl(['myaccount/turnover/delete', 'id' => $value['turnover_id']]); ?>" class="btn btn-default bg-blue">Delete</a>-->
                                            </div>
                                        </div>
                                    </span><br>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</section>