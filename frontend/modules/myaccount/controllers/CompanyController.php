<?php

namespace frontend\modules\myaccount\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Session;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use common\models\Company;
use common\models\Turnover;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

/**
 * Company controller for the `myaccount` module
 */
class CompanyController extends Controller {

    public $defaultAction = 'view';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView() {
        $modelCompany = Company::find()->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])->one();
        if ($modelCompany === NULL) {
            throw new NotFoundHttpException('The requested page does not exist.');
            //return $this->redirect(['create']);
        }
        $modelTurnover = Turnover::find()->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])
                        ->select(['turnover_id', 'financial_year', 'currency_id', 'conversion_type', 'amount'])
                        ->orderBy(['financial_year' => SORT_DESC])->all();
        return $this->render('view', [
                    'modelCompany' => $modelCompany,
                    'modelTurnover' => $modelTurnover,
        ]);
    }

    public function actionCreate() {
        $modelCompany = new Company();
        $modelCompany->scenario = 'insert';
        $modelCompany->user_id = Yii::$app->user->identity->id;

        if ($modelCompany->load(Yii::$app->request->post())) {
            if (UploadedFile::getInstance($modelCompany, 'logo_file_name')) {
                $modelCompany->logo = UploadedFile::getInstance($modelCompany, 'logo_file_name');
                $modelCompany->logo_base_name = $modelCompany->logo->getBaseName();
                $modelCompany->logo_size = $modelCompany->logo->size;
                if ($modelCompany->logo->error === 0) {
                    list($modelCompany->logo_width, $modelCompany->logo_height) = getimagesize($modelCompany->logo->tempName);
                } else {
                    $modelCompany->addError('logo_file_name', 'Logo size allow only 2 Mb.');
                }
                $modelCompany->logo_ext = $modelCompany->logo->getExtension();
                $modelCompany->logo_file_name = preg_replace('/\s+/', '', $modelCompany->logo->getBaseName() . time());
            }
        }

        if (Yii::$app->request->isAjax && Yii::$app->request->post() && !$modelCompany->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelCompany);
        }

        if (Yii::$app->request->post()) {

            if (!empty($modelCompany->installed_capacity_unit) && $modelCompany->installed_capacity_unit == '2') {
                $modelCompany->installed_capacity = ($modelCompany->installed_capacity * 1000);
            }

            if ($modelCompany->validate(null, false) && $modelCompany->upload() && $modelCompany->save()) {
                Yii::$app->session->setFlash('success', 'Company information added successfully.');
                return $this->redirect(['view']);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for adding company infomation.');
            }
        }
        Yii::$app->session->setFlash('info', 'There is no any company added in your account, so first add new company.');
        return $this->render('update', [
                    'modelCompany' => $modelCompany,
        ]);
    }

    public function actionUpdate() {
        $modelCompany = (new Company())->find()->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])->one();
        if ($modelCompany === NULL) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $modelCompany->user_id = Yii::$app->user->identity->id;
        $modelCompany->scenario = 'update';

        $install_capacity_unit = $modelCompany->installed_capacity_unit;
        $install_capacity = $modelCompany->installed_capacity;
        $modelCompany->installed_capacity = ($modelCompany->installed_capacity_unit == '2') ? ($modelCompany->installed_capacity / 1000) : $modelCompany->installed_capacity;

        if (Yii::$app->request->post()) {
            $_POST['Company']['logo_file_name'] = $modelCompany->logo_file_name;
            $modelCompany->setAttributes($_POST['Company']);
            if (!empty(UploadedFile::getInstance($modelCompany, 'logo_file_name'))) {
                $modelCompany->logo = UploadedFile::getInstance($modelCompany, 'logo_file_name');
                $modelCompany->logo_base_name = $modelCompany->logo->getBaseName();
                $modelCompany->logo_size = $modelCompany->logo->size;
                if ($modelCompany->logo->error === 0) {
                    list($modelCompany->logo_width, $modelCompany->logo_height) = getimagesize($modelCompany->logo->tempName);
                } else {
                    $modelCompany->addError('logo_file_name', 'Logo size allow only 2 Mb.');
                }
                $modelCompany->logo_ext = $modelCompany->logo->getExtension();
                $modelCompany->logo_file_name = preg_replace('/\s+/', '', $modelCompany->logo->getBaseName() . time());
            }
        }

        if (Yii::$app->request->isAjax && Yii::$app->request->post() && !$modelCompany->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelCompany);
        }


        if (Yii::$app->request->post()) {

            if ($install_capacity != $modelCompany->installed_capacity || $install_capacity_unit != $modelCompany->installed_capacity_unit) {
                if (!empty($modelCompany->installed_capacity_unit) && $modelCompany->installed_capacity_unit == '2') {
                    $modelCompany->installed_capacity = ($modelCompany->installed_capacity * 1000);
                }
            }

            if ($modelCompany->validate(null, false) && !empty($modelCompany->logo)) {
                $modelCompany->upload();
            }

            if ($modelCompany->validate(null, false) && $modelCompany->save()) {
                Yii::$app->session->setFlash('success', 'Company information updated successfully.');
                return $this->redirect(['view']);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for updating company infomation.');
            }
        }

        return $this->render('update', [
                    'modelCompany' => $modelCompany
        ]);
    }

}
