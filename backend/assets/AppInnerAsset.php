<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppInnerAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web/themeassets/';
    public $css = [
        'css/icons/icomoon/styles.css',
        'css/bootstrap.css',
        'css/core.css',
        'css/components.css',
        'css/colors.css',
        'css/common.css',
    ];
    public $js = [
        'js/plugins/loaders/pace.min.js',
        'js/core/libraries/jquery.min.js',
        'js/core/libraries/bootstrap.min.js',
        'js/plugins/loaders/blockui.min.js',
        'js/core/app.js',
        'emodal/eModal.min.js',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
