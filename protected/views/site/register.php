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

    .nav-tabs .nav-link.active {
        background-color: #c5e36a !important;
        color: #293ac1 !important;
        font-weight: bolder !important;
    }

    .nav-tabs .nav-item .nav-link {
        color: #293ac1 !important
    }
</style>

<div id="app">
    <section class="section">
        <div class="container mt-2">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="login-brand">
                        <img src="<?= Yii::$app->request->baseUrl ?>/themes/assets/img/logo/logo.png" alt="logo" width="90" class="">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Register</h4>
                        </div>

                        <div class="card-body">

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="akun-tab" data-toggle="tab" href="#akun" role="tab" aria-controls="akun" aria-selected="true">Data Akun</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Data Profile</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="akun" role="tabpanel" aria-labelledby="akun-tab">
                                    <?php $form = ActiveForm::begin(['id' => 'registerakun', 'options' => [
                                        'class' => 'needs-validation',
                                        'novalidate' => true,
                                        'enctype' => 'multipart/form-data',
                                    ],]) ?>
                                    <div class="mx-2" id="formakun">
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
                                        <div class="row justify-content-end">
                                            <button type="button" class="btn btn-primary btn-sm" id="nextToDataProfile" onclick="nextDtProfile()">Next <i class="fa fa-arrow-circle-right"></i></button>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <?= $form->field($model, 'nik')->textInput(['placeholder' => 'NIK:3287XXXXXX', 'autocomplete' => 'off']) ?>
                                        </div>
                                        <div class="form-group col-6">
                                            <?= $form->field($model, 'no_hp')->textInput(['placeholder' => 'Masukan Nomor Handphone yang aktif', 'autocomplete' => 'off', 'type' => 'number']) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <?= $form->field($model, 'rt')->dropdownList($rt, ['prompt' => ' -- Pilih RT -- ']) ?>
                                        </div>
                                        <div class="form-group col-6">
                                            <?= $form->field($model, 'rw')->dropdownList($rw, ['prompt' => ' -- Pilih RW -- ']) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <?= $form->field($model, 'alamat')->textarea(['placeholder' => 'Masukan alamt anda', 'rows' => '10']) ?>
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
                                </div>
                            </div>    
                            
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
        $("#modalSipoyan").modal('show')
        $.ajax({
            url: "<?php echo Url::to(['site/termandcond']); ?>",
            type: "POST",
            dataType: "html",
            data: '',
            beforeSend: function() {},
            success: function(data) {
                $("#modalSipoyan").find(".modal-dialog").addClass('modal-xl');
                $("#modalSipoyan").find("h5.modal-title").html('Layanan dan Privasi Aplikasi SIPOYAN dan SIWASUKMA')
                $("#modalSipoyan").find(".modal-body").html(data);
                $("#modalSipoyan").find(".modal-body").html(data);
                $("#modalSipoyan").find(".modal-footer #agreeOk").hide();
                $("#modalSipoyan").find(".modal-footer #dismissClose").removeClass('btn-secondary').addClass('btn-primary').html('Saya menyetujui');
            },
        });
    });

    function nextDtProfile()
    {
        $("#profile").addClass('show active');
        $("#akun").removeClass('show active');
        $("#akun-tab").removeClass('active');
        $("#profile-tab").addClass('active');
    }
</script>