<?php

use common\models\CHospital;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var common\models\Profile $model
 */

$this->title = $model->name. ' '.$model->surname;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-content profile-page">
    <!-- PROFILE TAB CONTENT -->
    <div class="tab-pane profile active" id="profile-tab">
        <div class="row">
            <div class="col-md-3">
                <div class="user-info-left">
                    <img src="<?php echo $model->FullAvatarUrl ?>" alt="Profile Picture" class="img-circle img-responsive" style="max-width: 70%;display:initial">
                    <h2><?=$model->getFullName()?> <i class="fa fa-circle green-font online-icon"></i><sup class="sr-only">online</sup></h2>
                    <h5 class="profile-designation"><?=ArrayHelper::getValue($model->getPositionArray(), $model->main_pst, 'ไม่ระบุ') .' '.ArrayHelper::getValue($model->getPostypenameArray(), $model->plevel, '')?></h5>
                    <ul class="list-group">
                        <li class="list-group-item"><i class="glyphicon glyphicon-briefcase mr5"></i> <?=CHospital::getHospitalName($model->off_id)?></li>

                    </ul>
                    <div class="contact">
                        <a href="<?=Url::toRoute(['setting/update-profile', 'id' => Yii::$app->user->getId()])?>" class="btn btn-block btn-custom-secondary"><i class="fa fa-edit"></i> ปรับปรุงข้อมูล</a>
                        <ul class="list-inline social">
                            <li><a href="#" title="Facebook"><i class="fa fa-facebook-square"></i></a></li>
                            <li><a href="#" title="Twitter"><i class="fa fa-twitter-square"></i></a></li>
                            <li><a href="#" title="Google Plus"><i class="fa fa-google-plus-square"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="user-info-right">
                    <h3><i class="fa fa-square"></i> Basic Information</h3>
                    <?= DetailView::widget([
                        'model' => $model,
                        'condensed'=>true,
                        'hover'=>true,
                        'bordered' => false,
                        'striped' => false,
                        'mode'=> DetailView::MODE_VIEW,
//                        'panel'=>[
//                            'heading'=>'<i class="fa fa-user"></i> Personal Information',
//                            //'type'=>DetailView::TYPE_PRIMARY,
//                        ],
                        'attributes' => [

                            //'cid',
                            [
                                'attribute' => 'pname',
                                'value' => ArrayHelper::getValue($model->getTitlesArray(), $model->pname, 'ไม่ระบุ')
                            ],

                            [
                                'attribute' => 'name',
                                'value' => $model->getFullName()
                            ],

//                            [
//                                'attribute'=>'birthday',
//                                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
//                                'type'=>DetailView::INPUT_WIDGET,
//                                'widgetOptions'=> [
//                                    'class'=>DateControl::classname(),
//                                    'type'=>DateControl::FORMAT_DATE
//                                ]
//                            ],
                            [
                                'attribute' => 'gender',
                                'value' => ArrayHelper::getValue($model->getGenderArray(), $model->gender, 'ไม่ระบุ')
                            ],

//                            'blood_group',

//                            [
//                                'attribute' => 'marry_status',
//                                'value' => ArrayHelper::getValue($model->getMstatusArray(), $model->marry_status, 'ไม่ระบุ')
//                            ],



                        ],
                        'deleteOptions'=>[
                            'url'=>['delete', 'id' => $model->id],
                            'data'=>[
                                'confirm'=>'Are you sure you want to delete this item?',
                                'method'=>'post',
                            ],
                        ],
                        'enableEditMode'=>false,
                    ]) ?>

                    <h3><i class="fa fa-square"></i> Work Information</h3>
                    <?= DetailView::widget([
                        'model' => $model,
                        'condensed'=>true,
                        'hover'=>true,
                        'bordered' => false,
                        'striped' => false,
                        'mode'=> DetailView::MODE_VIEW,

                        'attributes' => [
//                            'stf_id',
                            [
                                'attribute' => 'off_id',
                                'value' => ArrayHelper::getValue($model->getHosArray(27), $model->off_id, 'ไม่ระบุ')
                            ],
                            [
                                'attribute' => 'off_id18',
                                'value' => ArrayHelper::getValue($model->getHosArray(27), $model->off_id18, 'ไม่ระบุ')
                            ],
                            [
                                'attribute' => 'stf_type',
                                'value' => ArrayHelper::getValue($model->getStftypeArray(), $model->stf_type, 'ไม่ระบุ')
                            ],
                            [
                                'attribute' => 'main_pst',
                                'value' => ArrayHelper::getValue($model->getPositionArray(), $model->main_pst, 'ไม่ระบุ') .' '.ArrayHelper::getValue($model->getPostypenameArray(), $model->plevel, '')
                            ],
                            'position',

                            [
                                'attribute' => 'dr_special',
                                'value' => ArrayHelper::getValue($model->getSpArray(), $model->dr_special, 'ไม่ระบุ')
                            ],
//                            'licence_no',
//                            [
//                                'attribute'=>'birthday',
//                                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
//                                'type'=>DetailView::INPUT_WIDGET,
//                                'widgetOptions'=> [
//                                    'class'=>DateControl::classname(),
//                                    'type'=>DateControl::FORMAT_DATE
//                                ]
//                            ],


                            [
                                'attribute' => 'workgroup',
                                'value' => $model->getWorkgroup($model->workgroup)
                            ],

                            [
                                'attribute'=>'dt_started',
                                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
                                'type'=>DetailView::INPUT_WIDGET,
                                'widgetOptions'=> [
                                    'class'=>DateControl::classname(),
                                    'type'=>DateControl::FORMAT_DATE
                                ]
                            ],

                        ],
                        'deleteOptions'=>[
                            'url'=>['delete', 'id' => $model->id],
                            'data'=>[
                                'confirm'=>'Are you sure you want to delete this item?',
                                'method'=>'post',
                            ],
                        ],
                        'enableEditMode'=>false,
                    ]) ?>

                    <h3><i class="fa fa-square"></i> Contact Information</h3>
                    <?= DetailView::widget([
                        'model' => $model,
                        'condensed'=>true,
                        'hover'=>true,
                        'bordered' => false,
                        'striped' => false,
                        'mode'=> DetailView::MODE_VIEW,

                        'attributes' => [


                            [
                                'attribute' => 'addr_part',
                                'value' => $model->addr_part.' หมู่ '.$model->moo_part .' '.$model->setBankIfNull($model->rd_part)
                                    .' ต.'. ArrayHelper::getValue($model->getSubdistrictnameArray($model->amp_part), $model->tmb_part, 'ไม่ระบุ')
                                    .' อ.'. ArrayHelper::getValue($model->getDistrictnameArray($model->chw_part), $model->amp_part, 'ไม่ระบุ')
                                    .' จ.'. ArrayHelper::getValue($model->getProvinceArray(), $model->chw_part, 'ไม่ระบุ')
                            ],


                            'mobile_tel',
                            'email:email',

                            'Note:ntext',

                        ],
                        'deleteOptions'=>[
                            'url'=>['delete', 'id' => $model->id],
                            'data'=>[
                                'confirm'=>'Are you sure you want to delete this item?',
                                'method'=>'post',
                            ],
                        ],
                        'enableEditMode'=>false,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>