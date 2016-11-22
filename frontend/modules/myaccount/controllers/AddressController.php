<?php

namespace frontend\modules\myaccount\controllers;

use Yii;
use common\models\Address;
use common\models\AddressSearch;
use common\models\Company;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Country;
use common\models\State;
use common\models\City;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * AddressController implements the CRUD actions for Address model.
 */
class AddressController extends Controller {

    public $defaultAction = 'view';

    /**
     * Displays a single Address model.
     * @param integer $id
     * @return mixed
     */
    public function actionView() {
        $modelAddress = Address::find()->joinWith('state')->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])
                        ->select(['address.*', 'state.name'])
                        ->orderBy(['modified_at' => SORT_DESC])->all();
        return $this->render('view', [
                    'modelAddress' => $modelAddress,
        ]);
    }

    /**
     * Creates a new Address model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $modelAddress = new Address();

        $modelAddress->scenario = 'insert_front';
        $modelAddress->user_id = Yii::$app->user->identity->id;

        if (Yii::$app->request->isAjax && $modelAddress->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelAddress);
        }

        if ($modelAddress->load(Yii::$app->request->post()) && $modelAddress->validate()) {
            if ($modelAddress->save()) {
                Yii::$app->session->setFlash('success', 'Company address added successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for adding company address.');
            }
            return $this->redirect(['view']);
        }

        $stateList = ArrayHelper::map(State::find()->where('country_id = 101')->all(), 'id', 'name');

        return $this->render('update', [
                    'modelAddress' => $modelAddress,
                    'stateList' => $stateList,
        ]);
    }

    /**
     * Updates an existing Address model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $modelAddress = $this->findModel($id);
        $modelAddress->scenario = 'insert_front';

        if (Yii::$app->request->isAjax && $modelAddress->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelAddress);
        }

        if ($modelAddress->load(Yii::$app->request->post()) && $modelAddress->validate()) {
            if ($modelAddress->save()) {
                Yii::$app->session->setFlash('success', 'Company address updated successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for updating company address.');
            }
            return $this->redirect(['view']);
        }

        //$countryList = ArrayHelper::map(Country::find()->all(), 'id', 'name');
        $stateList = ArrayHelper::map(State::find()->where('country_id = 101')->all(), 'id', 'name');
        //$cityList = ArrayHelper::map(City::find()->where('state_id = :state_id', [':state_id' => $modelAddress->state_id])->all(), 'id', 'name');

        return $this->render('update', [
                    'modelAddress' => $modelAddress,
                    'stateList' => $stateList,
        ]);
    }

    public function actionCountrycmb() {
        $terms = (!empty(Yii::$app->request->queryParams['q'])) ? Yii::$app->request->queryParams['q'] : '';
        $modelCountry = Country::find()->select(['id', 'name'])->where(['like', 'name', $terms])->all();
        $listData = ArrayHelper::map($modelCountry, 'id', 'name');
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $listData;
    }

    public function actionStatecmb($id) {
        $modelState = State::find()
                ->where('country_id = :id', [':id' => $id])
                ->all();
        $cmbHtml = '';
        if (count($modelState) > 0) {
            $cmbHtml .= "<option value=''>Select State</option>";
            foreach ($modelState as $value) {
                $cmbHtml .= "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
            }
        }
        return $cmbHtml;
    }

    public function actionCitycmb($id) {
        $modelCity = City::find()
                ->where('state_id = :id', [':id' => $id])
                ->all();
        $cmbHtml = '';
        if (count($modelCity) > 0) {
            $cmbHtml .= "<option value=''>Select City</option>";
            foreach ($modelCity as $value) {
                $cmbHtml .= "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
            }
        }
        return $cmbHtml;
    }

    /**
     * Deletes an existing Address model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('danger', 'Company turnover deleted successfully.');
        return $this->redirect(['view']);
    }

    /**
     * Finds the Address model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Address the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Address::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
