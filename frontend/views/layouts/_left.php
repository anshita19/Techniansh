<?php
use yii\helpers\Html;

?>
<div id="myaccount-sidebar">
    <div id="dashboard-menu-icon">
        <span class="text">Menu</span><a href="javascript:;"><span></span></a>
    </div>
    <ul>
        <li id="dashboard"><a href="<?= Yii::$app->urlManager->createUrl(['myaccount'])?>">Dashboard</a></li>
        <li id="d-my-profile"><a href="<?= Yii::$app->urlManager->createUrl(['myaccount/myprofile'])?>">My Profile</a></li>
        <li id="d-change-password"><a href="<?= Yii::$app->urlManager->createUrl(['myaccount/changepassword'])?>">Change Password</a></li>
        <li id="d-logout"><?php echo Html::beginForm(['site/logout'], 'post', ['id' => 'frmLogout']); ?><a href="javascript:;" onclick="$('#frmLogout').submit();">Logout</a><?php echo Html::endForm(); ?></li>
    </ul>
</div>