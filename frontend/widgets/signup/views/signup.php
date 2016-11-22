<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use frontend\widgets\signup\assets\AppSignupAsset;
use yii\captcha\Captcha;
use common\widgets\Alert;

AppSignupAsset::register($this);
?>
<div class="row">
    <div id="page" class="clearfix">
        <?php
        echo Alert::widget();
        ?>
        <h1 class="text-center">Sign up with us <span>Lorem Ipsum is simply dummy text </span></h1>
        <div class="hidden-xs hidden-sm col-md-2 col-lg-4"></div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-4">
            <?php
           
            $form = ActiveForm::begin(['id' => 'signupfrm',
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'action' => Url::to(['/signup/default/create']),
                        'validationUrl' => ['/signup/default/validatesignup'],
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

            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <?php
                    echo $form->field($model, 'first_name', [
                        'template' => '<div class="input-group">{input}
                                            <div class="input-group-addon"><span class="icon sprite-person"></span></div></div>{error}'
                    ])->textInput(['placeholder' => 'First Name *', 'class' => 'form-control']);
                    ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <?php
                    echo $form->field($model, 'last_name', [
                        'template' => '<div class="input-group">{input}
                                            <div class="input-group-addon"><span class="icon sprite-person"></span></div></div>{error}'
                    ])->textInput(['placeholder' => 'Last Name *', 'class' => 'form-control']);
                    ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <?php
                    echo $form->field($model, 'address1', [
                        'template' => '<div class="input-group">{input}
                                            <div class="input-group-addon"><span class="icon sprite-address"></span></div></div>{error}'
                    ])->textInput(['placeholder' => 'Address Line 1', 'class' => 'form-control']);
                    ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <?php
                    echo $form->field($model, 'address2', [
                        'template' => '<div class="input-group">{input}
                                            <div class="input-group-addon"><span class="icon sprite-address"></span></div></div>{error}'
                    ])->textInput(['placeholder' => 'Address Line 2', 'class' => 'form-control']);
                    ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <?php
                    echo $form->field($model, 'city', [
                        'template' => '<div class="input-group">{input}
                                            <div class="input-group-addon"><span class="icon sprite-city"></span></div></div>{error}'
                    ])->textInput(['placeholder' => 'City', 'class' => 'form-control']);
                    ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <?php
                    echo $form->field($model, 'state', [
                        'template' => '{input}{error}',
                    ])->dropDownList([1 => 'Gujarat', 2 => 'Delhi', 3 => 'Goa', 4 => 'Maharashtra'], ['prompt' => 'Select State', 'class' => 'form-control state-list']);
                    ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <?php
                    echo $form->field($model, 'email', [
                        'enableAjaxValidation' => true,
                        'template' => '<div class="input-group">{input}
                                            <div class="input-group-addon"><span class="icon sprite-email"></span></div></div>{error}'
                    ])->textInput(['placeholder' => 'Email Address *', 'class' => 'form-control']);
                    ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <?php
                    echo $form->field($model, 'password_hash', [
                        'template' => '<div class="input-group">{input}
                                            <div class="input-group-addon"><span class="icon sprite-password"></span></div></div>{error}'
                    ])->passwordInput(['placeholder' => 'Choose a Password *', 'class' => 'form-control']);
                    ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <?php
                    echo $form->field($model, 'password_repeat', [
                        'template' => '<div class="input-group">{input}
                                            <div class="input-group-addon"><span class="icon sprite-password"></span></div></div>{error}'
                    ])->passwordInput(['placeholder' => 'Confirm Password *', 'class' => 'form-control']);
                    ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <?php
                    echo $form->field($model, 'phone', [
                        'template' => '<div class="input-group">{input}
                                            <div class="input-group-addon"><span class="icon sprite-mobile"></span></div></div>{error}'
                    ])->textInput(['placeholder' => 'Phone', 'class' => 'form-control']);
                    ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label>What services you are interested in?</label>
                    <?php
                    echo $form->field($model, 'services', [
                        'checkboxTemplate' => '<div class="form-group">{label}{input}{error}</div>',
                    ])->checkboxList($widget->signupService)->label(false);
                    ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group has-captcha">
                    <div class="input-group">
                        <?= $form->field($model, 'verifyCode', [
                            ])->widget(Captcha::className(), [
                            'template' => '{image}{input}',])
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <?php
                    echo $form->field($model, 'is_agree', [
                        'checkboxTemplate' => '{input}{label}{error}',
                    ])->checkbox()->label('I agree to <a href="#term-popup" class="terms-link fancybox">Terms & Conditions</a>');
                    ?>
                </div>
                <div id="term-popup" style="display: none;">
                    <h4>consectetur adipiscing elit</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis nibh dapibus, bibendum justo a, convallis mi.</p>
                    <ul>
                        <li>Integer vulputate sapien id ultricies vehicula.</li>
                        <li>Duis faucibus, purus id posuere eleifend, urna urna interdum metus, vitae facilisis dui mi a lectus. Nulla vestibulum justo imperdiet, ullamcorper eros eget, pharetra neque</li>
                        <li>Donec pellentesque porttitor augue, quis imperdiet ligula volutpat eget. </li>
                        <li>Cras nec mollis sapien, et convallis tortor. Vestibulum mollis elementum dui at convallis. Quisque vel malesuada ligula. </li>
                        <li>Nulla sit amet ex sed ligula sollicitudin hendrerit</li>
                    </ul>
                </div>    
            </div>
            <div class="col-xs-12">
                <input class="btn" type="submit" value="Sign Up">
            </div>
            <?php
            ActiveForm::end();
            ?>
        </div>
        <div class="hidden-xs hidden-sm col-md-2 col-lg-4"></div>
        <div class="col-xs-12">
            <div class="signin-block">
                <p>Already have <a href="<?=Yii::$app->homeUrl?>">Techniansh</a> account?, <a href="<?=Yii::$app->urlManager->createUrl(['site/signin'])?>">Sign In</a></p>
            </div>
        </div>
    </div>
</div>

<?php
$signupJs = <<<JS
    $(".state-list").select2();
    $('.fancybox').fancybox();
        
JS;
$this->registerJs($signupJs, $this::POS_READY);
$signupCss = <<<CSS
    .help-block-error{float:left}  
CSS;
$this->registerCss($signupCss);
?>