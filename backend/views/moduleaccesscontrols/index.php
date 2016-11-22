<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

use common\widgets\GridView;
use common\widgets\Alertbackend;

use backend\assets\AppInnerAsset;

AppInnerAsset::register($this);

$this->title = 'Module Access Controls';

?>

<?php

echo $this->render('//layouts/_pageheader', ['title' => $this->title, 'icon' => 'icon-megaphone', 'actions' => [
        ['method' => 'moduleaccesscontrols/create', 'icon' => 'icon-file-plus', 'label' => 'New', 'title' => 'New Module Access Control', 'modal' => 2],
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
                    [
                        'attribute' => 'role_id',
                        'label' => 'Role',
                        'value' => function($model) {
                            return Yii::$app->params['userGroup'][$model->role_id];
                        }
                    ],
                    ['class' => 'common\widgets\ActionColumn',
                        'urlCreator' => function($action, $dataProvider, $key, $index) {
                            if($action==='update' || $action==='delete'){
                                return Url::to(['moduleaccesscontrols/'.$action, 'id' =>$dataProvider['role_id']]);
                            }
                        }
                    ],
                ],
            ]);

            Pjax::end();

        ?>
        
    </div>
    
</div>
