<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model phi\models\ChospitalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chospital-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'hoscode') ?>

    <?= $form->field($model, 'hosname') ?>

    <?= $form->field($model, 'hosname_long') ?>

    <?= $form->field($model, 'hostype') ?>

    <?= $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'road') ?>

    <?php // echo $form->field($model, 'mu') ?>

    <?php // echo $form->field($model, 'subdistcode') ?>

    <?php // echo $form->field($model, 'distcode') ?>

    <?php // echo $form->field($model, 'provcode') ?>

    <?php // echo $form->field($model, 'postcode') ?>

    <?php // echo $form->field($model, 'hoscodenew') ?>

    <?php // echo $form->field($model, 'bed') ?>

    <?php // echo $form->field($model, 'level_service') ?>

    <?php // echo $form->field($model, 'bedhos') ?>

    <?php // echo $form->field($model, 'h_latitude') ?>

    <?php // echo $form->field($model, 'h_longitude') ?>

    <?php // echo $form->field($model, 'h_polygon_boundary') ?>

    <?php // echo $form->field($model, 'h_geometry') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
