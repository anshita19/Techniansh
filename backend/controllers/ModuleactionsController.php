<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;

use common\models\Module;
use common\models\ModuleAction;
use common\models\ModuleActionItem;
use common\models\ModuleActionSearch;

class ModuleactionsController extends Controller {

    public $layout = 'innermain';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'validate', 'getmoduleactionlists'],
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

        //Yii::$app->cache->flush();
        $searchModel = new ModuleActionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionValidate($id = 0) {
        $model = (!empty($id)) ? $this->findModel($id) : new ModuleAction();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function actionGetmoduleactionlists($id = 0) {
        $model = new ModuleAction();
        return $model->getControllerActionCheckboxList($id);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate() {
        $this->layout = 'iframemain';
        $model = new ModuleAction();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            $transaction = $model->getDb()->beginTransaction();
            if (!empty($model->action_name) && isset($model->action_name)) {
                $actionArr = $model->action_name;
                foreach ($actionArr as $value) {
                    $actionDataArr[] = [$model->module_id, $model->id, $value];
                }
                $moduleActionItemModel = Yii::$app->db->createCommand()->batchInsert('module_action_items', ['module_id', 'module_action_id', 'action_name'], $actionDataArr)->execute();
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
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $this->layout = 'iframemain';
        $model = $this->findModel($id);

        $modueActionItemArr = $model->getModuleActionItems()->asArray()->all();
        $modueActionItemPreArr = [];
        if (!empty($modueActionItemArr)) {
            foreach ($modueActionItemArr as $value) {
                $modueActionItemPreArr[] = $value['action_name'];
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = $model->getDb()->beginTransaction();
            if ($model->save()) {
                $modueActionItemAddArr = array_diff($model->action_name, $modueActionItemPreArr);
                $modueActionItemRemoveArr = array_diff($modueActionItemPreArr, $model->action_name);
                if (!empty($modueActionItemAddArr)) {
                    $modueActionItemDataArr = [];
                    foreach ($modueActionItemAddArr as $value) {
                        $modueActionItemDataArr[] = [$model->module_id, $model->id, $value];
                    }
                    $moduleActionItemModel = Yii::$app->db->createCommand()->batchInsert('module_action_items', ['module_id', 'module_action_id', 'action_name'], $modueActionItemDataArr)->execute();
                }
                if (!empty($modueActionItemRemoveArr)) {
                    ModuleActionItem::deleteAll(['and', 'module_action_id=:module_action_id', ['IN', 'action_name', $modueActionItemRemoveArr]], [':module_action_id' => $model->id]);
                }
                $transaction = $transaction->commit();
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
        $model->action_name = $modueActionItemPreArr;

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

    protected function findModel($id) {
        if (($model = ModuleAction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
