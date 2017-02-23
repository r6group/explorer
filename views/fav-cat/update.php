<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FavCat */

$this->title = 'Update Fav Cat: ' . ' ' . $model->cat_id;
$this->params['breadcrumbs'][] = ['label' => 'Fav Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cat_id, 'url' => ['view', 'id' => $model->cat_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fav-cat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
