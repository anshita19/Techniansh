<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppInnerAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alertbackend;

AppInnerAsset::register($this);

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
        <?php $this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to()]) ?>
        <?php //$this->registerJsFile(AppInnerAsset::register($this)->baseUrl . '/js/plugins/tables/datatables/datatables.min.js', ['position' => $this::POS_END]); ?>
        <?php $this->registerJsFile(AppInnerAsset::register($this)->baseUrl . '/js/plugins/forms/selects/select2.min.js', ['position' => $this::POS_END]); ?>
        <?php $this->registerJsFile(AppInnerAsset::register($this)->baseUrl . '/js/core/common.js', ['position' => $this::POS_END]); ?>
        <?php //$this->registerJsFile(AppInnerAsset::register($this)->baseUrl . '/js/pages/datatables_advanced.js', ['position' => $this::POS_END]); ?>
        
    </head>
    
    <body>
        
        <?php $this->beginBody() ?>
        
        <div id="ajax_loader"></div>
        <!-- Main navbar -->
        <?php echo $this->render("//layouts/nav"); ?>
        <!-- /main navbar -->

        <!-- Page container -->
        <div class="page-container">

            <!-- Page content -->
            <div class="page-content">

                <!-- Main sidebar -->
                <div class="sidebar sidebar-main">
                    <div class="sidebar-content">

                        <!-- User menu -->
                        <?php echo $this->render("//layouts/usernav"); ?>
                        <!-- /user menu -->

                        <!-- Main navigation -->
                        <?php echo $this->render("//layouts/leftnav"); ?>
                        <!-- /main navigation -->

                    </div>
                </div>
                <!-- /main sidebar -->

                <!-- Main content -->
                <div class="content-wrapper">

                    <!-- Page header -->
                   
                    <!-- /page header -->

                    <!-- Content area -->
                    <div class="content">

                        <!-- Page length options -->
                        <?php echo $content; ?>
                        <!-- /page length options -->

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
