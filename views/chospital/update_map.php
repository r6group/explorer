<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CHospital */

$this->title = 'Update map: ' . ' ' . $model->hosname;
$this->params['breadcrumbs'][] = ['label' => 'Chospitals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->hosname, 'url' => ['view', 'id' => $model->hoscode]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chospital-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_map', [
        'model' => $model,
    ]) ?>

</div>
