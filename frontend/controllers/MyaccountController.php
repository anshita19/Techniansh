<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Session;
use yii\web\Response;
use yii\authclient\AuthAction;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Request;
use yii\db\Expression;
use frontend\models\Profile;
use frontend\models\ChangePassword;
use yii\bootstrap\ActiveForm;

/**
 * Site controller
 */
class MyaccountController extends Controller {

    public $layout = 'myaccountmain';
   
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'modelportfolio', 'investmentnote', 'trackrecord', 'mysubscription', 'restructuring', 'myprofile', 'changepassword', 'Validateuserpassword'],
                'rules' => [                    
                    [
                        'actions' => ['index', 'modelportfolio', 'investmentnote', 'trackrecord', 'mysubscription', 'restructuring', 'myprofile', 'changepassword', 'Validateuserpassword'],
                        'allow' => true,
                        'roles' => ['@'], // access for login user
                    ],                    
                ],
            ],            
        ];
    }

    public function beforeAction($action) {
        //exit('3 befor action');
        //$this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    
    public function actionIndex() {               
        return $this->render('index');    
    }
    
    public function actionMyprofile() {
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
        
        return $this->render('myprofile', [
                    'model' => $modelProfile
        ]);
    }
    
    public function actionValidateuserpassword()
    {
        $modelChangepassword = new ChangePassword();

        if (Yii::$app->request->isAjax && $modelChangepassword->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelChangepassword);
        }
    }
    
    public function actionChangepassword()
    {
        $modelChangepassword = new ChangePassword();

        if ($modelChangepassword->load(Yii::$app->request->post()) && $modelChangepassword->validate()) {
                        
            if ($modelChangepassword->updatePassword()) {
                Yii::$app->session->setFlash('success', 'Password has been updated successfully.');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for updating password.');
            }            
        }
                
        return $this->render('changepassword', [
                    'model' => $modelChangepassword
        ]);
    }
}
