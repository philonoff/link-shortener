<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model app\models\forms\UpdatePasswordForm */

$this->title = "Изменить пароль";
$this->params['breadcrumbs'][] = [
    'label' => 'Кабинет',
    'url' => Url::to(['user/cabinet']),
];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-signup col-lg-5">
    <h1><?=Html::encode($this->title)?></h1>
    <?php
    $form = ActiveForm::begin([
        'id' => 'update-password-form',
        'enableAjaxValidation' => true,
    ]);

    $passwordHint = <<<EOD
    Количество символов: от 8 до 32 <br>
    Доступные символы: a-z A-Z 0-9 *.!@$%^&(){}[]:;<>,.?/~_+-=|\ <br>
    Как минимум по одному символу в нижнем и верхнем регистре, цифре, спецсимволу.
    EOD;
    ?>
    <i class="bi bi-clipboard"></i>
    <?= $form->field($model, 'old_password')->passwordInput()->label('Старый пароль')?>
    <?= $form->field($model, 'new_password')->passwordInput()->label('Новый пароль')->hint($passwordHint)?>
    <?= $form->field($model, 'password_repeat')->passwordInput()->label('Повторите пароль')?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить',['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end();?>
