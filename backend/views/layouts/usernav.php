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
<div class="sidebar-user">
    <div class="category-content">
        <div class="media">
            <a href="#" class="media-left"><img src="<?php echo AppInnerAsset::register($this)->baseUrl; ?>/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
            <div class="media-body">
                <span class="media-heading text-semibold"><?php echo (isset(Yii::$app->user->identity->first_name))?Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name:''; ?></span>
                <div class="text-size-mini text-muted">
                    <i class="text-size-small"></i> &nbsp;<?php echo (isset(Yii::$app->user->identity->email))?Yii::$app->user->identity->email:''; ?>
                </div>
            </div>
        </div>
    </div>
</div>