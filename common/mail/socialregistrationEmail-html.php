<?php
use yii;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->first_name.' '.$user->last_name) ?>,</p>
    
    <p>Your account has been created.</p>

    <p>Thank you for registering with <?=  Html::encode(Yii::$app->name)?>.</p>
</div>
