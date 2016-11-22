<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Download controller
 */
class DownloadController extends Controller {

    //public $layout = 'innermain';
    public $params = [];
    public $file;

    public function init() {
        parent::init();
        $this->download();
    }

    public function download($expire=null) {

        $this->params = Yii::$app->request->getQueryParams();
        $file= Yii::getAlias('@uploads') . '/' . $this->params['file'];
               
        ($finf = finfo_open(FILEINFO_MIME)) or function () use ($file) {
		throw new \BadFunctionCallException("File '$file' not found", 404);
	};
	$mime = finfo_file($finf, $file);
	finfo_close($finf);
	header('Pragma: public');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT');
	header('ETag: ' . md5(dirname($file)));
	if ($expire) {
		header('Cache-Control: maxage=' . strtotime($expire));
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + strtotime($expire)) . ' GMT');
	}
	header('Content-Disposition: attachment; filename=' . basename($file));
	header('Content-Type: ' . $mime);
	header('Content-Length: ' . filesize($file));
	header('Connection: close');
	readfile($file);
    }

    /**
     * @inheritdoc
     */
    public function actions() {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

}
