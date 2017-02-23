<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>


<div>

    <div class="notfoundpanel">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="row" style="text-align: center">
        <div class="col-md-12" style="text-align: left">
            <h4><?= nl2br(Html::encode($message)) ?></h4>
        </div>
        </div>


    </div><!-- notfoundpanel -->

</div>