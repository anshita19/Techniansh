<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\SerialColumn;

use backend\assets\AppInnerAsset;

use common\widgets\GridView;
use common\widgets\ActionColumn;
use common\widgets\Alertbackend;

AppInnerAsset::register($this);

$this->title = 'Countries';

?>

<?php
echo $this->render('//layouts/_pageheader', ['title' => $this->title, 'icon' => 'icon-city', 'actions' => [
        ['method' => 'country/create', 'icon' => 'icon-file-plus', 'label' => 'New', 'title' => 'New Country', 'modal' => 2],
    ]
]);

echo '<div id="msg_panel">' . Alertbackend::widget() . '</div>';
?>

<div class="panel panel-flat">

    <div class="dataTables_wrapper no-footer">
        
        <?php
        
            echo $this->render('//layouts/_pagesize', ['id' => 'article_link_grid_pagesize']);

            yii\widgets\Pjax::begin(['id' => 'pjax_grid',  'timeout' => 10000, 'enablePushState' => false, 'options' => ['data-pjax-grid-container' => '1']]);

            echo GridView::widget([
                'id' => 'country_link_grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'filterSelector' => 'select[id="country_grid_pagesize"]',
                'columns' => [
                    [
                        'class' => SerialColumn::className(), 
                        'headerOptions' => ['class' => 'text-center', 'width' => '5%'], 
                        'contentOptions' => ['class' => 'text-center']
                    ],
                    [
                        'attribute' => 'name',
                    ],
                    [
                        'attribute' => 'sortname',
                    ],                    
                    [
                        'class' => ActionColumn::className(), 
                        'headerOptions' => ['class' => 'text-center', 'width' => '10%'], 
                        'contentOptions' => ['class' => 'text-center']
                    ],
                ],
            ]);
            yii\widgets\Pjax::end();
            
        ?>
        
    </div>
    
</div>
<script>
    $(document).ready(function () {
        $(".dataTable thead a").addClass("sorting");
    });
</script>
