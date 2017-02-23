<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sign-overlay"></div>
<div class="signpanel"></div>

<div class="panel signin">
    <div class="panel-heading" style="text-align: center">
        <a href="<?= Yii::$app->homeUrl; ?>"><?=Html::img('@web/images/logo-hex.png', ['alt'=>Yii::$app->name, 'style'=>'max-width:100%'])?> </a>
        <h4 class="panel-title">ยินดีต้อนรับ! กรุณาลงชื่อเข้าใช้.</h4>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'action' => Url::toRoute('/site/login')]); ?>


        <div class="form-group mb10">
            <?= $form->field($model, 'username', ['template' => "<div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-user\"></i></span>\n{input}</div>\n{hint}\n{error}"])->textInput(array('placeholder' => 'เลขประจำตัวประชาชน')); ?>
        </div>




        <div class="form-group nomargin">

            <?= $form->field($model, 'password', ['template' => "<div class=\"input-group\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-lock\"></i></span>\n{input}</div>\n{hint}\n{error}"])->passwordInput(array('placeholder' => 'Password')); ?>
        </div>


        <?= $form->field($model, 'rememberMe')->checkbox(['class' => '']) ?>


        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-quirk btn-block', 'name' => 'login-button']) ?>
        </div>
        <div style="color:#999;margin:1em 0">
            หากคุณลืม password
            <?= Html::a('ขอตั้ง Password ใหม่ที่นี่', ['/site/request-password-reset']) ?>.
        </div>
        <?php ActiveForm::end(); ?>
        <hr class="invisible">
        <div class="form-group">
            <a href="<?= Url::toRoute('site/signup'); ?>" class="btn btn-default btn-quirk btn-stroke btn-stroke-thin btn-block btn-sign">ยังไม่ได้เป็นสมาชิก? ลงละเบียนที่นี่!</a>

        </div>
    </div>
</div><!-- panel -->


