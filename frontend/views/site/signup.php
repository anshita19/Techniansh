<?php
/* @var $this yii\web\View */

//use Yii;
use frontend\assets\AppInnerAsset;

AppInnerAsset::register($this);
$this->title = Yii::$app->name;

echo frontend\widgets\signup\SignupWidget::widget();

?>

