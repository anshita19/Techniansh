<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use backend\assets\AppInnerAsset;

AppInnerAsset::register($this);
?>
<div class="navbar navbar-default header-highlight">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>"><span class="text-semibold" style="color:#FFFFFF;"><?= Yii::$app->name ?></span></a>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>

        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo AppInnerAsset::register($this)->baseUrl; ?>/images/placeholder.jpg" alt="">
                        <span><?php echo (isset(Yii::$app->user->identity->first_name)) ? Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name : ''; ?></span>
                        <i class="caret"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="<?= Yii::$app->urlManager->createUrl(['profile']) ?>"><i class="icon-user"></i> My profile</a></li>
                        <!--<li><a href="#"><i class="icon-cog5"></i> Change Password</a></li>-->
                        <li class="divider"></li>
                        <li>
                            <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'form-control no-border']) ?>
                            <?=
                            Html::a('<i class="icon-switch2"></i> Logout</a>', 'site/logout', [
                                'data' => [
                                    'method' => 'post',
                                ]
                            ])
                            ?>
                            <?= Html::endForm(); ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php
$this->registerCss('.no-border {
    border: 0;
    box-shadow: none;
    padding:0;
}
.no-border a{
    display:block;
    padding:8px 15px;
}
.no-border a i{
    margin-right:10px;
}
.no-border a:hover{
    background-color:#F5F5F5;
}');
?>
