<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;

$bundle=AppAsset::register($this);

if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}

?>
<?php $this->beginPage() ?>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo AppAsset::register($this)->baseUrl; ?>/images/favicon/ms-icon-144x144.png">
        <?php $this->head() ?>
        <!--[if lt IE 9]>
        <script src="<?php echo AppAsset::register($this)->baseUrl; ?>/scripts/html5shiv.min.js"></script>
        <script src="<?php echo AppAsset::register($this)->baseUrl; ?>/scripts/respond.min.js"></script>
      <![endif]-->
    </head>
    <body class="home">
        <?php $this->beginBody() ?>        
        <div id="mobile-menu"></div>
        <div class="container" id="wrapper">
            
            <div class="row">
                <!-- Navigation -->
                <?php echo $this->render("//layouts/_nav",['bundle'=>$bundle]); ?>
                <!-- /navigation -->
            </div>    
            
            <?php echo $content; ?>
            
            <!-- Bottom -->
            <?php echo $this->render("//layouts/_bottom",['bundle'=>$bundle]); ?>
            <!-- /bottom -->
            
        </div>
        
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
