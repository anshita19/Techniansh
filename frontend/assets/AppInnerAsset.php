<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppInnerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800|Cinzel:400,700,900|Condiment|Cantata+One',
        'styles/font-awesome.css',
        'styles/bootstrap.css',
        'styles/common.css',
        'styles/sub.css',
        'styles/responsive.css'
    ];
    public $js = [
        'scripts/jquery.min.js',
        'scripts/bootstrap.min.js',        
        'scripts/common.js',                
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
    public $depends = [
       // 'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
    ];
    
}
