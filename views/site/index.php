<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Регистрация';
?>
<div class="row text-center justify-content-center">
    <div class="col-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3><?= Html::encode($this->title) ?></h3></div>
            <div class="panel-body">
                <div class="site-login">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'registration-form',
                        'layout' => 'horizontal',
                        'fieldConfig' => [
//                        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
//                        'labelOptions' => ['class' => 'col-lg-1 control-label'],
                        ],
                    ]);
                    ?>

                    <?= $form->field($model, 'email')->textInput(['email']) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'password2')->passwordInput() ?>

                    <?= $form->field($model, 'last_name')->textInput() ?>

                    <?= $form->field($model, 'first_name')->textInput() ?>

                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11">
                            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>