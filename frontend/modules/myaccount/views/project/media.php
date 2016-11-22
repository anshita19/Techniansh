<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\web\Request;
use yii\i18n\Formatter;
use yii\bootstrap\ActiveField;
use yii\bootstrap\ActiveForm;
use frontend\modules\myaccount\Module;

$this->title = $MediaTitle;
?>
<section id="system-integrator-account" class="main-container">
    <div class="container">
        <?php echo $this->render("//layouts/_myaccountnav"); ?>
        <!-- Company Info Section -->
        <div class="company-information">
            <div class="row">
                <div class="sia-profile-logo">
                    <div class="sia-profile-top clearfix">
                        <div class="pic"><a href="#"><img alt="" src="<?=Module::getInstance()->company_logo?>"></a></div>
                        <div class="compname"><?=Module::getInstance()->company_name?><span>Service Provider</span></div>
                    </div>
                </div>
            </div>
            <?= common\widgets\Alert::widget() ?>    
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="title lg"><span class="pyr-sprite sprite-samples"></span> <?=$MediaTitle?></h2>
                </div>
            </div>
            <?php
            $form = ActiveForm::begin(['id' => 'updateawardfrm',
                        //'enableAjaxValidation' => true,
                        'enableClientValidation' => TRUE,
                        'options' => [
                            'class' => 'custom',
                            'role' => 'form',
                            'enctype' => "multipart/form-data",
                        ],
                        'fieldConfig' => [
                        //'options' => ['tag' => 'span']
                        ]
            ]);
            ?>
            <div class="row">
                <div class="col-xs-6 col-sm-6">
                    <div class="item">
                        <div class="form-group">
                            <div class="browse">
                                <?php
                                echo $form->field($modelProjectMedia, 'media_file_name', [
                                    'template' => '{input}{hint}{error}',
                                ])->fileInput(['class' => 'hide-input',
                                    'onchange' => 'jQuery(this).next().children().eq(0).val(jQuery(this).val());'
                                ]);
                                ?>
                                <div class="show-input"><input type="text" class="form-control" id="uploadfile" placeholder="Browse Multiple Files" style="display:none;"><span class="action">Browse</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                    <?php echo Html::submitButton('Upload', ['class' => 'btn bg-green']) ?>
                </div>
            </div>
            <?php
            ActiveForm::end();
            ?>
            <?php
            if (!empty($modelProjectMediaArr)) {
                foreach ($modelProjectMediaArr as $value) {
                    ?>
                    <div class="block2 profile-view custom">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="certi-thumb"><img class="img-responsive" src="<?= Yii::getAlias('@getuploads') ?>/project/<?=$MediaUpload?>/images/<?= $value['media_file_name'] . '.' . $value['media_ext'] ?>" alt=""></div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <?= Html::a('Delete', Yii::$app->urlManager->createUrl(['myaccount/project/deletemedia', 'id' => $value['project_media_id']]), ['class' => 'btn bg-red']) ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>