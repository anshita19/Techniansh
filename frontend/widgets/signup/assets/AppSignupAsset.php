<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\widgets\signup\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AppSignupAsset extends AssetBundle
{
    public $sourcePath='@frontend/widgets/signup/assets';
    
    public $js = [
        'scripts/jquery.fancybox.js',
        'scripts/select2.min.js',
    ];
    
    public $css = [
        'styles/jquery.fancybox.css',
        'styles/select2.css',
    ];
    
    public $jsOptions = [
        'position' => View::POS_END,
    ];
    
    public $depends = [
       //'\frontend\assets\AppInnerAsset',
    ];
    
}
