<?php

namespace frontend\widgets\contact\models;

use yii;
use yii\base\Model;
use common\models\User;
use common\models\Country;
use yii\base\InvalidParamException;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * Contact form
 */
class Contact extends Model {

    public $company_name;
    public $contact_person_name;
    public $email;
    public $country;
    public $mobile;
    public $requirement;            

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],            
            ['mobile', 'match', 'pattern' => '/^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$/', 'message' => 'Invalid mobile number.'],
            //['mobile', 'mobile', 'message' => 'Invalid mobile number.'],
            //['mobile', '\common\validators\MobileValidator', 'message' => 'Invalid mobile number.'],
            //['mobile', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This mobile number has already been taken.'],            
            [['company_name', 'contact_person_name','email','country', 'mobile', 'requirement'], 'required'],                        
        ];
    }

    public function sendContactEmail($contact) {
        return Yii::$app
                        ->mailer
                        ->compose(
                            ['html' => 'contactEmail-html'], ['contact' => $contact]
                        )
                        ->setFrom([$contact->email => $contact->contact_person_name])
                        ->setTo(Yii::$app->params['supportEmail'])
                        ->setSubject('New Contact Request')
                        ->send();        
    }

    public function sendBackContactEmail($contact) {
        return Yii::$app
                        ->mailer
                        ->compose(
                            ['html' => 'contactSendBackEmail-html'], ['contact' => $contact]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] => $contact->contact_person_name])
                        ->setTo($contact->email)
                        ->setSubject('Thanks for Reqest')
                        ->send();                
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email) {
        return Yii::$app->mailer->compose()
                        ->setTo($email)
                        ->setFrom([$this->email => $this->name])
                        ->setSubject($this->subject)
                        ->setTextBody($this->body)
                        ->send();
    }
    
    public function getCountryList(){
        $countryModel = Country::find()->all();
        if ($countryModel) {         
            return ArrayHelper::map($countryModel, 'name', 'name');
        }
        return ;
    }

}
