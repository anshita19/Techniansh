<?php

namespace frontend\widgets\signup\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use common\models\User;
use frontend\widgets\signup\models\Signup;

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
                        'actions' => ['create', 'validatesignup', 'active-account', 'cancel-account','captcha'],
                        'allow' => TRUE,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }
    
    public function actions() {
        return [
            'captcha' => [
                //'class' => 'common\widgets\captcha\CaptchaAction',
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionValidatesignup() {
        $model = new Signup();
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

    public function actionActiveAccount($token) {
        $modelSignup = new Signup();
        try {
            $user = $modelSignup->getActiveAccount($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        Yii::$app->session->setFlash('success', 'Your account successfully activated.');
        return $this->goHome();
    }

    public function actionCancelAccount($token) {
        $modelSignup = new Signup();
        try {
            $user = $modelSignup->getCancelAccount($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        Yii::$app->session->setFlash('success', 'Your registration successfully canceled.');
        return $this->goHome();
    }

    public function actionCreate() {
        $modelSignup = new Signup();

        if ($modelSignup->load(Yii::$app->request->post()) && $modelSignup->validate()) {
            if ($user = $modelSignup->register()) {
                if ($modelSignup->sendRegisterEmail($user)) {
                    Yii::$app->session->setFlash('success', 'Thank you for register. check the corresponding email for active your account.');
                } else {
                    Yii::$app->session->setFlash('error', 'There was an error sending email.');
                }
                return $this->redirect(['/signup']);
            }
        }else{
            echo '<pre>';
            print_r($modelSignup->getErrors());
            exit;
        }
    }

}
