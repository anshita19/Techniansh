<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use backend\assets\AppInnerAsset;
use common\widgets\GridView;
use common\widgets\Alertbackend;

AppInnerAsset::register($this);

$this->title = 'Session Manager';
?>

<?php
//echo $this->render('//layouts/_pageheader', ['title' => $this->title, 'icon' => 'icon-users4', 'createUrl' => 'account/create']);
echo $this->render('//layouts/_pageheader', ['title' => $this->title, 'icon' => 'icon-switch2']);

echo '<div id="msg_panel">' . Alertbackend::widget() . '</div>';
?>

<div class="panel panel-flat">

    <div class="dataTables_wrapper no-footer">
        <?php
        echo $this->render('//layouts/_pagesize', ['id' => 'session_grid_pagesize']);

        yii\widgets\Pjax::begin(['id' => 'pjax_session_grid', 'timeout' => 10000, 'enablePushState' => false, 'options' => ['data-pjax-grid-container' => '1']]);

        echo GridView::widget([
            'id' => 'session_grid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterSelector' => 'select[id="session_grid_pagesize"]',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'User',
                    'attribute' => 'user',
                    'enableSorting' => true,
                    'value' => function($model) {
                        return $model->userRel->first_name . ' ' . $model->userRel->last_name;
                    },
                    'contentOptions' => ['style' => 'width: 25%;'],
                ],
                [
                    'label' => 'Expires At',
                    'attribute' => 'expire',
                    'filter' => false,
                    'value' => function($model) {
                        return date("d-m-Y H:i", $model->expire);
                    },
                    'contentOptions' => ['style' => 'width: 10%;'],
                ],
                [
                    'label' => 'Last Access',
                    'attribute' => 'last_write',
                    'filter' => false,
                    'value' => function($model) {
                        return date("d-m-Y H:i", $model->last_write);
                    },
                    'contentOptions' => ['style' => 'width: 10%;'],
                ],
                [
                    'attribute' => 'ip_address',
                    'label' => 'IP Address',
                    'contentOptions' => ['style' => 'width: 10%;'],
                ],
                [
                    'label' => 'Type',
                    'format' => 'html',
                    'attribute' => 'session_type',
                    'contentOptions' => ['style' => 'width: 5%;'],
                    'value' => function($model) {
                return ($model->session_type == 1) ? '<span class="label label-success">' . Yii::$app->params['sessionType'][$model->session_type] . '</span>' : '<span class="label label-danger">' . Yii::$app->params['sessionType'][$model->session_type] . '</span>';
            }
                ],
                ['class' => 'common\widgets\ActionColumn',
                    'template' => '{logout}',
                    'contentOptions' => ['class' => 'text-center','style' => 'width: 10%;'],
                    'buttons' => [
                        'logout' => function ($url, $model) {
                            return Html::a('<span class="text-danger-600 icon-switch2"></span>', $url, [
                                        'data-toggle' => 'tooltip',
                                        'title' => Yii::t('yii', 'Logout'),
                                        'aria-label' => Yii::t('yii', 'Logout'),
                                        'data-action' => '1',
                                        'data-action-url' => $url,
                                        'data-msg' => 'Are you sure you want to logout this user?',
                                        'data-title' => 'Logout'
                            ]);
                        },
                            ]
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
        $('.sel_type').select2({minimumResultsForSearch: Infinity, width: 100});
        $('[data-pjax-grid-container="1"]').on('pjax:end', function (data, status, xhr, options) {
            $('.sel_type').select2({minimumResultsForSearch: Infinity, width: 100});
        });
    });
</script>
