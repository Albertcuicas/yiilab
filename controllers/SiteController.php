<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ValidarFormulario;
use app\models\ValidarFormularioAjax;
use yii\widgets\ActiveForm;
use yii\web\response;
use app\models\FormAlumnos;
use app\models\Alumnos;

class SiteController extends Controller
{

    public function actionCreate(){
        $model = new FormAlumnos;
        $msg = null;
        if($model->load(Yii::$app->request->post())){
            if ($model->validate()) {
                $table = new Alumnos;
                $table->nombre = $model->nombre;
                $table->apellidos = $model->apellidos;
                $table->clase = $model->clase;
                $table->nota_final = $model->nota_final;
                
                if ($table->insert()) {
                    $msg = "registro exitoso";
                    $model->nombre = null;    
                    $model->apellidos = null;    
                    $model->clase = null;    
                    $model->nota_final = null;                    

                }
                else{
                    $msg = "no se pudo completar el registro";
                }
            }
            else{
                $model->getErrors();
            }
        }
        return $this->render("create", ['model' => $model, 'msg' => $msg]);
    }


    public function actionSaluda($get = "Tutorial Yii"){
        $mensaje = "Hola Mundo";
        $numeros = [0,1,2,3,4,5];
        return $this->render("SALUDA",
        [
            "mensaje" => $mensaje,
            "array" =>  $numeros,
            "get" => $get,
            ]);
    
    }

    public function actionFormulario($mensaje = null){
        return $this->render("formulario",["mensaje" => $mensaje]);
    }

    public function actionRequest(){
        $mensaje = null;
        if (isset($_REQUEST["nombre"])) {
            $mensaje = "enviado sin problemas ".$_REQUEST["nombre"];
        }
        $this->redirect(["site/formulario","mensaje" => $mensaje]);
    }

    public function actionValidarformulario(){
        $model = new ValidarFormulario;
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                //xEj consul
            }
            else{
                $model->getErrors();
            }
        }
        return $this->render("validarformulario", ["model" => $model]);
    }

    public function actionValidarformularioajax(){

        $model =  new ValidarFormularioAjax;
        $msg = null;

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            // Consulta a base de Datos
            $msg = "Form eviado con exito";
            $model->nombre = null;
            $model->email = null;
        }
        else{
            $model->getErrors();
        }

        return $this->render("validarformularioajax", ['model' => $model, 'msg' => '']);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionHola($target = 'Mundo'){
        return $this->render('hola',['target' => $target]);
    }
}
