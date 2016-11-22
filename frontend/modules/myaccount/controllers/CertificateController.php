<?php

namespace frontend\modules\myaccount\controllers;

use Yii;
use common\models\Certificate;
use common\models\CertificateSearch;
use common\models\Company;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

/**
 * CertificateController implements the CRUD actions for Address model.
 */
class CertificateController extends Controller {

    public $defaultAction = 'view';

    /**
     * Displays a single Address model.
     * @param integer $id
     * @return mixed
     */
    public function actionView() {
        $modelCertificate = Certificate::find()->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])
                        ->orderBy(['modified_at' => SORT_DESC, 'created_at' => SORT_DESC])->all();
        return $this->render('view', [
                    'modelCertificate' => $modelCertificate,
        ]);
    }

    /**
     * Creates a new Certificate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $modelCertificate = new Certificate();

        $modelCertificate->scenario = 'insert';
        $modelCertificate->user_id = Yii::$app->user->identity->id;

        if ($modelCertificate->load(Yii::$app->request->post())) {
            if (UploadedFile::getInstance($modelCertificate, 'logo_file_name')) {
                $modelCertificate->logo = UploadedFile::getInstance($modelCertificate, 'logo_file_name');
                $modelCertificate->logo_base_name = $modelCertificate->logo->getBaseName();
                $modelCertificate->logo_size = $modelCertificate->logo->size;
                if ($modelCertificate->logo->error === 0) {
                    list($modelCertificate->logo_width, $modelCertificate->logo_height) = getimagesize($modelCertificate->logo->tempName);
                } else {
                    $modelCertificate->addError('logo_file_name', 'Logo size allow only 2 Mb.');
                }
                $modelCertificate->logo_ext = $modelCertificate->logo->getExtension();
                $modelCertificate->logo_file_name = preg_replace('/\s+/', '', $modelCertificate->logo->getBaseName() . time());
            }
        }

        if (Yii::$app->request->isAjax && Yii::$app->request->post() && !$modelCertificate->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelCertificate);
        }

        if (Yii::$app->request->post()) {
            if ($modelCertificate->validate(NULL, FALSE) && $modelCertificate->upload() && $modelCertificate->save()) {
                Yii::$app->session->setFlash('success', 'Certificate added successfully.');
                return $this->redirect(['view']);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for adding certificate.');
            }
        }

        return $this->render('update', [
                    'modelCertificate' => $modelCertificate,
        ]);
    }

    /**
     * Updates an existing Certificate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $modelCertificate = $this->findModel($id);
        $modelCertificate->scenario = 'update';

        if (Yii::$app->request->post()) {
            $_POST['Certificate']['logo_file_name'] = $modelCertificate->logo_file_name;
            $modelCertificate->setAttributes($_POST['Certificate']);
            if (!empty(UploadedFile::getInstance($modelCertificate, 'logo_file_name'))) {
                $modelCertificate->logo = UploadedFile::getInstance($modelCertificate, 'logo_file_name');
                $modelCertificate->logo_base_name = $modelCertificate->logo->getBaseName();
                $modelCertificate->logo_size = $modelCertificate->logo->size;
                if ($modelCertificate->logo->error === 0) {
                    list($modelCertificate->logo_width, $modelCertificate->logo_height) = getimagesize($modelCertificate->logo->tempName);
                } else {
                    $modelCertificate->addError('logo_file_name', 'Logo size allow only 2 Mb.');
                }
                $modelCertificate->logo_ext = $modelCertificate->logo->getExtension();
                $modelCertificate->logo_file_name = preg_replace('/\s+/', '', $modelCertificate->logo->getBaseName() . time());
            }
        }

        if (Yii::$app->request->isAjax && Yii::$app->request->post() && !$modelCertificate->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelCertificate);
        }

        if (Yii::$app->request->post()) {
            if ($modelCertificate->validate(NULL, FALSE) && !empty($modelCertificate->logo)) {
                $modelCertificate->upload();
            }
            if ($modelCertificate->validate(NULL, FALSE) && $modelCertificate->save()) {
                Yii::$app->session->setFlash('success', 'Certificate updated successfully.');
                return $this->redirect(['view']);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for updating certificate.');
            }
        }

        return $this->render('update', [
                    'modelCertificate' => $modelCertificate,
        ]);
    }

    /**
     * Deletes an existing Certificate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('danger', 'Certificate deleted successfully.');
        return $this->redirect(['view']);
    }

    /**
     * Finds the Certificate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Certificate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Certificate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
