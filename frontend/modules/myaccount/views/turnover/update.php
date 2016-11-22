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


$titleData=($modelTurnover->isNewRecord)?"Add":"Update";
$this->title = $titleData." Company Turnover";
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
                    <h2 class="title lg"><span class="pyr-sprite sprite-corpoffice"></span> <?php echo $titleData; ?> Company Turnover</h2>
                </div>
            </div>

            <?php
            $form = ActiveForm::begin(['id' => 'updatecompanyfrm',
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
                    <div class="col-xs-12 col-sm-3">
                        <div class="item">
                            <span class="label">Currency</span>
                            <?php
                             echo $form->field($modelTurnover, 'currency_id', [
                              'template' => '<div class="form-group">{input}{error}</div>',
                              ])->dropDownList(Yii::$app->params['currency'], ['class' => 'form-control','data-width'=>"auto", 'data-style'=>"select2", 'prompt' => 'Select Currency']);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="item">
                            <span class="label">Conversion Type</span>
                            <?php
                             echo $form->field($modelTurnover, 'conversion_type', [
                              'template' => '<div class="form-group">{input}{error}</div>',
                              ])->dropDownList(Yii::$app->params['currencyConversionType'], ['class' => 'form-control','data-width'=>"auto", 'data-style'=>"select2", 'prompt' => 'Select Conversion Type']);
                             ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="item">
                            <span class="label">Financial Year</span>
                            <?php
                            echo $form->field($modelTurnover, 'financial_year', [
                                'enableAjaxValidation' => true,
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="item">
                            <span class="label">Amount</span>
                            <?php
                            echo $form->field($modelTurnover, 'amount', [
                                'template' => '<div class="form-group">{input}{error}</div>',
                            ])->textInput(['class' => 'form-control brd']);
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
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
<script>
    $(document).ready(function () {
       // $('[data-style="select2"]').select2();
    });
</script>