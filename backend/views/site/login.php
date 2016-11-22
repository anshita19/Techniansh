<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\ActiveField;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$form = ActiveForm::begin(['id' => 'loginfrm',
            'enableAjaxValidation' => true,
            'fieldConfig' => [
                'options' => ['tag' => 'span']
            ]
        ]);
?>
<div class="panel panel-body login-form">
    <div class="text-center">
        
        <h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
    </div>

    <?php
    echo $form->field($model, 'email', [
        'template' => '<div class="form-group has-feedback has-feedback-left">
                          {input}{error}<div class="form-control-feedback">
            <i class="icon-user text-muted"></i></div></div>',
    ])->textInput(['class' => 'form-control', 'placeholder' => 'Email','autofocus' => true]);

    echo $form->field($model, 'password', [
        'template' => '<div class="form-group has-feedback has-feedback-left">
                          {input}{error}<div class="form-control-feedback">
            <i class="icon-lock2 text-muted"></i>
        </div></div>',
    ])->passwordInput(['class' => 'form-control', 'placeholder' => 'Password']);
    ?>
    <div class="form-group">
        <?= Html::button('Sign in <i class="icon-arrow-right14 position-right"></i>', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button', 'type' => 'submit']) ?>
    </div>
</div>
<?php
ActiveForm::end();
$js = <<<JS
      $('form#loginfrm').on('afterValidate',function (e) {
     var form = $(this);
     // return false if form still have some validation errors
     if (form.find('.has-error').length) {
      $(".panel").velocity("callout.shake", { stagger: 500 });
        e.preventDefault();
     }
});  
JS;
$this->registerJs($js);
?>
