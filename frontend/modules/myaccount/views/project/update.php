<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveField;
use yii\bootstrap\ActiveForm;
use common\models\ProjectMedia;
use frontend\modules\myaccount\Module;

$titleData = ($modelProject->isNewRecord) ? "Add" : "Update";
$this->title = $titleData . " Project";
?>
<section id="system-integrator-account" class="main-container">
    <div class="container">
        <?php echo $this->render("//layouts/_myaccountnav"); ?>
        <!-- Company Info Edit Section -->
        <div class="company-information-edit">
            <div class="row">
                <div class="sia-profile-logo">
                    <div class="sia-profile-top clearfix">
                        <div class="pic"><a href="#"><img alt="" src="<?= Module::getInstance()->company_logo ?>"></a></div>
                        <div class="compname"><?= Module::getInstance()->company_name ?><span>Service Provider</span></div>
                    </div>
                </div>
            </div>
            <?= common\widgets\Alert::widget() ?>
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="title lg"><span class="pyr-sprite sprite-projects"></span> <?php echo $titleData; ?> Project</h2>
                </div>
            </div>

            <?php
            $form = ActiveForm::begin(['id' => 'updateprojectfrm',
                        //'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'options' => [
                            'class' => 'custom',
                            'role' => 'form',
                            'enctype' => "multipart/form-data",
                        ],
                        'fieldConfig' => [
                        //'options' => ['tag' => 'span']
                        ]
            ]);
            ?>

            <div class="block2 profile-view edit">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Capacity</span>
                            <?php
                            echo $form->field($modelProject, 'capacity', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Capacity Unit</span>
                            <?php
                            echo $form->field($modelProject, 'capacity_unit', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->dropDownList(Yii::$app->params['capacityUnit'], ['class' => 'form-control', 'data-width' => "auto", 'data-style' => "select2", 'prompt' => 'Select Unit']);
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Project Type</span>
                            <?php
                            echo $form->field($modelProject, 'project_type', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->dropDownList(Yii::$app->params['projectType'], ['class' => 'form-control', 'data-width' => "auto", 'data-style' => "select2", 'prompt' => 'Select Project Type']);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Company Name</span>
                            <?php
                            echo $form->field($modelProject, 'company_name', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Project Description</span>
                            <?php
                            echo $form->field($modelProject, 'description', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textarea(['class' => 'form-control brd', 'rows' => 4, 'cols' => 5]);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="title"><span class="pyr-sprite sprite-client-detail"></span> Client Contact Details</div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Name</span>
                            <?php
                            echo $form->field($modelProject, 'client_name', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Email</span>
                            <?php
                            echo $form->field($modelProject, 'client_email', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Phone</span>
                            <?php
                            echo $form->field($modelProject, 'client_phone', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Share Client Details</span>
                            <?php
                            echo $form->field($modelProject, 'is_share_client_detail', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->dropDownList(['Y' => 'Yes', 'N' => 'No'], ['class' => 'form-control', 'data-width' => "auto", 'data-style' => "select2", 'prompt' => 'Please Select']);
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">State</span>
                            <?php
                            echo $form->field($modelProject, 'state_id', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->dropDownList($stateList, [
                                'class' => 'form-control',
                                'data-width' => "auto",
                                'data-style' => "select2",
                                'prompt' => 'Select State',
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">City</span>
                            <?php
                            echo $form->field($modelProject, 'city', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>


                    <!--                    <div class="col-xs-12">
                                            <div class="item documents">
                                                <div class="form-group">
                                                    <div class="browse">
                    <?php
                    echo $form->field($modelProject, 'mediaCommission', [
                        'template' => '{input}{hint}{error}',
                    ])->fileInput(['class' => 'hide-input', 'accept' => 'image/*',
                        'onchange' => 'jQuery(this).next().children().eq(0).val(jQuery(this).val());'
                    ]);
                    ?>
                                                        <div class="show-input"><input type="text" placeholder="Browse Multiple Files" id="uploadfile" class="form-control"><span class="action">Browse</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?php echo Html::submitButton('Save', ['class' => 'btn bg-green']) ?>
                </div>
            </div>
            <?php
            ActiveForm::end();
            ?>
        </div>
        <?php
        if (!$modelProject->isNewRecord) {
            ?>

            <div class="row">
                <div class="col-xs-12">
                    <h2 class="title lg"><span class="pyr-sprite sprite-samples"></span> Commissioining Certificate</h2>
                </div>
            </div>
            <div class="block2 profile-view edit">
                <?php
                if (!empty($mediaArr)) {
                    ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="item clearfix">
                                <?php
                                foreach ($mediaArr[ProjectMedia::PROJECT_MEDIA_COMMISSIONING] as $value) {
                                    ?>
                                    <span class="certi-thumb"><img alt="" src="<?= Yii::getAlias('@getuploads') ?>/project/commissioning/images/<?= $value ?>" class="img-responsive"></span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?= Html::a((empty($mediaArr)?'Add':'Edit'), Yii::$app->urlManager->createUrl(['myaccount/project/mediacommissioning', 'id' => $modelProject->project_id]), ['class' => 'btn bg-blue']) ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h2 class="title lg"><span class="pyr-sprite sprite-samples"></span> Contract Certificate</h2>
                </div>
            </div>
            <div class="block2 profile-view edit">
                <?php
                if (!empty($mediaArr)) {
                    ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="item clearfix">
                                <?php
                                foreach ($mediaArr[ProjectMedia::PROJECT_MEDIA_CONTRACT] as $value) {
                                    ?>
                                    <span class="certi-thumb"><img alt="" src="<?= Yii::getAlias('@getuploads') ?>/project/contract/images/<?= $value ?>" class="img-responsive"></span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?= Html::a((empty($mediaArr)?'Add':'Edit'), Yii::$app->urlManager->createUrl(['myaccount/project/mediacontract', 'id' => $modelProject->project_id]), ['class' => 'btn bg-blue']) ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h2 class="title lg"><span class="pyr-sprite sprite-samples"></span> Project Photo</h2>
                </div>
            </div>
            <div class="block2 profile-view edit">
                <?php
                if (!empty($mediaArr)) {
                    ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="item clearfix">
                                <?php
                                foreach ($mediaArr[ProjectMedia::PROJECT_MEDIA_PHOTO] as $value) {
                                    ?>
                                    <span class="certi-thumb"><img alt="" src="<?= Yii::getAlias('@getuploads') ?>/project/photo/images/<?= $value ?>" class="img-responsive"></span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?= Html::a((empty($mediaArr)?'Add':'Edit'), Yii::$app->urlManager->createUrl(['myaccount/project/mediaphoto', 'id' => $modelProject->project_id]), ['class' => 'btn bg-blue']) ?>
                    </div>
                </div>
            </div>

            <?php
        }
        ?>
    </div>
</section>