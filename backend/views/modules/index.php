<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Pjax;

use common\widgets\GridView;
use common\widgets\Alertbackend;

use backend\assets\AppInnerAsset;

AppInnerAsset::register($this);

$this->title = 'Modules';

?>

<?php

echo $this->render('//layouts/_pageheader', ['title' => $this->title, 'icon' => 'icon-megaphone', 'actions' => [
        ['method' => 'modules/create', 'icon' => 'icon-file-plus', 'label' => 'New', 'title' => 'New Module', 'modal' => 2],
    ]
]);

echo '<div id="msg_panel">' . Alertbackend::widget() . '</div>';

?>

<div class="panel panel-flat">

    <div class="dataTables_wrapper no-footer">
        
        <?php
        
            echo $this->render('//layouts/_pagesize', ['id' => 'grid_pagesize']);

            Pjax::begin(['id' => 'pjax_grid', 'timeout' => 10000, 'enablePushState' => false, 'options' => ['data-pjax-grid-container' => '1']]);

            echo GridView::widget([
                'id' => 'grid',
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'filterSelector' => 'select[id="grid_pagesize"]',
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['class' => 'text-center', 'width' => '5%'],
                        'contentOptions' => ['class' => 'text-center']
                    ],
                    'name:raw:Module Name',
                    'controller_name:raw:Controller Name',
                    [
                        'attribute' => 'sort_order',
                        'label' => 'Order',
                        'format' => 'integer',
                        'headerOptions' => ['class' => 'text-right', 'width' => '5%'],
                        'contentOptions' => ['class' => 'text-right']
                    ],
                    ['class' => 'common\widgets\ActionColumn'],
                ],
            ]);

            Pjax::end();
        
        ?>
        
    </div>
    
</div>
