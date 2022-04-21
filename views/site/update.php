<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = 'Пользователь ' . $model->last_name . ' ' . $model->first_name;
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
                            ],
                        ]);
                        ?>

                        <?= $form->field($model, 'last_name')->textInput() ?>

                        <?= $form->field($model, 'first_name')->textInput() ?>

                        <div class="form-group">
                            <div class="col-lg-offset-1 col-lg-11">
                                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                                <?= Html::Button('Удалить', ['class' => 'btn btn-danger', 'data-toggle' => "modal", 'data-target' => "#exampleModalCenter"]) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Профиль</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= 'Пользователь ' . $model->last_name . ' ' . $model->first_name; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" user=<?= $model->id ?> id='delete' class="btn btn-primary">Удалить профиль</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        var urlDelete = "<?php echo Url::to(['site/delete']); ?>";
    </script>

<?php
$js = Yii::getAlias('@web') . '/script.js';
$this->registerJsFile($js, ['depends' => [\yii\web\JqueryAsset::className()]]);
?>