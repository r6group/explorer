<?php

namespace phi\controllers;

use Yii;
use common\models\Report;
use app\models\MenuSearch;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\s;
use yii\helpers\ArrayHelper;
use common\models\Profile;
use common\components\ActiveResponse;
use yii\base\ErrorException;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['user-report', 'create', 'update'],
                'rules' => [
                    [
                        'actions' => ['user-report', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionUserReport()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->userreport(Yii::$app->request->queryParams);

        return $this->render('user-report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    private static function getSummaryTables($db = 'db_health')
    {


        $appConnection = \app\models\ReportDb::find()->where(['dsp_name' => $db])->one();
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

            $data = $connection->createCommand("SHOW TABLES WHERE Tables_in_" . $appConnection->db_name . " NOT LIKE 'cox_%'")->queryAll();
            $tables = ArrayHelper::map($data, 'Tables_in_' . $appConnection->db_name, 'Tables_in_' . $appConnection->db_name);

        } else {
            $connection = Yii::$app->db_health;
            $data = $connection->createCommand("SHOW TABLES WHERE Tables_in_health_explorer NOT LIKE 'cox_%'")->queryAll();
            $tables = ArrayHelper::map($data, 'Tables_in_health_explorer', 'Tables_in_health_explorer');
        }


        return $tables;
    }


    private static function getColumns($db, $table_sql, $is_sql = false)
    {
        $columns = [];
        if (!empty($db) && !empty($table_sql)) {

            $appConnection = \app\models\ReportDb::find()->where(['dsp_name' => $db])->one();
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
                $columns = $connection->createCommand($table_sql)->queryOne();
                $columns = array_keys($columns);

                $map_val = [];
                foreach ($columns as $value) {
                    //array_push($map_val, [$key => $key]);
                    $map_val = array_merge($map_val, [$value => $value]);
                    //$map_val = [$value => $value];
                }
                $columns = $map_val;

            } else {
                $schema = $connection->getSchema()->getTableSchema($table_sql);

                if ($schema !== null) {
                    $columns = ArrayHelper::map($schema->columns, 'name', 'name');

                }
            }


        }

        return $columns;
    }


    public function actionUpdateDistrict()
    {

        $prov = '';
        if (isset($_POST['prov'])) {
            $prov = $_POST['prov'];
        }


        $ar = new ActiveResponse();


        if (empty($prov)) {
            $ar->script("
            var options = $('#s-district');
            options.html('');
            options.select2('val', '');

            var options = $('#s-hospcode');
            options.html('');
            options.select2('val', '');

            var options = $('#s-cup');
            options.html('');
            options.select2('val', '');
            ");


        } else {
            //$dist = \common\models\Profile::getDistrictArray($prov);

            $dist = ArrayHelper::map(Profile::getDistrictArray($prov), 'ampurcodefull', 'ampurname');
            //$dist = \common\models\CDistrict::find()->select(['ampurcode', 'ampurname'])->where(['changwatcode' => $prov])->orderBy('ampurname')->all();
            $js = '';
            foreach ($dist as $key => $value) {
                $js .= "options.append($('<option/>').val('" . $key . "').text('" . $value . "'));";
            }

            $ar->script("
            var options = $('#s-district');
            options.html('');
            " . $js . "
            options.select2('val', '');
            ");

            $hosp = \common\models\Profile::getHosArray($prov);
            $js = '';
            foreach ($hosp as $key => $value) {
                $js .= "options.append($('<option/>').val('" . $key . "').text('" . $value . "'));";
            }

            $ar->script("
            var options = $('#s-hospcode');
            options.html('');
            " . $js . "
            options.select2('val', '');
            ");

            $hosp = \common\models\Profile::getCupArray($prov);
            $js = '';
            foreach ($hosp as $key => $value) {
                $js .= "options.append($('<option/>').val('" . $key . "').text('" . $value . "'));";
            }

            $ar->script("
            var options = $('#s-cup');
            options.html('');
            " . $js . "
            options.select2('val', '');
            ");


        }

        return $ar;
    }

    public function actionUpdateSubdistrict()
    {

        $prov = '';
        if (isset($_POST['prov'])) {
            $prov = $_POST['prov'];
        }

        $district = '';
        if (isset($_POST['district'])) {
            $district = $_POST['district'];
        }


        $ar = new ActiveResponse();


        if (empty($district)) {
            $ar->script("
            var options = $('#s-subdistrict');
            options.html('');
            options.select2('val', '');

            ");

            if (!empty($prov)) {
                $hosp = \common\models\Profile::getHosArray($prov);
                $js = '';
                foreach ($hosp as $key => $value) {
                    $js .= "options.append($('<option/>').val('" . $key . "').text('" . $value . "'));";
                }

                $ar->script("
                var options = $('#s-hospcode');
                options.html('');
                " . $js . "
                options.select2('val', '');
                ");
            }

        } else {


            $subdist = ArrayHelper::map(Profile::getSubdistrictArray($district), 'tamboncodefull', 'tambonname');

            $js = '';
            foreach ($subdist as $key => $value) {
                $js .= "options.append($('<option/>').val('" . $key . "').text('" . $value . "'));";
            }

            $ar->script("
            var options = $('#s-subdistrict');
            options.html('');
            " . $js . "
            options.select2('val', '');
            ");

            $hosp = \common\models\Profile::getHosArray($prov, substr($district, 2, 2));
            $js = '';
            foreach ($hosp as $key => $value) {
                $js .= "options.append($('<option/>').val('" . $key . "').text('" . $value . "'));";
            }

            $ar->script("
            var options = $('#s-hospcode');
            options.html('');
            " . $js . "
            options.select2('val', '');
            ");

        }

        return $ar;
    }


    public function actionLoadTables()
    {


        $ar = new ActiveResponse();


        $tables = [];

        if (isset($_POST['db'])) {
            $db = $_POST['db'];
            if (isset($db)) {


                try {
                    $tables = $this->getSummaryTables($db);

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

                //$columns = $this->queryColumn($table)
            }
        } else {
            $ar->script("'use strict'; $.gritter.add({
              title: 'Error',
              text: 'โหลด fields ไม่เสร็จสิ้น.',
              fade_in_speed: 'fast',
              fade_out_speed: 200,
              time: 3000,
              class_name: 'with-icon check-circle error'
            });");
            return $ar;
        }


        $js = '';
        $ckb = '';
        foreach ($tables as $key => $value) {
            $js .= "options.append($('<option/>').val('" . $value . "').text('" . $value . "'));";

            $ckb .= "<label><input type=\"checkbox\" name=\"Report[chart_x][]\" value=\"" . $value . "\"> " . $value . "</label>";
        }
        $ar->script("
var options = $('#report-table_name');
options.html('');
" . $js . "
options.select2('val', '');
");


        // Success
        $ar->script("'use strict'; $.gritter.add({
title: 'Success',
text: 'โหลด Tables เสร็จสิ้น.',
fade_in_speed: 'fast',
fade_out_speed: 200,
time: 1000,
class_name: 'with-icon check-circle success'
});");


        return $ar;
    }


    public function actionLoadSqlFields()
    {


        $ar = new ActiveResponse();
        $columns = [];

        if (isset($_POST['sql'])) {
            $sql = $_POST['sql'];
            $db = $_POST['db'];
            //if (isset($table)) {


            try {
                $appConnection = \app\models\ReportDb::find()->where(['dsp_name' => $db])->one();
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
                $columns = $connection->createCommand(str_replace('#plus#', '+', $sql))->queryOne();
                $columns = array_keys($columns);
            } catch (\yii\db\Exception $e) {
                $ar->script("
                    var options = $('.field-report-sql');
                    options.append('<div class=\"alert alert-danger\" id=\"sql-msg\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><h4>Oop! " . Html::encode(preg_replace("/\r\n|\r|\n/", '', $e->getName()), false) . "</h4> " . Html::encode(preg_replace("/\r\n|\r|\n/", '', $e->getMessage()), false) . "</div>');
                    ");


                return $ar;

            }

            //$columns = $this->queryColumn($table)
            //}
        } else {
            $ar->script("'use strict'; $.gritter.add({
              title: 'Error',
              text: 'โหลด fields ไม่เสร็จสิ้น.',
              fade_in_speed: 'fast',
              fade_out_speed: 200,
              time: 3000,
              class_name: 'with-icon check-circle error'
            });");
            return $ar;
        }


        $model = new Report();


        // assign html to div
        $this->layout = '/no_layout';
        $ar->html('fields-containner', $this->render('_from_fields', [
            'model' => $model,
            'columns' => $columns,
        ]));

        $js = '';
        $ckb = '';
        $auto_chart_y = "options.append($('<option/>').val('(auto)').text('(AUTO)'));";

        foreach ($columns as $key => $value) {
            $js .= "options.append($('<option/>').val('" . $value . "').text('" . $value . "'));";

            $ckb .= "<label><input type=\"checkbox\" name=\"Report[chart_x][]\" value=\"" . $value . "\"> " . $value . "</label>";
        }

        // Success
        $ar->script("'use strict'; $.gritter.add({
      title: 'Success',
      text: 'โหลด fields เสร็จสิ้น.',
      fade_in_speed: 'fast',
      fade_out_speed: 200,
      time: 2000,
      class_name: 'with-icon check-circle success'
    });");

        $ar->script("
var options = $('#report-area_fieldname');
options.html('');
" . $js . "
options.select2('val', '');

var options = $('#report-time_fieldname');
options.html('');
" . $js . "
options.select2('val', '');

var options = $('#report-hosp_fieldname');
options.html('');
" . $js . "
options.select2('val', '');

var options = $('#report-chart_x');
options.html('');
options.html('" . $ckb . "');

var options = $('#report-chart_y');
options.html('');
" . $auto_chart_y . "
" . $js . "
options.select2('val', '');

var options = $('#report-group_0');
options.html('');
" . $js . "
options.select2('val', '');

var options = $('#report-group_1');
options.html('');
" . $js . "
options.select2('val', '');

var options = $('#report-order_by');
options.html('');
" . $js . "
options.select2('val', '');



");


        return $ar;
    }


    public function actionLoadFields()
    {
        $model = new Report();

        $columns = [];
        if (isset($_POST['table'])) {
            $table = $_POST['table'];
            $db = $_POST['db'];

            isset($table) ? $columns = $this->getColumns($db, $table, false) : $columns = [];
        }

        $guery_type = '999';
        if (isset($_POST['query_type'])) {
            $guery_type = $_POST['query_type'];
        }

        $ar = new ActiveResponse();


        // show standart browser's alert
        //$ar->alert($table);

        if ($guery_type == '1') {
            // assign html to div
            $this->layout = '/no_layout';
            $ar->html('fields-containner', $this->render('_from_fields', [
                'model' => $model,
                'columns' => $columns,
            ]));
        } else {
            //$ar->html('fields-containner', '');
        }

        $js = '';
        $ckb = '';
        $fields = '';
        $auto_chart_y = "options.append($('<option/>').val('(auto)').text('(AUTO)'));";


        foreach ($columns as $key => $value) {
            $js .= "options.append($('<option/>').val('" . $value . "').text('" . $value . "'));";

            $ckb .= "<label><input type=\"checkbox\" name=\"Report[chart_x][]\" value=\"" . $value . "\"> " . $value . "</label>";
            $fields .= "<span class=\"btn btn-primary btn-sm\" onclick=\"$(\\'#report-sql\\').insertAtCaret(\\'" . $value . ", \\');\">" . $value . "</span>";
        }


        if ($guery_type == '2') {
            $js = '';
            $ckb = '';

            $ar->script("
                var options = $('#sql-fields');
                options.html('" . $fields . "');

                var options = $('#fields-list');
                options.html('\\n    " . implode(',\n    ', $columns) . "');

                ");


        } else {


            $ar->script("
var options = $('#report-area_fieldname');
options.html('');
" . $js . "
options.select2('val', '');

var options = $('#report-time_fieldname');
options.html('');
" . $js . "
options.select2('val', '');

var options = $('#report-hosp_fieldname');
options.html('');
" . $js . "
options.select2('val', '');

var options = $('#report-chart_x');
options.html('');
options.html('" . $ckb . "');

var options = $('#report-chart_y');
options.html('');
" . $auto_chart_y . "
" . $js . "
options.select2('val', '');

var options = $('#report-group_0');
options.html('');
" . $js . "
options.select2('val', '');

var options = $('#report-group_1');
options.html('');
" . $js . "
options.select2('val', '');

var options = $('#report-order_by');
options.html('');
" . $js . "
options.select2('val', '');


        var options = $('#sql-fields');
        options.html('');
        options.html('" . $fields . "');
");
        }


        // Success
        $ar->script("'use strict'; $.gritter.add({
      title: 'Success',
      text: 'โหลด fields เสร็จสิ้น.',
      fade_in_speed: 'fast',
      fade_out_speed: 200,
      time: 1000,
      class_name: 'with-icon check-circle success'
    });");


//
//        // modify attribute
//        $ar->attr('element', 'data-pjax' '0');
//
//            // assign value to element
//            $ar->val('element', 'new value');
//
//            // modify css
//            $ar->css('element', 'cssattr', 'value');
//
//            //redirect
//            $ar->redirect('/new_page.php');
//
//            // evaluate javascript
//            $ar->script("alert('wow!')");
//
//            // and much, much more...
//            $ar->focus('element');
//            $ar->addClass('element', 'class');
//            $ar->removeClass('element', 'class');
//            $ar->show('element');
//            $ar->hide('element');
//            $ar->fadeIn('element');
//            $ar->fadeOut('element');

        return $ar;
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Report();

        $searchModel = new s();
        $searchModel->search(Yii::$app->request->queryParams);


        $district = ArrayHelper::map(Profile::getDistrictArray($searchModel->province), 'ampurcodefull', 'ampurname');
        $subdistrict = ArrayHelper::map(Profile::getSubdistrictArray($searchModel->district), 'tamboncodefull', 'tambonname');


        $user_db = ArrayHelper::map(\app\models\ReportDb::find()->select(['dsp_name'])->where(['user_id' => Yii::$app->user->identity->getId()])->orderBy('dsp_name')->all(), 'dsp_name', 'dsp_name');
        //$user_db = ArrayHelper::map(\app\models\ReportDb::find()->select(['dsp_name'])->all(), 'dsp_name', 'dsp_name');
        empty($model->db_name) ? $tables = [] : $tables = $this->getSummaryTables($model->db_name);
        //$tables = $this->getSummaryTables();


        if (Yii::$app->request->post()) {

            $array = ArrayHelper::getValue($_POST['Report'], 'fields_param', null);
            empty($array) ? $model->fields = null : $model->fields = serialize($array);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->parent_id = 0;
            empty($model->query_type) ? $model->query_type = 1 : null;
            empty($model->hosp_visible) ? $model->hosp_visible = explode(',', '03,04,05,06,07,08,09,17,18') : null;

            empty($model->pagesize) ? $model->pagesize = 20 : null;
            //empty($model->list_limit) ? $model->list_limit = 'DESC' : null;

            $columns = $this->getColumns($model->db_name, $model->table_name, $model->query_type == '2');
            empty($model->fields) && $model->query_type <> '1' ? $model->fields_param = [] : $model->fields_param = unserialize($model->fields);

            return $this->render('create', [
                'model' => $model,
                'user_db' => $user_db,
                'searchModel' => $searchModel,
                'district' => $district,
                'subdistrict' => $subdistrict,
                'tables' => $tables,
                'columns' => $columns,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {


        $model = $this->findModel($id);
        $searchModel = new s();
        $searchModel->search(Yii::$app->request->queryParams);


        if ($model->user_id <> Yii::$app->user->identity->getId()) {
            return $this->render('//screen/errorpermission',
                [
                    'name' => '403 Forbidden',
                    'message' => 'ขออภัย! คุณไม่ได้รับสิทธิ์ให้แก้ไขข้อมูลนี้ได้'
                ]
            );
        } else {


            if ($model->load(Yii::$app->request->post())) {
                $array = ArrayHelper::getValue($_POST['Report'], 'fields_param', null);
                empty($array) ? $model->fields = null : $model->fields = serialize($array);
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {

                if (!$model->load(Yii::$app->request->post())) {
                    empty($model->area_visible) ? $model->area_visible = null : $model->area_visible = explode(',', $model->area_visible);
                    empty($model->hosp_visible) ? $model->hosp_visible = null : $model->hosp_visible = explode(',', $model->hosp_visible);
                    empty($model->time_visible) ? $model->time_visible = null : $model->time_visible = explode(',', $model->time_visible);
                    empty($model->chart_x) ? $model->chart_x = null : $model->chart_x = explode(',', $model->chart_x);
                }

                $district = ArrayHelper::map(Profile::getDistrictArray($searchModel->province), 'ampurcodefull', 'ampurname');
                $subdistrict = ArrayHelper::map(Profile::getSubdistrictArray($searchModel->district), 'tamboncodefull', 'tambonname');

                $user_db = ArrayHelper::map(\app\models\ReportDb::find()->select(['dsp_name'])->where(['user_id' => Yii::$app->user->identity->getId()])->orderBy('dsp_name')->all(), 'dsp_name', 'dsp_name');
                empty($model->db_name) ? $tables = [] : $tables = $this->getSummaryTables($model->db_name);


                empty($model->fields) ? $model->fields_param = [] : $model->fields_param = unserialize($model->fields);


                $columns = $model->query_type == '1' ? $this->getColumns($model->db_name, $model->table_name, false) : $this->getColumns($model->db_name, $model->sql, true);


                return $this->render('update', [
                    'model' => $model,
                    'user_db' => $user_db,
                    'searchModel' => $searchModel,
                    'district' => $district,
                    'subdistrict' => $subdistrict,
                    'tables' => $tables,
                    'columns' => $columns,
                ]);
            }
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Report::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
