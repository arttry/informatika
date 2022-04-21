<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistrationForm;
use app\models\User;
use \yii\helpers\Url;

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
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            $permittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $url = substr(str_shuffle($permittedChars), 0, 20);
            $model->auth_token = $url;
            $pass = $model->password;
            $model->password = md5($pass);
            $model->password2 = md5($pass);
            if($model->save()){
                $model->password = $pass;
                $model->password2 = $pass;
                $active = Url::to(['site/activate', 'url' => $url, 'email' => $model->email]);
                Yii::$app->session->setFlash('success', 'Вы успешно зарегестрированы на сайте, ссылка для активации: ' . '<a href="'.$active.'">перейти</a>');
            }
            else{
                $model->password = $pass;
                $model->password2 = $pass;
            }
        }
        return $this->render('index', ['model' => $model, 'url' => $url]);
    }


    public function actionActivate(){
        $url = Yii::$app->request->get('url');
        $email = Yii::$app->request->get('email');
        $model = User::find()->where(['email' => $email, 'auth_token' => $url])->one();
        if($model !== null){
            $model->activity = 1;
            $model->save();
//            return $this->render('index', ['model' => $model]);
            return $this->redirect(['site/update', 'id' => $model->id]);
        }
        else{
            Yii::$app->session->setFlash('error', 'Неверные данные');
            return $this->redirect(['site/index']);
        }
    }


    public function actionUpdate($id){
        $model = User::find()->where(['id' => $id])->one();
        if ($model->load(Yii::$app->request->post())){
            $model->save();
            Yii::$app->session->setFlash('success', 'Данные успешно сохранены');
        }
        return $this->render('update', ['model' => $model]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->render('index1');
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(Yii::$app->user->identity->activity == 1){
//                $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
                return $this->redirect(['site/update', 'id' => Yii::$app->user->identity->id]);
            }
        }
        return $this->render('login', [
            'model' => $model,
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

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /*
     * удаление пользователя
     */
    public function actionDelete(){
        if (Yii::$app->request->post('id')) {
            $user = User::find()->where(['id' => Yii::$app->request->post('id')])->one();
            $user->delete();
            return $this->redirect(['site/index']);
        }
    }

}
