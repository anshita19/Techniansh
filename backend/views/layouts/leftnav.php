<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use backend\assets\AppInnerAsset;
use common\models\User;

AppInnerAsset::register($this);
?>
<div class="sidebar-category sidebar-category-visible">
    <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion">

            <!-- Main -->
            <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
            <li>
                <a href="#"><i class="icon-city"></i><span>Countries & States</span></a>
                <ul>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['country']) ?>" data-canonical="<?= Yii::$app->urlManager->createUrl(['country']) ?>"><i class="icon-city"></i> <span>Country</span></a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['state']) ?>" data-canonical="<?= Yii::$app->urlManager->createUrl(['state']) ?>"><i class="icon-city"></i> <span>State</span></a></li>
                </ul>
            </li>
            <?php if(Yii::$app->user->identity->user_type ==  User::TYPE_Admin) { ?>
            
            <li><a href="#"><i class="icon-calendar52"></i> <span>User & Role Management</span></a>
                <ul>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['accounts'])?>"><i class="icon-users"></i> <span>Accounts</span></a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['roles'])?>"><i class="icon-users"></i> <span>Roles</span></a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['modules'])?>"><i class="icon-users"></i> <span>Modules</span></a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['moduleactions'])?>"><i class="icon-users"></i> <span>Module Actions</span></a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['moduleaccesscontrols'])?>"><i class="icon-users"></i> <span>Module Access Controls</span></a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['session'])?>"><i class="icon-switch2"></i> <span>Session Manager</span></a></li>
                </ul>
            </li>
            <?php
                }
            ?>
            <!-- /main -->

        </ul>
    </div>
</div>