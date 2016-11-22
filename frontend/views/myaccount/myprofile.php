<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use frontend\assets\AppInnerAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use common\widgets\Alert;

$bundle=AppInnerAsset::register($this);

$this->title = 'My Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?php echo $this->title; ?></h1>
    
    <?php
        echo Alert::widget();
        $form = ActiveForm::begin(['id' => 'myprofilefrm',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,                    
            'options' => [
                'class' => 'clearfix',                
                'role' => 'form',                        
            ],
            'fieldConfig' => [
                'options' => ['class' => '']
            ]
        ]);
    ?>
    
    <div class="row">
        <?php
        echo $form->field($model, 'first_name', [
            'template' => '<div class="col-xs-6 col-sm-6">
                      <div class="form-group"><div class="input-group">{input}<div class="input-group-addon"><span class="icon sprite-person"></span></div></div>{error}</div></div>',
        ])->textInput(['class' => 'form-control', 'placeholder' => 'First Name*']);

        echo $form->field($model, 'last_name', [
            'template' => '<div class="col-xs-6 col-sm-6">
                      <div class="form-group"><div class="input-group">{input}<div class="input-group-addon"><span class="icon sprite-person"></span></div></div>{error}</div></div>',
        ])->textInput(['class' => 'form-control', 'placeholder' => 'Last Name*']);
        ?>
    </div>
    
    <div class="row">
        <?php
        echo $form->field($model, 'address1', [
            'template' => '<div class="col-xs-6 col-sm-6">
                      <div class="form-group"><div class="input-group">{input}<div class="input-group-addon"><span class="icon sprite-address"></span></div></div>{error}</div></div>',
        ])->textInput(['class' => 'form-control', 'placeholder' => 'Address Line 1']);

        echo $form->field($model, 'address2', [
            'template' => '<div class="col-xs-6 col-sm-6">
                      <div class="form-group"><div class="input-group">{input}<div class="input-group-addon"><span class="icon sprite-address"></span></div></div>{error}</div></div>',
        ])->textInput(['class' => 'form-control', 'placeholder' => 'Address Line 2']);
        ?>
    </div>
    
    <div class="row">
        <?php
        echo $form->field($model, 'city', [
            'template' => '<div class="col-xs-6 col-sm-6">
                      <div class="form-group"><div class="input-group">{input}<div class="input-group-addon"><span class="icon sprite-city"></span></div></div>{error}</div></div>',
        ])->textInput(['class' => 'form-control', 'placeholder' => 'City']);

        echo $form->field($model, 'state', [
                'template' => '<div class="col-xs-6 col-sm-6">
                      <div class="form-group"><div class="input-group">{input}</div>{error}</div></div>',
            ])->dropDownList($model->getStateList(), ['prompt' => 'Select State', 'class' => 'form-control state-list']);
        ?>
    </div>
    
    <div class="row">
        <?php
        echo $form->field($model, 'phone', [
            'template' => '<div class="col-xs-6 col-sm-6">
                      <div class="form-group"><div class="input-group">{input}<div class="input-group-addon"><span class="icon sprite-landline"></span></div></div>{error}</div></div>',
        ])->textInput(['class' => 'form-control', 'placeholder' => 'Phone']);
        
        echo $form->field($model, 'mobile', [
            'template' => '<div class="col-xs-6 col-sm-6">
                      <div class="form-group"><div class="input-group">{input}<div class="input-group-addon"><span class="icon sprite-mobile"></span></div></div>{error}</div></div>',
        ])->textInput(['class' => 'form-control', 'placeholder' => 'Mobile']);
        ?>
    </div>
    
    <div class="btn-wrap">
        <input class="btn btn-save" type="submit" value="Send">        
    </div>        
    
    
<?php
    ActiveForm::end();

    $this->registerCssFile(AppInnerAsset::register($this)->baseUrl . '/styles/select2.css');
    $this->registerJsFile(AppInnerAsset::register($this)->baseUrl . '/scripts/select2.min.js');

$activemenuJS = <<<JS
    $("#myaccount-sidebar ul li#d-my-profile").addClass("active");
JS;

$this->registerJs($activemenuJS, $this::POS_READY);

$myprofileJs = <<<JS
    $(".state-list").select2({
        placeholder: "Select your State :*",
        allowClear: true
    });        
JS;
$this->registerJs($myprofileJs, $this::POS_READY);
?>