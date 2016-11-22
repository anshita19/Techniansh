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
 * Turnover controller for the `myaccount` module
 */
class TurnoverController extends Controller {

    public $defaultAction = 'view';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView() {
        $modelTurnover = Turnover::find()->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])
                        ->select(['turnover_id', 'financial_year', 'currency_id', 'conversion_type', 'amount'])
                        ->orderBy(['financial_year' => SORT_DESC])->all();
        return $this->render('view', [
                    'modelTurnover' => $modelTurnover,
        ]);
    }

    public function actionCreate() {
        $modelTurnover = new Turnover();

        $modelTurnover->scenario = 'insert_front';
        $modelTurnover->user_id = Yii::$app->user->identity->id;

        if (Yii::$app->request->isAjax && $modelTurnover->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelTurnover);
        }

        if ($modelTurnover->load(Yii::$app->request->post()) && $modelTurnover->validate()) {
            if ($modelTurnover->save()) {
                Yii::$app->session->setFlash('success', 'Company turnover added successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for adding company turnover.');
            }
            return $this->redirect(['view']);
        }

        return $this->render('update', [
                    'modelTurnover' => $modelTurnover,
        ]);
    }

    public function actionUpdate($id) {
        $modelTurnover = Turnover::findOne($id);
        $modelTurnover->user_id = Yii::$app->user->identity->id;
        $modelTurnover->scenario = 'insert_front';

        if (Yii::$app->request->isAjax && $modelTurnover->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelTurnover);
        }

        if ($modelTurnover->load(Yii::$app->request->post()) && $modelTurnover->validate()) {
            if ($modelTurnover->save()) {
                Yii::$app->session->setFlash('success', 'Company turnover updated successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for updating company turnover.');
            }
            return $this->redirect(['view']);
        }

        return $this->render('update', [
                    'modelTurnover' => $modelTurnover
        ]);
    }

    public function actionDelete($id) {
        $modelTurnover = Turnover::findOne($id);
        if ($modelTurnover !== NULL) {
            $modelTurnover->delete();
            Yii::$app->session->setFlash('danger', 'Company turnover deleted successfully.');
            return $this->redirect(['view']);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
