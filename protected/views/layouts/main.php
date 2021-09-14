<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="<?php echo Yii::$app->request->baseUrl ?>/themes/js/jquery-3.6.0.js "></script>
</head>

<body>
    <?php $this->beginBody() ?>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <?php echo $this->render('@app/views/layouts/topbar'); ?>
            <?php echo $this->render('@app/views/layouts/sidebar'); ?>

            <!-- KONTENT PAGES -->
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <?= $content ?>
                </section>
            </div>
            <!-- END OF MAIN CONTENT -->

            <?php echo $this->render('@app/views/layouts/footer'); ?>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>