<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\web\Request;
use yii\i18n\Formatter;
use common\models\ProjectMedia;
use frontend\modules\myaccount\Module;

$this->title = 'View Project';
?>
<section id="system-integrator-account" class="main-container">
    <div class="container">
        <?php echo $this->render("//layouts/_myaccountnav"); ?>
        <div class="manage-projects-edit">
            <div class="row">
                <div class="sia-profile-logo">
                    <div class="sia-profile-top clearfix">
                        <div class="pic"><a href="#"><img alt="" src="<?=Module::getInstance()->company_logo?>"></a></div>
                        <div class="compname"><?=Module::getInstance()->company_name?><span>Service Provider</span></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h2 class="title lg text-left"><span class="pyr-sprite sprite-projects"></span> View Project</h2>
                </div>
            </div>

            <div class="block2 profile-view">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Capacity</span>
                            <span class="value"><?= Html::encode($modelProject->capacity) ?>&nbsp; <?= Html::encode(Yii::$app->params['capacityUnit'][$modelProject->capacity_unit]) ?></span>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Project Type</span>
                            <span class="value"><?= Html::encode(Yii::$app->params['projectType'][$modelProject->project_type]) ?></span>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Project Description</span>
                            <span class="value"><?= Formatter::asNtext($modelProject->description) ?></span>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Client Name</span>
                            <span class="value"><?= Html::encode($modelProject->company_name) ?></span>
                        </div><br>
                    </div>

                    <div class="col-xs-12">
                        <div class="title"><span class="pyr-sprite sprite-client-detail"></span> Client Contact Details</div>
                    </div>

                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Name</span>
                            <span class="value"><?= Html::encode($modelProject->client_name) ?></span>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Email</span>
                            <span class="value"><?= Formatter::asEmail($modelProject->client_email) ?></span>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Phone</span>
                            <span class="value"><?= Html::encode($modelProject->client_phone) ?></span>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Share Client Details</span>
                            <span class="value"><?= ($modelProject->is_share_client_detail == 'Y') ? Html::encode('Yes') : Html::encode('No') ?></span>
                        </div><br>
                    </div>

                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">State</span>
                            <span class="value"><?= Html::encode($modelState->name) ?></span>
                        </div><br>
                    </div>

                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">City</span>
                            <span class="value"><?= Html::encode($modelProject->city) ?></span>
                        </div><br>
                    </div>

                    <div class="col-xs-12">
                        <div class="title"><span class="pyr-sprite sprite-samples"></span> Documents</div>
                    </div>

                    <?php
                    if (!empty($mediaArr)) {
                        ?>
                        <div class="col-xs-12">
                            <div class="item">
                                <span class="label">Commissioning Certificate</span><br>
                                <span class="value clearfix">
                                    <?php
                                    foreach ($mediaArr[ProjectMedia::PROJECT_MEDIA_COMMISSIONING] as $value) {
                                        ?>
                                        <span class="certi-thumb"><img alt="" src="<?= Yii::getAlias('@getuploads') ?>/project/commissioning/images/<?= $value ?>" class="img-responsive"></span>
                                        <?php
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if (!empty($mediaArr)) {
                        ?>
                        <div class="col-xs-12">
                            <div class="item">
                                <span class="label">Contract Certificate</span><br>
                                <span class="value clearfix">
                                    <?php
                                    foreach ($mediaArr[ProjectMedia::PROJECT_MEDIA_CONTRACT] as $value) {
                                        ?>
                                        <span class="certi-thumb"><img alt="" src="<?= Yii::getAlias('@getuploads') ?>/project/contract/images/<?= $value ?>" class="img-responsive"></span>
                                        <?php
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if (!empty($mediaArr)) {
                        ?>
                        <div class="col-xs-12">
                            <div class="item no-brd">
                                <span class="label">Project Photos</span><br>
                                <span class="value clearfix">
                                    <?php
                                    foreach ($mediaArr[ProjectMedia::PROJECT_MEDIA_PHOTO] as $value) {
                                        ?>
                                        <span class="certi-thumb"><img alt="" src="<?= Yii::getAlias('@getuploads') ?>/project/photo/images/<?= $value ?>" class="img-responsive"></span>
                                        <?php
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12 custom">
                    <?= Html::a('Edit', Yii::$app->urlManager->createUrl(['myaccount/project/update', 'id' => $modelProject->project_id]), ['class' => 'btn bg-blue']) ?>
                </div>
            </div>
        </div>
    </div>
</section>