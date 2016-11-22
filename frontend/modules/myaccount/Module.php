<?php

namespace frontend\modules\myaccount;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use frontend\modules\myaccount\controllers\DefaultController;
use common\models\Company;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

/**
 * myaccount module definition class
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\myaccount\controllers';
    public $layout = '//innermain';
    public $navSel = 'myaccount'; // set the modules name
    public $company_name;
    public $company_logo;

    /**
     * @inheritdoc
     */

    public function init() {
        parent::init();
    }

    public function beforeAction($action) {

        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($this->getCompany() === NULL) {
            if ($action->controller->id != 'default' && $action->id != 'index') {
                if ($action->controller->id != 'profile') {
                    $defaultController = new DefaultController($action->id, $action);
                    $defaultController->redirectCompany($action);
                }
            }
        } else {
            if ($action->controller->id == 'company' && $action->id == 'create') {
                throw new ForbiddenHttpException('The requested page does not exist.');
            }
        }

        return true; // or false to not run the action
    }

    public function getCompany() {
        if (($model = Company::find()->where('user_id = :user_id', [':user_id' => Yii::$app->user->identity->id])->one()) !== null) {
            $this->company_name=$model->company_name;
            $this->company_logo=Yii::getAlias('@getuploads').'/company/images/'.$model->logo_file_name . '.' . $model->logo_ext;
            return $model;
        } else {
            return NULL;
        }
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['@'], // access for login user
                    ],
                ],
            ],
        ];
    }

}
