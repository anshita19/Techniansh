<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use frontend\assets\AppInnerAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use common\widgets\Alert;

$bundle=AppInnerAsset::register($this);

$this->title = 'Restructuring';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?php echo $this->title; ?></h1>
    
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    
    <?php
        echo Alert::widget();
        $form = ActiveForm::begin(['id' => 'restructuringfrm',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,                    
                    'options' => [
                        'class' => 'clearfix',
                        'enctype' => 'multipart/form-data',
                        'role' => 'form',                        
                    ],
                    'fieldConfig' => [
                        'options' => ['class' => '']
                    ]
        ]);
    ?>
    
    <div class="row">
        <?php
            echo $form->field($model, 'document', [
                'template' => '<div class="col-xs-12">
                          <div class="form-group clearfix"><div class="browse">{input}<div class="show"><input type="text" placeholder="Please Upload File" id="uploadfile" class="form-control"><span class="action">Browse</span></div><small>you must attach your file (DOC and PDF Only - Max. 2 MB)</small>{error}</div></div></div>',
            ])->fileInput(['class' => 'form-control hide-field', 'onchange' => 'jQuery(this).next().children().eq(0).val(jQuery(this).val());', 'placeholder' => 'Please upload file']);
        ?>
    </div>
        
    <div class="col-xs-12">
        <input class="btn btn-submit" type="submit" value="Send">            
    </div>        
    
    <?php
        ActiveForm::end();
    

$activemenuJS = <<<JS
    $("#myaccount-sidebar ul li#d-restructuring").addClass("active");
JS;

$this->registerJs($activemenuJS, $this::POS_READY);
?>