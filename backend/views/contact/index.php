<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use backend\assets\AppInnerAsset;
use common\widgets\GridView;
use common\widgets\Alertbackend;

AppInnerAsset::register($this);

$this->title = 'Contacts';
?>

<?php
//echo $this->render('//layouts/_pageheader', ['title' => $this->title, 'icon' => 'icon-users4', 'createUrl' => 'account/create']);
echo $this->render('//layouts/_pageheader', ['title' => $this->title, 'icon' => 'icon-users4', 'actions' => [
        ['method' => 'contact/create', 'icon' => 'icon-file-plus', 'label' => 'New', 'modal' => 2],
    ]
]);

echo '<div id="msg_panel">' . Alertbackend::widget() . '</div>';
?>

<div class="panel panel-flat">



    <div class="dataTables_wrapper no-footer">
        <?php
        echo $this->render('//layouts/_pagesize', ['id' => 'contact_grid_pagesize']);

        yii\widgets\Pjax::begin(['id' => 'pjax_contact_grid', 'timeout' => 10000, 'enablePushState' => false, 'options' => ['data-pjax-grid-container' => '1']]);

        echo GridView::widget([
            'id' => 'contact_grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterSelector' => 'select[id="contact_grid_pagesize"]',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Name',
                    'attribute' => 'name',
                    'filter' => true,
                    'value' => function($model) {
                        return $model->first_name.' '.$model->last_name;
                    }
                ],
                'organization',        
                'designation',        
                'email:email',
                'mobile',
                ['class' => 'common\widgets\ActionColumn'],
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
