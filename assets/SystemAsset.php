<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SystemAsset extends AssetBundle
{
    public $jsOptions = ['async'=>'async'];
    public $js = [
		'//apps.bdimg.com/libs/amd.loader/0.9.0/amd.loader.js',
    ];
    public $depends = [
        'app\assets\AppAsset'
    ];
}
