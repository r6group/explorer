<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FavItem */

$this->title = 'Create Fav Item';
$this->params['breadcrumbs'][] = ['label' => 'Fav Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fav-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
