<?php

namespace frontend\modules\myaccount\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Session;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use common\models\Profile;

/**
 * Profile controller for the `myaccount` module
 */
class ProfileController extends Controller {

    public $defaultAction = 'view';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView() {
        return $this->render('view');
    }

    public function actionUpdate() {
        $modelProfile = new Profile();

        if (Yii::$app->request->isAjax && $modelProfile->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelProfile);
        }

        if ($modelProfile->load(Yii::$app->request->post()) && $modelProfile->validate()) {
            if ($user = $modelProfile->profileUpdate()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully.');
                return $this->redirect(['view']);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for updating profile.');
            }
            
        }
        
        $modelProfile->attributes=Yii::$app->user->getIdentity()->attributes; 
        
        return $this->render('update', [
                    'modelProfile' => $modelProfile
        ]);
    }

}
