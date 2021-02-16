<?php

namespace app\controllers;

use app\models\Url;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\Pagination;

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
        $usersUrls = Url::findAll(['user_id' => Yii::$app->user->getId()]);

        return $this->render('index', ['usersUrls' => $usersUrls]);
    }

    public function actionUrlAnalytics($token)
    {
        return $this->render('url-analytics');
    }
}