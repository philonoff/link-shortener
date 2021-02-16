<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model app\models\forms\UpdateUsernameForm */

$this->title = "Изменить логин";
$this->params['breadcrumbs'][] = [
    'label' => 'Кабинет',
    'url' => Url::to(['cabinet/index']),
];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-signup col-lg-5">
    <h1><?=Html::encode($this->title)?></h1>
    <?php
    $form = ActiveForm::begin([
        'id' => 'update-nickname-form',
    ]);

    $usernameHint = <<<EOD
    Количество символов: от 4 до 20 <br>
    Доступные символы: a-z A-Z 0-9 ._- <br>
    EOD;
    ?>
    <i class="bi bi-clipboard"></i>
    <?= $form->field($model, 'username')->label('Логин')->hint($usernameHint)?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить',['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end();?>
