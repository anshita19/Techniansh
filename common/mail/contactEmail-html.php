<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="password-reset">
    <table width="450" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #A6CE39; font-size:11px; color:#2d303a;">    
    <tr><td align="left" valign="top"><table width="450" border="0" cellpadding="0" cellspacing="0" style="background:#F1F1F1; font-size:110%; padding:20px;">
    <tr><td align="left" valign="top" colspan="2" height="20"></td></tr>
    <tr><td align="left" valign="top" colspan="2" style="font-size:12px; padding:5px; background:#A6CE39; font-weight:bold; color:#fff;">Personnel Details</td></tr>
    <tr><td align="left" valign="top" colspan="2" height="15"></td></tr>
    <tr><td align="right" valign="top" width="20%" height="30" style="color:#7B736E;">Company Name</td><td align="left" valign="top" width="80%" style="padding-left:10px;"><?= Html::encode($contact->contact_person_name) ?></td></tr>
    <tr><td align="right" valign="top" height="30" style="color:#7B736E;">Contact Person</td><td align="left" valign="top" style="padding-left:10px;"><?= Html::encode($contact->contact_person_name) ?></td></tr>
    <tr><td align="right" valign="top" height="30" style="color:#7B736E;">Email</td><td align="left" valign="top" style="padding-left:10px;"><?= Html::encode($contact->email) ?></td></tr>
    <tr><td align="right" valign="top" height="30" style="color:#7B736E;">Country</td><td align="left" valign="top" style="padding-left:10px;"><?= Html::encode($contact->country) ?></td></tr>
    <tr><td align="right" valign="top" height="30" style="color:#7B736E;">Mobile</td><td align="left" valign="top" style="padding-left:10px;"><?= Html::encode($contact->mobile) ?></td></tr>
    <tr><td align="right" valign="top" height="30" style="color:#7B736E;">Requirements</td><td align="left" valign="top" style="padding-left:10px;"><?= Html::encode($contact->requirement) ?></td></tr>    
    </table></td></tr></table>
</div>
