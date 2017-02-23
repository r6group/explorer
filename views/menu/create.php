<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Menu */

$this->title = 'สร้างรายงาน';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'user_db' => $user_db,
        'searchModel' => $searchModel,
        'district' => $district,
        'subdistrict' => $subdistrict,
        'tables'=> $tables,
        'columns'=> $columns,
    ]) ?>

</div>
