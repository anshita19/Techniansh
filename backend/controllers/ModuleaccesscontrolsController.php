<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;

use common\models\ModuleActionItem;
use common\models\ModuleAccessControl;
use common\models\ModuleAccessControlSearch;

class ModuleaccesscontrolsController extends Controller {

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
                    'status' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionIndex() {

        $searchModel = new ModuleAccessControlSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionValidate($id = 0) {
        $model = (!empty($id)) ? $this->findModel($id) : new ModuleAccessControl();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function getModuleAccessControlListSelected($id) {
        $model = ModuleAccessControl::find()->where('role_id = :role_id', [':role_id' => $id])->select(['module_id', 'module_action_item_id'])->asArray()->all();
        $selArr = [];
        foreach ($model as $key => $value) {
            $selArr[$value['module_id']][] = $value['module_id'] . '_' . $value['module_action_item_id'];
        }
        return $selArr;
    }

    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate() {
        
        $this->layout = 'iframemain';
        $model = new ModuleAccessControl();
        $accessControllArr = $model->getModuleAccessControlList();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $transaction = $model->getDb()->beginTransaction();
            if (!empty($model->module_action_item_id)) {
                $moduleItemArr = [];
                foreach (array_filter($model->module_action_item_id) as $value) {
                    foreach ($value as $value) {
                        $moduleActionId = explode('_', $value);
                        $module_id = $moduleActionId[0];
                        $module_action_item_id = $moduleActionId[1];
                        $moduleItemArr[] = [$model->role_id, $module_id, $module_action_item_id, Yii::$app->request->getUserIP(), Yii::$app->user->identity->id];
                    }
                }
                Yii::$app->db->createCommand()->batchInsert('module_access_controls', ['role_id', 'module_id', 'module_action_item_id', 'creator_ip', 'creator_id'], $moduleItemArr)->execute();
            }
            $transaction = $transaction->commit();
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
        }
        
        return $this->render('create', [
            'model' => $model,
            'accessControllArr' => $accessControllArr
        ]);
    }

    public function actionUpdate($id) {
        
        $this->layout = 'iframemain';
        $model = ModuleAccessControl::find()->where('role_id = :role_id', [':role_id' => $id])->one();

        $accessControllArr = $model->getModuleAccessControlList($id);
        $accessControlSelectedArr = $this->getModuleAccessControlListSelected($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $transaction = $model->getDb()->beginTransaction();

            $preArr = [];
            foreach (array_filter($accessControlSelectedArr) as $key => $value) {
                foreach ($value as $value) {
                    $preArr[] = $value;
                }
            }
            $postArr = [];
            foreach (array_filter($model->module_action_item_id) as $key => $value) {
                foreach ($value as $value) {
                    $postArr[] = $value;
                }
            }
            $moduleActionAddArr = array_diff($postArr, $preArr);
            $moduleActionRemoveArr = array_diff($preArr, $postArr);

            if (!empty($moduleActionAddArr)) {
                $moduleItemArr = [];
                foreach ($moduleActionAddArr as $value) {
                    $moduleActionId = explode('_', $value);
                    $module_id = $moduleActionId[0];
                    $module_action_item_id = $moduleActionId[1];
                    $moduleItemArr[] = [$model->role_id, $module_id, $module_action_item_id, Yii::$app->request->getUserIP(), Yii::$app->user->identity->id];
                }
                Yii::$app->db->createCommand()->batchInsert('module_access_controls', ['role_id', 'module_id', 'module_action_item_id', 'creator_ip', 'creator_id'], $moduleItemArr)->execute();
            }

            if (!empty($moduleActionRemoveArr)) {
                foreach ($moduleActionRemoveArr as $value) {
                    $moduleItemRemoveArr = [];
                    $moduleActionId = explode('_', $value);
                    $module_id = $moduleActionId[0];
                    $module_action_item_id = $moduleActionId[1];
                    $moduleItemRemoveArr[] = $module_action_item_id;
                    ModuleAccessControl::deleteAll('role_id=:role_id and module_action_item_id=:module_action_item_id', [':role_id' => $model->role_id, ':module_action_item_id' => $module_action_item_id]);
                }
            }
            $transaction = $transaction->commit();
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

        $model->module_action_item_id = $accessControlSelectedArr;

        return $this->render('create', [
            'model' => $model,
            'accessControllArr' => $accessControllArr,
        ]);
    }

    public function actionDelete($id) {
        if (Yii::$app->request->post()) {
            ModuleAccessControl::deleteAll('role_id = :role_id', ['role_id' => $id]);
            Yii::$app->response->format = Response::FORMAT_JSON;
            $dismsg['msgtype'] = 'danger';
            $dismsg['msg'] = 'Record deleted successfully';
            return $dismsg;
        }
    }

    protected function findModel($id) {
        if (($model = ModuleAccessControl::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
