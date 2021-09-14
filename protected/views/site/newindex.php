<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>

<div class="section-header">
    <h1>Blank pages</h1>
</div>

<div class="section-body">
</div>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="<?php echo Url::toRoute(['site/logout']) ?>">Log Out</a></p>
    </div>
</div>