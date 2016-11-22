<?php

namespace backend\controllers;

use Yii;
use common\models\Country;
use common\models\CountrySearch;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * CountryController implements the CRUD actions for Country model.
 */
class CountryController extends Controller {
    
    public $layout = 'innermain';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'validate', 'countrylist', 'status', 'select2list'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'status' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex() {

        //Yii::$app->cache->flush();
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCountrylist($q = '') {
        $query = Country::find()->select(['country.country_id', 'country.name'])                
                ->Where(['like', 'name', Yii::$app->getRequest()->getQueryParam('q')])->asArray()->all();
        return Json::encode($query);
    }

    public function actionValidate($id = 0) {
        $model = (!empty($id)) ? $this->findModel($id) : new Country();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * Displays a single Country model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Country model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->layout = 'iframemain';
        $model = new Country();

        if ($model->load(Yii::$app->request->post())) {
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
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Country model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $this->layout = 'iframemain';
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) {

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
        }
        //$model->parent_id=$id;
        return $this->render('create', [
                    'model' => $model,
        ]);
    }
    
    public function actionSelect2list($q = null, $id = null) {
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $out = ['results' => ['id' => '', 'text' => '']];
        
        if (!is_null($q)) {
            $query = Country::find()->select(['country_id as id', 'name as text'])
                ->filterWhere(['like', 'name', Yii::$app->getRequest()->getQueryParam('q')])
                ->limit(20)->asArray()->all();
            
            return ['results' => $query];
        } elseif ($id > 0) {
            return ['results' => ['id' => $id, 'text' => Country::find($id)->name]];
        }
        
        return $out;
    }
    
    public function actionStatus($id) {
        if (Yii::$app->request->post()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findModel($id);
            $model->status = Yii::$app->request->post()['status'];
            $model->save();
            $dismsg['msgtype'] = 'success';
            $dismsg['msg'] = 'Status updated successfully';
            return $dismsg;
        }
    }

    /**
     * Deletes an existing Account model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        if (Yii::$app->request->post()) {
            $model=$this->findModel($id);
            $model->delete();            
            Yii::$app->response->format = Response::FORMAT_JSON;
            $dismsg['msgtype'] = 'danger';
            $dismsg['msg'] = 'Record deleted successfully';
            return $dismsg;
        }
    }

    /**
     * Finds the Country model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Country the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Country::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    
}
