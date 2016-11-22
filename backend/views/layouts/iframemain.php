<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppIframeAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

AppIframeAsset::register($this);
if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    
    <head>
        
        <title><?= Html::encode($this->title) ?></title>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <?php $this->head() ?>
        <?php $this->registerJsFile(AppIframeAsset::register($this)->baseUrl . '/js/core/common.js', ['position' => $this::POS_END]); ?>
        <style>
            div.required label:after {
                content: " *";
                color: red;
            }
        </style>
        
    </head>
    
    <body>
        
        <?php $this->beginBody() ?>

        <!-- Page container -->
        <div class="page-container login-container">

            <!-- Page content -->
            <div class="page-content">

                <!-- Main content -->
                <div class="content-wrapper">

                    <!-- Content area -->
                    <div class="content">

                        <!-- Error wrapper -->
                        <?php echo $content; ?>
                        <!-- /error wrapper -->


                    </div>
                    <!-- /content area -->

                </div>
                <!-- /main content -->

            </div>
            <!-- /page content -->

        </div>
        <!-- /page container -->

        <?php $this->endBody() ?>
        
    </body>
    
</html>

<?php $this->endPage() ?>