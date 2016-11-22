<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\ActiveField;
use yii\web\JsExpression;
use yii\widgets\Pjax;

use common\widgets\Alertbackend;

use backend\assets\AppIframeAsset;

AppIframeAsset::register($this);

$this->title = Yii::t('app', 'Create Module Action');

echo '<div id="msg_panel">' . Alertbackend::widget() . '</div>';

?>

<div class="panel panel-flat">
    
    <?php Pjax::begin(['id' => 'new_moduleaction', 'options' => ['data-pjax-form-container' => '1']]) ?>
    
    <?php
    
    $form = ActiveForm::begin(['id' => 'moduleactionfrm',
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
            echo $form->field($model, 'module_id', [
                'template' => '<div class="col-xs-6 col-sm-6">
                                      <div class="form-group">{label}{input}{error}</div></div>',
            ])->dropDownList($model->getModuleCmb(), ['class' => 'form-control select', 'prompt' => 'Please Select','disabled'=>(!$model->isNewRecord)?true:false, 'onchange' => '
                $.post( "' . Yii::$app->urlManager->createUrl('moduleactions/getmoduleactionlists?id=') . '"+$(this).val(),{ _csrf: yii.getCsrfToken()}, function( data ) {
			$( "#moduleaction-action_name" ).html( data );
			$("input:checkbox[name=\'ModuleAction[action_name][]\']").uniform({radioClass: "choice"});
                });
            ']);
            ?>	

            <?php
            echo '<div class="col-xs-6 col-sm-6">' . $form->field($model, 'action_name', [
                'checkboxTemplate' => '<div class="form-group">{label}<div class="choice"><span class="checked">{input}</span></div>{error}</div>',
            ])->checkboxList($model->getControllerActionCheckboxList($model->module_id), ['itemOptions' => ['class' => 'styled']]) . '</div>';
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