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

$this->title = 'Update My Profile';
?>
<section id="system-integrator-account" class="main-container">
    <div class="container">
        <?php echo $this->render("//layouts/_myaccountnav"); ?>
        <!-- Profile Edit Section -->
        <div class="my-profile-edit">
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
                    <h2 class="title lg"><span class="pyr-sprite sprite-client-detail"></span> Edit Profile</h2>
                </div>
            </div>
            <?php
            $form = ActiveForm::begin(['id' => 'updateprofilefrm',
                        //'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'options' => [
                            'class' => 'custom',
                            'role' => 'form'
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
                            <span class="label">First Name</span>
                            <?php
                            echo $form->field($modelProfile, 'first_name', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-6">
                        <div class="item">
                            <span class="label">Last Name</span>
                            <?php
                            echo $form->field($modelProfile, 'last_name', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    
                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Email</span>
                            <?php
                            echo $form->field($modelProfile, 'email', [
                                'enableAjaxValidation'=>true,
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    
                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Phone</span>
                            <?php
                            echo $form->field($modelProfile, 'mobile', [
                                'enableAjaxValidation'=>true,
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>

<!--                    <div class="col-xs-12">
                        <div class="item">
                            <span class="label">Password</span>
                            <div class="form-group">
                                <input type="password" class="form-control brd" value="••••••••">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control brd" value="" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control brd" value="" placeholder="Confirm Password">
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
    </div>
</section>