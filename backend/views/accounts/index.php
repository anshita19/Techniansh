<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Pjax;

use common\widgets\GridView;
use common\widgets\Alertbackend;

use backend\assets\AppInnerAsset;

AppInnerAsset::register($this);

$this->title = 'Accounts';

?>

<?php

echo $this->render('//layouts/_pageheader', ['title' => $this->title, 'icon' => 'icon-users', 'actions' => [
        ['method' => 'accounts/create', 'icon' => 'icon-file-plus', 'label' => 'New', 'title' => 'Create Account', 'modal' => 2],
    ]
]);

echo '<div id="msg_panel">' . Alertbackend::widget() . '</div>';

?>

<div class="panel panel-flat">
    
    <div class="dataTables_wrapper no-footer">
        
        <?php
        
            echo $this->render('//layouts/_pagesize', ['id' => 'grid_pagesize']);

            Pjax::begin(['id' => 'pjax_grid',  'timeout' => 10000, 'enablePushState' => false, 'options' => ['data-pjax-grid-container' => '1']]);

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
                    'name',
                    'email:email',
                    'mobile',
                    [
                        'label' => 'Status',
                        'attribute' => 'user_status',
                        'filter' => Html::activeDropDownList($searchModel, 'user_status', common\models\User::$statusLabels, ['class' => 'select', 'prompt' => 'All']),
                        'value' => function($model) { return common\models\User::$statusLabels[$model->user_status]; },
                        'headerOptions' => ['class' => 'text-center', 'width' => '5%'], 
                        'contentOptions' => ['class' => 'text-center']
                    ],
                    [
                        'label' => 'Type',
                        'attribute' => 'user_type',
                        'filter' => Html::activeDropDownList($searchModel, 'user_type', common\models\User::$typeLabels, ['class' => 'select', 'prompt' => 'All']),
                        'value' => function($model) { return common\models\User::$typeLabels[$model->user_type]; },
                        'headerOptions' => ['class' => 'text-center', 'width' => '5%'], 
                        'contentOptions' => ['class' => 'text-center']
                    ],
                    ['class' => 'common\widgets\ActionColumn'],
                ],
            ]);

            Pjax::end();
        
        ?>
        
    </div>
    
</div>
