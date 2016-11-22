<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveField;
use yii\bootstrap\ActiveForm;
use frontend\modules\myaccount\Module;

$titleData = ($modelPreference->isNewRecord) ? "Add" : "Update";
$this->title = $titleData . " Preference";
?>
<section id="system-integrator-account" class="main-container">
    <div class="container">
        <?php echo $this->render("//layouts/_myaccountnav"); ?>
        <!-- Company Info Edit Section -->
        <div class="company-information-edit">
            <div class="row">
                <div class="sia-profile-logo">
                    <div class="sia-profile-top clearfix">
                        <div class="pic"><a href="#"><img alt="" src="<?=Module::getInstance()->company_logo?>"></a></div>
                        <div class="compname"><?=Module::getInstance()->company_name?><span>Service Provider</span></div>
                    </div>
                </div>
            </div>
            <?= common\widgets\Alert::widget() ?>
            <div class="manage-preferences">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="title lg spl"><span class="pyr-sprite sprite-preferences"></span> <?=$titleData?> Preferences</h2>
                    </div>
                </div>
                <?php
                $form = ActiveForm::begin(['id' => 'updatepreferencefrm',
                            //'enableAjaxValidation' => false,
                            'enableClientValidation' => true,
                            'options' => [
                                'class' => 'custom',
                                'role' => 'form',
                            ],
                            'fieldConfig' => [
                            //'options' => ['tag' => 'span']
                            ]
                ]);
                ?>
                <div class="preferences">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="title"><span class="pyr-sprite sprite-modules"></span> Modules</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <?php
                                        echo $form->field($modelPreference, 'moduleType')->checkboxList([
                                            'is_module_trusted' => $modelPreference->getAttributeLabel('is_module_trusted'),
                                            'is_module_other' => $modelPreference->getAttributeLabel('is_module_other')
                                                ], ['item' => function($index, $label, $name, $checked, $value) {
                                                $checked = ($checked == '1') ? 'checked="checked"' : '';
                                                return "<input type='checkbox' {$checked} name='{$name}' value='{$value}' id='{$value}' ><label class='mar-right' for='{$value}'><span></span> {$label}</label>";
                                            }
                                        ])->label(false);
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group inline-select">
                                        <?php
                                        echo $form->field($modelPreference, 'module_capacity', [
                                            //'options' => ['tag' => 'span'],
                                            'template' => '{input}{error}',
                                        ])->textInput(['class' => 'form-control input-lg', 'placeholder' => 'Size']);
                                        ?>

                                        <div class="select-style">
                                            <?php
                                            echo $form->field($modelPreference, 'module_capacity_unit', [
                                                'template' => '{input}{error}',
                                            ])->dropDownList(Yii::$app->params['capacityUnit'], ['class' => 'form-control', 'data-width' => "auto", 'prompt' => 'Select Unit']);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (!empty($mediaArr)) {
                                ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <ul class="custom-img-chkbox">
                                            <?php
                                            foreach ($mediaArr['module'] as $value) {
                                                $selDiv = '';
                                                $checked = '';
                                                if (!empty($value['module_sel_id'])) {
                                                    $selDiv = 'active';
                                                    $checked = 'checked="checked"';
                                                }
                                                ?>
                                                <li>
                                                    <div data-toggle="buttons" class="btn-group">
                                                        <label class="btn btn-default <?= $selDiv ?>">
                                                            <img alt="<?= $value['name'] ?>" title="<?= $value['name'] ?>" src="<?= Yii::getAlias('@getuploads') ?>/manufacturer/images/<?= $value['logo'] ?>">
                                                            <div class="bizcontent">
                                                                <?php
                                                                echo Html::checkbox('Preference[module_logo][]', $checked, ['value' => $value['id']]);
                                                                ?>
                                                                <span class="fa fa-check fa-lg"></span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div><hr>
                                <?php
                            }
                            ?>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="title"><span class="pyr-sprite sprite-inverters"></span> Inverters</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <?php
                                        echo $form->field($modelPreference, 'inverterType')->checkboxList([
                                            'is_inverter_trusted' => $modelPreference->getAttributeLabel('is_inverter_trusted'),
                                            'is_inverter_other' => $modelPreference->getAttributeLabel('is_inverter_other')
                                                ], ['item' => function($index, $label, $name, $checked, $value) {
                                                $checked = ($checked == '1') ? 'checked="checked"' : '';
                                                return "<input type='checkbox' {$checked} name='{$name}' value='{$value}' id='{$value}' ><label class='mar-right' for='{$value}'><span></span> {$label}</label>";
                                            }
                                        ])->label(false);
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group inline-select">
                                        <?php
                                        echo $form->field($modelPreference, 'inverter_capacity', [
                                            //'options' => ['tag' => 'span'],
                                            'template' => '{input}{error}',
                                        ])->textInput(['class' => 'form-control input-lg', 'placeholder' => 'Size']);
                                        ?>
                                        <div class="select-style">
                                            <?php
                                            echo $form->field($modelPreference, 'inverter_capacity_unit', [
                                                'template' => '{input}{error}',
                                            ])->dropDownList(Yii::$app->params['capacityUnit'], ['class' => 'form-control', 'data-width' => "auto", 'prompt' => 'Select Unit']);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if (!empty($mediaArr)) {
                                ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <ul class="custom-img-chkbox">
                                            <?php
                                            foreach ($mediaArr['inverter'] as $value) {
                                                $selDiv = '';
                                                $checked = '';
                                                if (!empty($value['inverter_sel_id'])) {
                                                    $selDiv = 'active';
                                                    $checked = 'checked="checked"';
                                                }
                                                ?>
                                                <li>
                                                    <div data-toggle="buttons" class="btn-group">
                                                        <label class="btn btn-default <?= $selDiv ?>">
                                                            <img alt="<?= $value['name'] ?>" title="<?= $value['name'] ?>" src="<?= Yii::getAlias('@getuploads') ?>/manufacturer/images/<?= $value['logo'] ?>">
                                                            <div class="bizcontent">
                                                                <?php
                                                                echo Html::checkbox('Preference[inverter_logo][]', $checked, ['value' => $value['id']]);
                                                                ?>
                                                                <span class="fa fa-check fa-lg"></span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div><hr>
                                <?php
                            }
                            ?>

                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo Html::submitButton('Save', ['class' => 'btn bg-green']) ?>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <?php
                ActiveForm::end();
                ?>
            </div>

        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        // $('[data-style="select2"]').select2();
    });
</script>