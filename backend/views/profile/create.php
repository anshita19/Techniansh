<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
//use yii\widgets\ActiveField;
use yii\bootstrap\ActiveField;
use backend\assets\AppInnerAsset;
use yii\web\JsExpression;
use common\widgets\Alertbackend;

/* @var $this yii\web\View */
/* @var $model backend\models\News */
/* @var $form yii\widgets\ActiveForm */
AppInnerAsset::register($this);
$this->title = Yii::t('app', 'Profile');

echo $this->render('//layouts/_pageheader', ['title' => $this->title, 'icon' => 'icon-user']);

echo '<div id="msg_panel">'.Alertbackend::widget().'</div>';
?>
<div class="panel panel-flat">
    <?php
    $form = yii\bootstrap\ActiveForm::begin(['id' => 'profilefrm',
                //'enableAjaxValidation' => true,
                'enableClientValidation' => true,
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
            echo $form->field($model, 'mobile', [
                'enableAjaxValidation' => true,
                'template' => '<div class="col-md-6">
              <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Mobile']);

            echo $form->field($model, 'email', [
                'enableAjaxValidation' => true,
                'template' => '<div class="col-md-6">
              <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Email']);
            ?>
        </div>

        <div class="row">
            <?php
            echo $form->field($model, 'password_hash', [
                
                'template' => '<div class="col-md-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->passwordInput(['class' => 'form-control','placeholder' => 'Password']);
            
            echo $form->field($model, 'password_repeat', [
                'enableAjaxValidation' => true,
                'template' => '<div class="col-md-6">
                          <div class="form-group">{label}{input}{error}</div></div>',
            ])->passwordInput(['class' => 'form-control','placeholder' => 'Re-type Password']);
            ?>

        </div>

        <div class="text-right">
            <button class="btn btn-primary" type="submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
        </div>
    </div>
    <?php
    ActiveForm::end();
    ?>
</div>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>