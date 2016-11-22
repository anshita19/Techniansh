<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\ActiveField;
use backend\assets\AppIframeAsset;
use yii\web\JsExpression;
use common\models\User;
use common\widgets\Alertbackend;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\News */
/* @var $form yii\widgets\ActiveForm */
AppIframeAsset::register($this);
$this->title = Yii::t('app', 'Create Account');
echo '<div id="msg_panel">' . Alertbackend::widget() . '</div>';
?>
<div class="panel panel-flat">
    <?php Pjax::begin(['id' => 'new_account', 'options' => ['data-pjax-form-container' => '1']]) ?>
    <?php
    $form = ActiveForm::begin(['id' => 'accountfrm',
                //'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'validationUrl' => [(!empty($model->id))?'validate?id='.$model->id:'validate'],
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
                'template' => '<div class="col-xs-6 col-sm-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'First Name']);

            echo $form->field($model, 'last_name', [
                'template' => '<div class="col-xs-6 col-sm-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Last Name']);
            ?>
        </div>

        <div class="row">
            <?php
            echo $form->field($model, 'mobile', [
                'enableAjaxValidation' => true,
                'template' => '<div class="col-xs-6 col-sm-6">
              <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Mobile']);

            echo $form->field($model, 'email', [
                'enableAjaxValidation' => true,
                'template' => '<div class="col-xs-6 col-sm-6">
              <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Email']);
            ?>
        </div>

        <div class="row">
            <?php
            echo $form->field($model, 'user_status', [
                'template' => '<div class="col-xs-6 col-sm-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->dropDownList(User::$statusLabels, ['class' => 'form-control select', 'prompt' => 'Please Select']);
            
            echo $form->field($model, 'user_type', [
                'template' => '<div class="col-xs-6 col-sm-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->dropDownList(User::$typeLabels, ['class' => 'form-control select', 'prompt' => 'Please Select']);
            ?>

        </div>
        
        <div class="row">
            <?php
            echo $form->field($model, 'password_hash', [
                
                'template' => '<div class="col-xs-6 col-sm-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->passwordInput(['class' => 'form-control','placeholder' => 'Password']);
            
            echo $form->field($model, 'password_repeat', [
                'enableAjaxValidation' => true,
                'template' => '<div class="col-xs-6 col-sm-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->passwordInput(['class' => 'form-control','placeholder' => 'Re-type Password']);
            ?>

        </div>
        
        <div class="navbar-fixed-bottom text-right">
            <button class="btn btn-primary" type="submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
        </div>
    </div>
    <?php
    ActiveForm::end();
    ?>
    <?php Pjax::end(); ?>
</div>