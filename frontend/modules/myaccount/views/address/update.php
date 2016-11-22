<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveField;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\modules\myaccount\Module;


$titleData = ($modelAddress->isNewRecord) ? "Add" : "Update";
$this->title = $titleData . " Address";
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
                    <h2 class="title lg"><span class="pyr-sprite sprite-location"></span> <?php echo $titleData; ?> Address</h2>
                </div>
            </div>

            <?php
            $form = ActiveForm::begin(['id' => 'updateaddressfrm',
                        //'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'options' => [
                            'class' => 'custom',
                            'role' => 'form',
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
                            <span class="label">Phone</span>
                            <?php
                            echo $form->field($modelAddress, 'contact', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">FAX</span>
                            <?php
                            echo $form->field($modelAddress, 'fax', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Email</span>
                            <?php
                            echo $form->field($modelAddress, 'email', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Address</span>
                            <?php
                            echo $form->field($modelAddress, 'address', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textarea(['class' => 'form-control brd', 'cols' => 10, 'rows' => 5]);
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">State</span>
                            <?php
                            echo $form->field($modelAddress, 'state_id', [
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
                            echo $form->field($modelAddress, 'city', [
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