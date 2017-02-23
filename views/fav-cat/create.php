<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FavCat */

$this->title = 'Create Fav Cat';
$this->params['breadcrumbs'][] = ['label' => 'Fav Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fav-cat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
