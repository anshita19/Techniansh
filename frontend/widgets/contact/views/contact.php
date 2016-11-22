<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use frontend\widgets\contact\assets\AppContactAsset;
use common\widgets\Alert;

AppContactAsset::register($this);
?>
<div id="contact-form">
    <h3>Contact Us</h3>
    <?php
    echo Alert::widget();
    ?>    
        <?php

        $form = ActiveForm::begin(['id' => 'contactfrm',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'action' => Url::to(['/contact/default/send']),
                    'validationUrl' => ['/contact/default/validatecontact'],
                    'options' => [
                        'class' => 'clearfix',
                        'role' => 'form',
                        'data-pjax' => false,
                    ],
                    'fieldConfig' => [
                        'options' => ['class' => '']
                    ]
        ]);
        ?>

        <div class="form-group">
            <?php
            echo $form->field($model, 'company_name', [
                'template' => '<div class="input-group">{input}</div>{error}'
            ])->textInput(['placeholder' => 'Company Name *', 'class' => 'form-control']);
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $form->field($model, 'contact_person_name', [
                'template' => '<div class="input-group">{input}</div>{error}'
            ])->textInput(['placeholder' => 'Contact Person Name *', 'class' => 'form-control']);
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $form->field($model, 'email', [
                'enableAjaxValidation' => true,
                'template' => '<div class="input-group">{input}</div>{error}'
            ])->textInput(['placeholder' => 'Email Address *', 'class' => 'form-control']);
            ?>
        </div>        
        <div class="form-group">
            <?php
            echo $form->field($model, 'country', [
                'template' => '{input}{error}',
            ])->dropDownList($model->getCountryList(), ['prompt' => 'Select Country *', 'class' => 'form-control state-list']);
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $form->field($model, 'mobile', [
                'template' => '<div class="input-group">{input}</div>{error}'
            ])->textInput(['placeholder' => 'Mobile *', 'class' => 'form-control']);
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $form->field($model, 'requirement', [
                'template' => '<div class="input-group">{input}</div>{error}'
            ])->textarea(['placeholder' => 'Please describe your specific/customized requirements: *', 'rows' => 3, 'class' => 'form-control']);
            ?>
        </div>                        
        <div class="btn-wrap pull-right">                
            <input class="btn btn-form" type="submit" value="Send">
            <input class="btn btn-form" type="reset" value="Reset">
        </div>        
        <?php
        ActiveForm::end();
        ?>    
</div>

<?php
$contactJs = <<<JS
    $(".state-list").select2({
        placeholder: "Select your Country :*",
        allowClear: true
    });        
JS;
$this->registerJs($contactJs, $this::POS_READY);
?>