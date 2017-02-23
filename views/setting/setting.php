<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Setting';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

<fieldset>
    <h3><i class="fa fa-square"></i> บทบาทและสิทธิ์การใช้ระบบ</h3>
    <ul class="fa-ul">

    <?php

    for ($i = 0; $i < sizeof($data); $i++) {

        ?>
        <li><i class="fa-li fa fa-check-square"></i><?=$data[$i]['description']?></li>

        <?php
    }
    ?>
    </ul>
</fieldset>
