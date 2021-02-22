<?php

/* @var $this yii\web\View */
/* @var $user app\models\User */

$confirmChangeLink = Yii::$app->urlManager->createAbsoluteUrl(['user/confirm-email-update', 'token' => $user->email_change_token]);
?>
    Здарвствуйте, <?= $user->username ?>,

    Перейдите по ссылке для подтверждения изменения почты:

<?= $confirmChangeLink ?>