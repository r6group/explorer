<?php

namespace phi\controllers;

use app\models\MenuSearch;
use common\models\CHospital;
use common\models\ReportMenu;
use app\models\ReportScope;
use app\models\s;
use yii\web\NotFoundHttpException;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;
use common\models\Report;
use common\models\Profile;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use leandrogehlen\querybuilder\Translator;
use app\models\ReportDb;
use common\components\ActiveResponse;
use app\models\FavItem;
use app\models\FavCat;
use yii\helpers\Html;
//use xj\qrcode\actions;
use xj\qrcode\QRcode;
//use xj\qrcode\widgets\Text;
//use xj\qrcode\widgets\Email;
//use xj\qrcode\widgets\Card;


class ReportController extends \yii\web\Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [ 'update'],
                'rules' => [
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

//            [
//                'class' => 'yii\filters\PageCache',
//                'only' => ['index'],
//                'duration' => 180,
//                'variations' => [
//                    \Yii::$app->language,
//                ],
//                'dependency' => [
//                    'class' => 'yii\caching\DbDependency',
//                    'sql' => 'SELECT COUNT(*) FROM post',
//                ],
//            ],
        ];
    }





    private static function ConvertDate($date)
    {

        $months = ['มกราคม' => '01', 'กุมภาพันธ์' => '02', 'มีนาคม' => '03', 'เมษายน' => '04', 'พฤษภาคม' => '05', 'มิถุนายน' => '06', 'กรกฎาคม' => '07', 'สิงหาคม' => '08', 'กันยายน' => '09', 'ตุลาคม' => '10', 'พฤศจิกายน' => '11', 'ธันวาคม' => '12'];

        $valueStr = empty($date) ? '' : explode(' ', $date);
        return empty($valueStr) ? null : ($valueStr[2] - 543) . '-' . $months[$valueStr[1]] . '-' . $valueStr[0];


    }


    private static function getScope($report_model)
    {
        $searchModel = new s();
        $searchModel->search(Yii::$app->request->queryParams);

        $userId = 0;
        if (!\Yii::$app->user->isGuest) {
            $userId = \Yii::$app->user->identity->id;
        }

        $profileModel = Profile::findOne(['user_id' => $userId]);

//        if (($profileModel)) {
//
//            //(empty($searchModel->province) && (empty($searchModel->repid))) ? $searchModel->province = $profileModel->chw_part : $searchModel->province = $searchModel->province;
//            //empty($searchModel->hospcode) ? $searchModel->hospcode = substr($profileModel->off_id,2,5) : $searchModel->hospcode = $searchModel->hospcode;
//            $searchModel->province = $profileModel->chw_part;
//            $searchModel->district = $profileModel->amp_part;
//            $searchModel->hospcode = $profileModel->off_id;
//        }


        if (empty($searchModel->scope)) {
            $scope = Yii::$app->config->get('PHI.DEFAULT_SCOPE');
            $searchModel->region = Yii::$app->config->get('PHI.DEFAULT_REGION');

            if (strpos(',' . $report_model->area_visible . ',', ','.$scope.',') > 0) {
                $searchModel->scope = $scope;

                //$searchModel->scope = $searchModel::SCOPE_PROVINCE;
            } else {
                empty($report_model->area_visible) ? null : $searchModel->scope = explode(',', $report_model->area_visible)[0];
            }

            empty($report_model->time_visible) ? null : $searchModel->timescope = explode(',', $report_model->time_visible)[0];


            if (empty($searchModel->govyear)) {
                $searchModel->govyear = date('m') >= 10 ? Yii::$app->thai->thaidate('Y') + 1 : Yii::$app->thai->thaidate('Y');

            }

            $searchModel->startdate = Yii::$app->thai->thaidate('d F Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1));
            $searchModel->enddate = Yii::$app->thai->thaidate('d F Y');


            $cookies = Yii::$app->request->cookies;
            $lock_locate = $cookies->getValue('lock_locate', 'no');


            if ($lock_locate == 'yes' && !empty($report_model->area_visible)) {

                $visible_scope = explode(',',$report_model->area_visible);
                $scope = $cookies->getValue('scope', Yii::$app->config->get('PHI.DEFAULT_SCOPE'));
                if (in_array($scope, $visible_scope)) {
                    $searchModel->scope = $scope;
                }

                //$searchModel->scope = $cookies->getValue('scope', Yii::$app->config->get('PHI.DEFAULT_SCOPE'));
                $searchModel->region = $cookies->getValue('region', Yii::$app->config->get('PHI.DEFAULT_REGION'));
                $searchModel->province = $cookies->getValue('province', Yii::$app->config->get('PHI.DEFAULT_PROVINCE'));
                $searchModel->district = $cookies->getValue('district', '01');
                $searchModel->cup = $cookies->getValue('cup', '00001');
                $searchModel->subdistrict = $cookies->getValue('subdistrict', '01');
                $searchModel->hospcode = $cookies->getValue('hospcode', '02444');


            } else if (isset($profileModel)) {
                $hospital = \common\models\CHospital::findOne(['hoscode' => $searchModel->hospcode = $profileModel->off_id]);

                if (isset($hospital)) {
                    $searchModel->province = $hospital->provcode;
                    $searchModel->district = $hospital->provcode.$hospital->distcode;
                    $searchModel->hospcode = $profileModel->off_id;
                }

            } else {
                $searchModel->region = Yii::$app->config->get('PHI.DEFAULT_REGION');
                $searchModel->province = Yii::$app->config->get('PHI.DEFAULT_PROVINCE');
            }
        }


        return $searchModel;

    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            //deny widget set size & margin & ecLevel
//            'qrcode' => [
//                'class' => xj\qrcode\actions\QRcodeAction::className(),
//                'enableCache' => false,
//                //
//                'allowClientEclevel' => false,
//                'ecLevel' => QRcode::QR_ECLEVEL_H,
//                //
//                'defaultSize' => 4,
//                'allowClientSize' => false,
//                //
//                'defaultMargin' => 2,
//                'allowClientMargin' => false,
//            ],


        ];
    }



    public function actionIndex()
    {

        $id = Yii::$app->getRequest()->getQueryParam('id');
        $repid = Yii::$app->getRequest()->getQueryParam('repid');


        $model = ReportMenu::findOne(['id' => $id]);
        $query = Report::find()->where('FIND_IN_SET (' . $id . ',menutype) >0 AND active = 1');


        $searchModel = new MenuSearch();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,

        ]);


    }


    public function actionAnalysis()
    {
        return $this->render('analysis');
    }


    public function actionMap()
    {
        return $this->render('map');
    }


    public function actionList()
    {

        $id = Yii::$app->getRequest()->getQueryParam('id');
        $repid = Yii::$app->getRequest()->getQueryParam('repid');


        $model = ReportMenu::findOne(['id' => $id]);
        $query = Report::find()->where('FIND_IN_SET (' . $id . ',menutype) >0 AND active = 1');


        $searchModel = new MenuSearch();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);


        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,

        ]);


    }


    private static function getColumns($db, $table_sql, $is_sql)
    {
        $columns = [];
        if (!empty($db) && !empty($table_sql)) {

            $appConnection = ReportDb::find()->where(['dsp_name' => $db])->one();
            if (!empty($appConnection)) {
                $connection = new \yii\db\Connection([
                    // dsn user and password are from session, set these value during login procedure
                    'dsn' => 'mysql:host=' . $appConnection->server . ';dbname=' . $appConnection->db_name,
                    'username' => $appConnection->user,
                    'password' => $appConnection->pass,
                    'charset' => 'utf8',
                    'enableSchemaCache' => true,
                    'schemaCacheDuration' => 3600,
                    'schemaCache' => 'cache',
                ]);

            } else {
                $connection = Yii::$app->db_health;
            }

            if ($is_sql == true) {
                $schema = $connection->createCommand($table_sql)->queryOne();
                $columns = array_keys($schema);

            } else {
                $schema = $connection->getSchema()->getTableSchema($table_sql);
                if ($schema !== null) {
                    $columns = ArrayHelper::map($schema->columns, 'name', 'name');

                }

            }


        }

        return $columns;
    }


    public function actionSetFavorite()
    {

        $ar = new ActiveResponse();

        if (isset($_POST['cat_id'])) {
            $cat_id = $_POST['cat_id'];
            $report_url = $_POST['report_url'];
            $report_title = $_POST['report_title'];
            if (isset($cat_id)) {

                try {

                    if ($cat_id == 0) {
                        $fav_cat = new FavCat();
                        $fav_cat->cat_name = 'My Favorite';
                        $fav_cat->user_id = \Yii::$app->user->identity->getId();
                        if ($fav_cat->save()) {
                            $cat_id = $fav_cat->cat_id;
                        }

                    }

                    $report_url = str_replace('!@#', '&', $report_url);

                    $fav_item = FavItem::find()->where(['user_id' => \Yii::$app->user->identity->getId(), 'report_url' => $report_url])->all();

                    if ($fav_item) {
                        //FavItem::deleteAll(['user_id' => \Yii::$app->user->identity->getId(), 'report_url' => $report_url]);
                        FavItem::updateAll(['cat_id'=>$cat_id*1], ['user_id' => \Yii::$app->user->identity->getId(), 'report_url' => $report_url]);
                        $ar->script("'use strict'; $.gritter.add({
                          title: 'Success',
                          text: 'Saved.',
                          fade_in_speed: 'fast',
                          fade_out_speed: 200,
                          time: 1000,
                          class_name: 'with-icon check-circle success'
                        });");
                        return $ar;

                    } else {

                        $fav_item = new FavItem();
                        $fav_item->report_url = $report_url;
                        $fav_item->cat_id = $cat_id;
                        $fav_item->report_title = $report_title;
                        $fav_item->user_id = \Yii::$app->user->identity->getId();
                        if ($fav_item->save()) {
                            $ar->script("'use strict'; $.gritter.add({
                          title: 'Success',
                          text: 'Saved.',
                          fade_in_speed: 'fast',
                          fade_out_speed: 200,
                          time: 1000,
                          class_name: 'with-icon check-circle success'
                        });");
                            return $ar;
                        }
                    }

                } catch (\yii\db\Exception $e) {
                    $ar->script("'use strict'; $.gritter.add({
                      title: '" . Html::encode(preg_replace("/\r\n|\r|\n/", '', $e->getName()), false) . "',
                      text: '" . Html::encode(preg_replace("/\r\n|\r|\n/", '', $e->getMessage()), false) . "',
                      fade_in_speed: 'fast',
                      fade_out_speed: 300,
                      time: 6000,
                      class_name: 'with-icon check-circle danger'
                    });");
                    return $ar;

                }
            }
        } else {
            $ar->script("'use strict'; $.gritter.add({
              title: 'Error',
              text: 'Empty cat_id.',
              fade_in_speed: 'fast',
              fade_out_speed: 200,
              time: 3000,
              class_name: 'with-icon check-circle error'
            });");
            return $ar;
        }

    }


    /**
     * @return string
     */
    public function actionView()
    {

        $id = Yii::$app->getRequest()->getQueryParam('id');
        $repid = Yii::$app->getRequest()->getQueryParam('repid-link');
        $repid = empty($repid) ? Yii::$app->getRequest()->getQueryParam('repid') : $repid;
        $cat_id = Yii::$app->getRequest()->getQueryParam('cat-link');
        $cat_id = empty($cat_id) ? Yii::$app->getRequest()->getQueryParam('catid') : $cat_id;
        $cat_id = empty($cat_id) ? '0' : $cat_id;
        $embeded = Yii::$app->getRequest()->getQueryParam('embeded');
            $show_table = Yii::$app->getRequest()->getQueryParam('show_table');
            $show_chart = Yii::$app->getRequest()->getQueryParam('show_chart');
            $show_tool = Yii::$app->getRequest()->getQueryParam('show_tool');




        $frameid = Yii::$app->getRequest()->getQueryParam('frameid');
        $user_id = \Yii::$app->user->isGuest ? 0 : \Yii::$app->user->getId();
        $fav_cat = \Yii::$app->user->isGuest ? [] : \app\models\FavCat::find()->where(['user_id' => $user_id])->asArray(true)->all();


        if ($repid) {

            $models = Report::find()->where(['id' => $repid])->one();

            if ($models->active == 0 && $models->user_id <> $user_id) {
                return $this->render('/site/error', [
                    'name' => 'Page Not Available',
                    'message' => 'This page is now inactive.' , //$e->getMessage(),

                ]);
            }

            $models->hits = $models->hits + 1;
            $models->trigger_view = 1;
            $models->save();



            $reportsearchmodel = new MenuSearch();


            $searchModel = $this->getScope($models);
            $searchModel->id = $id;
            $searchModel->repid = $repid;
            $searchModel->catid = $cat_id;

            $reports_in_cat = Report::find()->where('FIND_IN_SET (' . $cat_id . ',menutype) >0')->andWhere('active = 1')->all();


            $fields_array = unserialize($models->fields);
            if ($models->query_type == 1) {
                $columns = $this->getColumns($models->db_name, $models->table_name, false);
            } else {
                $columns = $this->getColumns($models->db_name, $models->sql, true);
            }
            $select_fields = [];

            $use_grouping = $models->list_style == '0';

            foreach ($columns as $column => $value) {

                $array = ArrayHelper::getValue($fields_array, $value, []);
                if (ArrayHelper::getValue($array, 'display', '') == '1') {
                    $func = ArrayHelper::getValue($array, 'function', '');
                    $formula = ArrayHelper::getValue($array, 'formula', '');
                    if (($func <> '' || $formula <> '')) {
                        $select_fields[] = ($formula <> '') ? $formula . ' AS ' . $value : strtoupper($func) . '(s.' . $value . ') AS ' . $value;

                    } else {
                        $select_fields[] = 's.' . $value;
                    }
                }

            }

            $time_elapsed_secs = 0;
            $select_prefix = '';
            $select_posfix = '';
            $join = '';
            $joinfield = '';
            $from = '';
            $group_by = '';
            $where = '';
            $remark = '';
            $chart_y_field = '';


            if ($models->db_name == 'db_hdc') {
                $co_zone = 'czone';
                $co_province = 'cchangwat';
                $co_district = 'campur';
                $co_subdistrict = 'ctambon';
                $co_village = 'cvillage';
                $co_village_hospcode = 'village';
                $co_hospital = 'chospital';
                $co_cup = 'cmastercup';

            } else {
                $co_zone = 'health_explorer.co_zone';
                $co_province = 'health_explorer.co_province';
                $co_district = 'health_explorer.co_district';
                $co_subdistrict = 'health_explorer.co_subdistrict';
                $co_village = 'health_explorer.co_village';
                $co_village_hospcode = 'health_explorer.co_village_hospcode';
                $co_hospital = 'health_explorer.co_hospital';
                $co_cup = 'health_explorer.co_mastercup';
            }


            $remark .= ' ' . $models->title;

            $remark_time = '';
            $where_time = '';
            $fields = [];
            $fields[] = ['class' => 'kartik\grid\SerialColumn'];
            $fields_url = [];


            if ($searchModel->timescope == s::SCOPE_TIME_DATE) {
                if (!empty($searchModel->startdate) && !empty($searchModel->enddate)) {
                    //empty($where) ? null : $where_time = ' AND';
                    empty($models->time_fieldname) ? null : $where_time .= ' ' . $models->time_fieldname . ' BETWEEN "' . $this->ConvertDate($searchModel->startdate) . '" AND "' . $this->ConvertDate($searchModel->enddate) . '"';
                    $remark_time = ' ระหว่างวันที่ ' . $searchModel->startdate . ' ถึง ' . $searchModel->enddate;
                }
            } elseif ($searchModel->timescope == s::SCOPE_TIME_GOVYEAR) {
                if (!empty($searchModel->govyear)) {
                    //empty($where) ? null : $where_time = ' AND';
                    empty($models->time_fieldname) ? null : $where_time .= ' ' . $models->time_fieldname . ' = "' . $searchModel->govyear . '"';
                    $remark_time = ' ปีงบประมาณ ' . $searchModel->govyear;
                }
            } elseif ($searchModel->timescope == s::SCOPE_TIME_YEAR) {
                if (!empty($searchModel->govyear)) {
                    //empty($where) ? null : $where .= ' AND';
                    empty($models->time_fieldname) ? null : $where_time .= ' ' . $models->time_fieldname . ' = "' . $searchModel->govyear . '"';
                    $remark_time = ' ปี พ.ศ. ' . $searchModel->govyear;
                }
            }

            if ($searchModel->scope == s::SCOPE_REGION) {
                if (empty($searchModel->region)) {
                    $select_prefix .= 'SELECT c.zonecode, c.zonename AS `เขตสุขภาพ`,';
                    $from .= ' FROM ' . $co_zone . ' c LEFT JOIN (';
                    $joinfield = 'co.zonecode AS joinfield,';
                    $join = ' INNER JOIN ' . $co_province . ' co ON LEFT (s.' . $models->area_fieldname . ', 2) = co.changwatcode ';
                    $group_by .= ' co.zonecode';
                    $where .= '';
                    $select_posfix = ' ) s ON c.zonecode = s.joinfield';
                    $group_postfix = ' GROUP BY c.zonename';// ORDER BY c.zonecode
                    $remark .= ' ทุกเขตสุขภาพ';
                    $chart_y_field = 'เขตสุขภาพ';

                    $fields_url = [
                        'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                        'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                            return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px' onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-region').val('" . $d['zonecode'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\">" . "</a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-region').val('" . $d['zonecode'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                        }
                    ];
                } else {
                    $select_prefix .= 'SELECT c.changwatcode, c.changwatname AS `จังหวัด`, ';
                    $from .= ' FROM ' . $co_province . ' c LEFT JOIN (';
                    $joinfield = 'LEFT (s.' . $models->area_fieldname . ', 2) AS joinfield,';
                    $join = ' ';
                    $group_by .= ' joinfield ';
                    $select_posfix = ' ) s ON s.joinfield = c.changwatcode WHERE c.zonecode = "' . $searchModel->region . '"';
                    $group_postfix = ' GROUP BY c.changwatname';// ORDER BY c.changwatname
                    $remark .= ' เขตสุขภาพที่ ' . $searchModel->region;
                    $chart_y_field = 'จังหวัด';

                    $fields_url = [
                        'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                        'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                            return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope + 1) . "');$('#l-province').val('" . $d['changwatcode'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope + 1) . "');$('#l-province').val('" . $d['changwatcode'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                        }
                    ];
                }

            } elseif ($searchModel->scope == s::SCOPE_PROVINCE) {
                if (empty($searchModel->province)) {
                    if (!empty($models->area_fieldname)) {
                        $select_prefix .= 'SELECT c.changwatcode, c.changwatname AS `จังหวัด`, ';
                        $from .= ' FROM ' . $co_province . ' c LEFT JOIN (';
                        $joinfield = 'LEFT (s.' . $models->area_fieldname . ', 2) AS joinfield,';
                        $join = ' ';
                        $group_by .= ' joinfield ';
                        $select_posfix = ' ) s ON s.joinfield = c.changwatcode';
                        $group_postfix = ' GROUP BY c.changwatname';// ORDER BY c.changwatname
                        $chart_y_field = 'จังหวัด';

                        $fields_url = [
                            'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                            'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                                return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-province').val('" . $d['changwatcode'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-province').val('" . $d['changwatcode'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                            }
                        ];
                    }

                    $remark .= ' ทุกจังหวัด';
                } else {
                    if (!empty($models->area_fieldname)) {
                        $select_prefix .= 'SELECT c.ampurcodefull, c.ampurname AS `อำเภอ`, ';
                        $from .= ' FROM ' . $co_district . ' c LEFT JOIN (';
                        $joinfield = 'LEFT (s.' . $models->area_fieldname . ', 4) AS joinfield,';
                        $join = ' ';
                        $group_by .= ' joinfield ';
                        $select_posfix = ' ) s ON s.joinfield = c.ampurcodefull WHERE c.ampurname NOT LIKE "*%" AND c.changwatcode = "' . $searchModel->province . '"';
                        $group_postfix = '  GROUP BY c.ampurname';// ORDER BY c.ampurcodefull
                        empty($models->area_fieldname) ? null : $where .= ' LEFT(' . $models->area_fieldname . ',2) = "' . $searchModel->province . '"';
                        $chart_y_field = 'อำเภอ';
                        $remark .= ' จ.' . \common\models\CProvince::findOne(['changwatcode' => $searchModel->province])->toArray(['changwatname'])['changwatname'];

                        $fields_url = [
                            'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                            'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                                return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope + 1) . "');$('#l-district').val('" . $d['ampurcodefull'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope + 1) . "');$('#l-district').val('" . $d['ampurcodefull'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                            }
                        ];
                    }


                }

            } elseif ($searchModel->scope == s::SCOPE_DISTRICT) {
                if (!empty($models->area_fieldname)) {
                    if (empty($searchModel->province)) {
                        $select_prefix .= 'SELECT c.changwatcode, c.ampurcodefull, c.ampurname AS `อำเภอ`, ';
                        $from .= ' FROM ' . $co_district . ' c LEFT JOIN (';
                        $joinfield = 'LEFT (s.' . $models->area_fieldname . ', 4) AS joinfield,';
                        $join = ' ';
                        $group_by .= ' joinfield ';
                        $select_posfix = ' ) s ON s.joinfield = c.ampurcodefull WHERE c.ampurname NOT LIKE "*%"';
                        $group_postfix = ' GROUP BY c.ampurname';// ORDER BY c.ampurcodefull
                        $chart_y_field = 'อำเภอ';
                        $remark .= ' ทุกอำเภอ';

                        $fields_url = [
                            'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                            'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                                return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-province').val('" . $d['changwatcode'] . "');$('#l-district').val('" . $d['ampurcodefull'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-province').val('" . $d['changwatcode'] . "');$('#l-district').val('" . $d['ampurcodefull'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                            }
                        ];
                    } elseif (empty($searchModel->district)) {
                        $select_prefix .= 'SELECT c.ampurcodefull, c.ampurname AS `อำเภอ`, ';
                        $from .= ' FROM ' . $co_district . ' c LEFT JOIN (';
                        $joinfield = 'LEFT (s.' . $models->area_fieldname . ', 4) AS joinfield,';
                        $join = ' ';
                        $group_by .= ' joinfield ';
                        $select_posfix = ' ) s ON s.joinfield = c.ampurcodefull WHERE c.ampurname NOT LIKE "*%" AND c.changwatcode = "' . $searchModel->province . '"';
                        $group_postfix = ' GROUP BY c.ampurname';// ORDER BY c.ampurcodefull
                        empty($models->area_fieldname) ? null : $where .= ' LEFT(' . $models->area_fieldname . ',2) = "' . $searchModel->province . '"';
                        $chart_y_field = 'อำเภอ';
                        $remark .= ' ทุกอำเภอ (จ.' . \common\models\CProvince::findOne(['changwatcode' => $searchModel->province])->toArray(['changwatname'])['changwatname'] . ')';

                        $fields_url = [
                            'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                            'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                                return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-district').val('" . $d['ampurcodefull'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-district').val('" . $d['ampurcodefull'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                            }
                        ];
                    } else {
                        $select_prefix .= 'SELECT c.tamboncodefull, c.tambonname AS `ตำบล`, s.ampurname AS `อำเภอ`, ';
                        $from .= ' FROM ' . $co_subdistrict . ' c LEFT JOIN (';
                        $joinfield = 'LEFT (s.' . $models->area_fieldname . ', 6) AS joinfield, c.ampurname,';
                        $join = ' LEFT JOIN ' . $co_district . ' c ON LEFT (s.' . $models->area_fieldname . ', 4) = c.ampurcodefull ';
                        $group_by .= ' joinfield ';
                        $select_posfix = ' ) s ON s.joinfield = c.tamboncodefull WHERE c.tambonname NOT LIKE "*%" AND c.ampurcode = "' . $searchModel->district . '"';
                        $group_postfix = ' GROUP BY c.tambonname';// ORDER BY c.tamboncodefull
                        empty($models->area_fieldname) ? null : $where .= ' LEFT(' . $models->area_fieldname . ',4) = "' . $searchModel->district . '"';
                        $chart_y_field = 'ตำบล';
                        $remark .= ' อ.' . \common\models\CDistrict::findOne(['ampurcodefull' => $searchModel->district])->toArray(['ampurname'])['ampurname']
                            . ' จ.' . \common\models\CProvince::findOne(['changwatcode' => $searchModel->province])->toArray(['changwatname'])['changwatname'];

                        $fields_url = [
                            'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                            'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                                return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope + 1) . "');$('#l-subdistrict').val('" . $d['tamboncodefull'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope + 1) . "');$('#l-subdistrict').val('" . $d['tamboncodefull'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                            }
                        ];
                    }

                }
            } elseif ($searchModel->scope == s::SCOPE_SUBDISTRICT) {
                if (empty($searchModel->province)) {
                    $select_prefix .= 'SELECT c.tamboncodefull, c.ampurcode, c.changwatcode, c.tambonname AS `ตำบล`, ';
                    $from .= ' FROM ' . $co_subdistrict . ' c LEFT JOIN (';
                    $joinfield = 'LEFT (s.' . $models->area_fieldname . ', 6) AS joinfield, c.ampurname,';
                    $join = ' LEFT JOIN ' . $co_district . ' c ON LEFT (s.' . $models->area_fieldname . ', 4) = c.ampurcodefull ';
//                    $join .= ' LEFT JOIN ' . $co_district . ' c ON LEFT (s.' . $models->area_fieldname . ', 4) = c.ampurcodefull ';
                    $group_by .= ' joinfield ';
                    $select_posfix = ' ) s ON s.joinfield = c.tamboncodefull WHERE c.tambonname NOT LIKE "*%"';
                    $group_postfix = ' GROUP BY c.tambonname';// ORDER BY c.tamboncodefull
                    $chart_y_field = 'ตำบล';
                    $remark .= ' ทุกตำบล';

                    $fields_url = [
                        'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                        'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                            return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-province').val('" . $d['changwatcode'] . "');$('#l-district').val('" . $d['ampurcode'] . "');$('#l-subdistrict').val('" . $d['tamboncodefull'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-province').val('" . $d['changwatcode'] . "');$('#l-district').val('" . $d['ampurcode'] . "');$('#l-subdistrict').val('" . $d['tamboncodefull'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                        }
                    ];
                } elseif (empty($searchModel->district)) {
                    $select_prefix .= 'SELECT c.tamboncodefull, c.ampurcode, CONCAT("[อ.", d.ampurname ,"] ต.",c.tambonname) AS `ตำบล`, ';
                    $from .= ' FROM ' . $co_subdistrict . ' c LEFT JOIN (';
                    $joinfield = 'LEFT (s.' . $models->area_fieldname . ', 6) AS joinfield, c.ampurname,';

                    $join = ' LEFT JOIN ' . $co_district . ' c ON LEFT (s.' . $models->area_fieldname . ', 4) = c.ampurcodefull ';
//
                    $group_by .= ' joinfield ';
                    $select_posfix = ' ) s ON s.joinfield = c.tamboncodefull ';
                    $select_posfix .= ' LEFT JOIN ' . $co_district . ' d ON c.ampurcode = d.ampurcodefull ';
                    $select_posfix .= ' WHERE c.tambonname NOT LIKE "*%" AND c.changwatcode = "' . $searchModel->province . '"';
                    $group_postfix = ' GROUP BY c.tambonname';// ORDER BY c.tamboncodefull
                    empty($models->area_fieldname) ? null : $where .= ' LEFT(' . $models->area_fieldname . ',2) = "' . $searchModel->province . '"';
                    $chart_y_field = 'ตำบล';
                    $remark .= ' ทุกตำบลใน จ.' . \common\models\CProvince::findOne(['changwatcode' => $searchModel->province])->toArray(['changwatname'])['changwatname'];

                    $fields_url = [
                        'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                        'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                            return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-district').val('" . $d['ampurcode'] . "');$('#l-subdistrict').val('" . $d['tamboncodefull'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-district').val('" . $d['ampurcode'] . "');$('#l-subdistrict').val('" . $d['tamboncodefull'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                        }
                    ];

                } elseif (empty($searchModel->subdistrict)) {
                    $select_prefix .= 'SELECT c.tamboncodefull, c.tambonname AS `ตำบล`, ';
                    $from .= ' FROM ' . $co_subdistrict . ' c LEFT JOIN (';
                    $joinfield = 'LEFT (s.' . $models->area_fieldname . ', 6) AS joinfield, c.ampurname,';
                    $join = ' LEFT JOIN ' . $co_district . ' c ON LEFT (s.' . $models->area_fieldname . ', 4) = c.ampurcodefull ';
                    $group_by .= ' joinfield ';
                    $select_posfix = ' ) s ON s.joinfield = c.tamboncodefull WHERE c.tambonname NOT LIKE "*%" AND c.ampurcode = "' . $searchModel->district . '"';
                    $group_postfix = ' GROUP BY c.tambonname';// ORDER BY c.tamboncodefull
                    empty($models->area_fieldname) ? null : $where .= ' LEFT(' . $models->area_fieldname . ',4) = "' . $searchModel->district . '"';
                    $chart_y_field = 'ตำบล';
                    $remark .= ' ทุกตำบลใน อ.' . \common\models\CDistrict::findOne(['ampurcodefull' => $searchModel->district])->toArray(['ampurname'])['ampurname']
                        . ' จ.' . \common\models\CProvince::findOne(['changwatcode' => $searchModel->province])->toArray(['changwatname'])['changwatname'];

                    $fields_url = [
                        'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                        'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                            return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-subdistrict').val('" . $d['tamboncodefull'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-subdistrict').val('" . $d['tamboncodefull'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                        }
                    ];

                } else {
                    $select_prefix .= 'SELECT c.villagename AS `หมู่บ้าน`, s.tambonname AS `ตำบล`, ';
                    $from .= ' FROM ' . $co_village . ' c LEFT JOIN (';
                    $joinfield = 'LEFT (s.' . $models->area_fieldname . ', 8) AS joinfield, c2.tambonname, c.ampurname,';
                    $join = ' LEFT JOIN ' . $co_district . ' c ON LEFT (s.' . $models->area_fieldname . ', 4) = c.ampurcodefull LEFT JOIN ' . $co_subdistrict . ' c2 ON LEFT(s.' . $models->area_fieldname . ', 6)  = c2.tamboncodefull ';
                    $group_by .= ' joinfield ';
                    $select_posfix = ' ) s ON s.joinfield = c.villagecodefull WHERE c.villagename NOT LIKE "*%" AND c.tamboncode = "' . $searchModel->subdistrict . '"';
                    $group_postfix = ' GROUP BY c.villagecodefull';// ORDER BY c.villagecodefull

                    empty($models->area_fieldname) ? null : $where .= ' LEFT(' . $models->area_fieldname . ',6) = "' . $searchModel->subdistrict . '"';
                    $chart_y_field = 'หมู่บ้าน';
                    $remark .= ' ต.' . \common\models\CSubdistrict::findOne(['tamboncodefull' => $searchModel->subdistrict])->toArray(['tambonname'])['tambonname']
                        . ' อ.' . \common\models\CDistrict::findOne(['ampurcodefull' => $searchModel->district])->toArray(['ampurname'])['ampurname']
                        . ' จ.' . \common\models\CProvince::findOne(['changwatcode' => $searchModel->province])->toArray(['changwatname'])['changwatname'];

                    $fields_url = ['label' => $chart_y_field, 'attribute' => $chart_y_field, 'class' => '\kartik\grid\DataColumn', 'pageSummary' => false, 'noWrap' => true];
                }
            } elseif ($searchModel->scope == s::SCOPE_CUP) {
                if (!empty($models->hosp_fieldname)) {
                    if (empty($searchModel->province)) {
                        $select_prefix .= 'SELECT c.hoscode, CONCAT(c.provcode, c.distcode) distcode, c.provcode, CONCAT(c.hoscode, \' \',REPLACE(REPLACE(c.hosname, "โรงพยาบาลส่งเสริมสุขภาพตำบล", "รพ.สต."), "โรงพยาบาลส่งเสริมสุขภาพ", "รพ.สต.")) AS `หน่วยบริการ`, ';
                        $from .= ' FROM ' . $co_hospital . ' c LEFT JOIN (';
                        $joinfield = ' s.' . $models->hosp_fieldname . ' AS `joinfield`,';
                        $group_by .= ' joinfield ';
                        $select_posfix = ' ) s ON s.joinfield = c.hoscode WHERE c.hoscode <> "00000" AND c.hostype IN (' . $models->hosp_visible . ')';
                        $group_postfix = ' GROUP BY c.hoscode';

                        $where .= '';
                        $chart_y_field = 'หน่วยบริการ';

                        $remark .= ' ทุกสถานบริการ';

                        $fields_url = [
                            'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                            'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                                return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope + 1) . "');$('#l-province').val('" . $d['provcode'] . "');$('#l-district').val('" . $d['distcode'] . "');$('#l-hospcode').val('" . $d['hoscode'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope + 1) . "');$('#l-province').val('" . $d['provcode'] . "');$('#l-district').val('" . $d['distcode'] . "');$('#l-hospcode').val('" . $d['hoscode'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                            }
                        ];
                    } elseif (empty($searchModel->cup)) {
                        $select_prefix .= 'SELECT c.hoscode, CONCAT(c.provcode, c.distcode) distcode, c.provcode, CONCAT(c.hoscode, \' \',REPLACE(REPLACE(c.hosname, "โรงพยาบาลส่งเสริมสุขภาพตำบล", "รพ.สต."), "โรงพยาบาลส่งเสริมสุขภาพ", "รพ.สต.")) AS `หน่วยบริการ`, ';
                        $from .= ' FROM ' . $co_hospital . ' c LEFT JOIN (';
                        $joinfield = ' s.' . $models->hosp_fieldname . ' AS `joinfield`,';
                        $group_by .= ' joinfield ';
                        $select_posfix = ' ) s ON s.joinfield = c.hoscode WHERE c.provcode = "' . $searchModel->province . '" AND c.hoscode <> "00000" AND c.hostype IN (' . $models->hosp_visible . ')';
                        $group_postfix = ' GROUP BY c.hoscode';

                        $where .= '';// LEFT(' . $models->area_fieldname . ',2) = "' . $searchModel->province . '"
                        $chart_y_field = 'หน่วยบริการ';

                        $remark .= ' ทุกสถานบริการ (จ.' . \common\models\CProvince::findOne(['changwatcode' => $searchModel->province])->toArray(['changwatname'])['changwatname'] . ')';

                        $fields_url = [
                            'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                            'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                                return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope + 1) . "');$('#l-province').val('" . $d['provcode'] . "');$('#l-district').val('" . $d['distcode'] . "');$('#l-hospcode').val('" . $d['hoscode'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope + 1) . "');$('#l-province').val('" . $d['provcode'] . "');$('#l-district').val('" . $d['distcode'] . "');$('#l-hospcode').val('" . $d['hoscode'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                            }
                        ];
                    } else {
                        $select_prefix .= 'SELECT h.hoscode, CONCAT(h.provcode, h.distcode) distcode, h.provcode, CONCAT(h.hoscode, \' \',REPLACE(REPLACE(h.hosname, "โรงพยาบาลส่งเสริมสุขภาพตำบล", "รพ.สต."), "โรงพยาบาลส่งเสริมสุขภาพ", "รพ.สต.")) AS `หน่วยบริการ`, ';
                        $from .= ' FROM ' . $co_cup . ' c LEFT JOIN (';
                        $joinfield = ' s.' . $models->hosp_fieldname . ' AS `joinfield`,';
                        $group_by .= ' joinfield ';
                        $select_posfix = ' ) s ON s.joinfield = c.hsub LEFT JOIN ' . $co_hospital . ' h ON c.hsub = h.hoscode WHERE c.hmain = "' . $searchModel->cup . '"';
                        $group_postfix = ' GROUP BY joinfield';

                        $where = $where_time;
                        $where_time = '';
                        $chart_y_field = 'หน่วยบริการ';

                        $remark .= ' CUP ' . \common\models\CMastercup::findOne(['hsub' => $searchModel->cup])->toArray(['hmainname'])['hmainname'];

                        $fields_url = [
                            'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                            'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                                return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope + 1) . "');$('#l-province').val('" . $d['provcode'] . "');$('#l-district').val('" . $d['distcode'] . "');$('#l-hospcode').val('" . $d['hoscode'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope + 1) . "');$('#l-province').val('" . $d['provcode'] . "');$('#l-district').val('" . $d['distcode'] . "');$('#l-hospcode').val('" . $d['hoscode'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                            }
                        ];
                    }
                }

            } elseif ($searchModel->scope == s::SCOPE_HEALTH_UNIT) {
                if (!empty($models->hosp_fieldname)) {
                    if (empty($searchModel->province)) {
                        $select_prefix .= 'SELECT c.hoscode, CONCAT(c.provcode, c.distcode) distcode, c.provcode, CONCAT(c.hoscode, \' \',REPLACE(REPLACE(c.hosname, "โรงพยาบาลส่งเสริมสุขภาพตำบล", "รพ.สต."), "โรงพยาบาลส่งเสริมสุขภาพ", "รพ.สต.")) AS `หน่วยบริการ`, ';
                        $from .= ' FROM ' . $co_hospital . ' c LEFT JOIN (';
                        $joinfield = ' s.' . $models->hosp_fieldname . ' AS `joinfield`,';
                        $group_by .= ' joinfield ';
                        $select_posfix = ' ) s ON s.joinfield = c.hoscode WHERE c.hoscode <> "00000" AND c.hostype IN (' . $models->hosp_visible . ')';
                        $group_postfix = ' GROUP BY c.hoscode';

                        $where = $where_time;
                        $where_time = '';
                        $chart_y_field = 'หน่วยบริการ';

                        $remark .= ' ทุกสถานบริการ';

                        $fields_url = [
                            'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                            'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                                return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-province').val('" . $d['provcode'] . "');$('#l-district').val('" . $d['distcode'] . "');$('#l-hospcode').val('" . $d['hoscode'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-province').val('" . $d['provcode'] . "');$('#l-district').val('" . $d['distcode'] . "');$('#l-hospcode').val('" . $d['hoscode'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                            }
                        ];

                    } elseif (empty($searchModel->district)) {
                        $select_prefix .= 'SELECT c.hoscode, CONCAT(c.provcode, c.distcode) distcode, c.provcode,  CONCAT(c.hoscode, \' \',REPLACE(REPLACE(c.hosname, "โรงพยาบาลส่งเสริมสุขภาพตำบล", "รพ.สต."), "โรงพยาบาลส่งเสริมสุขภาพ", "รพ.สต.")) AS `หน่วยบริการ`, ';
                        $from .= ' FROM ' . $co_hospital . ' c LEFT JOIN (';
                        $joinfield = ' s.' . $models->hosp_fieldname . ' AS `joinfield`,';
                        $group_by .= ' joinfield ';
                        $select_posfix = ' ) s ON s.joinfield = c.hoscode WHERE c.provcode = "' . $searchModel->province . '" AND c.hoscode <> "00000" AND c.hostype IN (' . $models->hosp_visible . ')';
                        $group_postfix = ' GROUP BY c.hoscode';

                        $where = $where_time;
                        $where_time = '';
                        //$use_grouping ? $where .= ' LEFT(' . $models->area_fieldname . ',2) = "' . $searchModel->province . '"' : $where .= '';
                        $chart_y_field = 'หน่วยบริการ';

                        $remark .= ' ทุกสถานบริการ (จ.' . \common\models\CProvince::findOne(['changwatcode' => $searchModel->province])->toArray(['changwatname'])['changwatname'] . ')';

                        $fields_url = [
                            'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                            'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                                return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-province').val('" . $d['provcode'] . "');$('#l-district').val('" . $d['distcode'] . "');$('#l-hospcode').val('" . $d['hoscode'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-province').val('" . $d['provcode'] . "');$('#l-district').val('" . $d['distcode'] . "');$('#l-hospcode').val('" . $d['hoscode'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                            }
                        ];
                    } elseif (empty($searchModel->hospcode)) {
                        $select_prefix .= 'SELECT c.hoscode, CONCAT(c.provcode, c.distcode) distcode, c.provcode, CONCAT(c.hoscode, \' \',REPLACE(REPLACE(c.hosname, "โรงพยาบาลส่งเสริมสุขภาพตำบล", "รพ.สต."), "โรงพยาบาลส่งเสริมสุขภาพ", "รพ.สต.")) AS `หน่วยบริการ`, ';
                        $from .= ' FROM ' . $co_hospital . ' c LEFT JOIN (';
                        $joinfield = ' s.' . $models->hosp_fieldname . ' AS `joinfield`,';
                        $group_by .= ' joinfield ';
                        $select_posfix = ' ) s ON s.joinfield = c.hoscode WHERE CONCAT(c.provcode, c.distcode) = "' . $searchModel->district . '" AND c.hoscode <> "00000" AND c.hostype IN (' . $models->hosp_visible . ')';
                        $group_postfix = ' GROUP BY c.hoscode';

                        //$use_grouping ? $where .= ' LEFT(' . $models->area_fieldname . ',4) = "' . $searchModel->district . '"' : $where .= '';
                        $where = $where_time;
                        $where_time = '';
                        $chart_y_field = 'หน่วยบริการ';

                        $remark .= ' ทุกสถานบริการใน อ.' . \common\models\CDistrict::findOne(['ampurcodefull' => $searchModel->district])->toArray(['ampurname'])['ampurname']
                            . ' จ.' . \common\models\CProvince::findOne(['changwatcode' => $searchModel->province])->toArray(['changwatname'])['changwatname'];

                        $fields_url = [
                            'label' => $chart_y_field, 'attribute' => $chart_y_field, 'pageSummary' => false, 'noWrap' => true,
                            'format' => 'raw', 'value' => function ($d) use ($searchModel, $chart_y_field) {
                                return "<a href=\"javascript:void(0)\" class='glyphicon glyphicon-new-window pull-right' style='font-size: 8px;' onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-province').val('" . $d['provcode'] . "');$('#l-district').val('" . $d['distcode'] . "');$('#l-hospcode').val('" . $d['hoscode'] . "');$('#filter-submit').closest('form').attr('target', '_blank').submit()\"></a><a href=\"javascript:void(0)\" onclick=\"$('#l-scope').val('" . ($searchModel->scope) . "');$('#l-province').val('" . $d['provcode'] . "');$('#l-district').val('" . $d['distcode'] . "');$('#l-hospcode').val('" . $d['hoscode'] . "');$('#filter-submit').closest('form').removeAttr('target').submit()\" style='margin-right:16px'>" . $d[$chart_y_field] . "</a>";
                            }
                        ];
                    } else {
                        if ($use_grouping == true) {
                            $select_prefix .= 'SELECT v.villagename AS `หมู่บ้าน`, t.tambonname AS `ตำบล`,  ';//a.ampurname AS `อำเภอ`,
                            $from .= ' FROM ' . $co_village_hospcode . ' c LEFT JOIN (';
                            $joinfield = 's.' . $models->hosp_fieldname . ' AS joinfield, s.' . $models->area_fieldname . ' AS joinarea,';
                            $join = '';
                            $group_by .= ' joinarea ';
                            $select_posfix = ' ) s ON s.joinarea = c.VID ';
                            $select_posfix .= ' LEFT JOIN ' . $co_village . ' v ON c.VID = v.villagecodefull';
                            $select_posfix .= ' LEFT JOIN ' . $co_subdistrict . ' t ON v.tamboncode = t.tamboncodefull';
                            $select_posfix .= ' LEFT JOIN ' . $co_district . ' a ON v.ampurcode = a.ampurcodefull';
                            $select_posfix .= ' LEFT JOIN ' . $co_province . ' p ON v.changwatcode = p.changwatcode';

                            $select_posfix .= ' WHERE c.HOSPCODE = "' . $searchModel->hospcode . '" AND v.villagename IS NOT NULL';
                            $group_postfix = ' GROUP BY c.VID';

                            $where = $where_time;
                            $where_time = '';

                            //empty($models->area_fieldname) ? null : $where .= ' LEFT(' . $models->area_fieldname . ',6) = "' . $searchModel->subdistrict . '"';
                            $chart_y_field = 'หมู่บ้าน';


                            $remark .= ' เขตพื้นที่รับผิดชอบ ' . \common\models\CHospital::findOne(['hoscode' => $searchModel->hospcode])->toArray(['hosname'])['hosname'];
                            $fields_url = ['label' => $chart_y_field, 'attribute' => $chart_y_field, 'class' => '\kartik\grid\DataColumn', 'pageSummary' => false, 'noWrap' => true];
                        } else {
                            $select_prefix .= 'SELECT CONCAT(c.hoscode, \' \',REPLACE(REPLACE(c.hosname, "โรงพยาบาลส่งเสริมสุขภาพตำบล", "รพ.สต."), "โรงพยาบาลส่งเสริมสุขภาพ", "รพ.สต.")) AS `หน่วยบริการ`, ';
                            $from .= ' FROM ' . $co_hospital . ' c LEFT JOIN (';
                            $joinfield = ' s.' . $models->hosp_fieldname . ' AS `joinfield`,';
                            $group_by .= ' joinfield ';
                            $select_posfix = ' ) s ON s.joinfield = c.hoscode WHERE CONCAT(c.provcode, c.distcode) = "' . $searchModel->district . '" AND c.hoscode <> "00000" AND c.hostype IN (' . $models->hosp_visible . ')';
                            $group_postfix = ' GROUP BY c.hoscode';

                            $where .= ' ' . $models->hosp_fieldname . ' = "' . $searchModel->hospcode . '"';
                            $chart_y_field = 'หน่วยบริการ';

                            $remark .= ' ' . \common\models\CHospital::findOne(['hoscode' => $searchModel->hospcode])->toArray(['hosname'])['hosname'];
                            $fields_url = ['label' => $chart_y_field, 'attribute' => $chart_y_field, 'class' => '\kartik\grid\DataColumn', 'pageSummary' => false, 'noWrap' => true];
                        }

                    }
                }

            }

            $remark = $remark . $remark_time;
            //empty($group_by) ? $group_by = '' : $group_by = ' GROUP BY' . $group_by;

            $appConnection = ReportDb::find()->where(['dsp_name' => $models->db_name])->one();
            if (!empty($appConnection)) {
                $connection = new \yii\db\Connection([
                    // dsn user and password are from session, set these value during login procedure
                    'dsn' => 'mysql:host=' . $appConnection->server . ';dbname=' . $appConnection->db_name,
                    'username' => $appConnection->user,
                    'password' => $appConnection->pass,
                    'charset' => 'utf8',
                    'enableSchemaCache' => true,
                    'schemaCacheDuration' => 3600,
                    'schemaCache' => 'cache',
                ]);


            } else {
                $connection = Yii::$app->db_health;
            }

            $prefix_fields = '';

            empty($select_fields) ? $select_fields = ' s.* ' : $select_fields = implode(',', $select_fields);

            $prefix_fields = $select_fields;


            if ($use_grouping == false) {
                $group_postfix = '';
                $group_by = '';
                $from = str_replace('LEFT JOIN', 'INNER JOIN', $from);
                $join = str_replace('LEFT JOIN', 'INNER JOIN', $join);

                if (!empty($models->group_0)) {
                    $group_postfix = ' GROUP BY ' . $models->group_0;
                    $group_by = ' ' . $models->group_0;
                }
            } else {
                if (!empty($models->group_0)) {
                    $from = str_replace('LEFT JOIN', 'INNER JOIN', $from);
                    $join = str_replace('LEFT JOIN', 'INNER JOIN', $join);
                    $group_by = ' ' . $models->group_0;
                    $group_postfix = ' GROUP BY ' . $models->group_0;
                }
            }


            empty($group_by) ? $group_by = '' : $group_by = ' GROUP BY' . $group_by;


            $param = [];
            $rules = Json::decode(Yii::$app->request->get('rules'));
            if ($rules) {
                $translator = new Translator($rules);
                empty($where) ? $where = ' ' . $translator->where() : $where = ' ' . $translator->where() . ' AND ' . $where;
                $param = $translator->params();

            }
            //array_push($param, [':govyear' => $searchModel->govyear]);
            //$param[].= [':govyear' => $searchModel->govyear];

           // $param = [':govyear' => ''];

            if ($models->query_type == 1) { //Table
                if ($where <> '' && $where_time <> '') {
                    $where = $where . ' AND ' . $where_time;
                }
                empty($where) ? $where = '' : $where = ' WHERE' . $where;
                if (empty($select_prefix)) {
                    $sql = ' SELECT * FROM ' . $models->table_name . $where;
                } else {
                    $sql = $select_prefix . str_replace('COUNT(', 'SUM(', $prefix_fields) . $from . "SELECT " . $joinfield . $select_fields . " FROM " . $models->table_name . ' s ' . $join . $where . $group_by . $select_posfix . $group_postfix;
                }

            } else { //SQL

                empty($where) ? $where = '' : $where = ' WHERE' . $where;

                if (!empty($where_time)) {
//                    if (strpos(strtolower($models->sql), 'where ') > 0) {
//                        $models->sql = str_replace('where ', 'where ' . $where_time . ' AND ', strtolower($models->sql));
//                        $where_time = '';
//                    } else {
                    $models->sql .= ' HAVING' . $where_time;
                    $where_time = '';
//                    }
                }

                if (!isset($group_postfix)) {
                    $group_postfix = '';
                }

                if (empty($select_prefix)) {
                    $sql = str_replace('""', '\\"', str_replace(';', '', $models->sql)) . $where;
                } else {
                    $sql = $select_prefix . str_replace('COUNT(', 'SUM(', $prefix_fields) . $from . "SELECT " . $joinfield . $select_fields . " FROM (" . str_replace('""', '\\"', str_replace(';', '', $models->sql)) . $where_time . ') s ' . $join . $where . $group_by . $select_posfix . $group_postfix;
                }

            }

            $order_by = '';
            empty($models->order_by) ? null : $order_by = ' ORDER BY ' . $models->order_by;

            $order_direction = '';
            empty($models->order_direction) ? null : $order_direction = ' ' . $models->order_direction;

            $limit = '';
            ($models->list_limit > 0) ? $limit = ' LIMIT ' . $models->list_limit : null;

            $sql .= $order_by . $order_direction . $limit;


            try {
                $dependency = null;
//                $dependency = [
//                    'class' => 'yii\caching\DbDependency',
//                    'sql' => 'SELECT MAX(updated_at) FROM post',
//                ];

                $start = microtime(true);
                $data = $connection->cache(function ($connection) USE ($sql, $searchModel, $param){

                    // the result of the SQL query will be served from the cache
                    // if query caching is enabled and the query result is found in the cache
                    return $connection->createCommand($sql, [':repyear' => $searchModel->govyear])->bindValues($param)->queryAll();

                },300, $dependency);

                //$data = $connection->createCommand($sql, [':repyear' => $searchModel->govyear])->bindValues($param)->queryAll();

                $time_elapsed_secs = microtime(true) - $start;
            } catch (\yii\db\Exception $e) {

                return $this->render('/site/dberror', [
                    'name' => $e->getName(),
                    'message' => $e->getMessage() , //$e->getMessage(),

                ]);

            }


            $models->sql = $sql;


            $seconds = number_format((float)$time_elapsed_secs, 2, '.', '');


            $totalRecord = sizeof($data);
            $i = 0;
            $start_field = 2;

            if ($searchModel->scope == s::SCOPE_DISTRICT) {
                if (!empty($models->area_fieldname)) {
                    $start_field = 3;
                }
            } elseif ($searchModel->scope == s::SCOPE_SUBDISTRICT) {
                if (empty($searchModel->province)) {
                    $start_field = 4;
                } elseif (empty($searchModel->district)) {
                    $start_field = 3;
                }
            } elseif ($searchModel->scope == s::SCOPE_CUP) {
                if (empty($searchModel->cup)) {
                    $start_field = 4;
                } elseif (!empty($searchModel->cup)) {
                    $start_field = 4;
                }
            } elseif ($searchModel->scope == s::SCOPE_HEALTH_UNIT) {
                if (!empty($models->hosp_fieldname)) {
                    if (empty($searchModel->province)) {
                        $start_field = 4;
                    } elseif (empty($searchModel->district)) {
                        $start_field = 4;
                    } elseif (empty($searchModel->hospcode)) {
                        $start_field = 4;
                    } elseif ($use_grouping == false) {
                        $start_field = 1;
                    }

                }
            }


            !$use_grouping ? null : $fields[] = $fields_url;

            $chart_caption = '';

            if ($totalRecord > 0) {
                $arr = array_keys($data[0]);
                foreach ($arr as $value) {
                    $i++;
                    $array = ArrayHelper::getValue($fields_array, $value, []);

                    $phi = ArrayHelper::getValue($array, 'phi', '');
                    $func = ArrayHelper::getValue($array, 'function', '');
                    $caption = ArrayHelper::getValue($array, 'caption', $value);
                    $caption = empty($caption) ? $value : $caption;
                    $format = ArrayHelper::getValue($array, 'format', 'text');
                    $format_attr = ArrayHelper::getValue($array, 'format_val', 0);


                    if (strpos($caption, '|') !== false) {

                        $caption = explode('|',$caption)[0];
                    }


                    if ($format == 'number') {
                        $format = 'decimal';
                        $format_attr = 0;
                    }

                    ($format == 'text') ? $hAlign = 'left' : $hAlign = 'right';

                    if ($i > $start_field) {
                        if ($use_grouping) {
                            if ($i == $start_field) {
                                $chart_y_field = $value;
                            }

                            if ($i == $start_field) {
                                $chart_caption = $value;
                            }

                        }

                        if ($i == $start_field) {
                            $chart_caption = $value;
                        }


                        $own_data = \Yii::$app->user->isGuest ? '00000' : Profile::findOne(['user_id' => \Yii::$app->user->getId()])->off_id;
                        if ($phi == 1 && ($own_data == '00000' || $own_data <> $searchModel->hospcode) && CHospital::findOne(['hoscode' => $own_data])->hostype <> '01' && CHospital::findOne(['hoscode' => $own_data])->hostype <> '02' && \Yii::$app->user->getId() <> 23 ){

                            $fields[] = ['label' => $caption, 'attribute' => $value, 'headerOptions' => ['class' => 'text-center'],'class' => '\kartik\grid\DataColumn', 'pageSummary' => false, 'noWrap' => true, 'hAlign'=>'center',
                                'format'=>'raw',
                                'value'=>function($row) use ($value, $format_attr) {
                                        return '<i class="fa fa-eye-slash"></i>';
                                }];
                        } elseif (($func <> '')) {
                            //function ($summary, $data, $widget) { return 'Count is ' . $summary; }
                            $fields[] = ['label' => $caption, 'attribute' => $value,'headerOptions' => ['class' => 'text-center'], 'class' => '\kartik\grid\DataColumn', 'pageSummary' => true, 'noWrap' => true, 'hAlign' => $hAlign, 'format' => [$format, $format_attr], 'pageSummaryFunc' => 'f_' . str_replace('count', 'sum', strtolower($func))];
                        } elseif ($format == 'html'){
                            $fields[] = ['label' => $caption, 'attribute' => $value, 'headerOptions' => ['class' => 'text-center'],'class' => '\kartik\grid\DataColumn', 'pageSummary' => false, 'noWrap' => true, 'hAlign'=>'center',
                                'format'=>'raw',
                                'value'=>function($row) use ($value, $format_attr) {
                                    if ($row[$value] == null) {
                                        return $format_attr;
                                    } else {
                                        return $row[$value];
                                    }
                                }];
                        } else {
                            $fields[] = ['label' => $caption, 'attribute' => $value, 'headerOptions' => ['class' => 'text-center'],'class' => '\kartik\grid\DataColumn', 'pageSummary' => false, 'noWrap' => true];
                        }

                    }


                }
            }

            $page_size = $models->pagesize;

            ($totalRecord > 0) ? $sort = ['attributes' => array_keys($data[0])] : $sort = [];
            $dataProvider = new ArrayDataProvider([
                'allModels' => $data,
                'sort' => $sort,
                'pagination' => [
                    'pageSize' => $page_size,
                ],
            ]);


            $district = ArrayHelper::map(Profile::getDistrictArray($searchModel->province), 'ampurcodefull', 'ampurname');
            $subdistrict = ArrayHelper::map(Profile::getSubdistrictArray($searchModel->district), 'tamboncodefull', 'tambonname');


            (empty($models->chart_y) || $models->chart_y == '(auto)') ? null : $chart_y_field = $models->chart_y;

//            if ($models->chart_y == '(auto)') {
//                $chart_y_field = $chart_caption;
//            }

            $header = [];
            if (!empty($models->column_header)) {

                if (strpos($models->column_header, '&&') !== false) {
                    foreach(explode('&&',$models->column_header) as $header_row){
                        $header_tmp = [];
                        foreach(preg_split("/((\r?\n)|(\r\n?))/", $header_row) as $line){
                            $var = explode('|', $line);
                            if (count($var) == 3) {
                                array_push($header_tmp, ['content'=>$var[0], 'options'=>['colspan'=>$var[1], 'class'=>$var[2]]]);
                            }
                        }
                        array_push($header,$header_tmp);

                    }

                } else {
                    foreach(preg_split("/((\r?\n)|(\r\n?))/", $models->column_header) as $line){
                        $var = explode('|', $line);
                        array_push($header, ['content'=>$var[0], 'options'=>['colspan'=>$var[1], 'class'=>$var[2]]]);
                    }
                }



            }

            $plot_line = [];
            if (!empty($models->line1_value)) {
                array_push($plot_line, ['value' => $models->line1_value, 'color' => '#ff0000', 'width' => 1, 'zIndex' => 4, 'label'=>['text'=>$models->line1_caption .': '. $models->line1_value .'%']]);
            }
            if (!empty($models->line2_value)) {
                array_push($plot_line, ['value' => $models->line2_value, 'color' => '#ff0000', 'width' => 1, 'zIndex' => 4, 'label'=>['text'=>$models->line2_caption .': '. $models->line2_value .'%']]);
            }
            if (!empty($models->line3_value)) {
                array_push($plot_line, ['value' => $models->line3_value, 'color' => '#ff0000', 'width' => 1, 'zIndex' => 4, 'label'=>['text'=>$models->line3_caption .': '. $models->line3_value .'%']]);
            }
            if (!empty($models->line4_value)) {
                array_push($plot_line, ['value' => $models->line4_value, 'color' => '#ff0000', 'width' => 1, 'zIndex' => 4, 'label'=>['text'=>$models->line4_caption .': '. $models->line4_value .'%']]);
            }

            if (!empty($embeded)) {
                $this->layout = '/blank';
                return $this->render('view', [
                    'dataProvider' => $dataProvider,
                    'reportsearchmodel' => $reportsearchmodel,
                    'title' => $models->title,
                    'columns' => $fields,
                    'sql' => $models->sql,
                    'report_model' => $models,
                    'embeded'=> $embeded,
                    'frameid'=>$frameid,
                    'desc' => '',
                    'header'=>$header,
                    'plot_line'=>$plot_line,
                    'searchModel' => $searchModel,
                    'district' => $district,
                    'subdistrict' => $subdistrict,
                    'remark' => $remark,
                    'reports_in_cat' => $reports_in_cat,
                    'cat_id' => $cat_id,
                    'chart_y_field' => $chart_y_field,
                    'db_time' => $seconds,
                    'rules' => $rules,
                    'fav_cat' => $fav_cat,
                    'show_table' => $show_table,
                    'show_chart' => $show_chart,
                    'show_tool' => $show_tool,

                ]);
            } else {
                return $this->render('view', [
                    'dataProvider' => $dataProvider,
                    'reportsearchmodel' => $reportsearchmodel,
                    'title' => $models->title,
                    'columns' => $fields,
                    'sql' => $models->sql,
                    'report_model' => $models,
                    'embeded'=> $embeded,
                    'frameid'=>$frameid,
                    'desc' => '',
                    'header'=>$header,
                    'plot_line'=>$plot_line,
                    'searchModel' => $searchModel,
                    'district' => $district,
                    'subdistrict' => $subdistrict,
                    'remark' => $remark,
                    'reports_in_cat' => $reports_in_cat,
                    'cat_id' => $cat_id,
                    'chart_y_field' => $chart_y_field,
                    'db_time' => $seconds,
                    'rules' => $rules,
                    'fav_cat' => $fav_cat,
                    'show_table' => 1,
                    'show_chart' => 1,
                    'show_tool' => 1,
                ]);
            }



        } else {
            return $this->render('view', [
                'dataProvider' => null,
                'title' => '',
            ]);
        }


    }


    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProfileModel($user_id)
    {
        if (($model = Profile::findOne(['user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionGetDistrict()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $province_id = $parents[0];
                $out = $this->MapData(Profile::getDistrictArray($province_id), 'ampurcodefull', 'ampurname');
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }


    public function actionGetSubdistrict()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $province_id = empty($ids[0]) ? null : $ids[0];
            $amphur_id = empty($ids[1]) ? null : $ids[1];
            if ($province_id != null) {
                $out = $this->MapData(Profile::getSubdistrictArray($amphur_id), 'tamboncodefull', 'tambonname');
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }


    protected function MapData($datas, $fieldId, $fieldName)
    {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

}
