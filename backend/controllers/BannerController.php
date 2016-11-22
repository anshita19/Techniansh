<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;

use common\models\User;
use common\models\Banner;
use common\models\BannerSearch;

class BannerController extends Controller {

    public $layout = 'innermain';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'validate'],
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
                
        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionValidate($id=0) {
        $model = (empty($id) ? new Banner() : $this->findModel($id));
        $model->image = UploadedFile::getInstance($model, 'image');
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
    
    public function actionCreate() {
        
        //Yii::$app->cache->flush();
        
        $this->layout = 'iframemain';
        $model = new Banner();
        $model->scenario = 'create';

        if (Yii::$app->request->post()) {            
            $model->load(Yii::$app->request->post());
            $model->image = UploadedFile::getInstance($model, 'image');
            
            if ($model->validate()) {
                
                list($width, $height) = getimagesize($model->image->tempName);
                
                $model->image_width = $width;
                $model->image_height = $height;
                $model->image_ext = strtolower($model->image->extension);
                $model->image_base_name = strtolower($model->image->baseName);
                $model->image_mime_type = FileHelper::getMimeType($model->image->tempName);
                $model->image_size = $model->image->size;
                $model->image_name = uniqid();
                
                if(empty($model->sort_order)) $model->sort_order = 1;
                
                $model->publish_at = date('Y-m-d H:i', strtotime(trim($model->publish_at)));
                if($model->expire_at != '') $model->expire_at = date('Y-m-d H:i', strtotime(trim($model->expire_at)));
                
                if($model->save(false)) $model->image->saveAs(Yii::getAlias('@uploads') . '/' . $model->image_name . '.' . $model->image_ext, true);                                
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
            $model->loadDefaultValues();
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id) {
        $this->layout = 'iframemain';
        $model = $this->findModel($id);
        $model->scenario = 'update';
                
        if (Yii::$app->request->post()) {
        
            
            $model->load(Yii::$app->request->post());
            $model->image = UploadedFile::getInstance($model, 'image');
                        
            if ($model->validate()) {
                
                if($model->image) {
                    list($width, $height) = getimagesize($model->image->tempName);

                    $model->image_width = $width;
                    $model->image_height = $height;
                    $model->image_ext = strtolower($model->image->extension);
                    $model->image_base_name = strtolower($model->image->baseName);
                    $model->image_mime_type = FileHelper::getMimeType($model->image->tempName);
                    $model->image_size = $model->image->size;
                    $model->image_name = uniqid();
                }
                
                $model->publish_at = date('Y-m-d H:i', strtotime(trim($model->publish_at)));
                if($model->expire_at != '') $model->expire_at = date('Y-m-d H:i', strtotime(trim($model->expire_at)));
                
                if($model->save() && $model->image) {
                    $model->image->saveAs(Yii::getAlias('@uploads') . '/' . $model->image_name . '.' . $model->image_ext, true);
                }
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
            
            $model->publish_at = date('d-m-Y H:i', strtotime($model->publish_at));
            if($model->expire_at != '') $model->expire_at = date('d-m-Y H:i', strtotime($model->expire_at));
            
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
        if (($model = Banner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
