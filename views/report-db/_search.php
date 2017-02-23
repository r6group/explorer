<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\ReportDbSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="report-db-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'dsp_name') ?>

    <?= $form->field($model, 'db_name') ?>

    <?= $form->field($model, 'server') ?>

    <?= $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'pass') ?>

    <?php // echo $form->field($model, 'port') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
