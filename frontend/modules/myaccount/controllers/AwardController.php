<?php

namespace frontend\modules\myaccount\controllers;

use Yii;
use common\models\Award;
use common\models\AddressSearch;
use common\models\Company;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

/**
 * AwardController implements the CRUD actions for Address model.
 */
class AwardController extends Controller {

    public $defaultAction = 'view';

    /**
     * Displays a single Address model.
     * @param integer $id
     * @return mixed
     */
    public function actionView() {
        $modelAward = Award::find()->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])
                        ->orderBy(['modified_at' => SORT_DESC, 'created_at' => SORT_DESC])->all();
        return $this->render('view', [
                    'modelAward' => $modelAward,
        ]);
    }

    /**
     * Creates a new Award model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $modelAward = new Award();

        $modelAward->scenario = 'insert';
        $modelAward->user_id = Yii::$app->user->identity->id;

        if ($modelAward->load(Yii::$app->request->post())) {
            if (UploadedFile::getInstance($modelAward, 'logo_file_name')) {
                $modelAward->logo = UploadedFile::getInstance($modelAward, 'logo_file_name');
                $modelAward->logo_base_name = $modelAward->logo->getBaseName();
                $modelAward->logo_size = $modelAward->logo->size;
                if ($modelAward->logo->error === 0) {
                    list($modelAward->logo_width, $modelAward->logo_height) = getimagesize($modelAward->logo->tempName);
                } else {
                    $modelAward->addError('logo_file_name', 'Logo size allow only 2 Mb.');
                }
                $modelAward->logo_ext = $modelAward->logo->getExtension();
                $modelAward->logo_file_name = preg_replace('/\s+/', '', $modelAward->logo->getBaseName() . time());
            }
        }

        if (Yii::$app->request->isAjax && Yii::$app->request->post() && !$modelAward->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelAward);
        }

        if (Yii::$app->request->post()) {
            if ($modelAward->validate(NULL, FALSE) && $modelAward->upload() && $modelAward->save()) {
                Yii::$app->session->setFlash('success', 'Award added successfully.');
                return $this->redirect(['view']);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for adding award.');
            }
        }

        return $this->render('update', [
                    'modelAward' => $modelAward,
        ]);
    }

    /**
     * Updates an existing Award model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $modelAward = $this->findModel($id);
        $modelAward->scenario = 'update';

        if (Yii::$app->request->post()) {
            $_POST['Certificate']['logo_file_name'] = $modelAward->logo_file_name;
            $modelAward->setAttributes($_POST['Certificate']);
            if (!empty(UploadedFile::getInstance($modelAward, 'logo_file_name'))) {
                $modelAward->logo = UploadedFile::getInstance($modelAward, 'logo_file_name');
                $modelAward->logo_base_name = $modelAward->logo->getBaseName();
                $modelAward->logo_size = $modelAward->logo->size;
                if ($modelAward->logo->error === 0) {
                    list($modelAward->logo_width, $modelAward->logo_height) = getimagesize($modelAward->logo->tempName);
                } else {
                    $modelAward->addError('logo_file_name', 'Logo size allow only 2 Mb.');
                }
                $modelAward->logo_ext = $modelAward->logo->getExtension();
                $modelAward->logo_file_name = preg_replace('/\s+/', '', $modelAward->logo->getBaseName() . time());
            }
        }

        if (Yii::$app->request->isAjax && Yii::$app->request->post() && !$modelAward->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelAward);
        }

        if (Yii::$app->request->post()) {
            if ($modelAward->validate(NULL, FALSE) && !empty($modelAward->logo)) {
                $modelAward->upload();
            }
            if ($modelAward->validate(NULL, FALSE) && $modelAward->save()) {
                Yii::$app->session->setFlash('success', 'Award updated successfully.');
                return $this->redirect(['view']);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for updating award.');
            }
        }

        return $this->render('update', [
                    'modelAward' => $modelAward,
        ]);
    }

    /**
     * Deletes an existing Award model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('danger', 'Award deleted successfully.');
        return $this->redirect(['view']);
    }

    /**
     * Finds the Award model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Certificate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Award::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
