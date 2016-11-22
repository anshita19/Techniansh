<?php

namespace frontend\modules\myaccount\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `myaccount` module
 */
class DefaultController extends Controller {
    

    public function redirectCompany($action) {
        
        $actionCompanyArr=['view','update'];
        if ($action->controller->id !== 'company' && $action->id != 'create' || ($action->controller->id == 'company' && in_array($action->id, $actionCompanyArr))) {
            $url = Yii::$app->urlManager->createUrl(['myaccount/company/create']);
            header('Location:'.$url);
            exit(0);
        }
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {

        return $this->render('index');
    }

}
