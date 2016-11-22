<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\models\Module;
use common\models\ModuleAccessControl;
use common\models\ModuleAction;
use yii\db\Connection;
use yii\caching\DbDependency;

/**
 * RbacComponent provides simple access control based on a set of rules.
 *
 * RbacComponent is an action filter. It will check its [[rules]] to find
 * the first rule that matches the current context variables (such as user action, user role).
 * The matching rule will dictate whether to allow or deny the access to the requested controller
 * action. If no rule matches, the access will be denied.
 *
 * 
 */
class RbacComponent extends Component {

    private $controllerAction = [];

    public function accessAction($controller = '') {
        $controller = ucfirst($controller) . 'Controller';
        $action = [];
        $db = Yii::$app->db;
        $dep = new DbDependency();
        $dep->reusable=true;
        $dep->sql = 'SELECT count(0) FROM module_access_control order by module_access_control_id asc';
        return $db->cache(function ($db) use ($controller) {
            $query = Module::find()->joinWith(['moduleAccesscontrol'])
                            ->where('module.controller_name=:controller_name', [':controller_name' => $controller])
                            ->asArray()->all();
            if (!empty($query[0]['moduleAccesscontrol'])) {
                foreach ($query[0]['moduleAccesscontrol'] as $value) {
                    $action[] = $value['action_name'];
                }
                $this->controllerAction = $action;
                return $action;
            } else {
                return $action;
            }
        }, 60,$dep);
    }

    public function canAccess($action = '') {
        $actionArr = explode('/', $action);
        if (count($actionArr) > 2)
            return false;
        if (count($actionArr) === 2) {
            $controller = ucfirst($actionArr[0]) . 'Controller';
            $query = Module::find()->joinWith(['moduleAccesscontrol'])
                            ->where('module.controller_name=:controller_name', [':controller_name' => $controller])
                            ->andWhere('module_action_item.action_name = :action_name', [':action_name' => $actionArr[1]])->count();
            if ($query > 0) {
                return true;
            }else{
                return false;
            }
        } else {
            if (!empty($this->controllerAction)) {
                return in_array(strtolower($action), $this->controllerAction);
            } else {
                return false;
            }
        }
    }

}
