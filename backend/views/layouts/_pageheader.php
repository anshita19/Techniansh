<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\helpers\BaseHtml;
use yii\widgets\ActiveForm;
use yii\data\Pagination;

if (isset($title)) {
    $pageTitle = $title;
} else {
    $pageTitle = Yii::$app->controller->id;
}
?>
<div class="page-header border-top-lg border-top-teal page-header-xs panel">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="<?php echo (isset($icon)) ? $icon : 'icon-grid'; ?> position-left"></i> <span class="text-semibold"><?php echo ucfirst($pageTitle); ?></span></h4>
        </div>
        <div class="heading-elements">
            <div class="heading-btn-group">
                <?php
                if (isset($actions)) {
                    foreach ($actions as $value) {
                        if (isset($value['method']) && !empty($value['method'])) {
                            $modal='';
                            switch ($value['modal']) {
                                case 1:
                                    $modal = 'modal';
                                    break;
                                case 2:
                                    $modal = 'emodal';
                                    break;
                                case 0:
                                    $modal = '';
                                    break;
                                default:
                                    $model = '';
                                    break;
                            }
                            ?>
                            <a data-title="<?php echo (isset($value['title']) ? $value['title'] : $value['label']); ?>" data-size="<?php echo (isset($value['size']) ? $value['size'] : 'lg'); ?>" data-toggle="<?php echo $modal; ?>" class="btn btn-link btn-float has-text" href="<?php echo Yii::$app->getUrlManager()->createUrl([$value['method']]); ?>"><i class="<?php echo $value['icon']; ?> text-teal"></i><span><?php echo $value['label']; ?></span></a>
                            <?php
                        }
                    }
                }
                ?>
<!--                <a data-action="export" class="btn btn-link btn-float has-text" data-href="opportunitiesxls.php" href="#"><i class="icon-file-excel text-teal"></i><span>Export</span></a>-->
            </div>
        </div>
        <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>
    <div class="breadcrumb-line breadcrumb-line-wide">
        <ul class="breadcrumb">
            <li><a href="<?php echo Yii::$app->homeUrl; ?>">Home</a></li>
            <li class="active"><?php echo ucfirst($pageTitle); ?></li>
        </ul>
    </div>
</div>
