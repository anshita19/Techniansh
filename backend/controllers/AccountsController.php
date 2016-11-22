<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;

use common\models\User;
use common\models\UserMacAddress;

use backend\models\Account;
use backend\models\AccountSearch;

class AccountsController extends Controller {

    public $layout = 'innermain';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'validate', 'select2list'],
                        'allow' => (isset(Yii::$app->user->identity->user_type) && Yii::$app->user->identity->user_type == User::TYPE_Admin) ? TRUE : FALSE,
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

    public function actionIndex() {

        $searchModel = new AccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionValidate($id = 0) {
        $model = (!empty($id)) ? $this->findModel($id) : new Account();
        $model->scenario = (!empty($id)) ? 'update' : 'insert';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate() {
        $this->layout = 'iframemain';
        $model = new Account();
        $model->scenario = 'insert';

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->register();
            }

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $dismsg['msgtype'] = 'success';
                $dismsg['msg'] = 'Record added successfully';
                return $dismsg;
            } else {
                Yii::$app->session->setFlash('success', 'Record added successfully');
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $this->layout = 'iframemain';
        $model = $this->findModel($id);
        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $model->register($model->id);
            }
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $dismsg['msgtype'] = 'success';
                $dismsg['msg'] = 'Record updated successfully';
                return $dismsg;
            } else {
                Yii::$app->session->setFlash('success', 'Record updated successfully');
                return $this->redirect(['index']);
            }
        }
        $model->password_hash = '';
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        if (Yii::$app->request->post()) {
            $this->findModel($id)->delete();
            Yii::$app->response->format = Response::FORMAT_JSON;
            $dismsg['msgtype'] = 'danger';
            $dismsg['msg'] = 'Record deleted successfully';
            return $dismsg;
        }
    }
    
    public function actionSelect2list($q = null, $id = null) {
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $out = ['results' => ['id' => '', 'text' => '']];
        
        if (!is_null($q)) {
            $query = Account::find()->select(['id as id', 'concat(first_name, " ", last_name) as text'])
                ->filterWhere(['like', 'concat(first_name, " ", last_name)', Yii::$app->getRequest()->getQueryParam('q')])
                ->limit(20)->asArray()->all();
            
            return ['results' => $query];
        } elseif ($id > 0) {
            return ['results' => ['id' => $id, 'text' => Account::find($id)->first_name]];
        }
        
        return $out;
    }

    protected function findModel($id) {
        if (($model = Account::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
