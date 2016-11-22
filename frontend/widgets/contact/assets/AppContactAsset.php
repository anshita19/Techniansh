<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\widgets\contact\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AppContactAsset extends AssetBundle
{
    public $sourcePath='@frontend/widgets/contact/assets';
    
    public $js = [    
        'scripts/select2.min.js',
    ];
    
    public $css = [        
        'styles/select2.css',
    ];
    
    public $jsOptions = [
        'position' => View::POS_END,
    ];
    
    public $depends = [
       //'\frontend\assets\AppInnerAsset',
    ];
    
}
