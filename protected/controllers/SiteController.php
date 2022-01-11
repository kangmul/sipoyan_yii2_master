<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Role;
use app\models\Rt;
use app\models\Tac;
use app\models\Users;
use Exception as GlobalException;
use PHPUnit\Util\Log\JSON;
use yii\db\Exception;
use yii\helpers\Url;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'logout'],
                'rules' => [
                    [
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor' => 0xFFFFFF,
                'fontFile' => dirname(__FILE__) . '/../../themes/stisla-master/assets/fonts/nunito-v9-latin-regular.ttf',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(['site/login']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $verifikasi = [];
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (Yii::$app->request->isGet && isset($_GET['data'])) {
            $dtver = unserialize($this->actionSafedecode($_GET['data']));
            $matchdata = Users::find()->where(['username' => $dtver['username'], 'email' => $dtver['email']])->one();
            if ((strtotime(date('Y-m-d H:i:s')) - strtotime($dtver['datelinkmail'])) > 60 * 60 * 1000 * 24) {
                $verifikasi = ['success' => false, 'message' => 'Account failed to verified', 'status' => 'Link expired'];
            } else {
                $matchdata->validate = true;
                $matchdata->validate_by = $dtver['email'];
                $matchdata->validation_date = date("Y-m-d H:i:s");
                if ($matchdata->save()) {
                    $verifikasi = ['success' => true, 'messgage' => 'Account verified', 'status' => 'Account verified'];
                    $sendmailtoadmin = $this->actionSendmail($matchdata, 'activation');
                    if ($sendmailtoadmin) {
                        $verifikasi = ['success' => true, 'message' => 'Your account is in the process of activation by Administrator', 'status' => 'Process Activation'];
                    } else {
                        $verifikasi = ['success' => false, 'message' => 'Your account is failed to process activation by Administrator', 'status' => 'Failed Activation'];
                    }
                }
            }
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['site/newidx']);
        }

        // if ($model->load(Yii::$app->request->post())) {
        //     $users = new Users();
        //     $aktivateuser = $users->getAktivasi($model->username);
        //     if (!$aktivateuser->is_active) {
        //         $verifikasi = ['success' => false, 'message' => 'Your account is in the process of activation by Administrator', 'status' => 'Process Activation'];
        //     }
        // }
        $model->password = '';
        return $this->render('login', [
            'model' => $model, 'verified' => $verifikasi
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        // return $this->goHome();
        return $this->redirect(['site/login']);
    }

    public function actionNewidx()
    {
        $this->layout = 'main';
        return $this->render('newindex');
    }

    public function actionRegister()
    {
        $rt = Rt::find()->where('is_active = :is_active', [':is_active' => true])->all();
        $model = new Users;
        return $this->render('register', ['rt' => $rt, 'model' => $model]);
    }

    public function actionSubmitregisterakun()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            try {
                $data = $_POST['Users'];
                $model = new Users();
                $role = Role::find()->where('is_active = :isactive and role = :role', [':isactive' => true, ':role' => 'member'])->one();
                $model->attributes = $data;
                if (!$model->validate()) {
                    foreach ($model->getErrors() as $key => $dt) {
                        $response['success'] = false;
                        $response['status'] = "Failed";
                        $response['message'] = $dt[0];
                        $response['code'] = 204;
                    }
                } else if ($data['password'] !== $_POST['password'] || empty($_POST['password'])) {
                    $response['success'] = false;
                    $response['status'] = "Failed";
                    $response['message'] = "Your password do not match";
                    $response['code'] = 204;
                } else {
                    $model->password = Yii::$app->getSecurity()->generatePasswordHash($data['password']);
                    $model->authKey = Yii::$app->params['keyCode'];
                    $model->username = strtolower($data['username']);
                    $model->first_name = strtolower($data['first_name']);
                    $model->last_name = strtolower($data['last_name']);
                    $model->accessToken = Yii::$app->params['keyCode'];
                    $model->is_active = false;
                    $model->created_by = $data['username'];
                    $model->created_date = date('Y-m-d H:i:s');
                    $model->validate = false;
                    $model->role_id = $role->id;
                    $model->agree = true;
                    if ($model->save()) {
                        $mailaktivations = $this->actionSendmail($model, 'registration');
                        if ($mailaktivations) {
                            $response['success'] = true;
                            $response['status'] = "Success";
                            $response['message'] = "Please Verified your email address !.";
                            $response['code'] = 200;
                        }
                    } else {
                        $response['success'] = false;
                        $response['status'] = "Error";
                        $response['message'] = "The server has encountered a situation it doesn't know how to handle.";
                        $response['code'] = 500;
                    }
                }
            } catch (Exception $e) {
                return "Server Error : " . $e;
            }
            echo json_encode($response);
            Yii::$app->end();
        }
    }

    public function actionTermandcond()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $tac = Tac::find('is_active = :isactive', [':isactive' => true])->one();
            return $this->renderPartial('termandcond', ['tac' => $tac]);
        }
    }

    public function actionSendmail($data, $status)
    {
        if ($status == 'registration') {
            $dataverifikasi = ['username' => $data->username, 'email' => $data->email, 'created_date' => $data->created_date, 'datelinkmail' => date('Y-m-d H:i:s'), 'keycode' => $data->authKey];
            $dtadiencode = $this->actionSafeencode(serialize($dataverifikasi));
            $mailto = $data->email;
            $templatebody = '<div class="card" style="margin: 30px auto;max-width: 450px;width: 100%;background-color: #FFF;border-radius: 15px;border: 5px solid #9ba4e4;box-shadow: 15px 15px rgba(155,164,228, 0.09);height: 350px;"><div class="header" style="padding: 20px;"><center>APLIKASI SIPOYAN - SIWA SUKMA</center></div><hr class="pemisah" style="border-top: 10px solid #9ba4e4;width: 380px;position: relative;"><div class="content" style="padding: 10px;"><p>Anda telah mengirim permintaan untuk melakukan verifikasi e-mail Anda pada Aplikasi SIPOYAN - SIWA SUKMA.</p><p>Gunakan tombol dibawah ini untuk memverifikasi email anda.</p></div><div class="areatombol" style="margin-top: 30px ;"><center><a href="' . Yii::$app->urlManager->createAbsoluteUrl(["site/login", "data" => $dtadiencode]) . '" class="btnverif" style="padding: 20px;width: auto;border-radius: 10px;background-color: #FC544B;border-width: inherit;color: #fff; text-decoration: none;">Verifikasi Email</a></center></div></div>';
        } else {
            $mailto = 'sipoyan.siwasukma@gmail.com';
            $validate = $data->validate == '1' ? 'Tervalidasi' : 'Tidak di validasi';
            $aktif = ($data->is_active) ? "Sudah diaktivasi" : "Belum diaktivasi";
            $templatebody = '<div class="card" style="margin: 30px auto;max-width: 450px;width: 100%;background-color: #FFF;border-radius: 15px;border: 5px solid #9ba4e4;box-shadow: 15px 15px rgba(155,164,228, 0.09);height: 600px;"><div class="header" style="padding: 20px;"><center>APLIKASI SIPOYAN - SIWA SUKMA</center></div><hr class="pemisah" style="border-top: 10px solid #9ba4e4;width: 380px;position: relative;"><div class="content" style="padding: 10px;"><p>Mohon untuk di aktivasi user dengan identitas dibawah ini, karena sistem telah mendeteksi bahwa user tersebut sudah melakukan verifikasi email dan akun nya sendiri. </p><p><h4>Identitas User</h4></p><table style="margin: 10px 10px; border: none;"><tr><td>Nama</td><td>:</td><td style="text-transform: uppercase">' . $data->first_name . ' ' . $data->last_name . '</td></tr><tr><td>Username</td><td>:</td><td>' . $data->username . '</td></tr><tr><td>Email</td><td>:</td><td>' . $data->email . '</td><tr><td>Status</td><td>:</td><td style="background-color: green; border-radius: 5px; text-align: center; color: #ffff;">' . $validate . '</td></tr></tr><tr><td>Verified By</td><td>:</td><td>' . $data->validate_by . '</td></tr><tr><td>No Handphone</td><td>:</td><td>' . $data->no_hp . '</td></tr><tr><td>Created Date</td><td>:</td><td>' . $data->created_date . '</td></tr><tr><td>Verified Date</td><td>:</td><td>' . $data->validation_date . '</td></tr><tr><td>Status Aktif</td><td>:</td><td><span style="background-color: #d33; padding: 2px 5px; border-radius: 10px; color: #ffffff;">' . $aktif . '</span></td></tr></table></div></div>';
        }
        $message = Yii::$app->mailerGmail->compose()
            ->setFrom(Yii::$app->params['adminapp'])
            ->setTo($mailto)
            ->setSubject('Verifikasi Akun')
            ->setHtmlBody($templatebody);
        if ($message->send()) {
            return true;
        }
        return false;
    }

    public function actionSafeencode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    public function actionSafedecode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public function actionProseslogin()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->isPost){            
            try {
                $model = new LoginForm();
                var_dump($model->load(Yii::$app->request->post()));
                var_dump($model->login());
                exit;
                
                
                if ($model->load(Yii::$app->request->post()) && $model->login()) {
                    $data = [
                        'status' => 'success',
                        'data' => 'token'
                    ];
                    return $data; 
                    
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}
