<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

//namespace yii\authclient\widgets;
namespace common\widgets\authclient;

use yii\web\AssetBundle;

/**
 * AuthChoiceAsset is an asset bundle for [[AuthChoice]] widget.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 2.0
 */
class AuthChoiceStyleAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/authclient/assets';
    public $css = [
        'authchoice.css',
    ];
}
