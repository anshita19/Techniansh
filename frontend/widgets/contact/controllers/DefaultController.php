<?php

namespace frontend\widgets\contact\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use common\models\User;
use frontend\widgets\contact\models\Contact;

/**
 * Default controller for the `myaccount` module
 */
class DefaultController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['send', 'validatecontact'],
                        'allow' => TRUE,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionValidatecontact() {
        $model = new Contact();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $attributes = $model->activeAttributes();
            foreach ($attributes as $id => $name) {
                if($name == 'verifyCode'){
                    unset($attributes[$id]);
                }
            }
            return ActiveForm::validate($model);
        }
    }

    public function actionSend() {
        $modelContact = new Contact();

        if ($modelContact->load(Yii::$app->request->post()) && $modelContact->validate()) {            
            if ($modelContact->sendContactEmail($modelContact)) {                
                if ($modelContact->sendBackContactEmail($modelContact)) {
                    Yii::$app->session->setFlash('success', 'Thanks for contacting us. we shall soon contact you on your given contact details.');
                }
                else {
                    Yii::$app->session->setFlash('error', 'There was an error sending email.');
                }
                
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }
            return $this->redirect(['/site/contact']);            
        }
//        else
//        {
//            echo '<pre>';
//            print_r($modelContact->getErrors());
//            exit;
//        }
    }

}
