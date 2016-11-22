<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\ActiveField;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

use common\widgets\Alertbackend;

use backend\assets\AppIframeAsset;

AppIframeAsset::register($this);

$this->title = Yii::t('app', 'Create Module Access Control');

echo '<div id="msg_panel">' . Alertbackend::widget() . '</div>';

?>

<div class="panel panel-flat">
    
    <?php Pjax::begin(['id' => 'new_moduleaccesscontrol', 'options' => ['data-pjax-form-container' => '1']]) ?>
    
    <?php
    
        $form = ActiveForm::begin(['id' => 'moduleaccesscontrolfrm',
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
        
        <?php
        
            echo '<div class="row">';

                echo $form->field($model, 'role_id', [
                    'template' => '<div class="col-xs-6 col-sm-6">
                                          <div class="form-group">{label}{input}{error}</div></div>',
                ])->dropDownList($model->getRoleCmb($model->role_id), ['class' => 'form-control select', 'prompt' => 'Please Select', 'disabled' => !$model->isNewRecord]);
                
            echo '</div>';
            
            echo '<div class="row form-group">
                <div class="col-xs-3 col-sm-3 text-bold">Module</div>
                <div class="col-xs-9 col-sm-9 text-bold">Action</div>
            </div>';
            
            $i=1; $html = '';
            
            foreach ($accessControllArr as $key=>$module) {
                $keyArr = $module['moduleActionItems'];
                $actionArr = ArrayHelper::map($module['moduleActionItems'], function($keyArr){
                    return $keyArr['module_id'] . '_' . $keyArr['id'];
                } , 'action_name');
                $error = (count($accessControllArr)==$i) ? '{error}' : '';
                $html .='<div class="row"><div class="col-xs-3 col-sm-3">' . $module['name'] . '</div>';
                $html .='<div class="col-xs-9 col-sm-9">' . $form->field($model, 'module_action_item_id[' . $module['id'] . ']', [
                            'inlineCheckboxListTemplate' => '{label}<span class="checked">{input}</span>'.$error,
                        ])->inline()->checkboxList($actionArr, ['itemOptions' => ['class' => 'styled', 'labelOptions' => ['style' => 'margin-right:5px;']]])->label(false) . '</div></div>';
                $i++;
            }
            
            echo '<div id="module_action_container" class="row">';
                echo '<div class="col-xs-12">';
                    echo $html;
                echo '</div>';
            echo '</div>';
            
        ?>	
        
    </div>

    <div class="navbar-fixed-bottom text-right">
        <button class="btn btn-primary" type="submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
    </div>
    
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
    
</div>
