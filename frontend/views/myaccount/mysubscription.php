<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use frontend\assets\AppInnerAsset;
use yii\helpers\Html;

$bundle=AppInnerAsset::register($this);

$this->title = 'Model Portfolio Subscriptions';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?php echo $this->title; ?></h1>
    
    <div class="table-responsive">
        
        <?php
            if($currentplans)
            {
        ?>        
                <div class="table-title clearfix">
                    <h3 class="pull-left">Current Subscriptions</h3>                    
                </div>
                <table class="table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <th>Plan</th>
                            <th>Start From</th>
                            <th>Expired On</th>                            
                            <th>Amount</th>                            
                            <th>Gain-Loss</th>                            
                        </tr>
                        <?php                            
                            echo '<tr>
                                    <td>' . $currentplans->title . '</td>                                        
                                    <td>' . Yii::$app->formatter->asDate($currentplans->start_dt, "php:M d, Y") . '</td>
                                    <td>' . Yii::$app->formatter->asDate($currentplans->end_dt, "php:M d, Y") . '</td>
                                    <td>₹ ' . $currentplans->price . '</td>                                        
                                    <td class="align-left">' . ($currentplangainloss >= 0 ? '' : (-1*$currentplangainloss) . '%') . '<span class="amount' . ($currentplangainloss >= 0 ? ' profit' : ' loss') . '" style="width:' . ($currentplangainloss >= 0 ? $currentplangainloss : (-1*$currentplangainloss)) . '%;"></span>' . ($currentplangainloss >= 0 ? $currentplangainloss . '%' : '') . '</td>
                                </tr>';                            
                        ?>                        
                    </tbody>
                </table>
        <?php
            }
            
            if($previousplans)
            {
        ?>        
                <div class="table-title clearfix">
                    <h3 class="pull-left">Past Subscriptions</h3>                    
                </div>
                <table class="table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <th>Plan</th>
                            <th>Start From</th>
                            <th>Expired On</th>                            
                            <th>Amount</th>                            
                            <th>Gain-Loss</th>                            
                        </tr>
                        <?php            
                            foreach($previousplans as $item)
                            {
                                echo '<tr>
                                        <td>' . $item->title . '</td>                                        
                                        <td>' . Yii::$app->formatter->asDate($item->start_dt, "php:M d, Y") . '</td>
                                        <td>' . Yii::$app->formatter->asDate($item->end_dt, "php:M d, Y") . '</td>
                                        <td>₹ ' . $item->price . '</td>                                        
                                        <td class="align-left">' . ($pastplangainloss >= 0 ? '' : (-1*$pastplangainloss) . '%') . '<span class="amount' . ($pastplangainloss >= 0 ? ' profit' : ' loss') . '" style="width:' . ($pastplangainloss >= 0 ? $pastplangainloss : (-1*$pastplangainloss)) . '%;"></span>' . ($pastplangainloss >= 0 ? $pastplangainloss . '%' : '') . '</td>
                                    </tr>';                            
                            }
                        ?>                        
                    </tbody>
                </table>
        <?php
            }
            
            if(count($currentplans) == 0 && count($previousplans) == 0)
            {
                echo 'No Records Found!!!';
            }
        ?>
    </div>
    
<?php

$activemenuJS = <<<JS
    $("#myaccount-sidebar ul li#d-my-subscriptions").addClass("active");
JS;

$this->registerJs($activemenuJS, $this::POS_READY);
?>