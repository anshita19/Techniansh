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

$titleData = ($modelNotification->isNewRecord) ? "Add" : "Update";
$this->title = $titleData . " Notification";
?>
<section id="system-integrator-account" class="main-container">
    <div class="container">
        <?php echo $this->render("//layouts/_myaccountnav"); ?>
        <!-- Manage Notifications Edit Section -->
        <div class="manage-notifications-edit">
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
                    <h2 class="title lg"><span class="pyr-sprite sprite-notifications"></span> <?= $titleData ?> Notification</h2>
                </div>
            </div>

            <?php
            $form = ActiveForm::begin(['id' => 'updateprojectfrm',
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
                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Set Alert for <span class="info">You can select multiple states</span></span>
                            <?php
                            echo $form->field($modelNotification, 'state_id', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->dropDownList($stateList, [
                                'class' => 'form-control',
                                'data-width' => "auto",
                                'data-style' => "select2",
                                'prompt' => 'Select State',
                                'multiple'=>'multiple'
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Project Type</span>
                            <?php
                            echo $form->field($modelNotification, 'project_type', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->dropDownList(Yii::$app->params['projectType'], ['class' => 'form-control', 'data-width' => "auto", 'data-style' => "select2", 'prompt' => 'Select Project Type']);
                            ?>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Minimum Order Value</span>
                            <?php
                            echo $form->field($modelNotification, 'minimum_order_value', [
                                'template' => '<div class="form-group otp">
                                <span>Rupees</span>{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Capacity</span>
                            <?php
                            echo $form->field($modelNotification, 'capacity', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Capacity Unit</span>
                            <?php
                            echo $form->field($modelNotification, 'capacity_unit', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->dropDownList(Yii::$app->params['capacityUnit'], ['class' => 'form-control', 'data-width' => "auto", 'data-style' => "select2", 'prompt' => 'Select Unit']);
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