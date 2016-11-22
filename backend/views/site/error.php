<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use Yii;
use yii\helpers\Html;

$this->context->layout = 'errormain';

$this->title = $name;
preg_match('#\((.*?)\)#', $this->title, $match);
$errorCode = $match[1];
?>

<div class="container-fluid text-center">
    <h1 class="error-title"><?php echo $errorCode; ?></h1>
    <h6 class="text-semibold content-group">Oops, an error has occurred.</br> 
        <?php echo nl2br(Html::encode($message)); ?>
    </h6>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <a href="<?php echo Yii::$app->homeUrl; ?>" class="btn btn-primary btn-block content-group"><i class="icon-circle-left2 position-left"></i> Go to dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>