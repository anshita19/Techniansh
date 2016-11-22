<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\widgets\testimonial\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'styles/jquery.bxslider.css',
    ];
    
    public $js = [
        'scripts/jquery.bxslider.js',
    ];
    
    public $cssOptions = [
    ];
    
    public $jsOptions = [
        'position' => View::POS_END,
    ];
    
    public $depends = [
       '\frontend\assets\AppAsset',
    ];
    
}
