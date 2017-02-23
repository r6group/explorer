<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CHospital */

$this->title = $model->hosname;
$this->params['breadcrumbs'][] = ['label' => 'Chospitals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chospital-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->hoscode], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->hoscode], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'hoscode',
            'hosname',
            'hosname_long',
            'hostype',
            'address',
            'road',
            'mu',
            'subdistcode',
            'distcode',
            'provcode',
            'postcode',
            'hoscodenew',
            'bed',
            'level_service',
            'bedhos',
            'h_latitude',
            'h_longitude',
            'h_polygon_boundary:ntext',
            'h_geometry',
        ],
    ]) ?>

</div>
