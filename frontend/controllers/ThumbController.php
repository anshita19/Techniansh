<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use common\widgets\thumbnail\EasyThumbnailImage;

/**
 * Thumb controller
 */
class ThumbController extends Controller {

    //public $layout = 'innermain';
    public $params = [];
    public $image;

    public function init() {
        parent::init();
        $this->generateThumb();
    }

    public function generateThumb() {

        $this->params = Yii::$app->request->getQueryParams();
        
        $this->image = Yii::getAlias('@uploads') . '/' . $this->params['img'];
        EasyThumbnailImage::thumbnailImg(
                $this->image, $this->params['width'], $this->params['height'],  $this->params['img'] ,EasyThumbnailImage::THUMBNAIL_OUTBOUND, ['alt' => 'abcd']
        );
    }

    /**
     * @inheritdoc
     */
    public function actions() {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

}
