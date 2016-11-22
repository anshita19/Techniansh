<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\validators;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Json;
use yii\validators\Validator;
use yii\validators\ValidationAsset;

/**
 * SlugValidator validates that the attribute value matches the specified [[pattern]].
 * 
 * SlugValidator will support the following formats:
 *  
 *   use slug with "-" and remove space in string
 *
 *
 */
class SlugValidator extends Validator {

    
    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view) {

        $id = (isset($model->id) && !empty($model->id)) ? ', id:' . $model->id : '';
        $url = Yii::$app->urlManager->createUrl(['/seo/default/validateslug']);

        return <<<JS
        
            deferred.push($.post("$url", {_csrf:yii.getCsrfToken(),slug: value$id}).done(function(data) {
                if (data !== '') {
                    messages.push(data);
                }
            }));
        
JS;
    }

}
