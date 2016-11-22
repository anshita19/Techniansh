<?php

use frontend\assets\AppInnerAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use common\widgets\Alert;

$bundle=AppInnerAsset::register($this);

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?php echo $this->title; ?></h1>

    <?php
        echo Alert::widget();
        $form = ActiveForm::begin(['id' => 'changepasswordfrm',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,                    
            'validationUrl' => ['/myaccount/validateuserpassword'],
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
            echo $form->field($model, 'password_hash', [
                'template' => '<div class="col-xs-6 col-sm-6"><div class="form-group">
                                    <div class="input-group">
                                        {input}<div class="input-group-addon"><span class="icon sprite-password"></span></div></div>{error}</div></div>',
            ])->passwordInput(['placeholder' => 'Enterm Old Password', 'class' => 'form-control']);
        ?>
    </div>
    
    <div class="row">
    <?php        
        echo $form->field($model, 'new_password', [
                'template' => '<div class="col-xs-6 col-sm-6"><div class="form-group">
                                    <div class="input-group">
                                        {input}<div class="input-group-addon"><span class="icon sprite-password"></span></div></div>{error}</div></div>',
            ])->passwordInput(['placeholder' => 'Enter New Password', 'class' => 'form-control']);
    ?>
    </div>
    
    <div class="row">
    <?php        
        echo $form->field($model, 'retype_password', [
                'template' => '<div class="col-xs-6 col-sm-6"><div class="form-group">
                                    <div class="input-group">
                                        {input}<div class="input-group-addon"><span class="icon sprite-password"></span></div></div>{error}</div></div>',
            ])->passwordInput(['placeholder' => 'Rewrite New Password', 'class' => 'form-control']);
    ?>
    </div>
    
    <div class="btn-wrap">
        <input class="btn btn-save" type="submit" value="Save">        
    </div>  
    
    <?php
    ActiveForm::end();                
    ?>            
<?php
$activemenuJS = <<<JS
    $("#myaccount-sidebar ul li#d-change-password").addClass("active");
JS;

$this->registerJs($activemenuJS, $this::POS_READY);
?>