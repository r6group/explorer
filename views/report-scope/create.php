<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ReportScope */

$this->title = 'Create Report Scope';
$this->params['breadcrumbs'][] = ['label' => 'Report Scopes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-scope-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
