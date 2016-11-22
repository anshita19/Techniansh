<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\ActiveField;
use yii\web\JsExpression;

use kartik\select2\Select2;
use backend\assets\AppIframeAsset;

use common\models\Country;

AppIframeAsset::register($this);
$this->title = Yii::t('app', 'New Country');

?>

<div class="panel panel-flat">
    
    <?php yii\widgets\Pjax::begin(['id' => 'new_country_link', 'options' => ['data-pjax-form-container' => '1']]) ?>
    
    <?php
    
        $form = yii\bootstrap\ActiveForm::begin([
            'id' => 'frmFaq',
            'enableClientValidation' => true,
            'validationUrl' => ['validate' . (empty($model->id) ? '' : '?id='.$model->id)],
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
        
        <?php

        echo '<div class="row">';

        echo $form->field($model, 'name', [
            'template' => '<div class="col-xs-6">
                      <div class="form-group">{label}{input}{error}</div></div>',
        ])->textInput(['class' => 'form-control', 'autofocus' => 'autofocus']);
        
        echo $form->field($model, 'sortname', [
            'template' => '<div class="col-xs-6">
                      <div class="form-group">{label}{input}{error}</div></div>',
        ])->textInput(['class' => 'form-control']);

        echo '</div>';
        
        ?>
        
        <div class="navbar-fixed-bottom text-right">
            <button class="btn btn-primary" type="submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
        </div>    
    
    <?php ActiveForm::end(); ?>
    <?php yii\widgets\Pjax::end(); ?>
    
</div>
<style>
    
    div.required label:after {
        content: " *";
        color: red;
    }
</style>