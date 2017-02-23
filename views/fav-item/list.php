<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use common\models\Profile;


/* @var $this yii\web\View */
/* @var $searchModel app\models\FavItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="fav-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'cat_id',
            [
                //'label' => 'คัดกรองแล้ว',
                'attribute' => 'report_title',
                'format' => 'raw',
                'value' => function ($row) {
                    return '<a href="http://203.157.145.19' . $row['report_url'] . '">' . $row['report_title'] . '</a>';
                    //return '<a href="'.Yii::$app->urlManager->createUrl(['qry/province', 'provid'=>$d['provid']]).'">'.$d['provname'].'</a>';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>

