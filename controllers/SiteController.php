<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\forms\MinifierUrlForm;
use app\models\Url;
use yii\web\NotFoundHttpException;
use app\models\CountryAnalytics;

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
        $model = new MinifierUrlForm();

        if (Yii::$app->request->isPost) {
            $formData = Yii::$app->request->post();

            if ($model->load($formData) && $model->validate() && $url = $model->save()) {
                $model = new MinifierUrlForm();
                return $this->render('index', ['model' => $model, 'url' => $url]);
            }
        }

        return $this->render('index', ['model' => $model]);
    }

    /**
     * Redirects from short url to actual long url
     * @param $token
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRedirect($token)
    {
        $url = Url::findOne(['token' => $token]);

        if ($url) {
            if (!$url->checkIfExpired()) {
                // TODO: add data validation
                $clientIP = Yii::$app->ip->getClientIpAddress();
                // TODO: add data validation
                $countryInfo = Yii::$app->ip->getCountryByIp($clientIP);

                $countryAnalytics = CountryAnalytics::findOne(['url_token'=> $token, 'country' => $countryInfo->country]);

                if ($countryAnalytics) {
                    $countryAnalytics->updateClicks();
                    $countryAnalytics->update();
                } else {
                    $countryAnalytics = new CountryAnalytics();
                    $countryAnalytics->fillIn($token, $countryInfo->country);
                    $countryAnalytics->save();
                }

                Yii::$app->response->redirect($url->long_url, 302);

            } else {
                Yii::$app->session->setFlash('error', 'Срок действия короткой ссылки истек');
                return $this->goHome();
            }
        } else {
            throw new NotFoundHttpException('Page not found.');
        }
    }

}
