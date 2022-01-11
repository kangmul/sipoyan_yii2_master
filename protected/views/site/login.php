<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'Login';

?>
<div id="app">
    <section class="section">
        <div class="d-flex flex-wrap align-items-stretch">
            <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                <div class="p-4 m-3">
                    <img src="<?= Yii::$app->request->baseUrl ?>/themes/assets/img/logo/logo.png" alt="logo" width="80" class="shadow-light mb-5 mt-3">
                    <h4 class="text-dark font-weight-normal">Welcome</h4>
                    <p class="text-muted">Before you get started, you must login or register if you don't already have an account.</p>
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'class' => 'needs-validation',
                        'layout' => 'horizontal',
                        'action' => 'proseslogin',
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                            'labelOptions' => ['class' => 'col-lg-4 col-md-4 col-form-label'],
                        ],
                    ]); ?>
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Email or Username') ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <!-- <a href="auth-forgot-password.html" class="float-left mt-3">
                        Forgot Password?
                        </a> -->
                        <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4" id="btn-submit-login">
                        Login
                        </button>
                    </div>

                <?php ActiveForm::end(); ?>

                <div class="mt-5 text-center">Don't have an account? <a href="auth-register.html">Create new one</a></div>

                <div class="text-center mt-5 text-small">
                    Copyright &copy; SIWASUKMA Made with 💙 by Stisla
                    <div class="mt-2">
                        <a href="#">Privacy Policy</a>
                        <div class="bullet"></div>
                        <a href="#">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="<?= Yii::$app->request->baseUrl ?>/themes/assets/img/background/laptop-wallpaper-1600x900.jpg">
                <div class="absolute-bottom-left index-2">
                    <div class="text-light p-5 pb-2">
                        <div class="mb-5 pb-3">
                            <h1 class="mb-2 display-4 font-weight-bold">Good Morning</h1>
                            <h5 class="font-weight-normal text-muted-transparent">Bandung, Jawa Barat Indonesia</h5>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>

<script>
    $('#login-form').on('submit', function (e){
        e.preventDefault();
        let formId = new FormData($('#' + $(this).attr('id'))[0]);
        let url = $(this).attr('action')
        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: formId,
            beforeSend: function () {
                
            },
            success: function(result){
                console.log(result);
            },

        });
    })
</script>