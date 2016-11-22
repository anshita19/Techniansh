<?php

use yii\helpers\Html;
use frontend\assets\AppInnerAsset;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveField;
use yii\bootstrap\ActiveForm;

AppInnerAsset::register($this);
//$baseAssetUrl = AppAsset::register($this)->baseUrl . '/';
?>
<div class="container">
    <div class="row">        
        <div id="page" class="clearfix">
            <h1 class="text-center">Let's sign in <span>Lorem Ipsum is simply dummy text </span></h1>
            <div class="hidden-xs col-sm-2 col-md-2 col-lg-4"></div>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-4">
                <div class="form reg-form login">                    
                    <div id="message">
                        <div class="text-danger"></div>
                    </div>
                    <?php
                    $form = ActiveForm::begin(['id' => 'loginfrm',
                                'enableAjaxValidation' => true,
                                //'enableClientValidation' => true,
                                'options' => [
                                    'class' => 'custom',
                                    'role' => 'form'
                                ],
                                'fieldConfig' => [
                                // 'options' => ['tag' => 'span']
                                ]
                    ]);
                    ?>
                    <div class="form-box">
                        <div class="form-content">
                            <?php
                            echo $form->field($modelLogin, 'email', [
                                'template' => '<div class="control form-group"><div class="input-group">
                                                {input}<div class="input-group-addon"><span class="icon sprite-email"></span></div></div>{error}</div>',
                            ])->textInput(['placeholder' => 'Email Address']);

                            echo $form->field($modelLogin, 'password', [
                                'template' => '<div class="control form-group"><div class="input-group">
                                                {input}<div class="input-group-addon"><span class="icon sprite-password"></span></div></div>{error}</div>',
                            ])->passwordInput(['placeholder' => 'Password']);

                            ?>

                            <div class="control form-group">
                                <input type="submit" value="Sign In" class="btn">
                            </div>
                            <p>If you do not remember your password, <a href="reset-password">Reset here</a></p>
                        </div>
                        
                        <div class="hidden-xs col-sm-2 col-md-2 col-lg-4"></div>
                        <div class="col-xs-12">
                            <div class="signin-block">
                                <p>Do not have <a href="#">Techniansh</a> account?, <a href="<?=Yii::$app->urlManager->createUrl(['site/signup'])?>">Sign Up here</a></p>
                            </div>
                        </div>
                    </div>
                    <?php
                    ActiveForm::end();
                    ?>
                </div>
            </div>
        </div>        
    </div>
</div>
<?php
$this->registerCssFile(AppInnerAsset::register($this)->baseUrl . '/styles/form.css');
