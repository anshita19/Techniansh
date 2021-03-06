<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use backend\assets\AppInnerAsset;
use common\widgets\GridView;
use common\widgets\Alertbackend;
use yii\widgets\Pjax;

AppInnerAsset::register($this);

$this->title = 'Usergroup';

echo $this->render('//layouts/_pageheader', ['title' => $this->title, 'icon' => 'icon-megaphone', 'actions' => [
        ['method' => 'usergroup/create', 'icon' => 'icon-file-plus', 'label' => 'New', 'modal' => 2],
    ]
]);
echo '<div id="msg_panel">' . Alertbackend::widget() . '</div>';
?>

<div class="panel panel-flat">

    <div class="dataTables_wrapper no-footer">
        <?php
        echo $this->render('//layouts/_pagesize', ['id' => 'usergroup_grid_pagesize']);

        Pjax::begin(['id' => 'pjax_usergroup_grid', 'timeout' => 10000, 'enablePushState' => false, 'options' => ['data-pjax-grid-container' => '1']]);

        echo GridView::widget([
            'id' => 'usergroup_grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterSelector' => 'select[id="usergroup_grid_pagesize"]',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['class' => 'text-center', 'width' => '5%'],
                    'contentOptions' => ['class' => 'text-center']
                ],
                'group_name:raw:Group Name',
                ['class' => 'common\widgets\ActionColumn'],
            ],
        ]);
        Pjax::end();
        ?>
    </div>
</div>
