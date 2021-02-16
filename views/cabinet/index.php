<?php

use yii\helpers\Url;
use yii\helpers\Html;


/* @var $usersUrls app\models\Url */

$this->title = "Кабинет";
$this->params['breadcrumbs'][] = $this->title;


Yii::$app->formatter->locale = 'ru-RU';
?>


<ul class="list-group" style="width: 200px">
    <li class="list-group-item"><?= Html::a('Изменить логин', Url::to(['user/update-username']))?></li>
    <li class="list-group-item"><?= Html::a('Изменить пароль', Url::to(['user/update-password']))?></li>
    <li class="list-group-item"><?= Html::a('Изменить email', Url::to(['user/update-email']))?></li>
</ul>

<?php if ($usersUrls):?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Оригинальная ссылка</th>
            <th scope="col">Короткая ссылка</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Дата истечения срока действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($usersUrls as $key => $url):?>
            <tr>
                <th scope="row"><?=$key + 1?></th>
                <td><?= Html::a(Html::encode($url->long_url), Html::encode($url->long_url), ['target' => '_blank']) ?></td>
                <td><?= Html::a(Yii::$app->request->serverName . "/" . $url->token, Url::to(['site/redirect', 'token' => $url->token]), ['target' => '_blank']) ?></td>
                <td><?= Yii::$app->formatter->asDatetime($url->created_at, 'short')?></td>
                <td><?= Yii::$app->formatter->asDatetime($url->expiry_at, 'short')?></td>
                <td><a href="<?= Url::to(['cabinet/url-analytics', 'token' => $url->token])?>">Аналитика</a></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?php else:?>
    <h3>Вы пока не добивили ни одной ссылки</h3>
<?php endif;?>


