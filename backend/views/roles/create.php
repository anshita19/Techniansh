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
$this->title = Yii::t('app', 'Create Usergroup');
echo '<div id="msg_panel">' . Alertbackend::widget() . '</div>';
?>
<div class="panel panel-flat">
    <?php Pjax::begin(['id' => 'new_usergroup', 'options' => ['data-pjax-form-container' => '1']]) ?>
    <?php
    $form = ActiveForm::begin(['id' => 'usergroupfrm',
                //'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'validationUrl' => [(!empty($model->usergroup_id)) ? 'validateusergroup?id=' . $model->usergroup_id : 'validateusergroup'],
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
            echo $form->field($model, 'title', [
                'template' => '<div class="col-xs-6 col-sm-6">
                                      <div class="form-group">{label}{input}{error}</div></div>',
            ])->textInput(['class' => 'form-control', 'placeholder' => 'Title']);
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