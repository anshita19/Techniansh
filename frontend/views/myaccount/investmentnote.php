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

$this->title = 'Investment Note';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?php echo $this->title; ?></h1>
    <?php Pjax::begin(['id' => 'pjax_investmentnote',  'timeout' => 10000, 'enablePushState' => false,'options' => ['data-pjax-investmentnote' => '1']]); ?>
    
    <div class="clearfix">
        
        <?php                                                
            $form = ActiveForm::begin(['id' => 'investmentnotefrm',
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
                            <?php if(!$stock_id) { ?><th>Stock</th><?php } ?>
                            <th>Title</th>
                            <th>Date</th>
                            <th>&nbsp;</th>                            
                        </tr>
                        <?php
                            foreach($items as $item) {                                    
                                echo '<tr>
                                        ' . (!$stock_id ? '<td>' . $item->stock->company_name . '</td>' : '') . '
                                        <td>' . $item->title . '	</td>
                                        <td>' . Yii::$app->formatter->asDate($item->publish_at, "php:M d, Y") . '</td>                                        
                                        <td class="pdf">' . Yii::$app->formatter->asShortSize($item->file_size) . ' <a href="' . Yii::$app->urlManager->createUrl(['download/investmentnote/'.$item->file_name.'.'. $item->file_ext]) . '"><img class="img-responsive" src="' . $bundle->baseUrl . '/images/pdf-icon.png"></a></td>
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
    $("#myaccount-sidebar ul li#d-investment-notes").addClass("active");
JS;

$this->registerJs($activemenuJS, $this::POS_READY);

$investmentnoteJs = <<<JS
    
    $(".stock-list").select2({
        placeholder: "Select Stock",
        allowClear: true
    }); 
        
    $(".pickadate-accessibility-date").daterangepicker({applyClass: 'bg-slate-600', cancelClass: 'btn-default', showDropdowns: true, locale: { format: 'DD/MM/YYYY' }, startDate: '01/04/$previousYear', endDate: '31/03/$currentYear' });
        
    submitModelportfolioform();
        
    function submitModelportfolioform(){
        $('#stock-company_name').on('change',function(){
            $('#investmentnotefrm').submit();
        });    
            
        $('.applyBtn').on('click',function(){
            $('#investmentnotefrm').submit();
        });             
    }
   
   $('[data-pjax-investmentnote="1"]').on('pjax:end', function (data, status, xhr, options) {   
        submitModelportfolioform();   
        $(".stock-list").select2({
            placeholder: "Select Stock",
            allowClear: true
        }); 
        
        $(".pickadate-accessibility-date").daterangepicker({applyClass: 'bg-slate-600', cancelClass: 'btn-default', showDropdowns: true, locale: { format: 'DD/MM/YYYY' }, startDate: '01/04/$previousYear', endDate: '31/03/$currentYear' });
    });
        
        
JS;
$this->registerJs($investmentnoteJs, $this::POS_READY);
?>