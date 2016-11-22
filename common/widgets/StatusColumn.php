<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\widgets;

use Yii;
use Closure;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\Column;

/**
 * StatusColumn is a column for the [[GridView]] widget that displays buttons for viewing and manipulating the items.
 *
 * To add an StatusColumn to the gridview, add it to the [[GridView::columns|columns]] configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     // ...
 *     [
 *         'class' => StatusColumn::className(),
 *         // you may configure additional properties here
 *     ],
 * ]
 * ```
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class StatusColumn extends Column {

    /**
     * @inheritdoc
     */
    public $headerOptions = ['class' => 'text-left', 'width' => '14%'];
    public $contentOptions = ['class' => 'text-left'];

    /**
     * @var string the ID of the controller that should handle the actions specified here.
     * If not set, it will use the currently active controller. This property is mainly used by
     * [[urlCreator]] to create URLs for different actions. The value of this property will be prefixed
     * to each action name to form the route of the action.
     */
    public $controller;

    /**
     * @var string the template used for composing each cell in the action column.
     * Tokens enclosed within curly brackets are treated as controller action IDs (also called *button names*
     * in the context of action column). They will be replaced by the corresponding button rendering callbacks
     * specified in [[buttons]]. For example, the token `{view}` will be replaced by the result of
     * the callback `buttons['view']`. If a callback cannot be found, the token will be replaced with an empty string.
     *
     * As an example, to only have the view, and update button you can add the StatusColumn to your GridView columns as follows:
     *
     * ```
     * ['class' => 'yii\grid\StatusColumn', 'template' => '{view} {update}'],
     * ```
     *
     * @see buttons
     */
    //public $template = '{view} {update} {delete}';
    public $template = '{status}';
    public $header = 'Status';
    public $message = 'Are you sure you want to change the status of this item?';
    public $title = 'Status';
    public $url;
    public $attribute = 'status';
    public $filter;
    public $visibleBtn = true;
    public $filterInputOptions = ['class' => 'form-control select', 'id' => null, 'prompt' => 'All'];

    /**
     * @var array button rendering callbacks. The array keys are the button names (without curly brackets),
     * and the values are the corresponding button rendering callbacks. The callbacks should use the following
     * signature:
     *
     * ```php
     * function ($url, $model, $key) {
     *     // return the button HTML code
     * }
     * ```
     *
     * where `$url` is the URL that the column creates for the button, `$model` is the model object
     * being rendered for the current row, and `$key` is the key of the model in the data provider array.
     *
     * You can add further conditions to the button, for example only display it, when the model is
     * editable (here assuming you have a status field that indicates that):
     *
     * ```php
     * [
     *     'update' => function ($url, $model, $key) {
     *         return $model->status === 'editable' ? Html::a('Update', $url) : '';
     *     },
     * ],
     * ```
     */
    public $buttons = [];

    /** @var array visibility conditions for each button. The array keys are the button names (without curly brackets),
     * and the values are the boolean true/false or the anonymous function. When the button name is not specified in
     * this array it will be shown by default.
     * The callbacks must use the following signature:
     *
     * ```php
     * function ($model, $key, $index) {
     *     return $model->status === 'editable';
     * }
     * ```
     *
     * Or you can pass a boolean value:
     *
     * ```php
     * [
     *     'update' => \Yii::$app->user->can('update'),
     * ],
     * ```
     * @since 2.0.7
     */
    public $visibleButtons = [];

    /**
     * @var callable a callback that creates a button URL using the specified model information.
     * The signature of the callback should be the same as that of [[createUrl()]].
     * If this property is not set, button URLs will be created using [[createUrl()]].
     */
    public $urlCreator;

    /**
     * @var array html options to be applied to the [[initDefaultButtons()|default buttons]].
     * @since 2.0.4
     */
    public $buttonOptions = [];

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->initDefaultButtons();
        $this->registerClientScript();
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons() {
        if (!isset($this->buttons['status'])) {
            $this->buttons['status'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', $this->title),
                    'aria-label' => Yii::t('yii', $this->title),
                    'data-statusAction' => '1',
                    'data-action-url' => ($this->url) ? $this->url : $url,
                    'data-msg' => $this->message,
                    'data-title' => $this->title,
                    'data-value' => ($model->status == '0') ? '1' : '0',
                        ], $this->buttonOptions);
                $status = '<div class="btn-group"><a href="#" class="label-flat text-' . Yii::$app->params['statusClass'][$model->status] . ' dropdown-toggle" data-toggle="dropdown"><i class="' . Yii::$app->params['statusIcon'][$model->status] . ' position-left"></i> ' . Yii::$app->params['status'][$model->status] . ' <span class="caret"></span></a>';
                if ($this->visibleBtn) {
                    $status .= '<ul class="dropdown-menu dropdown-menu-right">';
                    foreach (Yii::$app->params['status'] as $key => $value) {
                        if ($key == $model->status)
                            continue;

                        $status .= '<li>' . Html::a('<i class="' . Yii::$app->params['statusIcon'][$key] . ' position-left"></i> ' . $value, 'javascript:;', $options) . '</li>';
                    }
                    $status .= '</ul>';
                }
                $status .= '</div>';
                return $status;
            };
        }
    }

    /**
     * Creates a URL for the given action and model.
     * This method is called for each button and each row.
     * @param string $action the button name (or action ID)
     * @param \yii\db\ActiveRecord $model the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the current row index
     * @return string the created URL
     */
    public function createUrl($action, $model, $key, $index) {
        if (is_callable($this->urlCreator)) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index);
        } else {
            $params = is_array($key) ? $key : ['id' => (string) $key];
            $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

            return Url::toRoute($params);
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index) {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];

            if (isset($this->visibleButtons[$name])) {
                $isVisible = $this->visibleButtons[$name] instanceof \Closure ? call_user_func($this->visibleButtons[$name], $model, $key, $index) : $this->visibleButtons[$name];
            } else {
                $isVisible = true;
            }

            if ($isVisible && isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);
                return call_user_func($this->buttons[$name], $url, $model, $key);
            } else {
                return '';
            }
        }, $this->template);
    }

    protected function renderFilterCellContent() {
        if ($this->filter === false) {
            return;
        }

        if (is_string($this->filter)) {
            return $this->filter;
        }

        $model = $this->grid->filterModel;

        $this->filter = Yii::$app->params['status'];

        if ($this->filter !== false && $this->attribute !== null && $model->isAttributeActive($this->attribute)) {

            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = ' ' . Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }

            if (is_array($this->filter)) {
                $options = array_merge(['prompt' => 'All'], $this->filterInputOptions);
                return Html::activeDropDownList($model, $this->attribute, $this->filter, $options) . $error;
            } else {
                return Html::activeTextInput($model, $this->attribute, $this->filterInputOptions) . $error;
            }
        } else {
            return parent::renderFilterCellContent();
        }
    }

    /**
     * Registers the required scripts for the toggle column to work properly
     */
    protected function registerClientScript() {

        $gridViewDeleteScript = <<<JS
                $('[data-statusAction="1"]').on('click',function(e){
                    e.preventDefault();
                    var self=this;
                    var msg=(typeof $(self).attr('data-msg')!== typeof undefined && $(self).attr('data-msg') !== false) ? $(self).attr('data-msg') : "Are you sure you want to perform this action?";
                    var title=(typeof $(self).attr('data-title')!== typeof undefined && $(self).attr('data-title') !== false) ? $(self).attr('data-title') : "Action";
                    eModal.confirm(msg,title).then(function(){
                        $.ajax({
                                url: $(self).attr('data-action-url'),
                                type: "post",
                                dataType:"json",
                                data:{_csrf:yii.getCsrfToken(),status:$(self).attr('data-value')},
                                error: function(xhr, status, error) {
                                    jsonObj={"msgtype":"warning","msg":xhr.responseText};
                                    displayMessage(jsonObj);
                                }
                            }).done(function(data) {
                                var container = $("[data-pjax-grid-container=\"1\"]");
                                var grid = $('[data-gridurl]');
                                if (container.length == 0 || grid.length == 0) return;
                                $.pjax.defaults=false;
                                $.pjax.reload({url: grid.eq(0).data('gridurl'), container: container[0], push:false, replace: true});
                                displayMessage(data);
                            });
                            return false;
                        },function(){return false});
                });
                
JS;
        $view = $this->grid->getView();
        $view->registerJs($gridViewDeleteScript);
    }

}
