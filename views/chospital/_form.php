<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CHospital */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chospital-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hoscode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hosname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hostype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'road')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subdistcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'distcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'provcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hoscodenew')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bed')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level_service')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bedhos')->textInput(['maxlength' => true]) ?>




    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
