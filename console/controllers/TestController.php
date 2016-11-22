<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace console\controllers;
 
use yii\console\Controller;
 
/**
 * Test controller
 */
class TestController extends Controller {
 
    public function actionIndex() {
        echo "cron service runnning";
    }
 
    public function actionMail($to,$p) {
        echo "Sending mail to " . $to.'=>'.$p;
    }
 
}

