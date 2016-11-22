<?php

namespace common\models;

use Yii;
use common\components\UsercontrolBehavior;
use common\components\UseripBehavior;
use common\components\UsertimestampBehavior;
use yii\captcha\CaptchaAction as CaptchaActionBase;

/**
 * This is the model class for table "appoinment".
 *
 * @property integer $appoinment_id
 * @property string $title
 * @property string $start_date_time
 * @property string $end_date_time
 * @property string $contact
 * @property string $details
 * @property integer $status
 * @property integer $additional_people
 * @property string $created_at
 * @property string $creator_ip
 * @property integer $creator_id
 * @property string $modified_at
 * @property string $modifier_ip
 * @property integer $modifier_id
 */
class CaptchaAction extends CaptchaActionBase {

    
    public function validate($input, $caseSensitive) {
        
        $code = $this->getVerifyCode();
        $valid = $caseSensitive ? ($input === $code) : strcasecmp($input, $code) === 0;
        $session = Yii::$app->getSession();
        $session->open();
        $name = $this->getSessionKey() . 'count';
        $session[$name] = $session[$name] + 1;
        if (Yii::$app->request->isAjax) {
            return false;
        }
        if ($valid || $session[$name] > $this->testLimit && $this->testLimit > 0) {
            $this->getVerifyCode(true);
        }

        return $valid;
    }


}
