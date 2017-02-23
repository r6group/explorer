<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Profile $model
 */

$this->title = 'Update Profile: ' . ' ' . $model->name. ' '.$model->surname;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name. ' '.$model->surname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<hr class="darken">
        <h4><?= Html::encode($this->title) ?></h4>


        <?= $this->render('_form', [
            'model' => $model,
            'district'=> $district,
            'subdistrict' =>$subdistrict
        ]) ?>


