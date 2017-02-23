<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace phi\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/wfmi-style.css',
//        'themes/quirk/lib/Hover/hover.css',
//        'themes/quirk/lib/fontawesome/css/font-awesome.css',
//        'themes/quirk/lib/ionicons/css/ionicons.css',
//        'themes/quirk/lib/jquery-toggles/toggles-full.css',
//        'themes/quirk/css/quirk.css',
//        //'themes/quirk/css/animsition.css', //Display page transition effects apply on only some page
    ];
    public $js = [
//        'themes/quirk/lib/jquery-toggles/toggles.js',
//        'themes/quirk/lib/raphael/raphael.js',
//        'themes/quirk/lib/jquery-knob/jquery.knob.js',
//        'themes/quirk/js/quirk.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
       // 'phi\assets\AngularAsset',
    ];
}
