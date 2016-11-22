<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use frontend\assets\AppInnerAsset;
use yii\helpers\Html;
use yii\widgets\Pjax;

use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use common\widgets\Alert;

$bundle=AppInnerAsset::register($this);

$this->title = 'Model Portfolio';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?php echo $this->title; ?></h1>
    <?php Pjax::begin(['id' => 'pjax_modelportfolio',  'timeout' => 10000, 'enablePushState' => false,'options' => ['data-pjax-modelportfolio' => '1']]); ?>
    
    <div class="clearfix">
        
        <?php                                                
            $form = ActiveForm::begin(['id' => 'modelportfoliofrm',
                'enableClientValidation' => false,                
                'options' => [
                    'class' => 'clearfix',                
                    'role' => 'form', 
                    'data-pjax' => true
                ],
                'fieldConfig' => [
                    'options' => ['class' => '']
                ]
            ]);
        ?>
        <div class="date-block">
            <?php
                echo $form->field($model, 'company_name', [
                        'template' => '<div class="form-group"><div class="input-group">{input}</div>{error}</div>',
                    ])->dropDownList($model->getStockList(), ['prompt' => 'Select Stock', 'class' => 'form-control stock-list']);
                
                echo $form->field($model, 'valid_from_to', [
                            'template' => '<div class="form-group datepicker"><div class="input-group">{input}<div class="input-group-addon"><span class="icon sprite-calendar"></span></div></div>{error}</div>',
                        ])->textInput(['class' => 'form-control pickadate-accessibility-date daterange-basic']);
            ?>
        </div>
        <?php
            ActiveForm::end();                
        ?>  
        
    </div>
    
    <div class="table-responsive">
        
        <?php
            if($items)
            {
        ?>        
                <table class="table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <th>Stock</th>
                            <th>Entry Date</th>
                            <th>Entry Price</th>
                            <th>Price Band</th>
                            <th>Investment Notes</th>
                        </tr>
                        <?php
                            foreach($items as $item) {    
                                
                                echo '<tr>
                                        <td>' . $item->stock->company_name . '</td>
                                        <td>' . Yii::$app->formatter->asDate($item->created_at, "php:M d, Y") . '</td>
                                        <td>₹ ' . $item->price_entry . '	</td>
                                        <td>₹ ' . $item->price_from . ' - ₹ ' . $item->price_to . '</td>
                                        <td class="pdf"><a href="' . $bundle->baseUrl . '/myaccount/investmentnote?id=' . $item->stock->id . '"><img class="img-responsive center-block" src="' . $bundle->baseUrl . '/images/pdf-icon.png"><span class="number">' . count($item->stock->investmentNotes) . '</span></a></td>
                                    </tr>';
                            }
                        ?>                        
                    </tbody>
                </table>
        <?php
            }
            else
            {
                echo 'No Records Found!!!';
            }
        ?>
    </div>
    
<?php
    Pjax::end();

    $previousYear = date('Y')-1;
    $currentYear = date('Y');
    
$this->registerCssFile(AppInnerAsset::register($this)->baseUrl . '/styles/select2.css');
$this->registerJsFile(AppInnerAsset::register($this)->baseUrl . '/scripts/select2.min.js');
$this->registerJsFile(AppInnerAsset::register($this)->baseUrl . '/scripts/core/moment.js', ['position' => $this::POS_END]);
$this->registerJsFile(AppInnerAsset::register($this)->baseUrl . '/scripts/pickers/daterangepicker.js', ['position' => $this::POS_END]);

$activemenuJS = <<<JS
    $("#myaccount-sidebar ul li#d-model-portfolio").addClass("active");
JS;

$this->registerJs($activemenuJS, $this::POS_READY);

$modelportfolioJs = <<<JS
    
    $(".stock-list").select2({
        placeholder: "Select Stock",
        allowClear: true
    }); 
        
    $(".pickadate-accessibility-date").daterangepicker({applyClass: 'bg-slate-600', cancelClass: 'btn-default', showDropdowns: true, locale: { format: 'DD/MM/YYYY' }, startDate: '01/04/$previousYear', endDate: '31/03/$currentYear' });
        
    submitModelportfolioform();
        
    function submitModelportfolioform(){
        $('#stock-company_name').on('change',function(){
            $('#modelportfoliofrm').submit();
        });    
            
        $('.applyBtn').on('click',function(){
            $('#modelportfoliofrm').submit();
        });             
    }
   
   $('[data-pjax-modelportfolio="1"]').on('pjax:end', function (data, status, xhr, options) {   
        submitModelportfolioform();   
        $(".stock-list").select2({
            placeholder: "Select Stock",
            allowClear: true
        }); 
        
        $(".pickadate-accessibility-date").daterangepicker({applyClass: 'bg-slate-600', cancelClass: 'btn-default', showDropdowns: true, locale: { format: 'DD/MM/YYYY' }, startDate: '01/04/$previousYear', endDate: '31/03/$currentYear' });
    });
        
        
JS;
$this->registerJs($modelportfolioJs, $this::POS_READY);
?>