<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReportScope */

$this->title = 'Update Report Scope: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Report Scopes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="report-scope-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
