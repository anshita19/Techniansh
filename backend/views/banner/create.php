<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\ActiveField;
use yii\web\JsExpression;

use backend\assets\AppIframeAsset;

use common\models\Banner;

AppIframeAsset::register($this);
$this->title = Yii::t('app', 'New Banner');

?>

<div class="panel panel-flat">
    
    <?php yii\widgets\Pjax::begin(['id' => 'new_banner', 'options' => ['data-pjax-form-container' => '1']]) ?>
    
    <?php
    
        $form = yii\bootstrap\ActiveForm::begin([
            'id' => 'frmBanner',
            'enableClientValidation' => true,
            'validationUrl' => ['validate' . (empty($model->id) ? '' : '?id='.$model->id)],
            'options' => [
                'class' => 'custom',
                'role' => 'form',
                'data-pjax' => true,
            ],
            'fieldConfig' => [
                'options' => ['class' => '', 'enctype' => 'multipart/form-data']
            ]
        ]);
        
    ?>
    
    <div class="panel-body">

        <?php

        echo '<div class="row">';

        echo $form->field($model, 'quote', [
            'template' => '<div class="col-xs-12">
                      <div class="form-group">{label}{input}{error}</div></div>',
        ])->textarea(['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Quote from the author', 'autofocus' => 'autofocus']);

        echo '</div>';
        
        echo '<div class="row">';

        echo $form->field($model, 'author', [
            'template' => '<div class="col-xs-8">
                      <div class="form-group">{label}{input}{error}</div></div>',
        ])->textInput(['class' => 'form-control', 'placeholder' => 'Author of the quote']);

        echo $form->field($model, 'sort_order', [
            'template' => '<div class="col-xs-4">
                      <div class="form-group">{label}{input}{error}</div></div>',
        ])->textInput(['class' => 'form-control', 'placeholder' => 'Sequence of appearance']);
        
        echo '</div>';
        
        echo '<div class="row">';

        echo $form->field($model, 'image', [
            'template' => '<div class="col-xs-12">
                      <div class="form-group">{label}{input}{error}</div></div>',
        ])->fileInput(['class' => 'form-control', 'placeholder' => 'Browse the image to be put in background']);

        echo '</div>';
        
        echo '<div class="row">';

        echo $form->field($model, 'publish_at', [
            'enableAjaxValidation' => true,
            'template' => '<div class="col-xs-12 col-sm-6">
                      <div class="form-group has-feedback has-feedback-right">{label}{input}<div class="form-control-feedback"><i class="icon-calendar"></i></div>{error}</div></div>',
        ])->textInput(['class' => 'form-control anytime-both', 'placeholder' => 'Timestamp when the item should go live']);
        
        echo $form->field($model, 'expire_at', [
            'enableAjaxValidation' => true,
            'template' => '<div class="col-xs-12 col-sm-6">
                      <div class="form-group has-feedback has-feedback-right">{label}{input}<div class="form-control-feedback"><i class="icon-calendar"></i></div>{error}</div></div>',
        ])->textInput(['class' => 'form-control anytime-both', 'placeholder' => 'Timestamp when the item should go off']);

        echo '</div>';

        ?>

        <div class="navbar-fixed-bottom text-right">
            <button class="btn btn-primary" type="submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
        </div>
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
<?php
$this->registerJsFile(AppIframeAsset::register($this)->baseUrl . '/js/core/moment.js', ['position' => $this::POS_END]);
$this->registerJsFile(AppIframeAsset::register($this)->baseUrl . '/js/plugins/pickers/anytime.min.js', ['position' => $this::POS_END]);
$datePickerJs = <<<JS
    $(function () {                      
        $(".anytime-both").AnyTime_picker({
            format: "%d-%m-%Y %H:%i",
        });
    });
JS;
$this->registerJs($datePickerJs, $this::POS_READY);
?>