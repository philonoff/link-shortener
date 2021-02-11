<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\forms\SignupForm;
use app\models\forms\SigninForm;
use yii\filters\AccessControl;

class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function() {
                    $this->goHome();
                },
                'only' => ['signup', 'signin', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['signup', 'signin'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays sign up page
     *
     * @return string
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isPost) {
            $formData = Yii::$app->request->post();

            if ($model->load($formData) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Вы успешно зарегистрированы. Войдите в аккаунт использую логин и пароль.');
                return $this->redirect('/user/signin');
            }
        }
        return $this->render('signup', ['model' => $model]);
    }

    /**
     * Displays sign in page
     *
     * @return string
     */
    public function actionSignin()
    {
        $model = new SigninForm();

        if (Yii::$app->request->isPost) {
            $formData = Yii::$app->request->post();

            if ($model->load($formData) && $model->signin()) {
                return $this->redirect('/user/cabinet');
            }

        }
        return $this->render('signin', ['model' => $model]);
    }

    /**
     *
     * Logout user
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}