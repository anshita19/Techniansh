<?php
/**
 * @link https://github.com/himiklab/yii2-recaptcha-widget
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace himiklab\yii2\recaptcha;

use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\validators\Validator;

/**
 * ReCaptcha widget validator.
 *
 * @author HimikLab
 * @package himiklab\yii2\recaptcha
 */
class ReCaptchaValidator extends Validator
{
    const GRABBER_PHP = 1; // file_get_contents
    const GRABBER_CURL = 2; // CURL, because sometimes file_get_contents is deprecated

    const SITE_VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';
    const CAPTCHA_RESPONSE_FIELD = 'g-recaptcha-response';

    /** @var boolean Whether to skip this validator if the input is empty. */
    public $skipOnEmpty = false;

    /** @var string The shared key between your site and ReCAPTCHA. */
    public $secret;

    /** @var int Choose your grabber for getting JSON, self::GRABBER_PHP = file_get_contents, self::GRABBER_CURL = CURL */
    public $grabberType = self::GRABBER_PHP;

    public $uncheckedMessage;

    public function init()
    {
        parent::init();
        if (empty($this->secret)) {
            if (!empty(Yii::$app->reCaptcha->secret)) {
                $this->secret = Yii::$app->reCaptcha->secret;
            } else {
                throw new InvalidConfigException('Required `secret` param isn\'t set.');
            }
        }

        if ($this->message === null) {
            $this->message = Yii::t('yii', 'The verification code is incorrect.');
        }
    }

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     * @param \yii\web\View $view
     * @return string
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $valid = false;
      // only validate if the captcha has been POSTed
      if (isset($_POST['recaptcha_challenge_field']) && isset($_POST['recaptcha_response_field'])) {
        // sessions are enabled, so we can cache the value
        if ($session = Yii::app()->session) { 
          // if this question that was asked before, check the cached answer
          if (isset($session['cCache']) && isset($session['cCache']['q'])
            && $session['cCache']['q'] == $_POST['recaptcha_challenge_field']
          ) {
            // if the cached answer equals the provided answer,
            // we know it was previously validated as correct
            if (isset($session['cCache']['a']) && 
                $session['cCache']['a'] == $_POST['recaptcha_response_field']) {
              $valid = true;
            }
          } else { // validate the captcha 
            $resp = recaptcha_check_answer(
              $this->privateKey,
              $_SERVER['REMOTE_ADDR'],
              $_POST['recaptcha_challenge_field'],
              $_POST['recaptcha_response_field']
            );
            // if it validates, store challenge and response hash in session
            if ($resp->is_valid) {
              if (Yii::app()->session) {
                Yii::app()->session['cCache'] = array(
                  'q' => $_POST['recaptcha_challenge_field'],
                  'a' => sha1($_POST['recaptcha_response_field']),
                );
              }
              $valid = true;
            }
          }
        }
      }
      // if the captcha or cached value were not validated, set the error
      if (!$valid) {
        $message = $this->message !== null ? $this->message : Yii::t('yii', 'The verification code is incorrect.');
        $this->addError($model, $attribute, $message);
      }
    }

    /**
     * @param string $value
     * @return array|null
     * @throws Exception
     */
    protected function validateValue($value)
    {
        if (empty($value)) {
            if (!($value = Yii::$app->request->post(self::CAPTCHA_RESPONSE_FIELD))) {
                return [$this->message, []];
            }
        }

        $request = self::SITE_VERIFY_URL . '?' . http_build_query([
                'secret' => $this->secret,
                'response' => $value,
                'remoteip' => Yii::$app->request->userIP
            ]);
        $response = $this->getResponse($request);
        if (!isset($response['success'])) {
            throw new Exception('Invalid recaptcha verify response.');
        }
        return $response['success'] ? null : [$this->message, []];
    }

    /**
     * @param string $request
     * @return mixed
     * @throws Exception
     */
    protected function getResponse($request)
    {
        if ($this->grabberType === self::GRABBER_PHP) {
            $response = @file_get_contents($request);

            if ($response === false) {
                throw new Exception('Unable connection to the captcha server.');
            }
        } else {
            $options = array(
                CURLOPT_CUSTOMREQUEST => 'GET',     //set request type post or get
                CURLOPT_POST => false,              //set to GET
                CURLOPT_RETURNTRANSFER => true,     // return web page
                CURLOPT_HEADER => false,            // don't return headers
                CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                CURLOPT_ENCODING => '',             // handle all encodings
                CURLOPT_AUTOREFERER => true,        // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                CURLOPT_TIMEOUT => 120,             // timeout on response
                CURLOPT_MAXREDIRS => 10,            // stop after 10 redirects
            );

            $ch = curl_init($request);
            curl_setopt_array($ch, $options);
            $content = curl_exec($ch);
            $err = curl_errno($ch);
            $errmsg = curl_error($ch);
            $header = curl_getinfo($ch);
            curl_close($ch);

            $header['errno'] = $err;
            $header['errmsg'] = $errmsg;
            $response = $content;

            if ($header['errno'] !== 0) {
                throw new Exception('Unable connection to the captcha server. ' . $header['errmsg']);
            }
        }

        return Json::decode($response, true);
    }
}
