<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
//use yii\widgets\ActiveField;
use yii\bootstrap\ActiveField;
use backend\assets\AppIframeAsset;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\models\News */
/* @var $form yii\widgets\ActiveForm */
AppIframeAsset::register($this);
$this->title = Yii::t('app', 'Create Contact');
?>
<div class="panel panel-flat">
    <?php yii\widgets\Pjax::begin(['id' => 'new_contact','enableReplaceState'=>false,
        'enablePushState'=>false, 'options' => ['data-pjax-form-container' => '1']]) ?>
    <?php
    $form = yii\bootstrap\ActiveForm::begin(['id' => 'contactfrm',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                //'action'=>['contact/create'],
                //'validateOnChange' => false,
                'validationUrl' => ['validatecontact'],
                'options' => [
                    'class' => 'custom',
                    'role' => 'form',
                    'data-pjax' => true,
                ],
                'fieldConfig' => [
                    'options' => ['class' => '']
                ]
    ]);
    ?>
    <div class="panel-body">

        <div class="row">
            <?php
            echo $form->field($model, 'first_name', [
                'enableAjaxValidation' => true,
                'template' => '<div class="col-md-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'First Name']);
            
            echo $form->field($model, 'last_name', [
                'template' => '<div class="col-md-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Last Name']);
            
            ?>
        </div>

        <div class="row">
            <?php
             echo $form->field($model, 'organization', [
              'template' => '<div class="col-md-6">
              <div class="form-group">{label}{input}{error}</div></div>',
              ])->textInput(['class' => 'form-control', 'placeholder' => 'Organization']);

              echo $form->field($model, 'designation', [
              'template' => '<div class="col-md-6">
              <div class="form-group">{label}{input}{error}</div></div>',
              ])->textInput(['class' => 'form-control', 'placeholder' => 'Designation']); 
            ?>
        </div>

        <div class="row">
            <?php
            echo $form->field($model, 'mobile', [
                'template' => '<div class="col-md-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Mobile']);
            
            echo $form->field($model, 'email', [
                //'enableAjaxValidation' => true,
                'template' => '<div class="col-md-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Email']);
            ?>
        </div>

        <div class="row">
            <?php
            echo $form->field($model, 'gender', [
                'template' => '<div class="col-md-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->dropDownList(Yii::$app->params['gender'], ['class' => 'form-control select', 'prompt' => 'Please Select']);
            ?>

        </div>

        <div class="navbar-fixed-bottom text-right">
            <button class="btn btn-primary" type="submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
        </div>
    </div>
    <?php
    ActiveForm::end();
    ?>
    <?php yii\widgets\Pjax::end(); ?>
</div>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>
