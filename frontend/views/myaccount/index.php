<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use frontend\assets\AppInnerAsset;
use yii\helpers\Html;

AppInnerAsset::register($this);

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?php echo $this->title; ?></h1>
    
<?php

$activemenuJS = <<<JS
    $("#myaccount-sidebar ul li#dashboard").addClass("active");	
JS;

$this->registerJs($activemenuJS, $this::POS_READY);
?>