<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\web\Request;
use yii\i18n\Formatter;
use frontend\modules\myaccount\Module;

$this->title = 'View Awards';
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
                    <h2 class="title lg"><span class="pyr-sprite sprite-awards"></span> Awards</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="add-address custom">
                        <?php
                        echo Html::a('+ Add New Award', Yii::$app->urlManager->createUrl(['myaccount/award/create']), ['class' => 'btn bg-yellow']);
                        ?>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($modelAward)) {
                foreach ($modelAward as $value) {
                    ?>
                    <div class="block2 profile-view custom">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="certi-thumb"><img class="img-responsive" src="<?= Yii::getAlias('@getuploads') ?>/award/images/<?= $value['logo_file_name'] . '.' . $value['logo_ext'] ?>" alt=""></div>
                                <div class="certi-title"><?=$value['award_title']?><br/><?=Yii::$app->params['awardMonth'][$value['award_month']]?>-<?=$value['award_year']?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <?= Html::a('Edit', Yii::$app->urlManager->createUrl(['myaccount/award/update', 'id' => $value['award_id']]), ['class' => 'btn bg-blue']) ?>
                            </div>
                            <div class="col-xs-6">
                                <?= Html::a('Delete', Yii::$app->urlManager->createUrl(['myaccount/award/delete', 'id' => $value['award_id']]), ['class' => 'btn bg-red']) ?>
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