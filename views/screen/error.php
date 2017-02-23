<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

//$this->title = $name;
?>


<div>

    <div class="notfoundpanel">
        <h1><?= Html::encode($this->title) ?></h1>
        <h3>Sorry</h3>
        <h4>The above error occurred while the Web server was processing your request.<br>Please contact us if you think this is a server error. Maybe you could try a search:</h4>
        <form action="index.html">
            <div class="input-group mb15">
                <input type="text" class="form-control" placeholder="Search here">
        <span class="input-group-btn">
          <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-search"></i></button>
        </span>
            </div>
        </form>

    </div><!-- notfoundpanel -->

</div>