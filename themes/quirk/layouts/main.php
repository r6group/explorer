<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use kartik\nav\NavX;
use yii\widgets\Breadcrumbs;
use phi\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\models\LoginForm;
use common\models\Profile;
use kartik\dropdown\DropdownX;
use common\models\Menu;
use common\components\MenuHelper;


AppAsset::register($this);
//$this->registerJs("
//
//   $('#noticePanel').on('show.bs.dropdown', function(e) {
//     $('.dropdown-backdrop').remove();
//   });
//
//   $('#usermenuPanel').on('show.bs.dropdown', function(e) {
//     $('.dropdown-backdrop').remove();
//   });
//
//", yii\web\View::POS_END, 'kill-backdrop');


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="th-TH">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?=$this->registerCss('
 .pace {
  -webkit-pointer-events: none;
  pointer-events: none;

  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
}

.pace-inactive {
  display: none;
}

.pace .pace-progress {
  background: #ff9300;
  position: fixed;
  z-index: 2000;
  top: 0;
  right: 100%;
  width: 100%;
  height: 2px;
}
 ');?>
    <!--<link rel="shortcut icon" href="<?= Url::to('@web/themes/quirk/images/favicon.png') ?>" type="image/png">-->
    <?= Yii::$app->view->registerJsFile(Url::to('@web/themes/quirk/lib/modernizr/modernizr.js'), ['position' => yii\web\View::POS_HEAD]); ?>
    <?= Yii::$app->view->registerJsFile(Url::to('@web/js/pace.min.js'), ['position' => yii\web\View::POS_HEAD]); ?>

    <link rel="shortcut icon" href="<?=Url::to('@web/favicon.ico')?>" type="image/x-icon" />
    <link rel="apple-touch-icon" href="<?=Url::to('@web/favicon.ico')?>" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?=Url::to('@web/apple-touch-icon.png')?>" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?=Url::to('@web/apple-touch-icon-72x72.png')?>" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?=Url::to('@web/apple-touch-icon-76x76.png')?>" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?=Url::to('@web/apple-touch-icon-114x114.png')?>" />
    <link rel="apple-touch-icon" sizes="120x120" href="<?=Url::to('@web/apple-touch-icon-120x120.png')?>" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?=Url::to('@web/apple-touch-icon-144x144.png')?>" />
    <link rel="apple-touch-icon" sizes="152x152" href="<?=Url::to('@web/apple-touch-icon-152x152.png')?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?=Url::to('@web/apple-touch-icon-180x180.png')?>" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?=Url::to('@web/themes/quirk/lib/html5shiv/html5shiv.js')?>"></script>
    <script src="<?=Url::to('@web/themes/quirk/lib/respond/respond.src.js')?>"></script>



    <![endif]-->



</head>
<body>
<div>
    <?php $this->beginBody() ?>

    <header>




        <?php



        NavBar::begin([
            'brandLabel' => Html::img('@web/images/logo-hex.png', ['alt'=>Yii::$app->name]),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-fixed-top',
            ],
        ]);

?>

        <div class="header-right pull-right">
            <ul class="headermenu">
                <?php
                if (Yii::$app->user->isGuest) {
                    ?>
                    <li>
                        <div class="btn-group">
                            <button class="btn">
                                <a href="<?= Url::toRoute('/site/signup'); ?>" class="btn"><i
                                        class="fa fa-globe"></i> Signup</a>
                            </button>

                        </div>
                    </li>
                    <li>
                        <div class="btn-group">
                            <button class="btn">
                                <a href="<?= Url::toRoute('/site/login'); ?>" class="btn"><i
                                        class="fa fa-key"></i> Login</a>
                            </button>

                        </div>
                    </li>


                    <?php
                } else {

                    $profile = Profile::findOne(['user_id' => Yii::$app->user->id]);
                    $profile->setScenario('frontend-update-own');


                    ?>
                    <li class="hidden-sm hidden-md">
                        <div id="noticePanel" class="btn-group">
                            <button class="btn btn-notice alert-notice" data-toggle="dropdown">
                                <i class="fa fa-globe"></i>
                            </button>
                            <div id="noticeDropdown" class="dropdown-menu dm-notice pull-right">
                                <div role="tabpanel">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs nav-justified" role="tablist">
                                        <li class="active"><a data-target="#notification" data-toggle="tab">Notifications
                                                (2)</a></li>
                                        <li><a data-target="#reminders" data-toggle="tab">Reminders (4)</a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="notification">
                                            <ul class="list-group notice-list">
                                                <li class="list-group-item unread">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <i class="fa fa-envelope"></i>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <h5><a href="">New message from Weno Carasbong</a>
                                                            </h5>
                                                            <small>June 20, 2015</small>
                                                            <span>Soluta nobis est eligendi optio cumque...</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item unread">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <h5><a href="">Renov Leonga is now following
                                                                    you!</a>
                                                            </h5>
                                                            <small>June 18, 2015</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <h5><a href="">Zaham Sindil is now following
                                                                    you!</a>
                                                            </h5>
                                                            <small>June 17, 2015</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <i class="fa fa-thumbs-up"></i>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <h5><a href="">Rey Reslaba likes your post!</a></h5>
                                                            <small>June 16, 2015</small>
                                                            <span>HTML5 For Beginners Chapter 1</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <i class="fa fa-comment"></i>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <h5><a href="">Socrates commented on your post!</a>
                                                            </h5>
                                                            <small>June 16, 2015</small>
                                                            <span>Temporibus autem et aut officiis debitis...</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <a class="btn-more" href="">View More Notifications <i
                                                    class="fa fa-long-arrow-right"></i></a>
                                        </div>
                                        <!-- tab-pane -->

                                        <div role="tabpanel" class="tab-pane" id="reminders">
                                            <h1 id="todayDay" class="today-day">...</h1>

                                            <h3 id="todayDate" class="today-date">...</h3>

                                            <span id="city"  class="today-weather"></span> <span id="head-deg"></span>


                                            <span id="head-condition-text"></span>

                                            <h4 class="panel-title">Upcoming Events</h4>
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <h4>20</h4>

                                                            <p>Aug</p>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <h5><a href="">HTML5/CSS3 Live! United States</a>
                                                            </h5>
                                                            <small>San Francisco, CA</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <h4>05</h4>

                                                            <p>Sep</p>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <h5><a href="">Web Technology Summit</a></h5>
                                                            <small>Sydney, Australia</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <h4>25</h4>

                                                            <p>Sep</p>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <h5><a href="">HTML5 Developer Conference 2015</a>
                                                            </h5>
                                                            <small>Los Angeles CA United States</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <h4>10</h4>

                                                            <p>Oct</p>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <h5><a href="">AngularJS Conference 2015</a></h5>
                                                            <small>Silicon Valley CA, United States</small>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <a class="btn-more" href="">View More Events <i
                                                    class="fa fa-long-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>

                        <div id="usermenuPanel" class="btn-group">
                            <button type="button" class="btn btn-logged" data-toggle="dropdown">

                                <img src="<?= $profile->FullAvatarUrl ?>" alt=""/>

                                <span class="hidden-sm"><?= Yii::$app->user->identity->fullname ?></span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="http://zone6.cbo.moph.go.th/backoffice/hrm/default/view?id=<?=$profile->id?>">
                                        <i
                                            class="glyphicon glyphicon-user"></i> My Profile</a>
                                </li>
                                <li><a href="http://zone6.cbo.moph.go.th/backoffice/cabinet/default/update"><i class="glyphicon glyphicon-cog"></i> Change Profile Picture</a>
                                </li>

                                <li><a href="http://zone6.cbo.moph.go.th/backoffice/hrm/default/update?id=<?=$profile->id?>"><i class="glyphicon glyphicon-cog"></i> Account Settings</a>
                                </li>
                                <li><a href="#"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
                                <li><a href="<?= Url::toRoute('/site/logout') ?>" data-method="post"><i
                                            class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="hidden-sm hidden-md">
                        <button id="chatview" class="btn btn-chat alert-notice">
                            <span class="badge-alert"></span>
                            <i class="fa fa-comments-o"></i>
                        </button>
                    </li>

                <?php } ?>
            </ul>
        </div>

        <?php

        echo NavX::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' =>  MenuHelper::getMenu(),
            'activateParents' => true,
            'encodeLabels' => false
        ]);

        ?>


        <!-- header-right -->
        <?php
        NavBar::end();
        ?>




    </header>

    <section>



        <div class="mainpanel">

            <!--<div class="pageheader">
              <h2><i class="fa fa-home"></i> Dashboard</h2>
            </div>-->
            <?php


            $lock_locate_request = Yii::$app->getRequest()->getQueryParam('lock_locate');
            $lock_locate_request = isset($lock_locate_request) ? $lock_locate_request : '';
            $cookies = Yii::$app->request->cookies;
            $lock_locate_cookie = $cookies->getValue('lock_locate', 'no');

            $scope = '';
            $region = '';
            $province = '';
            $district = '';
            $subdistrict = '';
            $hospcode= '';
            $locate = '';

            if (($lock_locate_cookie == 'yes' || $lock_locate_request == 'yes') && $lock_locate_request <> 'no') {
                if ($lock_locate_request == 'yes') {
                    $scope = Yii::$app->getRequest()->getQueryParam('scope');
                    $region = Yii::$app->getRequest()->getQueryParam('region');
                    $province = Yii::$app->getRequest()->getQueryParam('province');
                    $district = Yii::$app->getRequest()->getQueryParam('district');
                    $subdistrict = Yii::$app->getRequest()->getQueryParam('subdistrict');
                    $hospcode= Yii::$app->getRequest()->getQueryParam('hospcode');

                } else if ($lock_locate_cookie == 'yes'){
                    $scope = $cookies->getValue('scope', '');
                    $region = $cookies->getValue('region', '');
                    $province = $cookies->getValue('province', '');
                    $district = $cookies->getValue('district', '');
                    $subdistrict = $cookies->getValue('subdistrict', '');
                    $hospcode= $cookies->getValue('hospcode', '');
                }


                switch ($scope) {
                    case '1'://SCOPE_REGION
                        $locate = 'เขตสุขภาพที่ '.$region;
                        break;
                    case '2'://SCOPE_PROVINCE
                        $locate = 'จังหวัด'.common\models\CProvince::getProvinceName($province);
                        break;
                    case '3'://SCOPE_DISTRICT
                        $locate = 'อ.'.common\models\CDistrict::getDistrictName($district).' จ.'.common\models\CProvince::getProvinceName($province);
                        break;
                    case '4'://SCOPE_SUBDISTRICT
                        $locate = 'ต.'.common\models\CSubdistrict::getSubdistrictName($subdistrict).' อ.'.common\models\CDistrict::getDistrictName($district).' จ.'.common\models\CProvince::getProvinceName($province);
                        break;
                    case '5'://SCOPE_CUP
                        $locate = 'CUP '.common\models\CHospital::getHospitalName($hospcode);
                        break;
                    case '6'://SCOPE_HEALTH_UNIT
                        $locate = '['.$hospcode. '] '.common\models\CHospital::getHospitalName($hospcode).' อ.'.common\models\CDistrict::getDistrictName($district).' จ.'.common\models\CProvince::getProvinceName($province);
                        break;
                }
                ?>



                <div class="panel" style="margin-bottom: 0px">
                    <div class="panel-heading" style="padding: 15px 15px;">
                        <?=Html::a('<span class="glyphicon glyphicon-log-out"></span>', ['/site/index', 'lock_locate' => 'no'], ['class'=>'close'])?>
                        <h4 class="panel-title"><i class="fa fa-medkit"></i> คุณอยู่ใน <strong>Health Profile:</strong> <?=Html::a($locate, ['/site/health-profile'])?>. <?=Html::a('<i class="fa fa-gear"></i> เลือก Profile...', ['/site/index', 'tab' => 'profile'])?></h4>

                    </div>

                </div>



                <?php

            }
            ?>
            <div class="contentpanel">



                <?=
                Breadcrumbs::widget([
                    'options' => ['class' => 'breadcrumb breadcrumb-quirk'],
                    'homeLink' => [
                        'encode' => false,
                        'label' => Yii::t('yii', '<i class="fa fa-home mr5"></i> Home'),
                        'url' => Yii::$app->homeUrl,
                        'template' => "<li>{link}</li>\n",
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],

                ])
                ?>



                <?= Alert::widget() ?>

                <?= $content ?>



                <?php
                if (!isset($this->params['hide_footer'])) { ?>
                    <div class="row">
                        <div class="col-xs-12 col-sd-12 col-md-12 col-lg-12">
                            <div class="account-toggle hide-on-print">
                                <ul class="list-inline">
                                    <?php
                                    if (Yii::$app->user->isGuest) {
                                        echo '<li><i class="fa fa-key"></i> <a href="'.Url::toRoute(["/site/login"]).'">Login</a></span></li><li><i class="fa fa-globe"></i> <a href="'.Url::toRoute(["/site/signup"]).'">Sign-up</a></span></li>';

                                    } else {
                                        $profile = Profile::findOne(['user_id' => Yii::$app->user->id]);

                                        echo '<li><a href="'.Url::toRoute(["/site/logout"]).'" data-method="post" ><img src="'.$profile->FullAvatarUrl.'" alt=""/ style="max-width : 22px; border-radius: 50px;border: 2px solid #ffffff;"> Logout (' . Yii::$app->user->identity->fullname . ')</a></span></li>';
                                    }


                                    ?>


                                </ul>
                            </div>

                            <hr class="darken">
                            <div class="pull-right" style="padding: 6px">
                                Powered by
                                <?=Html::img('@web/images/logo-hex-footer.png', ['alt'=>'Powered by Health Explorer', 'style'=>"max-width: 100px", 'id'=>"footer-logo"])?>
                            </div>
                            <ul class="list-inline">
                                <li><a href="<?= Yii::$app->homeUrl ?>">Home</a></li>
                                <li><a href="<?= Url::toRoute('/site/about'); ?>">About</a></li>
                                <li><a href="<?= Url::toRoute('/site/about'); ?>">Privacy Policy</a></li>
                                <li><a href="<?= Url::toRoute('/site/about'); ?>">Terms of Use</a></li>
                                <li><a href="<?= Url::toRoute('/site/contact'); ?>">Contact Us</a></li>
                                <li>© 2015. All Rights Reserved.</li>

                            </ul>

                            <!-- Histats.com  START  (standard)-->
                            <script type="text/javascript">document.write(unescape("%3Cscript src=%27http://s10.histats.com/js15.js%27 type=%27text/javascript%27%3E%3C/script%3E"));</script>
                            <a href="http://www.histats.com" target="_blank" title="free counter statistics"  class="hide-on-print"><script  type="text/javascript" >
                                    try {Histats.start(1,3280813,4,205,255,27,"00011111");
                                        Histats.track_hits();} catch(err){};
                                </script></a>
                            <noscript><a href="http://www.histats.com" target="_blank"><img  src="http://sstatic1.histats.com/0.gif?3280813&101" alt="free counter statistics" border="0"></a></noscript>
                            <!-- Histats.com  END  -->
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
            <!-- contentpanel -->

        </div>
        <!-- mainpanel -->

    </section>
</div>



<?php $this->endBody() ?>


</body>
</html>
<?php $this->endPage() ?>
