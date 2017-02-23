<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CHospital */

$this->title = 'Create Chospital';
$this->params['breadcrumbs'][] = ['label' => 'Chospitals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chospital-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
