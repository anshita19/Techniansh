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
use common\models\State;
use common\models\Country;
use common\models\StateSearch;

class StateController extends Controller {

    public $layout = 'innermain';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'select2list'],
                        'allow' => TRUE,
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
        $searchModel = new StateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSelect2list($q = null, $id = null) {
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $out = ['results' => ['id' => '', 'text' => '']];
        
        $country = Country::findOne(['name' => 'India']);
        
        if (!is_null($q)) {
            $query = State::find()->select(['state_id as id', 'name as text'])
                ->filterWhere(['like', 'name', Yii::$app->getRequest()->getQueryParam('q')])->limit(20)->asArray()->all();
            
            return ['results' => $query];
        } elseif ($id > 0) {
            return ['results' => ['id' => $id, 'text' => State::find($id)->name]];
        }
        
        return $out;
    }
    
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate() {
        $this->layout = 'iframemain';
        $model = new State();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && !$model->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            if ($model->validate()) {
                $model->save();
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
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id) {
        $this->layout = 'iframemain';
        $model = $this->findModel($id);
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && !$model->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            
            if ($model->validate()) {
                $model->save();
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
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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

    protected function findModel($id) {
        if (($model = State::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
