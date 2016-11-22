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

$this->title = 'Projects';
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
                    <h2 class="title lg"><span class="pyr-sprite sprite-projects"></span> Projects</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="add-address custom">
                        <?php
                        echo Html::a('+ Add New Project', Yii::$app->urlManager->createUrl(['myaccount/project/create']), ['class' => 'btn bg-yellow']);
                        ?>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($modelProject)) {
                foreach ($modelProject as $value) {
                    $capacity = ($value['capacity_unit'] == '2') ? ($value['capacity'] / 1000) : $value['capacity'];
                    ?>
                    <div class="block2 profile-view custom projects">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="item no-brd">
                                    <span class="value color-blue"><a href="<?=Yii::$app->urlManager->createUrl(['myaccount/project/viewproject', 'id' => $value['project_id']])?>"><?= $capacity ?> <?= Yii::$app->params['capacityUnit'][$value['capacity_unit']] ?> Project at <?= $value['city'] ?></a></span>
                                    <span class="label"><?= $value['state']['name'] ?></span><br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <?= Html::a('Edit', Yii::$app->urlManager->createUrl(['myaccount/project/update', 'id' => $value['project_id']]), ['class' => 'btn bg-blue']) ?>
                            </div>
                            <div class="col-xs-6">
                                <?= Html::a('Delete', Yii::$app->urlManager->createUrl(['myaccount/project/delete', 'id' => $value['project_id']]), ['class' => 'btn bg-red']) ?>
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