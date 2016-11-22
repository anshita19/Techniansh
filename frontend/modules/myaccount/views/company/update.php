<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveField;
use yii\bootstrap\ActiveForm;
use frontend\modules\myaccount\Module;

$titleData=($modelCompany->isNewRecord)?"Add":"Update";
$this->title = $titleData." Company Information";
?>
<section id="system-integrator-account" class="main-container">
    <div class="container">
        <?php echo $this->render("//layouts/_myaccountnav"); ?>
        <!-- Company Info Edit Section -->
        <div class="company-information-edit">
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
                    <h2 class="title lg"><span class="pyr-sprite sprite-corpoffice"></span> <?php echo $titleData; ?> Company Information</h2>
                </div>
            </div>

            <?php
            $form = ActiveForm::begin(['id' => 'updatecompanyfrm',
                        //'enableAjaxValidation' => false,
                        'enableClientValidation' => TRUE,
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
                    <div class="col-xs-6">
                        <div class="item">
                            <span class="image"><span><img src="<?= Yii::getAlias('@getuploads') ?>/company/images/<?= $modelCompany->logo_file_name . '.' . $modelCompany->logo_ext ?>" alt=""></span><a href="#" class="remove"><span class="pyr-sprite sprite-remove"></span></a></span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="item">
                            <div class="form-group">
                                <div class="browse">
                                    <?php
                                    echo $form->field($modelCompany, 'logo_file_name', [
                                        'template' => '{input}{hint}{error}',
                                    ])->fileInput(['class' => 'hide-input',
                                        'onchange' => 'jQuery(this).next().children().eq(0).val(jQuery(this).val());'
                                    ])->hint('Accepted formats: png, jpg, gif. Max file size 2Mb');
                                    ?>
                                    <div class="show-input"><input type="text" class="form-control" id="uploadfile" placeholder="Browse Multiple Files" style="display:none;"><span class="action">Browse</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Name of Company</span>
                            <?php
                            echo $form->field($modelCompany, 'company_name', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Total Plant Capacity Executed</span>
                            <?php
                            echo $form->field($modelCompany, 'installed_capacity', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Total Plant Capacity Unit</span>
                            <?php
                             echo $form->field($modelCompany, 'installed_capacity_unit', [
                              'template' => '<div class="form-group">{input}{error}</div>',
                              ])->dropDownList(Yii::$app->params['capacityUnit'], ['class' => 'form-control','data-width'=>"auto", 'data-style'=>"select2", 'prompt' => 'Select Unit']);
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Number of Solar System Executed</span>
                            <?php
                            echo $form->field($modelCompany, 'total_projects', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Year of Incorporation</span>
                            <?php
                            echo $form->field($modelCompany, 'estd_year', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
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
    </div>
</section>
<!--<script>
    $(document).ready(function () {
        $('[data-style="select2"]').select2();
    });
</script>-->