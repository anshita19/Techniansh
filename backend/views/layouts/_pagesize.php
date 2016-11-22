<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\helpers\BaseHtml;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
?>
<div class="datatable-header">
    <!--            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                    <label>
                        <span>Filter:</span> 
                        <input type="search" class="" placeholder="Type to filter..." aria-controls="DataTables_Table_0">
                    </label>
                </div>-->
    <div class="dataTables_length">
        <label>
            <span>Show:</span> 
            <?php
            echo \nterms\pagesize\PageSize::widget([
                'sizes'=>Yii::$app->params['pageSizeList'],
                'defaultPageSize'=>  Yii::$app->params['defaultPageSize'],
                'template' => '{list}',
                'options' => ['id' => $id,
                    'class' => 'select'],
            ]);
            ?>
            <?php
            /*$pageSize = Yii::$app->session->get('pageSize', Yii::$app->params['defaultPageSize']);
            echo Html::dropDownList('pageSize', $pageSize, Yii::$app->params['pageSizeList'], array(
                'onchange' => "$.pjax.reload({container:'#" . $pjax_grid_id . "',push:false,replace:true, data:{pageSize: $(this).val()}});",
                'class' => 'select'));*/
            ?>
        </label>
    </div>
</div>
<?php
$pagesize_js = <<<SELECT_PAGESIZE_JS
        $('.select').select2({
        minimumResultsForSearch: Infinity,
        width: 75});
SELECT_PAGESIZE_JS;
$this->registerJs($pagesize_js);
$this->registerJs(
   '$(document).on("pjax:complete", function() {
        $(".select").select2({minimumResultsForSearch: Infinity,width: 75});
    });', \yii\web\View::POS_READY
);
?>