<?php

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/reset-password', 'token' => $user->password_reset_token]);
?>
    Здарвствуйте, <?= $user->username ?>,

    Перейдите по ссылке для восстановления пароля:

<?= $resetLink ?>