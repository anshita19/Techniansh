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
use common\models\Preference;
use common\models\PreferenceInverter;
use common\models\PreferenceModule;
use common\models\Manufacturer;
use yii\data\ActiveDataProvider;

/**
 * Preference controller for the `myaccount` module
 */
class PreferenceController extends Controller {

    public $defaultAction = 'view';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView() {
        $modelObj = Preference::find()->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])->one();
        $modelPreference = (is_object($modelObj)) ? $modelObj : (new Preference());

        $modelPreference->user_id = Yii::$app->user->identity->id;
        $mediaArr=$this->getManufacturerMedia();
        $moduleArr=$mediaArr['module_sel'];
        $inverterArr=$mediaArr['inverter_sel'];

        if (Yii::$app->request->isAjax && $modelPreference->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelPreference);
        }

        if ($modelPreference->load(Yii::$app->request->post()) && $modelPreference->validate()) {

            if (!empty(Yii::$app->request->post('Preference')['module_logo']) || !empty(Yii::$app->request->post('Preference')['inverter_logo'])) {
                if (!empty($modelPreference->module_capacity_unit) && $modelPreference->module_capacity_unit == '2') {
                    $modelPreference->module_capacity = ($modelPreference->module_capacity * 1000);
                }
                if (!empty($modelPreference->inverter_capacity_unit) && $modelPreference->inverter_capacity_unit == '2') {
                    $modelPreference->inverter_capacity = ($modelPreference->inverter_capacity * 1000);
                }

                if (!empty($modelPreference->moduleType)) {
                    $modelPreference->is_module_trusted = (in_array("is_module_trusted", $modelPreference->moduleType)) ? 'Y' : 'N';
                    $modelPreference->is_module_other = (in_array("is_module_other", $modelPreference->moduleType)) ? 'Y' : 'N';
                }
                if (!empty($modelPreference->inverterType)) {
                    $modelPreference->is_inverter_trusted = (in_array("is_inverter_trusted", $modelPreference->inverterType)) ? 'Y' : 'N';
                    $modelPreference->is_inverter_other = (in_array("is_inverter_other", $modelPreference->inverterType)) ? 'Y' : 'N';
                }

                $transaction = $modelPreference->getDb()->beginTransaction();
                $preferenceData = 1;
                if ($modelPreference->save()) {

                    // Transaction for Module
                    $moduleAddArr = array_diff(Yii::$app->request->post('Preference')['module_logo'], $moduleArr);
                    $moduleRemoveArr = array_diff($moduleArr, Yii::$app->request->post('Preference')['module_logo']);

                    if (!empty($moduleAddArr)) {
                        $moduleLogoArr = [];
                        foreach ($moduleAddArr as $value) {
                            $moduleLogoArr[] = [Yii::$app->user->identity->id, $value];
                        }
                        $modelPreferenceModule = Yii::$app->db->createCommand()->batchInsert('preference_module', ['user_id', 'manufacturer_id'], $moduleLogoArr)->execute();
                    }
                    if (!empty($moduleRemoveArr)) {
                        PreferenceModule::deleteAll(['and', 'user_id=:user_id', ['IN', 'manufacturer_id', $moduleRemoveArr]], [':user_id' => Yii::$app->user->identity->id]);
                    }

                    // Transaction for Inverter
                    $inverterAddArr = array_diff(Yii::$app->request->post('Preference')['inverter_logo'], $inverterArr);
                    $inverterRemoveArr = array_diff($inverterArr, Yii::$app->request->post('Preference')['inverter_logo']);

                    if (!empty($inverterAddArr)) {
                        $inverterLogoArr = [];
                        foreach ($inverterAddArr as $value) {
                            $inverterLogoArr[] = [Yii::$app->user->identity->id, $value];
                        }
                        $modelPreferenceInverter = Yii::$app->db->createCommand()->batchInsert('preference_inverter', ['user_id', 'manufacturer_id'], $inverterLogoArr)->execute();
                    }
                    if (!empty($inverterRemoveArr)) {
                        PreferenceInverter::deleteAll(['and', 'user_id=:user_id', ['IN', 'manufacturer_id', $inverterRemoveArr]], [':user_id' => Yii::$app->user->identity->id]);
                    }

                    $transaction = $transaction->commit();
                    if ($preferenceData == 1) {
                        Yii::$app->session->setFlash('success', 'Preference added successfully.');
                    } else {
                        Yii::$app->session->setFlash('error', 'There was an error for adding preference.');
                    }
                    return $this->refresh();
                }
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for adding preference dule to not select the manufacturer');
            }
        }

        $modelPreference->moduleType = [($modelPreference->is_module_trusted == 'Y') ? 'is_module_trusted' : '', ($modelPreference->is_module_other == 'Y') ? 'is_module_other' : ''];
        $modelPreference->inverterType = [($modelPreference->is_inverter_trusted == 'Y') ? 'is_inverter_trusted' : '', ($modelPreference->is_inverter_other == 'Y') ? 'is_inverter_other' : ''];

        return $this->render('update', [
                    'modelPreference' => $modelPreference,
                    'mediaArr' => $mediaArr
        ]);
    }

    public function getManufacturerMedia() {
        $manufacturerMediaArr = Manufacturer::find()->joinWith(['preferenceModule', 'preferenceInverter'])
                        ->select(['manufacturer.manufacturer_id', 'manufacturer.is_module', 'manufacturer.is_inverter', 'manufacturer.company_name', 'manufacturer.logo_file_name', 'manufacturer.logo_ext',
                            'preference_module.manufacturer_id as module_sel_id', 'preference_inverter.manufacturer_id as inverter_sel_id'])
                        ->where('is_module=:is_module OR is_inverter=:is_inverter', [':is_module' => 'Y', ':is_inverter' => 'Y'])->all();
        $mediaArr = [];
        $moduleArr = [];
        $inverterArr = [];
        if (!empty($manufacturerMediaArr)) {
            foreach ($manufacturerMediaArr as $value) {
                if ($value['is_module'] == 'Y') {
                    $mediaArr['module'][$value['manufacturer_id']]['id'] = $value['manufacturer_id'];
                    $mediaArr['module'][$value['manufacturer_id']]['module_sel_id'] = $value['module_sel_id'];
                    $mediaArr['module'][$value['manufacturer_id']]['name'] = $value['company_name'];
                    $mediaArr['module'][$value['manufacturer_id']]['logo'] = $value['logo_file_name'] . '.' . $value['logo_ext'];
                    if ($value['module_sel_id'] !== NULL) {
                        $moduleArr[] = $value['module_sel_id'];
                    }
                }
                if ($value['is_inverter'] == 'Y') {
                    $mediaArr['inverter'][$value['manufacturer_id']]['id'] = $value['manufacturer_id'];
                    $mediaArr['inverter'][$value['manufacturer_id']]['inverter_sel_id'] = $value['inverter_sel_id'];
                    $mediaArr['inverter'][$value['manufacturer_id']]['name'] = $value['company_name'];
                    $mediaArr['inverter'][$value['manufacturer_id']]['logo'] = $value['logo_file_name'] . '.' . $value['logo_ext'];
                    if ($value['inverter_sel_id'] !== NULL) {
                        $inverterArr[] = $value['inverter_sel_id'];
                    }
                }
            }
        }
        $mediaArr['module_sel']=$moduleArr;
        $mediaArr['inverter_sel']=$inverterArr;
        return $mediaArr;
    }

}
