<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Auth;
use common\models\Appoinment;
use common\models\Testimonial;
use yii\web\Session;
use yii\web\Response;
use frontend\models\LoginForm;
use yii\widgets\ActiveForm;
use yii\authclient\AuthAction;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Request;

/**
 * Site controller
 */
class SiteController extends Controller {

    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'register', 'mobile-verify', 'myaccount', 'event', 'annotation', 'participant', 'signin'],
                'rules' => [
                    [
                        'actions' => ['register', 'signin'],
                        'allow' => true,
                        'roles' => ['?'], // access for guest user
                    ],
                    [
                        'actions' => ['logout', 'myaccount', 'event', 'annotation', 'participant'],
                        'allow' => true,
                        'roles' => ['@'], // access for login user
                    ],
                    [
                        'actions' => ['mobile-verify'],
                        'allow' => (Yii::$app->session->has('social.client')) ? true : false, // access for mobile verification after social register
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        //exit('3 befor action');
        //$this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function actions() {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'common\widgets\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionSignin() {
        if (!Yii::$app->user->isGuest) {
            //return $this->goHome();
            return $this->goback();
        }

        $modelLogin = new LoginForm();

        if (Yii::$app->request->isAjax && $modelLogin->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelLogin);
        }

        if ($modelLogin->load(Yii::$app->request->post()) && $modelLogin->login()) {            
            return $this->redirect(['/myaccount']);
        } else {
            return $this->render('signin', [
                'modelLogin' => $modelLogin,
            ]);
        }
    }

    public function actionLogout() {

        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        
        return $this->render('index');
    }
    
    public function actionSignup() {
        $this->layout='innermain';
        return $this->render('signup');
    }
    
    public function actionWhoweare() {
        $this->layout='innermain';        
        return $this->render('whoweare');
    }
    
    public function actionContactus() {
        $this->layout='innermain';        
        return $this->render('contactus');
    }        
}
