<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    
    <head>
        
        <title><?= Html::encode($this->title) ?></title>
        <?= Html::csrfMetaTags() ?>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <?php $this->head() ?>
        <?php $this->registerJsFile(AppAsset::register($this)->baseUrl. '/js/plugins/velocity/velocity.min.js', ['position' => $this::POS_END]); ?>
        <?php $this->registerJsFile(AppAsset::register($this)->baseUrl. '/js/plugins/velocity/velocity.ui.min.js', ['position' => $this::POS_END]); ?>
        
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

                        <!-- Simple login form -->
                        <?php echo $content; ?>
                        <!-- /simple login form -->

                        <!-- Footer -->
                        <?php echo $this->render("//layouts/bottom"); ?>
                        <!-- /footer -->

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
