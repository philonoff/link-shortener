<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model app\models\forms\SignupForm */

$this->title = "Регистрация";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup col-lg-5">
    <h1><?=Html::encode($this->title)?></h1>
    <?php
    $form = ActiveForm::begin([
        'id' => 'register-form',
    ]);

    $usernameHint = <<<EOD
    Количество символов: от 4 до 20 <br>
    Доступные символы: a-z A-Z 0-9 ._- <br>
    EOD;

    $passwordHint = <<<EOD
    Количество символов: от 8 до 32 <br>
    Доступные символы: a-z A-Z 0-9 *.!@$%^&(){}[]:;<>,.?/~_+-=|\ <br>
    Как минимум по одному символу в нижнем и верхнем регистре, цифре, спецсимволу.
    EOD;
    ?>
    <i class="bi bi-clipboard"></i>
    <?= $form->field($model, 'username')->label('Логин')->hint($usernameHint)?>
    <?= $form->field($model, 'email')->input('email')?>
    <?= $form->field($model, 'password')->passwordInput()->label('Пароль')->hint($passwordHint)?>
    <?= $form->field($model, 'password_repeat')->passwordInput()->label('Повторите пароль')?>
    <div class="form-group">
        <?= Html::submitButton('Регистрация',['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end();?>
