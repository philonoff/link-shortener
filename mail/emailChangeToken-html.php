<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$confirmChangeLink = Yii::$app->urlManager->createAbsoluteUrl(['user/confirm-email-update', 'token' => $user->email_change_token]);
?>
<div class="password-reset">
    <p>Здравствуйте, <?= Html::encode($user->username) ?>,</p>

    <p>Перейдите по ссылке для подтверждения изменения почты:</p>

    <p><?= Html::a(Html::encode($confirmChangeLink), $confirmChangeLink) ?></p>
</div>