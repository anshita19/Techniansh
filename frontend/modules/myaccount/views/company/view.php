<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\web\Request;
use frontend\modules\myaccount\Module;

$this->title = 'View Company Information';
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
                    <h2 class="title lg"><span class="pyr-sprite sprite-corpoffice"></span> Company Info</h2>
                </div>
            </div>
            <div class="block2 profile-view">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="item">
                            <span class="value"><?= $modelCompany->company_name ?></span>
                            <span class="image"><span><img src="<?= Yii::getAlias('@getuploads') ?>/company/images/<?= $modelCompany->logo_file_name . '.' . $modelCompany->logo_ext ?>" alt="<?= $modelCompany->company_name ?>"></span></span>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Year of Incorporation</span>
                            <span class="value"><?php echo $modelCompany->estd_year; ?></span>
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
                                    <span class="value"><?php echo number_format($value['amount']).' '.  Yii::$app->params['currencyConversionType'][$value['conversion_type']].' &nbsp;('.$value['financial_year'].')' ?></span><br>
                                    <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Total Plant Capacity Executed</span>
                            <?php
                            $installedCapacity=(!empty($modelCompany->installed_capacity) && $modelCompany->installed_capacity_unit==2)?($modelCompany->installed_capacity/1000):$modelCompany->installed_capacity;
                            ?>
                            <span class="value"><?php echo number_format($installedCapacity).' '.Yii::$app->params['capacityUnit'][$modelCompany->installed_capacity_unit];?></span>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Number of Solar System Executed</span>
                            <span class="value"><?php echo $modelCompany->total_projects;?> Projects</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="add-address custom">
                        <?php
                        echo Html::a('Edit', Yii::$app->urlManager->createUrl(['myaccount/company/update']), ['class' => 'btn btn-default bg-blue']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>