<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model app\models\forms\SigninForm */

$this->title = "Вход";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup col-lg-5">
    <h1><?=Html::encode($this->title)?></h1>
    <?php
    $form = ActiveForm::begin([
        'id' => 'register-form',
    ]);
    ?>
    <?= $form->field($model, 'username')->label('Логин')?>
    <?= $form->field($model, 'password')->passwordInput()->label('Пароль')?>
    <div class="form-group">
        <?= Html::submitButton('Войти',['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end();?>