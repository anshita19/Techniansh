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
use common\models\Notification;
use common\models\NotificationLocation;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\State;

/**
 * Notification controller for the `myaccount` module
 */
class NotificationController extends Controller {

    public $defaultAction = 'view';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView() {
        $modelNotification = Notification::find()->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])->one();
        if (is_object($modelNotification)) {
            $modelNotificationLocation = NotificationLocation::find()->joinWith(['state'])->select(['state.name as state_id'])->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])->asArray()->all();
            $modelNotification->state_id = implode(' | ', array_column($modelNotificationLocation, 'state_id'));
            $modelNotification->capacity = ($modelNotification->capacity_unit == '2') ? ($modelNotification->capacity / 1000) : $modelNotification->capacity;
        }
        return $this->render('view', [
                    'modelNotification' => $modelNotification,
        ]);
    }

    public function actionCreate() {
        $modelObj = Notification::find()->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])->one();
        $modelNotification = (is_object($modelObj)) ? $modelObj : (new Notification());

        $modelNotification->user_id = Yii::$app->user->identity->id;
        $capacity_unit = $modelNotification->capacity_unit;
        $capacity = $modelNotification->capacity;
        $modelNotification->capacity = ($modelNotification->capacity_unit == '2') ? ($modelNotification->capacity / 1000) : $modelNotification->capacity;
        $modelNotificationLocation = NotificationLocation::find()->select(['state_id'])->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])->all();
        $stateSelArr = [];
        if (!empty($modelNotificationLocation)) {
            foreach ($modelNotificationLocation as $value) {
                $stateSelArr[] = $value['state_id'];
            }
        }

        if (Yii::$app->request->isAjax && $modelNotification->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelNotification);
        }

        if ($modelNotification->load(Yii::$app->request->post())) {
            if ($capacity != $modelNotification->capacity || $capacity_unit != $modelNotification->capacity_unit) {
                if (!empty($modelNotification->capacity_unit) && $modelNotification->capacity_unit == '2') {
                    $modelNotification->capacity = ($modelNotification->capacity * 1000);
                }
            }

            // Transaction for Location
            $stateAddArr = array_diff(Yii::$app->request->post('Notification')['state_id'], $stateSelArr);
            $stateRemoveArr = array_diff($stateSelArr, Yii::$app->request->post('Notification')['state_id']);

            if (!empty($stateAddArr)) {
                $stateArr = [];
                foreach ($stateAddArr as $value) {
                    $stateArr[] = [Yii::$app->user->identity->id, $value];
                }
                Yii::$app->db->createCommand()->batchInsert('notification_location', ['user_id', 'state_id'], $stateArr)->execute();
            }
            if (!empty($stateRemoveArr)) {
                NotificationLocation::deleteAll(['and', 'user_id=:user_id', ['IN', 'state_id', $stateRemoveArr]], [':user_id' => Yii::$app->user->identity->id]);
            }

            if ($modelNotification->validate() && $modelNotification->save()) {
                Yii::$app->session->setFlash('success', 'Notification added successfully.');
                return $this->redirect(['view']);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for adding notification.');
            }
        }

        $stateList = ArrayHelper::map(State::find()->where('country_id = 101')->all(), 'id', 'name');
        $modelNotification->state_id = $stateSelArr;

        return $this->render('update', [
                    'modelNotification' => $modelNotification,
                    'stateList' => $stateList,
        ]);
    }

}
