<?php

/*
 * This file is part of the Porcelanosa project.
 *
 * (c) Porcelanosa project <http://github.com/porcelanosa>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace frontend\widgets\signup;

use yii\base\Module as BaseModule;
use yii\filters\AccessControl;


/**
 * @author Porcelanosa
 */
class Module extends BaseModule {

    /**
     * @var string
     */
    public $defaultRoute = 'default/index';

    /**
     * @var array
     */
    public $admins = [];

    /**
     * @var string The Administrator permission name.
     */
    public $adminPermission;

    /**
     * @var string path to models for binding options
     */
    public $uploadPath = '';

    

    
}
