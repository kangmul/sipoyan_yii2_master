<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/css/site.css',


        // template login
        'themes/stisla-master/node_modules/bootstrap-social/bootstrap-social.css',
        'themes/stisla-master/node_modules/@fortawesome/fontawesome-free/css/all.min.css',

        'themes/stisla-master/assets/css/style.css',
        'themes/stisla-master/assets/css/components.css',
    ];
    public $js = [
        'themes/js/popper.min.js',
        'themes/js/bootstrap.min.js',
        'themes/js/jquery.nicescroll.min.js',
        'themes/js/moment.min.js',

        // JS Libraries
        'themes/stisla-master/node_modules/sweetalert/dist/sweetalert.min.js',

        // template JS
        'themes/stisla-master/assets/js/scripts.js',
        'themes/stisla-master/assets/js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
