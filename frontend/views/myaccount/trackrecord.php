<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use frontend\assets\AppInnerAsset;
use yii\helpers\Html;

$bundle=AppInnerAsset::register($this);

$this->title = 'Track Records';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?php echo $this->title; ?></h1>
    
    <div class="table-responsive">
        
        <?php
            if($currentitems)
            {
        ?>        
                <div class="table-title clearfix">
                    <h3 class="pull-left">Current Plans</h3>                    
                </div>
                <table class="table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <th>Stock</th>
                            <th>Entry Price</th>
                            <th>Entry Date</th>                            
                            <th>Exit Price</th>
                            <th>Exit Date</th>
                            <th>Gain-Loss</th>                            
                        </tr>
                        <?php
                            foreach($currentitems as $item) {                                    
                                $gainLoss = ($item->price_exit ? ($item->price_exit - $item->price_entry) : 0);                                
                                echo '<tr>
                                        <td>' . $item->stock->company_name . '</td>
                                        <td>₹ ' . $item->price_entry . '</td>
                                        <td>' . Yii::$app->formatter->asDate($item->valid_from, "php:M d, Y") . '</td>
                                        <td>' . ($item->price_exit ? '₹ ' . $item->price_exit : '&nbsp;') . '</td>
                                        <td>' . Yii::$app->formatter->asDate($item->valid_to, "php:M d, Y") . '</td>
                                        <td class="align-left">' . ($gainLoss >= 0 ? '' : '₹' . (-1*$gainLoss)) . '<span class="amount' . ($gainLoss >= 0 ? ' profit' : ' loss') . '" style="width:' . ($gainLoss >= 0 ? $gainLoss : (-1*$gainLoss)) . '%;"></span>' . ($gainLoss >= 0 ? '₹' . $gainLoss : '') . '</td>
                                    </tr>';
                            }
                        ?>                        
                    </tbody>
                </table>
        <?php
            }
            
            if($previousitems)
            {
        ?>        
                <div class="table-title clearfix">
                    <h3 class="pull-left">Past Plans</h3>                    
                </div>
                <table class="table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <th>Stock</th>
                            <th>Entry Price</th>
                            <th>Entry Date</th>                            
                            <th>Exit Price</th>
                            <th>Exit Date</th>
                            <th>Gain-Loss</th>                            
                        </tr>
                        <?php
                            foreach($previousitems as $item) {    
                                $gainLoss = ($item->price_exit ? ($item->price_exit - $item->price_entry) : 0);
                                echo '<tr>
                                        <td>' . $item->stock->company_name . '</td>
                                        <td>₹ ' . $item->price_entry . '</td>
                                        <td>' . Yii::$app->formatter->asDate($item->valid_from, "php:M d, Y") . '</td>
                                        <td>' . ($item->price_exit ? '₹ ' . $item->price_exit : '&nbsp;') . '</td>
                                        <td>' . Yii::$app->formatter->asDate($item->valid_to, "php:M d, Y") . '</td>
                                        <td class="align-left">' . ($gainLoss >= 0 ? '' : '₹' . (-1*$gainLoss)) . '<span class="amount' . ($gainLoss >= 0 ? ' profit' : ' loss') . '" style="width:' . ($gainLoss >= 0 ? $gainLoss : (-1*$gainLoss)) . '%;"></span>' . ($gainLoss >= 0 ? '₹' . $gainLoss : '') . '</td>
                                    </tr>';
                            }
                        ?>                        
                    </tbody>
                </table>
        <?php
            }
            
            if(count($currentitems) == 0 && count($previousitems) == 0)
            {
                echo 'No Records Found!!!';
            }
        ?>
    </div>
    
<?php

$activemenuJS = <<<JS
    $("#myaccount-sidebar ul li#d-track-record").addClass("active");
JS;

$this->registerJs($activemenuJS, $this::POS_READY);
?>