<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$activeLink = Yii::$app->urlManager->createAbsoluteUrl(['signup/default/active-account', 'token' => $user->ua_auth_key]);
$cancelLink = Yii::$app->urlManager->createAbsoluteUrl(['signup/default/cancel-account', 'token' => $user->uc_auth_key]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->first_name.' '.$user->last_name) ?>,</p>

    <p>Follow the link below to active your account:</p>

    <p><?= Html::a(Html::encode($activeLink), $activeLink) ?></p>
    
    <p>Follow the link below to cancel your registration:</p>

    <p><?= Html::a(Html::encode($cancelLink), $cancelLink) ?></p>
</div>
