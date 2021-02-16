<?php

namespace app\controllers;


use app\models\Url;
use app\models\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\Controller;
use app\models\forms\SignupForm;
use app\models\forms\SigninForm;
use app\models\forms\RequestPasswordResetForm;
use app\models\forms\ResetPasswordForm;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\forms\UpdateUsernameForm;
use app\models\forms\UpdatePasswordForm;
use yii\widgets\ActiveForm;
use yii\web\Response;

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
                'only' => ['signup', 'signin', 'logout', 'request-password-reset', 'reset-password', 'cabinet',
                    'update-username', 'update-password'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['signup', 'signin', 'request-password-reset', 'reset-password'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'cabinet', 'update-username', 'update-password'],
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
                return $this->redirect('/cabinet');
            }

        }
        return $this->render('signin', ['model' => $model]);
    }

    /**
     * Logout user
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     *Displays request password reset page
     *
     * @return string
     */
    public function actionRequestPasswordReset()
    {
        $model = new RequestPasswordResetForm();

        if (Yii::$app->request->isPost) {
            $formData = Yii::$app->request->post();

            if ($model->load($formData) && $model->validate()) {
                if ($model->sendEmail()) {
                    Yii::$app->session->setFlash('success', 'Ссылка для восстановления пароля отправлена на почту');
                    return $this->goHome();
                } else {
                    Yii::$app->session->setFlash('error', 'В данный момент восстановление пароля невозможно. Попробуйте позже.');
                }
            }
        }
        return $this->render('request-password-reset', ['model' => $model]);
    }

    /**
     *Displays reset password page
     *
     * @return string
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new NotFoundHttpException('Страница не найдена.');
        }

        if (Yii::$app->request->isPost) {
            $formData = Yii::$app->request->post();

            if ($model->load($formData) && $model->validate()) {
                if ($model->resetPassword()) {
                    Yii::$app->session->setFlash('success', 'Пароль успешно изменен');
                    return $this->redirect('/user/signin');
                }
            }
        }

        return $this->render('reset-password', ['model' => $model]);
    }

    /**
     * Displays user's cabinet
     * @return string
     */
    public function actionCabinet()
    {
        $usersUrls = Url::findAll(['user_id' => Yii::$app->user->getId()]);

        return $this->render('cabinet', ['usersUrls' => $usersUrls]);
    }

    /**
     * Displays update nickname form
     * @return string
     */
    public function actionUpdateUsername()
    {
        $model = new UpdateUsernameForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->update()) {
                Yii::$app->session->setFlash('success', 'Логин успешно изменен');
                return $this->redirect('/user/cabinet');
            }
        }

        return $this->render('update-username', ['model' => $model]);
    }

    /**
     * Displays update password form
     * @return array|string|Response
     */
    public function actionUpdatePassword()
    {
        $model = new UpdatePasswordForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->update()) {
                Yii::$app->session->setFlash('success', 'Пароль успешно изменен');
                return $this->redirect('/user/cabinet');
            }
        }

        return $this->render('update-password', ['model' => $model]);
    }
}
