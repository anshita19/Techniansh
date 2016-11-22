<?php

namespace backend\controllers;

use Yii;
use backend\models\Profile;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;

/**
 * ProfileController implements the CRUD actions for News model.
 */
class ProfileController extends Controller {

    public $layout = 'innermain';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex() {
        $modelProfile = new Profile();

        if (Yii::$app->request->isAjax && $modelProfile->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelProfile);
        }

        if ($modelProfile->load(Yii::$app->request->post()) && $modelProfile->validate()) {
            if ($modelProfile->profileUpdate()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully.');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for updating profile.');
            }
            
        }
        
        $modelProfile->attributes=Yii::$app->user->getIdentity()->attributes;
        $modelProfile->password_hash='';
        return $this->render('create', [
                    'model' => $modelProfile
        ]);
    }
    
}
