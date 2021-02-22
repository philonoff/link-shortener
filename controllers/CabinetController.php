<?php

namespace app\controllers;

use app\models\Url;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class CabinetController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function() {
                    $this->goHome();
                },
                'only' => ['index', 'url-analytics'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'url-analytics'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays user's cabinet
     * @return string
     */
    public function actionIndex()
    {
//        $usersUrls = Url::findAll(['user_id' => Yii::$app->user->getId()]);
        $usersUrls = Url::find()->where(['user_id' => Yii::$app->user->getId()])->orderBy('created_at DESC')->all();

        return $this->render('index', ['usersUrls' => $usersUrls]);
    }

    public function actionUrlAnalytics($token)
    {
        $url = Url::findOne(['token' => $token]);

        if ($url) {
            $countryAnalytics = $url->countryAnalytics;
            echo "<pre>";
            var_dump($countryAnalytics);
            die();
        } else {
            throw new NotFoundHttpException('Page not found.');
        }

        return $this->render('url-analytics');
    }
}