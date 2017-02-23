<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\ReportDb $model
 */

$this->title = 'Create Report Db';
$this->params['breadcrumbs'][] = ['label' => 'Report Dbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-db-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
