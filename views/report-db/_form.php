<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var app\models\ReportDb $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="report-db-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'dsp_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Display Name...', 'maxlength' => 60]],

            'server' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter DB Server Address...', 'maxlength' => 20]],

            'user' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter DB Username...', 'maxlength' => 80]],

            'pass' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => 'Enter DB Password...', 'maxlength' => 80]],

            'port' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter DB Port...', 'maxlength' => 8]],

            'db_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter DB Name...', 'maxlength' => 60]],

            'status' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Status...', 'maxlength' => 2]],

        ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
