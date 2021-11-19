<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Registrasi Akun';
?>

<style>
    .showtermandcond {
        color: #d33;
    }

    .showtermandcond:hover {
        cursor: pointer !important;
        color: #1783e4 !important;
    }
</style>

<div id="app">
    <section class="section">
        <div class="container mt-2">
            <div class="row">
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                    <div class="login-brand">
                        <img src="<?= Yii::$app->request->baseUrl ?>/themes/assets/img/logo/logo.png" alt="logo" width="90" class="">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Register</h4>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin(['id' => 'registerakun', 'options' => [
                                'class' => 'needs-validation',
                                'novalidate' => true,
                                'enctype' => 'multipart/form-data',
                            ],]) ?>
                            <div class="row">
                                <div class="form-group col-6">
                                    <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'First Name', 'autofocus' => true, 'autocomplete' => 'off', 'class' => 'text-capitalize form-control']); ?>
                                </div>
                                <div class="form-group col-6">
                                    <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Last Name', 'autofocus' => true, 'autocomplete' => 'off', 'class' => 'text-capitalize form-control']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <?= $form->field($model, 'username')->textInput(['placeholder' => 'Username', 'autofocus' => true, 'autocomplete' => 'off', 'class' => 'form-control text-lowercase']) ?>
                                </div>
                                <div class="form-group col-6">
                                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'exmple@contoh.com', 'autofocus' => true, 'autocomplete' => 'off']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'off', 'class' => 'pwstrength form-control', 'data-indicator' => 'pwindicator']) ?>
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="email">Password Confirmation</label>
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="off">
                                    <div class="invalid-feedback" id="confirm-password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-divider">
                                Your Home
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <?php $listdata = ArrayHelper::map($rt, 'id', 'rt'); ?>
                                    <?= $form->field($model, 'rt')->dropdownList($listdata, ['prompt' => ' -- Pilih RT -- ']) ?>
                                </div>
                                <div class="form-group col-6">
                                    <?= $form->field($model, 'no_hp')->textInput(['placeholder' => 'Masukan Nomor Handphone yang aktif', 'autocomplete' => 'off', 'type' => 'number']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <?= $form->field($model, 'alamat')->textarea(['placeholder' => 'Masukan alamt anda', 'cols' => '5', 'rows' => '10']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <?= $form->field($model, 'agree')->checkbox([
                                        'label' => '',
                                        'id' => 'agresstermcond',
                                    ])->label('<p class="agreetermandcond">I agree with the <span class="showtermandcond" >terms and conditions</span></p>') ?>
                                </div>
                                <div class="form-group col-6">
                                    <?= Html::submitButton('<i class="fas fa-paper-plane"></i>   Submit', ['class' => 'btn btn-primary  btn-lg btn-block', 'id' => 'submitregakun']); ?>
                                </div>
                            </div>

                            <?php ActiveForm::end(); ?>
                            <div class="text-center" id="loader" style="display: none;">
                                <button class="btn btn-icon icon-left btn-warning btn-lg col-md-3" style="border-radius: 30px !important;"><span style="font-size: 1.5rem !important;"><i class="fa fa-spinner fa-spin"></i></span> Loading ...</button>
                            </div>
                        </div>
                    </div>
                    <div class="simple-footer">
                        Copyright &copy; Muluk Dharmayana 2021, Template by Stisla.
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<script>
    $(document).ready(function() {
        $("#submitregakun").on("click", function(e) {
            e.preventDefault();
            var termandcond = $("#agresstermcond").is(":checked");
            var form = $("#registerakun")[0];
            var formData = new FormData(form);
            if (!termandcond) {
                swal('Failed', 'Make sure you check the terms and conditions', 'error');
                e.preventDefault();
            } else {
                $.ajax({
                    url: "<?php echo Url::to(['site/submitregisterakun']) ?>",
                    dataType: "JSON",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    beforeSend: function() {
                        $("#submitregakun").html("Loading ...").removeClass("btn-primary").addClass("btn-secondary");
                        $("#submitregakun").attr("disabled", true);
                        $("#loader").show();

                    },
                    success: function(data) {
                        swal(data.status, data.message, (data.success) ? "success" : "error");
                        if (data.success) {
                            swal({
                                title: 'Success',
                                text: 'Silakan periksa email anda untuk memverifikasi akun SIPOYAN - SIWA SUKMA',
                                icon: 'success',
                                dangerMode: true,
                                allowOutsideClick: false,
                                confirmButtonText: 'Ok',
                                showCancelButton: false,
                                closeOnClickOutside: false,
                            }).then((result) => {
                                if (result) {
                                    window.location.href = "<?php echo Url::toRoute(['site/login']); ?>"
                                }
                            })
                        } else {
                            $("#submitregakun").removeAttr("disabled").html("<i class='fas fa-paper-plane'></i>    Submit").removeClass("btn-secondary").addClass("btn-primary");
                            $("#loader").hide();
                        }
                    },
                })
            }
        });



    });

    $(".showtermandcond").on("click", function() {
        $.ajax({
            url: "<?php echo Url::to(['site/termandcond']); ?>",
            type: "POST",
            dataType: "html",
            data: '',
            beforeSend: function() {},
            success: function(data) {
                $("#modalload1").modal('show');
                $("#modalload1").find("#modaldata").html(data);
            },
        });
    });
</script>