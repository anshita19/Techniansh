<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="password-reset">
    <table width="450" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #A6CE39; font-family: arial; font-size:11px; color:#2d303a; background: #FFF;">
    <tr><td align="left" valign="top" style="border-bottom:1px solid #A6CE39; text-align:center;"><img src="http:' . $GLBHost . '/images/logo.png" style="margin:15px;"/></td></tr>
    <tr><td align="center" valign="middle" height="30" style="background: #A6CE39; color: #fff; text-transform: uppercase; font-weight: bold; font-size: 13px;">Enquiry</td></tr>
    <tr><td align="left" valign="top"><table width="450" border="0" cellpadding="0" cellspacing="0" align="center" style="font-size:110%; padding:10px;">
    <tr><td align="left" valign="top" colspan="2" height="10"></td></tr>
    <tr><td align="left" valign="top" colspan="2" height="10">
        <p>Dear <b><?= Html::encode($contact->contact_person_name) ?></b>, <br/><br/>
            We have successfully received your request.<br/><br/> 
            we will get back to you soon. <br><br/><br/> 
            Thank You, <br>
            <b>Team <?=  Html::encode(Yii::$app->name)?></b>
        </p>
    </td></tr>
    <tr><td align="left" valign="top" colspan="2" height="10"></td></tr>
    </table></td></tr></table>
</div>
