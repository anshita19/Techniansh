<?php

namespace frontend\modules\myaccount\controllers;

use Yii;
use common\models\Project;
use common\models\ProjectSearch;
use common\models\ProjectMedia;
use common\models\Company;
use common\models\State;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller {

    public $defaultAction = 'view';

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     */
    public function actionView() {
        $modelProject = Project::find()->joinWith('state')->where('user_id = :user_id and is_verified="Y"', [':user_id' => Yii::$app->user->identity->id])
                        ->select(['project.*', 'state.name'])
                        ->orderBy(['modified_at' => SORT_DESC, 'created_at' => SORT_DESC])->all();
        return $this->render('view', [
                    'modelProject' => $modelProject,
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $modelProject = new Project();
        $modelProjectMedia = new ProjectMedia();

        $modelProject->user_id = Yii::$app->user->identity->id;

        if (Yii::$app->request->isAjax && $modelProject->load(Yii::$app->request->post()) && !$modelProject->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelProject);
        }

        if ($modelProject->load(Yii::$app->request->post())) {
            if (!empty($modelProject->capacity_unit) && $modelProject->capacity_unit == '2') {
                $modelProject->capacity = ($modelProject->capacity * 1000);
            }
            if ($modelProject->validate() && $modelProject->save()) {
                Yii::$app->session->setFlash('success', 'Project information added successfully.');
                return $this->redirect(['view']);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for adding project infomation.');
            }
        }

        $stateList = ArrayHelper::map(State::find()->where('country_id = 101')->all(), 'id', 'name');

        return $this->render('update', [
                    'modelProject' => $modelProject,
                    'stateList' => $stateList
        ]);
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $modelProject = $this->findModel($id);

        $projectMediaArr = ProjectMedia::find()->select(['project_media_id', 'media_type', 'media_file_name', 'media_ext'])->where('project_id=:project_id', [':project_id' => $id])->all();
        $mediaArr = [];
        if (!empty($projectMediaArr)) {
            foreach ($projectMediaArr as $value) {
                $mediaArr[$value['media_type']][] = $value['media_file_name'] . '.' . $value['media_ext'];
            }
        }

        $modelProject->user_id = Yii::$app->user->identity->id;
        $install_capacity_unit = $modelProject->capacity_unit;
        $install_capacity = $modelProject->capacity;
        $modelProject->capacity = ($modelProject->capacity_unit == '2') ? ($modelProject->capacity / 1000) : $modelProject->capacity;
        $stateList = ArrayHelper::map(State::find()->where('country_id = 101')->all(), 'id', 'name');

        if (Yii::$app->request->isAjax && $modelProject->load(Yii::$app->request->post()) && !$modelProject->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelProject);
        }

        if ($modelProject->load(Yii::$app->request->post())) {

            if ($install_capacity != $modelProject->capacity || $install_capacity_unit != $modelProject->capacity_unit) {
                if (!empty($modelProject->capacity_unit) && $modelProject->capacity_unit == '2') {
                    $modelProject->capacity = ($modelProject->capacity * 1000);
                }
            }

            if ($modelProject->validate() && $modelProject->save()) {
                Yii::$app->session->setFlash('success', 'Project information updated successfully.');
                return $this->redirect(['view']);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for updating project infomation.');
            }
        }

        return $this->render('update', [
                    'modelProject' => $modelProject,
                    'stateList' => $stateList,
                    'mediaArr' => $mediaArr
        ]);
    }

    public function actionViewproject($id) {
        $modelProject = $this->findModel($id);
        $projectMediaArr = ProjectMedia::find()->select(['project_media_id', 'media_type', 'media_file_name', 'media_ext'])->where('project_id=:project_id', [':project_id' => $id])->all();
        $mediaArr = [];
        if (!empty($projectMediaArr)) {
            foreach ($projectMediaArr as $value) {
                $mediaArr[$value['media_type']][] = $value['media_file_name'] . '.' . $value['media_ext'];
            }
        }
        $modelProject->user_id = Yii::$app->user->identity->id;
        $modelProject->capacity = ($modelProject->capacity_unit == '2') ? ($modelProject->capacity / 1000) : $modelProject->capacity;
        $modelState = State::find()->select(['name'])->where('id = :id', [':id' => $modelProject->state_id])->one();

        return $this->render('viewproject', [
                    'modelProject' => $modelProject,
                    'modelState' => $modelState,
                    'mediaArr' => $mediaArr
        ]);
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('danger', 'Project deleted successfully.');
        return $this->redirect(['view']);
    }

    public function actionMediacommissioning($id) {
        $modelProjectMediaArr = ProjectMedia::find()->where('project_id=:project_id and media_type=:media_type', [
                    ':project_id' => $id,
                    ':media_type' => ProjectMedia::PROJECT_MEDIA_COMMISSIONING
                ])->all();
        $modelProjectMedia = new ProjectMedia();
        $modelProjectMedia->project_id = $id;

        if ($modelProjectMedia->load(Yii::$app->request->post())) {
            if (UploadedFile::getInstance($modelProjectMedia, 'media_file_name')) {
                $modelProjectMedia->media = UploadedFile::getInstance($modelProjectMedia, 'media_file_name');
                $modelProjectMedia->media_base_name = $modelProjectMedia->media->getBaseName();
                $modelProjectMedia->media_size = $modelProjectMedia->media->size;
                if ($modelProjectMedia->media->error === 0) {
                    list($modelProjectMedia->media_width, $modelProjectMedia->media_height) = getimagesize($modelProjectMedia->media->tempName);
                } else {
                    $modelProjectMedia->addError('media_file_name', 'Logo size allow only 2 Mb.');
                }
                $modelProjectMedia->media_ext = $modelProjectMedia->media->getExtension();
                $modelProjectMedia->media_file_name = preg_replace('/\s+/', '', $modelProjectMedia->media->getBaseName() . time());
            }
        }

        if (Yii::$app->request->isAjax && Yii::$app->request->post() && !$modelProjectMedia->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelProjectMedia);
        }

        if (Yii::$app->request->post()) {
            $modelProjectMedia->media_type = ProjectMedia::PROJECT_MEDIA_COMMISSIONING;
            if ($modelProjectMedia->validate(NULL, FALSE) && $modelProjectMedia->upload(ProjectMedia::PROJECT_MEDIA_COMMISSIONING) && $modelProjectMedia->save()) {
                Yii::$app->session->setFlash('success', 'Commissioning certificate added successfully.');
                return $this->redirect(['update', 'id' => $modelProjectMedia->project_id]);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for adding commssioning certificate.');
            }
        }

        return $this->render('media', [
                    'modelProjectMediaArr' => $modelProjectMediaArr,
                    'modelProjectMedia' => $modelProjectMedia,
                    'MediaTitle' => 'Commissioning Certificates',
                    'MediaUpload' => 'commissioning',
        ]);
    }

    public function actionMediacontract($id) {
        $modelProjectMediaArr = ProjectMedia::find()->where('project_id=:project_id and media_type=:media_type', [
                    ':project_id' => $id,
                    ':media_type' => ProjectMedia::PROJECT_MEDIA_CONTRACT
                ])->all();
        $modelProjectMedia = new ProjectMedia();
        $modelProjectMedia->project_id = $id;

        if ($modelProjectMedia->load(Yii::$app->request->post())) {
            if (UploadedFile::getInstance($modelProjectMedia, 'media_file_name')) {
                $modelProjectMedia->media = UploadedFile::getInstance($modelProjectMedia, 'media_file_name');
                $modelProjectMedia->media_base_name = $modelProjectMedia->media->getBaseName();
                $modelProjectMedia->media_size = $modelProjectMedia->media->size;
                if ($modelProjectMedia->media->error === 0) {
                    list($modelProjectMedia->media_width, $modelProjectMedia->media_height) = getimagesize($modelProjectMedia->media->tempName);
                } else {
                    $modelProjectMedia->addError('media_file_name', 'Logo size allow only 2 Mb.');
                }
                $modelProjectMedia->media_ext = $modelProjectMedia->media->getExtension();
                $modelProjectMedia->media_file_name = preg_replace('/\s+/', '', $modelProjectMedia->media->getBaseName() . time());
            }
        }

        if (Yii::$app->request->isAjax && Yii::$app->request->post() && !$modelProjectMedia->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelProjectMedia);
        }

        if (Yii::$app->request->post()) {
            $modelProjectMedia->media_type = ProjectMedia::PROJECT_MEDIA_CONTRACT;
            if ($modelProjectMedia->validate(NULL, FALSE) && $modelProjectMedia->upload(ProjectMedia::PROJECT_MEDIA_CONTRACT) && $modelProjectMedia->save()) {
                Yii::$app->session->setFlash('success', 'Contract certificate added successfully.');
                return $this->redirect(['update', 'id' => $modelProjectMedia->project_id]);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for adding contract certificate.');
            }
        }

        return $this->render('media', [
                    'modelProjectMediaArr' => $modelProjectMediaArr,
                    'modelProjectMedia' => $modelProjectMedia,
                    'MediaTitle' => 'Contract Certificates',
                    'MediaUpload' => 'contract',
        ]);
    }

    public function actionMediaphoto($id) {
        $modelProjectMediaArr = ProjectMedia::find()->where('project_id=:project_id and media_type=:media_type', [
                    ':project_id' => $id,
                    ':media_type' => ProjectMedia::PROJECT_MEDIA_PHOTO
                ])->all();
        $modelProjectMedia = new ProjectMedia();
        $modelProjectMedia->project_id = $id;

        if ($modelProjectMedia->load(Yii::$app->request->post())) {
            if (UploadedFile::getInstance($modelProjectMedia, 'media_file_name')) {
                $modelProjectMedia->media = UploadedFile::getInstance($modelProjectMedia, 'media_file_name');
                $modelProjectMedia->media_base_name = $modelProjectMedia->media->getBaseName();
                $modelProjectMedia->media_size = $modelProjectMedia->media->size;
                if ($modelProjectMedia->media->error === 0) {
                    list($modelProjectMedia->media_width, $modelProjectMedia->media_height) = getimagesize($modelProjectMedia->media->tempName);
                } else {
                    $modelProjectMedia->addError('media_file_name', 'Logo size allow only 2 Mb.');
                }
                $modelProjectMedia->media_ext = $modelProjectMedia->media->getExtension();
                $modelProjectMedia->media_file_name = preg_replace('/\s+/', '', $modelProjectMedia->media->getBaseName() . time());
            }
        }

        if (Yii::$app->request->isAjax && Yii::$app->request->post() && !$modelProjectMedia->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelProjectMedia);
        }

        if (Yii::$app->request->post()) {
            $modelProjectMedia->media_type = ProjectMedia::PROJECT_MEDIA_PHOTO;
            if ($modelProjectMedia->validate(NULL, FALSE) && $modelProjectMedia->upload(ProjectMedia::PROJECT_MEDIA_PHOTO) && $modelProjectMedia->save()) {
                Yii::$app->session->setFlash('success', 'Project photo added successfully.');
                return $this->redirect(['update', 'id' => $modelProjectMedia->project_id]);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error for adding project photo.');
            }
        }

        return $this->render('media', [
                    'modelProjectMediaArr' => $modelProjectMediaArr,
                    'modelProjectMedia' => $modelProjectMedia,
                    'MediaTitle' => 'Project Photos',
                    'MediaUpload' => 'photo',
        ]);
    }

    public function actionDeletemedia($id) {
        if (($modelProjectMedia = ProjectMedia::findOne($id)) !== null) {
            $projectId = $modelProjectMedia->project_id;
            $modelProjectMedia->delete();
            Yii::$app->session->setFlash('danger', 'Media deleted successfully.');
            return $this->redirect(['update', 'id' => $projectId]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
