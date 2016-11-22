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

$this->title = 'View Company Address';
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
                    <h2 class="title lg"><span class="pyr-sprite sprite-location"></span> Contact Info</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="add-address custom">
                        <?php
                        echo Html::a('+ Add New Address', Yii::$app->urlManager->createUrl(['myaccount/address/create']), ['class' => 'btn bg-yellow']);
                        ?>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($modelAddress)) {
                foreach ($modelAddress as $value) {
                    ?>
                    <div class="block2 profile-view custom">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="item no-brd">
                                    <span class="label">Address</span>
                                    <span class="value">
                                        <?php echo Formatter::asNtext($value['address']).'<br/>'.$value['city'].'<br/>'.$value['state']['name']; ?><br><br>
                                        Phone: <?php echo $value['contact'] ?><br>Fax: <?php echo $value['fax'] ?><br>Email: <?php echo Formatter::asEmail($value['email']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <?= Html::a('Edit', Yii::$app->urlManager->createUrl(['myaccount/address/update', 'id' => $value['address_id']]), ['class' => 'btn bg-blue']) ?>
                            </div>
                            <div class="col-xs-6">
                                <?= Html::a('Delete', Yii::$app->urlManager->createUrl(['myaccount/address/delete', 'id' => $value['address_id']]), ['class' => 'btn bg-red']) ?>
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