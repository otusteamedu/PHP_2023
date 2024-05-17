<?php

/** @var yii\web\View $this */

/** @var BankStatementForm $model */

use app\models\BankStatementForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Банковская выписка';
?>
<div class="site-index">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-4">
            <?= $form->field($model, 'start_time')->textInput(['type' => 'date']) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'end_time')->textInput(['type' => 'date']) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
