<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\ActiveField;
use backend\assets\AppIframeAsset;
use yii\web\JsExpression;
use common\widgets\Alertbackend;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\News */
/* @var $form yii\widgets\ActiveForm */
AppIframeAsset::register($this);
$this->title = Yii::t('app', 'Create Module');
echo '<div id="msg_panel">' . Alertbackend::widget() . '</div>';
?>
<div class="panel panel-flat">
    <?php Pjax::begin(['id' => 'new_module', 'options' => ['data-pjax-form-container' => '1']]) ?>
    <?php
    $form = ActiveForm::begin(['id' => 'modulefrm',
                //'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'validationUrl' => ['validate' . (empty($model->id) ? '' : '?id=' . $model->id)],
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
            echo $form->field($model, 'name', [
                'template' => '<div class="col-xs-6 col-sm-6">
                                      <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Name']);
			
			echo $form->field($model, 'controller_name', [
                'template' => '<div class="col-xs-6 col-sm-6">
                                      <div class="form-group">{label}{input}{hint}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Name of Controller'])
                                ->hint('Please provide propername of specified controller. eg. SiteController');

            ?>
        </div>

        <div class="row">
            <?php
			echo $form->field($model, 'css_class', [
                'template' => '<div class="col-xs-4 col-sm-4">
                                      <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'CSS Class']);
            
            echo $form->field($model, 'icon', [
                'template' => '<div class="col-xs-4 col-sm-4">
                                      <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Icon']);
            
            echo $form->field($model, 'sort_order', [
                'template' => '<div class="col-xs-4 col-sm-4">
                                      <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Sort Order']);
            ?>
        </div>                    
    </div>

    <div class="navbar-fixed-bottom text-right">
        <button class="btn btn-primary" type="submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
    </div>
</div>
<?php
ActiveForm::end();
?>
<?php Pjax::end(); ?>